<?php

namespace App\Models;

use App\Traits\GenerateSlug;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use HasFactory, HasUuids, SoftDeletes, GenerateSlug;

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

}
