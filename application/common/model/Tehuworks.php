<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 16:19
 */
namespace app\common\model;


class Tehuworks extends ModelBase{


    protected $autoWriteTimestamp = 'datetime';

    protected $auto = [];
    protected $insert = [];//
    protected $update = [];


    public function sysuser()
    {
        return $this->belongsTo('sysusers','post_user_id','id');
    }


}
