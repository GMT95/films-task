<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait GenerateSlug
{
    /* Auto generate slug based on name field */
    public static function bootGenerateSlug(): void
    {
        static::creating(function (Model $model) {
            $slug = Str::slug($model->name);

            while ($model::where('slug', $slug)->exists()) {
                /* Generate random string to maintain uniqueness */
                $slug = $slug . "-" . bin2hex(random_bytes(2));
            }

            $model->slug = $slug;
        });
    }
}
