<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\StateTransformer;

class States extends Model
{
    use HasFactory;

    public $transformer = StateTransformer::class;
    public function notes()
    {
        return $this->hasMany(Notes::class, 'states_id');
    }
    
}