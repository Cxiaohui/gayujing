<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 23:34
 */
namespace app\common\model;

class Events extends ModelBase{
    protected $autoWriteTimestamp = 'datetime';


    protected $auto = [];
    protected $insert = [];//
    protected $update = [];


    public function sysuser()
    {
        return $this->belongsTo('sysusers','post_user_id','id');
    }

    public function peopleList(){
        return $this->hasMany('EventPeoples','event_id','id');
    }
}