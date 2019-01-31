<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/30
 * Time: 22:42
 */
namespace app\api_v1\controller;



class Index extends Common{

    public function __construct($need_check=false)
    {
        parent::__construct(true);
    }

    public function index(){

        $this->res([
            'success'=>true,
            'msg'=>'ok',
            'result'=>[
                'data'=>[
                    'aa'=>'asfsd'
                ]
            ]
        ]);
    }
}