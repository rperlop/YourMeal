<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model {
    use HasFactory;

    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }

    public function restaurant(): BelongsTo {
        return $this->belongsTo( Restaurant::class );
    }

    public function images(): HasMany {
        return $this->hasMany( Image::class );
    }

    public function reports(): HasMany {
        return $this->hasMany( Report::class );
    }
}
