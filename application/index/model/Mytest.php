<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/2/19
 * Time: 23:06
 */
namespace app\index\model;
use think\Model;

class Mytest extends Model{

    protected $table = 'mytest';

    protected $autoWriteTimestamp = false;
    protected $createTime = false;
    protected $pk = 'ID';
    protected $sequence_prefix = '';

    public function getNextId($sequence=null){
        try {
            //sequence *.CURRVAL is not yet defined in this session
            $nextId = 0;
            $seqPrefix = $this->sequence_prefix ? $this->sequence_prefix : '_seq';
            $sequence = $sequence ? $sequence : $this->table . $seqPrefix;
            $q = $this->query("SELECT {$sequence}.nextval as t FROM DUAL"); //获取当前序列号
//            print_r($q);
            if ($q) {
                $nextId = $q[0]['T'];
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $nextId;
    }
}