<?php

namespace App\Models;

use App\Traits\GenerateSlug;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Film extends Model
{
    use HasFactory, HasUuids, SoftDeletes, GenerateSlug;

    /* Use slug for route model binding */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['deleted_at', 'pivot'];

    /*
        Film can have many genres
    */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class)
                    ->withTimestamps();
    }

    /*
        Film can have many comments
    */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /* Convert cents to dollars */
    protected function ticketPrice(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value / 100,
        );
    }

}
