<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 23:34
 */
namespace app\common\model;

class Tielu extends ModelBase{



    protected $table = 'ga_tielu_datas';
    protected $autoWriteTimestamp = 'datetime';


    protected $auto = [];
    protected $insert = [];//
    protected $update = [];

}