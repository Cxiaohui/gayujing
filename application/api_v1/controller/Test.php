<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 00:28
 */
namespace app\api_v1\controller;
use app\common\model\Sysusers,
    app\common\validate\Sysusers as SysuserValidate;

class Test extends Common{


    public function addSysuser(){

        $sysuser = new Sysusers();

        $data = [
            'name'=>'测试员',
            'mobile'=>'13344445555',
            'logaccount'=>'testman',
            'logpwd'=>'111111',
            'logstat'=>$sysuser->getLogstat()
        ];

        $vuser = new SysuserValidate();
        if(!$vuser->check($data)){

            return [
                'success'=>false,
                'msg'=>$vuser->getError()
            ];
        }
        $sysuser->save($data);
    }

    public function getSysuser(){
        $user = Sysusers::get(1);
        echo $user->getPwd('111111');
        return $user->logpwd;
    }


    public function apiToken(){

//        \app\api_v1\library\ApiToken::createSaveApiToken(1);
        echo \app\api_v1\library\ApiToken::getApiToken(1);

    }
}