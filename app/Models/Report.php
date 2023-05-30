<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model {
    use HasFactory;

    public function reviews(): HasMany {
        return $this->hasMany( Review::class );
    }

    public function users(): HasMany {
        return $this->hasMany( User::class );
    }
}
