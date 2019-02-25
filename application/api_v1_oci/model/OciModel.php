<?php
/**
 * Created by PhpStorm.
 * User: xiaohui
 * Date: 2019/2/24
 */
namespace app\api_v1_oci\model;
use app\common\model\ModelBase;
class OciModel extends ModelBase{

    protected $pk = 'ID';

    public $sequence_ext = '_seq';


    public function getNextId(){
        try {
            $nextId = 0;
            $sequence = $this->table . $this->sequence_ext;
//            echo $sequence;exit;
            $q = $this->query("SELECT {$sequence}.nextval as t FROM DUAL");

            if ($q) {
                $nextId = $q[0]['T'];
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $nextId;
    }


}

