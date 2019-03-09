<?php
/**
 * Created by PhpStorm.
 * User: xiaohui
 * Date: 2019/2/24
 */
namespace app\api_v1_oci\controller;

use think\Db;

class Test extends Common{


    public function t2(){
        print_r(config('database.'));
    }

    /**
     * 将图片以二进制方式存入数据库中
     * 问题1：ORA-22990: LOB locators cannot span transactions
     * 方法：ocifreedesc()移到ocicommit()之前，ociexecute($stmt,OCI_DEFAULT); 加上OCI_DEFAULT参数
     * 问题2：读取图片显示一片黑
     * 方法：用stream_get_contents获取blob的stream流
     * 问题3：多张图片插入
     * 参考：https://www.cnblogs.com/Caersi/p/7451007.html
     * 问题4：中文乱码
     * 方法：oci_connect 第4个参数加 utf8
     */
    public function ociop(){
        $data = [
            'id'=>3,
            'name'=>'中文乱不乱',
            'age'=>'24',
            'img_blod'=>'raw:EMPTY_BLOB()',
            'img2_blob'=>'raw:EMPTY_BLOB()',
        ];

        $returning = [
            'img_blod'=>':img_bold',
            'img2_blob'=>':img2_bolb'
        ];

        $blob_datas = [
            'img_blod'=>file_get_contents('http://pnd68waxi.bkt.clouddn.com/gaqn/id/201902241555250.jpg'),
            'img2_blob'=>file_get_contents('http://pnd68waxi.bkt.clouddn.com/gaqn/id/201902250043180.jpg')
        ];


        $ocle = \app\common\library\MyOracle::instance();
        $res = $ocle->insertWithBlob('MYTEST2',$data,$returning,$blob_datas);

        var_dump([
            $res,
            $ocle->getError()
        ]);
    }


    public function getoriimg($id=0,$filed=''){
        if(!$id){
            return ['not found'];
        }
        $info = \app\index\model\Mytest::find($id);
        if(!$info){
            return ['not found'];
        }

        header('Content-type: image/jpg');
        echo stream_get_contents($info->IMG_BLOD);
        exit;
    }

    public function addSysuser(){

        $sysuser = new \app\api_v1_oci\model\Sysusers();

        print_r($sysuser::get(1));exit;


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
