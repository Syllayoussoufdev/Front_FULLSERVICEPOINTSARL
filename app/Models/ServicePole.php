<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePole extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'short_desc',
        'full_desc',
        'icon',
        'image',
        'is_active',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }
}
