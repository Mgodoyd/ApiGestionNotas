<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    const Note_Ingresado= 'Ingresado';
    const Note_En_Proceso= 'Proceso';
    const Note_Finalizado= 'Finalizado';
    
    
     protected $fillable = [
        'title',
        'content',
        'states_id',
        'user_id',
     ];


     
    public static function getAvailableStates()
    {
        return [
            self::Note_Ingresado,
            self::Note_En_Proceso,
            self::Note_Finalizado,
        ];
    }
     
    public function user(){
        return $this->belongsTo(User::class); // "muchos a uno" 
    }

    /*public function state()
    {
        return $this->belongsTo(States::class, 'state_id'); // "muchos a uno"
    }*/
    /*public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }*/
  
    public function states()
    {
        return $this->belongsTo(States::class, 'states_id');
    }


  


    
    

}
