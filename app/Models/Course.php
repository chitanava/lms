<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function author():BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
