<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 19:57
 */
namespace app\common\model;


class Daliyworks extends ModelBase{


    protected $autoWriteTimestamp = 'datetime';

    protected $auto = [];
    protected $insert = [];//
    protected $update = [];


    public function sysuser()
    {
        return $this->belongsTo('sysusers','post_user_id','id');
    }

    public function photos(){
        return $this->hasMany('WorksPhotos','work_id','id');
    }

}