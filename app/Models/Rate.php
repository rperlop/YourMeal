<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    public function reviews(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Review::class);
    }

}
