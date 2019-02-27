<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 01:11
 */
namespace app\api_v1\controller;


class Options extends Common{

    public function __construct($need_check=false)
    {
        parent::__construct(false);
    }

    public function index(){

        $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'gobeijing_path'=>config('gobeijing_path'),
                'gobeijing_types'=>config('gobeijing_types'),
                'acttype_inbeijing'=>config('acttype_inbeijing'),
                'gotype'=>config('gotype'),
                'action_names'=>config('action_names'),
                'event_groups'=>config('event_groups'),
                'event_cates'=>config('event_cates'),
                'people_nums'=>config('people_nums'),
                'raodaos'=>config('raodaos'),
                'suqiu_types'=>config('suqiu_types'),
                'xinfang_cates'=>config('xinfang_cate'),
            ]
        ]);

    }

}