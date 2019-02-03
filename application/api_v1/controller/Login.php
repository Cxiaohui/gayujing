<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 00:53
 */
namespace app\api_v1\controller;
use app\common\model\Sysusers;
use app\api_v1\library\ApiToken;

class Login extends Common{

    public function __construct($need_check=false)
    {
        parent::__construct(false);
    }

    public function out(){
        ApiToken::cleanApiToken($this->user_id);
        return $this->res([
            'code'=>200,
            'msg'=>'退出成功'
        ]);
    }

    public function post(){

        if(!$this->request->isPost()){
            return $this->res([
                'code'=>201,
                'msg'=>'访问错误'
            ]);
        }

        $account = $this->request->post('account','','trim');
        $pwd = $this->request->post('pwd','','trim');

        if(!$account || !$pwd){
            return $this->res([
                'code'=>201,
                'msg'=>'请输入账号或密码'
            ]);
        }

        $user = Sysusers::where('mobile',$account)
            ->where('status',1)
            ->where('isdel',0)->find();

        if(!$user){

            $user = Sysusers::where('logaccount',$account)
                ->where('status',1)
                ->where('isdel',0)->find();
        }

        if(!$user){
            return $this->res([
                'code'=>201,
                'msg'=>'账号或密码不正确'
            ]);
        }

        /*print_r([
            $pwd,
            $user->logpwd,
            $user->getPwd($pwd)
        ]);*/

        if($user->logpwd != $user->getPwd($pwd)){
            return $this->res([
                'code'=>201,
                'msg'=>'账号或密码不正确.'
            ]);
        }

        $user_data = $user->returnInfo();
        $user_data['app_token'] = ApiToken::createSaveApiToken($user->id);


        return $this->res([
            'code'=>200,
            'msg'=>'登录成功',
            'data'=>$user_data
        ]);

    }

}