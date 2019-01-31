<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 23:45
 */
namespace app\common\model;

class EventPeoples extends ModelBase{
    protected $autoWriteTimestamp = 'datetime';


    protected $auto = [];
    protected $insert = [];//
    protected $update = [];


    /*public function event()
    {
        return $this->belongsTo('Events','event_id','id');
    }*/
}