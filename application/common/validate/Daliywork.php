<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 19:57
 */
namespace app\common\validate;

use think\Validate;

class Daliywork extends Validate{

    protected $rule = [
        'post_user_id'=>'require',
        'people_name'=>'require',
        'people_idnumber'=>'require',
        'people_mobile'=>'require',
//        'people_idcardpic0'=>'require',
//        'people_idcardpic1'=>'require',
        'gobeijing_path'=>'require',
        'content'=>'require',
        'gotype'=>'require',
        'action_name'=>'require',
        'action_desn'=>'require',
        'work_content'=>'require',
        ];

    protected $message  =   [
        'post_user_id.require' => '上报者信息缺失',
        'people_name.require' => '信访人姓名必须',
        'people_idnumber.require' => '上访人身份证号必须',
        'people_mobile.require' => '上访人通讯号码必须',
//        'people_idcardpic0.require' => '上访人身份证正面照片必须',
//        'people_idcardpic1.require' => '上访人身份反面证照片必须',
        'gobeijing_path.require' => '进京途径必须',
        'content.require' => '详细诉求必须',
        'gotype.require' => '上访方式必须',
        'action_name.require' => '过激行为必须',
        'action_desn.require' => '行为描述必须',
        'work_content.require' => '上访工作必须',
    ];


}