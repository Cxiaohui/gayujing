<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 00:16
 */
namespace app\api_v1_oci\validate;

use think\Validate;

class Sysusers extends Validate{


    protected $rule = [
        'NAME'=>'require|max:20',
        'MOBILE'=>'require|unique:sysusers',
        'LOGACCOUNT'=>'require|max:32|alphaDash|unique:sysusers',
        'LOGPWD'=>'require'
    ];
    protected $message  =   [
        'NAME.require' => '姓名必须',
        'NAME.max'     => '姓名最多不能超过20个字符',
        'MOBILE.require'   => '手机号码必须',
        'MOBILE.unique'   => '手机号码已经存在，请换一个',
        'LOGACCOUNT.require'  => '登录账号必须',
        'LOGACCOUNT.max'  => '登录账号在32个字符内',
        'LOGACCOUNT.alphaDash'  => '登录账号只能为字母和数字，下划线_及破折号-',
        'LOGACCOUNT.unique'  => '登录账号重复，请换一个',
        'LOGPWD.require'        => '登录密码必须',
    ];

    protected $scene = [
        'edit'  =>  ['NAME','MOBILE'],
    ];
}