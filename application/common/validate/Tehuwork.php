<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 16:31
 */
namespace app\common\validate;

use think\Validate;

class Tehuwork extends Validate{


    protected $rule = [
        'post_user_id'=>'require',
        'xinfang_name'=>'require',
        'xinfang_idnumber'=>'require',
        'xinfang_mobile'=>'require',
//        'xinfang_idcardpic0'=>'require',
//        'xinfang_idcardpic1'=>'require',
        'tongxi_name'=>'require',
        'tongxi_idnumber'=>'require',
        'tongxi_mobile'=>'require',
//        'tongxi_idcardpic0'=>'require',
//        'tongxi_idcardpic1'=>'require',
        'gobeijing_path'=>'require',
        'gobeijing_type'=>'require',
        'acttype_inbeijing'=>'require',
        'address_inbeijing'=>'require',
//        'lost_time'=>'require',
//        'find_time'=>'require',
//        'content'=>'require',
    ];
    protected $message  =   [
        'post_user_id.require' => '上报者信息缺失',

        'xinfang_name.require' => '信访人姓名必须',
        'xinfang_idnumber.require' => '信访人身份证号必须',
        'xinfang_mobile.require' => '信访人通讯号码必须',
//        'xinfang_idcardpic0.require' => '信访人身份证正面照片必须',
//        'xinfang_idcardpic1.require' => '信访人身份反面证照片必须',

        'gobeijing_path.require'   => '进京途径必须',
        'gobeijing_type.require'   => '进京方式必须',

        'tongxi_name.require' => '同行人姓名必须',
        'tongxi_idnumber.require' => '同行人身份证号必须',
        'tongxi_mobile.require' => '同行人通讯号码必须',
//        'tongxi_idcardpic0.require' => '同行人身份证正面照片必须',
//        'tongxi_idcardpic1.require' => '同行人身份反面证照片必须',


        'acttype_inbeijing.require'   => '在京行为类型必须',
        'address_inbeijing.require'   => '在京巡回地点必须',

//        'lost_time.require'  => '失联时间必须',
//        'find_time.require'  => '找到时间必须',
//        'content.require'  => '上访诉求必须'
    ];

    /*protected $scene = [
        'edit'  =>  ['name','mobile'],
    ];*/
}