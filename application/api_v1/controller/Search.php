<?php
/**
 * Created by PhpStorm.
 * User: xiaohui
 * Date: 2019/2/24
 */

namespace  app\api_v1\controller;

class Search extends Common{


    public function post(){

        if(!$this->request->isPost()){
            return $this->res([
                'code'=>201,
                'msg'=>'访问错误'
            ]);
        }

        $begin_time = $this->request->post("begin_time");
        $end_time = $this->request->post("end_time");



        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'list'=>[]
            ]
        ]);

    }


}