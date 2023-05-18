<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model {
    use HasFactory;

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Review::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(User::class);
    }

}
