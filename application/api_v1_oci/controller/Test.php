<?php
/**
 * Created by PhpStorm.
 * User: xiaohui
 * Date: 2019/2/24
 */
namespace app\api_v1_oci\controller;

class Test extends Common{


    public function addSysuser(){

        $sysuser = new \app\api_v1_oci\model\Sysusers();

        print_r($sysuser::get(2));exit;


        $data = [
            'NAME'=>'测试员1',
            'MOBILE'=>'13322223339',
            'LOGACCOUNT'=>'testman9',
            'LOGPWD'=>'111111',
            'TYPE'=>3,
            'LOGSTAT'=>$sysuser->getLogstat()
        ];
//        print_r($data);exit;
        $vuser = new \app\api_v1_oci\validate\Sysusers();
        if(!$vuser->check($data)){

            print_r( [
                'success'=>false,
                'msg'=>$vuser->getError()
            ]);
        }
        $ID = $sysuser->getNextId();
//        echo $ID;exit;
        $data['ID'] = $ID;
        $sysuser->save($data);
        echo $ID;
    }

}
