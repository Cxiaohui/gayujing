<?php
/**
 * Created by PhpStorm.
 * User: xiaohui
 * Date: 2019/2/24
 */
namespace app\api_v1\controller;

class Qiniu extends Common{


    public function token(){

        $config = config('app.qiniu');

        $uptoken = \app\common\library\Qiniu::get_uptoken($config['bucket1']);


        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'uptoken'=>$uptoken,
//                'qiniu'=>config('qiniu'),
                'bucket'=>$config['bucket1']
            ]
        ]);

    }

}