<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['film_id', 'user_id', 'text'];

    /* Comment belongs to user */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

     /* Comment belongs to film */
     public function film(): BelongsTo
     {
         return $this->belongsTo(Film::class);
     }
}
