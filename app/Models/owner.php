<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class owner extends User
{
    
    public function notes()
    {
        return $this->morphMany(Note::class, 'owner');// 1 a muchos
    }
}
