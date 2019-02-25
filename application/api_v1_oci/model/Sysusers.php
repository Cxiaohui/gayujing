<?php
/**
 * Created by PhpStorm.
 * User: xiaohui
 * Date: 2019/2/24
 */
namespace app\api_v1_oci\model;

use think\helper;

class Sysusers extends OciModel{

    protected $table = 'ga_sysusers';

    public function getLogstat()
    {
        return helper\Str::random(6);
    }

    public function getGenderTextAttr($value,$data)
    {
        $status = [0=>'未知',1=>'男',2=>'女'];
        return $status[$data['GENDER']];
    }

    public function setLogpwdAttr($value,$data)
    {

        return create_log_pwd($value,$data['LOGSTAT']);
    }

    public function getPwd($pwd){
        return create_log_pwd($pwd,$this->logstat);
    }
}