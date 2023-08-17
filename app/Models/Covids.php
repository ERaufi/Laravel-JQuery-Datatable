<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Covids extends Model
{
    use HasFactory;

    public function countries()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }
}
