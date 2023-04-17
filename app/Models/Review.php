<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function rates(): \Illuminate\Database\Eloquent\Relations\HasOne {
        return $this->hasOne(Rate::class);
    }

}
