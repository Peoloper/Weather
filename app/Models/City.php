<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class City extends Model
{
    protected $fillable = ['data', 'name', 'user_id'];

    protected $casts = [
        'data' => 'array',
    ];

    use HasFactory;

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
