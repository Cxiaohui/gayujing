<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 00:03
 */
namespace app\common\model;


use think\helper;

class Sysusers extends ModelBase{

    protected $autoWriteTimestamp = 'datetime';


    protected $auto = [];
    protected $insert = ['logpwd'];//
    protected $update = [];

    public function tehuworks()
    {
        return $this->hasMany('Tehuworks','post_user_id','id');
    }

    public function getLogstat()
    {
        return helper\Str::random(6);
    }

    public function setLogpwdAttr($value,$data)
    {

        return create_log_pwd($value,$data['logstat']);
    }

    public function getPwd($pwd){
        return create_log_pwd($pwd,$this->logstat);
    }

    public function returnInfo(){
        return [
            'user_id'=>$this->id,
            'utype'=>$this->utype,
            'name'=>$this->name,
            'gender'=>$this->gender,
            'mobile'=>$this->mobile,
            'education'=>$this->education,
            'headpic'=>$this->headpic,
            'logaccount'=>$this->logaccount,
        ];
    }



}