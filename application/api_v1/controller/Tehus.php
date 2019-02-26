<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 01:04
 */
namespace app\api_v1\controller;
use app\common\model\Tehuworks;
use app\common\validate\Tehuwork as TehuValidate;

class Tehus extends Common{

    public function __construct($need_check=false)
    {
        parent::__construct(true);
    }

    public function index(){

    }

    public function info(){
        $id = $this->request->get('id');
        if(!$id || $id<=0){
            return $this->res([
                'code'=>201,
                'msg'=>'访问错误'
            ]);
        }

        $tehuworks = Tehuworks::get($id);

        if(!$tehuworks){
            return $this->res([
                'code'=>201,
                'msg'=>'该信息不存在或被删除'
            ]);
        }
        $info = $tehuworks->toArray();
        $info['xinfang_idcardpic0'] = qnimg($info['xinfang_idcardpic0']);
        $info['xinfang_idcardpic1'] = qnimg($info['xinfang_idcardpic1']);
        $info['tongxi_idcardpic0'] = qnimg($info['tongxi_idcardpic0']);
        $info['tongxi_idcardpic1'] = qnimg($info['tongxi_idcardpic1']);

        $info['can_edit'] = 0;
        if($info['post_user_id'] == $this->user_id){
            $info['can_edit'] = 1;
        }

        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                //'user'=>$tehuworks->sysuser()->field('id,name')->find(),
                'info'=>$info
            ]
        ]);
    }

    public function test(){
        $this->user_id = 1;
        $post = [
            'id'=>2,
//            'post_user_id'=>'',
            'xinfang_name'=>'张三2',
            'xinfang_idnumber'=>'12345678900987654',
            'xinfang_mobile'=>'122222222222',
            'xinfang_idcardpic0'=>'xinfang_idcardpic0',
            'xinfang_idcardpic1'=>'xinfang_idcardpic1',
            'tongxi_name'=>'李四3',
            'tongxi_idnumber'=>'9876543298765',
            'tongxi_mobile'=>'144555555555',
            'tongxi_idcardpic0'=>'tongxi_idcardpic0',
            'tongxi_idcardpic1'=>'tongxi_idcardpic1',
            'gobeijing_path'=>'自驾车',
            'gobeijing_type'=>'直达',
            'acttype_inbeijing'=>'北京分流',
            'address_inbeijing'=>'北京三里屯',
            'lost_time'=>null,
            'find_time'=>null,
            'content'=>'我要上报我要上报我要上报我要上报我要上报我要上报我要上报我要上报我要上报',
        ];

        $post = [
            'xinfang_name' => '312',
    'xinfang_idnumber' => '3123',
    'xinfang_mobile' => '3123',
    'xinfang_idcardpic0' => 'gaqn/id/201902241557220.jpg',
        'xinfang_idcardpic1' => 'gaqn/id/201902241557260.jpg',
        'tongxi_name' => '哦请问哦请问',
        'tongxi_idnumber' => '123123131',
    'tongxi_mobile' => '31231',
    'tongxi_idcardpic0' => 'gaqn/id/201902241557460.jpg',
        'tongxi_idcardpic1' => 'gaqn/id/201902241557500.jpg',
        'gobeijing_path_id' => 3,
    'gobeijing_path' => '自驾车',
        'gobeijing_type_id' => 2,
        'raodao_id' => 2,
        'gobeijing_type' => '到市上访',
        'acttype_inbeijing_id' => 2,
    'acttype_inbeijing' => '北京分流',
        'address_inbeijing' => '3123123',
    'lost_time' => '2019-02-24',
    'find_time' => '2019-02-24'
        ];


        $this->post($post);
    }

    public function post($post=[]){

        if(empty($post)){

            if(!$this->request->isPost()){
                return $this->res([
                    'code'=>201,
                    'msg'=>'访问错误'
                ]);
            }

            $post = $this->request->post();
        }

        if(empty($post)){
            return $this->res([
                'code'=>201,
                'msg'=>'访问错误'
            ]);
        }

//        \app\common\library\Mylog::write($post,'tehus_data');

        $post['post_user_id'] = $this->user_id;

        $tehuValidate = new TehuValidate();

        if(!$tehuValidate->check($post)){
            return $this->res([
                'code'=>201,
                'msg'=>$tehuValidate->getError()
            ]);
        }
        $status = 1;
        if(isset($post['id']) && $post['id']>0){
            $status = 2;
            $tehuworks = Tehuworks::get($post['id']);
        }else{
            $tehuworks = new Tehuworks();
        }

        $tehuworks->post_user_id = $this->user_id;
        $tehuworks->status = $status;

        $tehuworks->xinfang_name = $post['xinfang_name'];
        $tehuworks->xinfang_idnumber = $post['xinfang_idnumber'];
        $tehuworks->xinfang_mobile = $post['xinfang_mobile'];

        if(isset($post['xinfang_idcardpic0'])){
            $tehuworks->xinfang_idcardpic0 = $post['xinfang_idcardpic0'];
        }
        if(isset($post['xinfang_idcardpic1'])){
            $tehuworks->xinfang_idcardpic1 = $post['xinfang_idcardpic1'];
        }

        $kvname = function($key,$kv_key) use ($post){
            $id_key = $key.'_id';
            if(!isset($post[$key]) && !isset($post[$id_key])){
                return [0,''];
            }

            $gnamekv = config($kv_key);

            if(isset($post[$id_key]) && isset($gnamekv[$post[$id_key]])){

                return [$post[$id_key],$gnamekv[$post[$id_key]]];

            }elseif(is_numeric($post[$key])){

                return isset($gnamekv[$post[$key]]) ? [$post[$key],$gnamekv[$post[$key]]] : [0,''];
            }

            return [0,$post[$key]];
        };
        //进京途径
        $gobeijing_path = $kvname('gobeijing_path','gobeijing_path_kv');
        $tehuworks->gobeijing_path_id = $gobeijing_path[0];
        $tehuworks->gobeijing_path = $gobeijing_path[1];
        //进京方式
        $gobeijing_type = $kvname('gobeijing_type','gobeijing_types_kv');
        $tehuworks->gobeijing_type_id = $gobeijing_type[0];
        $tehuworks->gobeijing_type = $gobeijing_type[1];
        //绕道
        $raodao = $kvname('raodao','raodaos_kv');
        $tehuworks->raodao_id = $raodao[0];
        $tehuworks->raodao = $raodao[1];

        //在京行为类型
        $acttype_inbeijing = $kvname('acttype_inbeijing','acttype_inbeijing_kv');
        $tehuworks->acttype_inbeijing_id = $acttype_inbeijing[0];
        $tehuworks->acttype_inbeijing = $acttype_inbeijing[1];

        $tehuworks->tongxi_name = $post['tongxi_name'];
        $tehuworks->tongxi_idnumber = $post['tongxi_idnumber'];
        $tehuworks->tongxi_mobile = $post['tongxi_mobile'];

        if(isset($post['tongxi_idcardpic0'])){
            $tehuworks->tongxi_idcardpic0 = $post['tongxi_idcardpic0'];
        }
        if(isset($post['tongxi_idcardpic1'])){
            $tehuworks->tongxi_idcardpic1 = $post['tongxi_idcardpic1'];
        }

        $tehuworks->address_inbeijing = $post['address_inbeijing'];
        if($post['lost_time']){
            $tehuworks->lost_time = $post['lost_time'];
        }
        if($post['find_time']){
            $tehuworks->find_time = $post['find_time'];
        }

        $tehuworks->content = isset($post['content']) ? $post['content'] : '';


        $res = $tehuworks->save();
        if($res){
            return $this->res([
                'code'=>200,
                'msg'=>'上报信息成功'
            ]);
        }
        return $this->res([
            'code'=>201,
            'msg'=>'上报信息失败'
        ]);
    }

}