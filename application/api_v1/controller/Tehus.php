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

        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                //'user'=>$tehuworks->sysuser()->field('id,name')->find(),
                'info'=>$tehuworks->toArray()
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

            if(is_numeric($post[$key])){
                $gnamekv = config($kv_key);
                return isset($gnamekv[$post[$key]]) ? $gnamekv[$post[$key]] : '';
            }
            return $post[$key];
        };


        $tehuworks->gobeijing_path = $kvname('gobeijing_path','gobeijing_path_kv');//$post['gobeijing_path'];
        $tehuworks->gobeijing_type = $post['gobeijing_type'];

        $tehuworks->tongxi_name = $post['tongxi_name'];
        $tehuworks->tongxi_idnumber = $post['tongxi_idnumber'];
        $tehuworks->tongxi_mobile = $post['tongxi_mobile'];
        if(isset($post['tongxi_idcardpic0'])){
            $tehuworks->tongxi_idcardpic0 = $post['tongxi_idcardpic0'];
        }
        if(isset($post['tongxi_idcardpic1'])){
            $tehuworks->tongxi_idcardpic1 = $post['tongxi_idcardpic1'];
        }

        $tehuworks->acttype_inbeijing = $kvname('acttype_inbeijing','acttype_inbeijing_kv');//$post['acttype_inbeijing'];
        $tehuworks->address_inbeijing = $post['address_inbeijing'];
        if($post['lost_time']){
            $tehuworks->lost_time = $post['lost_time'];
        }
        if($post['find_time']){
            $tehuworks->find_time = $post['find_time'];
        }

        $tehuworks->content = $post['content'];


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