<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;
    public function Notes(){
        return $this->hasMany(Notes::class);   // 1 a muchos
    }

}