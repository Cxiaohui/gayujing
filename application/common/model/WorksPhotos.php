<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 20:11
 */
namespace app\common\model;

class WorksPhotos extends ModelBase{

    protected $autoWriteTimestamp = 'datetime';

    protected $auto = [];
    protected $insert = [];//
    protected $update = [];


    public function sysuser()
    {
        return $this->belongsTo('daliyworks','work_id','id');
    }

}