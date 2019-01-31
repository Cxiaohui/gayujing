<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 00:16
 */
namespace app\common\validate;

use think\Validate;

class Sysusers extends Validate{


    protected $rule = [
        'name'=>'require|max:20',
        'mobile'=>'require|unique:sysusers',
        'logaccount'=>'require|max:32|alphaDash|unique:sysusers',
        'logpwd'=>'require'
    ];
    protected $message  =   [
        'name.require' => '姓名必须',
        'name.max'     => '姓名最多不能超过20个字符',
        'mobile.require'   => '手机号码必须',
        'mobile.unique'   => '手机号码已经存在，请换一个',
        'logaccount.require'  => '登录账号必须',
        'logaccount.max'  => '登录账号在32个字符内',
        'logaccount.alphaDash'  => '登录账号只能为字母和数字，下划线_及破折号-',
        'logaccount.unique'  => '登录账号重复，请换一个',
        'logpwd.require'        => '登录密码必须',
    ];

    protected $scene = [
        'edit'  =>  ['name','mobile'],
    ];
}