<?php
/**
 * Created by PhpStorm.
 * User: xiaohui
 * Date: 2019/2/24
 */
namespace app\api_v1\controller;

class Qiniu extends Common{


    public function token(){
        $uptoken = \app\common\library\Qiniu::get_uptoken(config('qiniu.bucket1'));


        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'uptoken'=>$uptoken,
                'bucket'=>config('qiniu.bucket1')
            ]
        ]);

    }

}