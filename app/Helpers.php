<?php

//check user access permission function start

use App\Models\UserModule\SuperAdmin;
use App\Models\UserModule\User;
use App\Models\LocationModule\Location;

function can($can){
        if( auth('web')->check() ){
            foreach( auth('web')->user()->role->permission as $permission ){
                if( $permission->key == $can ){
                    return true;
                }
            }
            return false;
        }
        return back();
        
    }
    //check user access permission function end

     //find root parent of category start
     function parent_location($id){
        
        $count = 0;
        while( $count != -1 ){
            $location = Location::find($id);
            if( $location->location_id == null ){
                $id = $location->id;
                $count = -1;
            }else{
                $id = $location->parent->id;
                $count++;
            }
        }
        return $location = Location::find($id);
        
       
    } 
    //find root parent of category end


    //unauthorized text start
    function unauthorized(){
        return "You are not authorized for this";
    }
    //unauthorized text end


    //mail from start
    function mail_from(){
        return "test@sehirulislamrehi.com";
    }
    //mail from end


?>