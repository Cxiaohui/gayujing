<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 09:53
 */
namespace app\api_v1\library;
use app\api_v1\model\AppTokens as AppTokenModel;
use app\api_v1\model\AppTokens;

class ApiToken{

    static public function checkToken($user_id,$user_token){
        $token = self::getApiToken($user_id);
        if($token){
            return $user_token == $token ? $user_id : -1;
        }
        return -2;
    }

    static public function cleanApiToken($user_id){
        $cache_key = self::getCacheKey($user_id);
        cache($cache_key,null);
        $apptokenmodel = AppTokens::get($user_id);
        if(!$apptokenmodel){
            return false;
        }
        $apptokenmodel->api_token = '';
        return $apptokenmodel->save();
    }

    static public function getApiToken($user_id){

        $cache_key = self::getCacheKey($user_id);
        $token = cache($cache_key);
        if($token){
            return $token;
        }

        $apptokenmodel = AppTokens::get($user_id);
        if(!$apptokenmodel){
            return false;
        }

        return $apptokenmodel->api_token;
    }

    static public function createSaveApiToken($user_id){
        $token = self::createApiToken($user_id);
        self::saveApiToken($user_id,$token);

        $cache_key = self::getCacheKey($user_id);
        cache($cache_key,null);
        cache($cache_key,$token);
        return $token;
    }

    static protected function getCacheKey($user_id){
        return config('api_cache_key.app_token').$user_id;
    }

    static protected function createApiToken($user_id){
        return md5(time().'-'.$user_id.'-'.request()->host());
    }

    static protected function saveApiToken($user_id,$token='',$token_expiry=null){
        if(!$token){
            $token = self::createApiToken($user_id);
        }
        if(!$token_expiry){
            //todo 使用时间处理库
            $token_expiry = date('Y-m-d H:i:s',time()+60*24*3600);
        }
        $apptokenmodel = AppTokens::get($user_id);
        if(!$apptokenmodel){
            $apptokenmodel = new AppTokenModel();
        }

        $apptokenmodel->user_id = $user_id;
        $apptokenmodel->user_type = 1;
        $apptokenmodel->api_token = $token;
        $apptokenmodel->token_expiry = $token_expiry;

        return $apptokenmodel->save();
    }
}