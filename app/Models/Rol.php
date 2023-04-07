<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
      use HasFactory;
      public function users()
      {
          return $this->belongsToMany(User::class,'rol_user');
      }
    
    protected $table = 'rols';



    public static function allRoles()
    {
        return static::all();
    }
    protected $fillable = [
        'id',
        'name_role',
    ];

    protected $hidden = [
        'pivot'
    ];
}
