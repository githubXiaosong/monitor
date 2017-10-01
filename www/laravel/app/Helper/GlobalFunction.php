<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 19:07
 */
namespace App\Helper;
use App\Notifications\ServerError;
use App\Notifications\StreamError;
use App\Notifications\StreamStatusChange;
use App\Policy;
use App\Server;
use App\Stream;
use App\User;

class GlobalFunction
{

    const DB_ERROR = 3;
    const CODE_SUCCEED = 0;
    const CODE_ERROR = 1;
    const PHONE_VALIDATE_ERROR =2 ;

    static function GetCallBackSign($time)
    {
        return md5(API_DEFINE_KEY . strval($time));
    }

//    return ['status' => 1, 'msg' => ['code' => [0 => '验证码有误']]];
    static function returnModel($status, $msg = null,$data = null)
    {
        return ['status' => $status, 'msg' => $msg ,'data' => $data];
    }

    static function getCurlOutput($addr)
    {
        $ch = curl_init($addr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }


    static function streamErrorNotifyAllUser($stream_id,$status,$msg){
        foreach (User::get() as $user) {
            $user->notify(new StreamError($stream_id,$status,$msg));
        }
    }

    static function serverErrorNotifyAllUser($server_id,$msg){
        foreach (User::get() as $user) {
            $user->notify(new ServerError($server_id,$msg));
        }
    }

    static function streamStatusChangeNotifyAllUser($stream_id,$per_status,$to_status){
        foreach (User::get() as $user) {
            $user->notify(new StreamStatusChange($stream_id,$per_status,$to_status));
        }
    }




}

