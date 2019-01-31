<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 01:02
 */
namespace app\api_v1\controller;
use app\common\model\Sysusers;

class Me extends Common{

    public function __construct($need_check=false)
    {
        parent::__construct(false);
        $this->user_id = 1;
    }

    public function index(){



    }


    public function info(){

        $user = Sysusers::where('status','=',1)->where('isdel','=',0)
            ->find($this->user_id);

        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'info'=>$user->returnInfo()
            ]
        ]);
    }

    public function test(){

        $post = [
            'new_pwd'=>'222222',
            'new_pwd2'=>'222222',
            'old_pwd'=>'111111',
        ];
        return $this->updatepwd($post);
    }

    public function updatepwd($post=[]){

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

        if($post['new_pwd'] != $post['new_pwd2']){
            return $this->res([
                'code'=>201,
                'msg'=>'两次密码不一致'
            ]);
        }

        $user = Sysusers::find($this->user_id);

        $old_pwd = $user->getPwd($post['old_pwd']);
        /*print_r([
            $post,
            $old_pwd,
            $user->logpwd,
            $user->getPwd(trim($post['new_pwd']))
        ]);*/
        if($old_pwd != $user->logpwd){
            return $this->res([
                'code'=>201,
                'msg'=>'原密码不正确'
            ]);
        }

//        $user->logpwd = $user->getPwd(trim($post['new_pwd']));
        $user->logpwd = trim($post['new_pwd']);
        $res = $user->save();

        if($res){
            return $this->res([
                'code'=>200,
                'msg'=>'修改密码成功'
            ]);
        }

        return $this->res([
            'code'=>201,
            'msg'=>'修改密码失败'
        ]);
    }

}