<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 00:54
 */
namespace app\api_v1\controller;
use app\common\controller\ApiCommon;
use think\Response;
use app\api_v1\library\ApiToken;
use app\common\model\Sysusers;

class Common extends ApiCommon{

    protected $datetime = '';
    protected $user_id = 0;
    protected $cur_user = null;

    public function __construct($need_check=false) {
        parent::__construct();

        if($need_check){
            $this->checkAppSafe();
        }
        $this->cur_user = $this->curUser();
        $this->datetime = date('Y-m-d H:i:s');

        if(!$this->powerCheck()){
            return $this->res([
                'code'=>102,
                'msg'=>'权限不足'
            ]);
        }

    }

    protected function checkAppSafe(){

        if(config('is_test')){
            $this->user_id = 1;
            return true;
        }
        $Authorization = $this->request->header('Authorization');

        if(!$Authorization){
            return $this -> res(['code' => 101, 'msg' => '无法访问']);
        }
        $auth_list = explode(':',$Authorization);
        if(count($auth_list)!=2 || !is_numeric($auth_list[0])){
            return $this -> res(['code' => 101, 'msg' => '无法访问.']);
        }
        //for test
        if(config('is_test')){
            return $auth_list[0];
        }

        $res_user_id = Apitoken::checkToken($auth_list[0],trim($auth_list[1]));
        if($res_user_id<=0){
            //
            $resean = [
                 0 =>'用户异常',
                -1 => '您的账户已在其他设备登录，请重新登录',
                -2 =>'Token过期，请重新登录',
                -3 =>'Token过期，请重新登录.'
            ];

            if($res_user_id == -1){
                \app\common\library\Mylog::write($auth_list,'auth');
            }

            return $this -> res([
                'code' => 401,
                'msg' => isset($resean[$res_user_id])?$resean[$res_user_id]:$resean[-3]
            ]);
        }
        $this->user_id = $res_user_id;
        return true;
    }

    protected function curUser(){
        if(!$this->user_id){
            return false;
        }
        $cache_key = config('api_cache_key.cur_user').$this->user_id;
        $user = cache($cache_key);
        /*if($user){
            return $user;
        }*/
        $user = Sysusers::get($this->user_id);
//        print_r($user);
        cache($cache_key,$user->toArray(),300);
        return $user->toArray();
    }

    protected function powerCheck(){
        //$user = Sysusers::get($this->user_id);
        if(!$this->user_id){
            return true;
        }
        if(!$this->cur_user){
            return false;
        }
//        print_r($this->cur_user);
        if(!in_array($this->cur_user['utype'],[1,2,3])){
            return false;
        }

        if($this->cur_user['utype'] == 1){
            return true;
        }
        if($this->cur_user['utype'] == 2){
            if($this->request->isGet()){
                return true;
            }

            return false;
        }
        return true;
    }

    protected function res($data,$code=200){

        $code = (string) $code;
        $data = tostring($data);

        Response::create($data,'json',$code)->send();
    }

}