<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\RolTransformer;

class Rol extends Model
{
      use HasFactory;

        public $transformer = RolTransformer::class;
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
