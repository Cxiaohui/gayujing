<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        print_r([
            config('app.qiniu.host'),
        ]) ;
        return '0';
    }
    public function sfds()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }


    public function stime(){

        $itime = '2019-02-23';



    }

    public function addblob(){

        $imgurl = qnimg('gaqn/id/201902250043400.jpg');
        $img_blob = file_get_contents($imgurl);
        //$img_blob = addslashes($img_blob);
//        $img_blob = base64_encode($img_blob);
        //oci_new_descriptor(Db::instance(),OCI_D_LOB);
        //exit;

        $mtest = new \app\index\model\Mytest();
        $mtest->getPdo();

        $test = \app\index\model\Mytest::find(1);


        $test->IMG_BLOD = $img_blob;
        $test->save();


//        print_r($test);



    }

    public function oci(){

        /*config([
            'type'=>'\think\oracle\Connection',
            'hostname'=>'localhost',
            'database'=>'xe',
            'username'=>'XIAOHUI',
            'password'=>'123456',
            'hostport'=>'49161',
            'prefix'=>'',
        ],'database');*/

        $test = new \app\index\model\Mytest();

        /*$test->ID = 2;
        $test->NAME = 'testci';
        $test->AGE = 31;*/
//        $id = $test->getNextId("auto_increment");
        $datetime = date('Y-m-d H:i:s');
        $data = [
            'ID'=>2,
            'NAME'=>'test-'.date('His'),
            'AGE'=>rand(18,55),
            'CREATE_TIME'=>Db::raw("to_timestamp('{$datetime}', 'yyyy-mm-dd hh24:mi:ss')")
        ];
        //$test->save(,[],'ID');

//        $test->insert($data);
//
//        echo $id;
//        $test->where(['ID'=>1])->delete();
//        $test->where(['ID'=>2])->delete();
        //to_char(col_time, 'syyyy-mm-dd hh24:mi:ss.ff9')
        $res = $test->Field(['ID','NAME','AGE',Db::raw("to_char(CREATE_TIME, 'yyyy-mm-dd hh24:mi:ss') as CREATE_TIME")])->all();
//        $res = Db::table('test')->select();
//
            /*->insert([
            'id'=>1,
            'name'=>'xiaohui',
            'age'=>22,
            'addtime'=>date('Y-m-d H:i:s')
        ]);*/
            //echo gmstrftime() ;

            /*Db::table('test')->insert([
                'ID'=>5,
                'NAME'=>'testestset',
                'AGE'=>24,
                'ADDTIME'=>`to_timestamp('2018-06-11 22:12:34','yyyy-mm-dd hh24:mi:ss')`
            ]);*/


        print_r($res);

    }

}
