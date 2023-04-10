<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\NotesTransformer;

class Notes extends Model
{
    use HasFactory;

    public $transformer = NotesTransformer::class;//transformador de la clase
    protected $table = 'notes';
    
     protected $fillable = [
        'title',
        'content',
        'states_id',
        'user_id',
     ];

    public function user(){ 
        return $this->belongsTo(User::class); // "muchos a uno" 
    }
  
    public function states() // "muchos a uno"
    {
        return $this->belongsTo(States::class, 'states_id');
    }
}
