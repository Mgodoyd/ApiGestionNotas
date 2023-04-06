<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
      use HasFactory;
    public function Users(){
        return $this->hasMany(User::class);   // 1 a muchos
    }
    
    protected $table = 'rols';

    public function getUsers()
    {
        return $this->hasMany(User::class, 'rol_id', 'id');
    }

    public static function allRoles()
    {
        return static::all();
    }
    protected $fillable = [
        'id',
        'name_role',
    ];
}
