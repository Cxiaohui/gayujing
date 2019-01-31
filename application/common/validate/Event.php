<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 23:36
 */
namespace app\common\validate;

use think\Validate;

class Event extends Validate{

    protected $rule = [
        'post_user_id'=>'require',
        'group_name'=>'require',
        'event_cate'=>'require',
        'happen_time'=>'require',
        'address'=>'require',
        'people_number'=>'require',
        'content'=>'require',
//        'do_unit_name'=>'require'
    ];

    protected $message  =   [
        'post_user_id.require' => '上报者信息缺失',
        'group_name.require' => '涉及群体必须',
        'event_cate.require' => '事件类别必须',
        'happen_time.require' => '发生时间必须',
        'address.require' => '地点必须',
        'people_number.require' => '人数规模必须',
        'content.require' => '事因\诉求必须',
        'do_unit_name.require' => '处置单位必须'
    ];


}