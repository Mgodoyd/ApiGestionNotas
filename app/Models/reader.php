<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ReaderTransformer;

class reader extends User
{ 
    public $transformer = ReaderTransformer::class;
    public function Notes(){
        return $this->hasMany(Notes::class);   // 1 a muchos
    }
}
