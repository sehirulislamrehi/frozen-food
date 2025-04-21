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

    //unauthorized text start
    function unauthorized(){
        return "You are not authorized for this request";
    }
    //unauthorized text end

    //mail from start
    function mail_from(){
        return "test@sehirulislamrehi.com";
    }
    //mail from end


    function HrisLogin($username, $password)
    {
        $url = "http://hris.prangroup.com:8696/Login/LoginHris/";

        $headers = array(
            "Authorization: Basic YXV0aDoxMlByYW5AMTIzNDU2JA==",
            "Content-Type: application/json",
        );

        $fields = [
            'username' => $username,
            'password' => $password,
        ];

        $postdata = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = json_decode(curl_exec($ch));

        if ($response->status && $response->status == "Success") {
            return true;
        }
        return false;
    }

    function UserInfo($staffid){
        $user_info_request = file_get_contents('http://172.17.2.114:90/auth_server/Project/Controllers/api-v1/automation/hris.php?query='.$staffid);
        
        $user = json_decode($user_info_request);

        $data['staffid'] = $user->staffid;
        $data['staffname'] = $user->staffname;
        $data['contactno'] = $user->contactno ? mobileNumberValidate($user->contactno) : '';
        $data['email'] = $user->email;
        $data['company'] = $user->company;
        $data['group'] = $user->group;
        $data['department'] = $user->department;
        $data['location'] = $user->location;
        $data['designation'] = $user->designation;
        $data['isactive'] = $user->isactive;
        $data['msg'] = $user->msg;
        $data['status'] = $user->status;
        $data =  json_encode($data);
        return $user = json_decode($data);

    }

    function mobileNumberValidate($mobile)
    {

        if(strlen($mobile) > 11) {
            $mobile = substr($mobile, -11);
        }
        return $mobile;
    }


    function ip(){
        return "10465";
    }


    function factor(){
        return [
            [
                'id' => 1,
                'name' => 'Packet'
            ]
        ];
    }

    function product_life_time($type){
        if( $type == "Local" ){
            return 1;
        }
        if( $type == "Export" ){
            return 2;
        }
    }

?>