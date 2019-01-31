<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 01:11
 */
namespace app\api_v1\controller;


class Options extends Common{


    public function index(){

        $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'gobeijing_path'=>config('gobeijing_path'),
                'acttype_inbeijing'=>config('gobeijing_path'),
                'gotype'=>config('gobeijing_path'),
                'action_names'=>config('gobeijing_path'),
                'event_groups'=>config('gobeijing_path'),
                'event_cates'=>config('gobeijing_path'),
            ]
        ]);

    }

}