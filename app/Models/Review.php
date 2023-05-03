<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    use HasFactory;

    public function rates(): \Illuminate\Database\Eloquent\Relations\HasOne {
        return $this->hasOne( Rate::class );
    }

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function restaurant() {
        return $this->belongsTo( Restaurant::class );
    }
}
