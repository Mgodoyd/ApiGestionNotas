<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reader extends User
{
    public function Notes(){
        return $this->hasMany(Notes::class);   // 1 a muchos
    }
}
