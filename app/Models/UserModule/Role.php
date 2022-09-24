<?php

namespace App\Models\UserModule;

use App\Models\LocationModule\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function permission(){
        return $this->belongsToMany(Permission::class);
    }

    public function role_location(){
        return $this->hasMany(RoleLocation::class,"role_id", "id");
    }

}