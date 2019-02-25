<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 01:05
 */
namespace app\api_v1\controller;
use app\common\model\Daliyworks;
use app\common\model\WorksPhotos;
use app\common\validate\Daliywork as DaliyworkValidate;

class Daliys extends Common{

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
        $daliyworks = Daliyworks::get($id);

        if(!$daliyworks){
            return $this->res([
                'code'=>201,
                'msg'=>'该信息不存在或被删除'
            ]);
        }
        $info = $daliyworks->toArray();
        $info['people_idcardpic0'] = qnimg($info['people_idcardpic0']);
        $info['people_idcardpic1'] = qnimg($info['people_idcardpic1']);
        $live_photos = $daliyworks->photos()->field('id,path')->where('type','=',1)->order('sort asc')->select();

        if(!empty($live_photos)){
            foreach($live_photos as $k=>$ph){
                $live_photos[$k]['file_url'] = qnimg($ph['path']);
            }
        }

        $life_photos = $daliyworks->photos()->field('id,path')->where('type','=',2)->order('sort asc')->select();

        if(!empty($life_photos)){
            foreach($life_photos as $sk=>$sph){
                $life_photos[$sk]['file_url'] = qnimg($sph['path']);
            }
        }


        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'info'=>$info,
//                'user'=>$daliyworks->sysuser()->field('id,name')->find(),
                'live_photos'=>$live_photos,
                'life_photos'=>$life_photos,

            ]
        ]);
    }

    public function test(){
        $this->user_id = 1;
        $post = [
            //'id'=>1,
            'people_name'=>'陈生ss',
            'people_idnumber'=>'00000000000',
            'people_mobile'=>'33333333',
            'people_idcardpic0'=>'people_idcardpic7777',
            'people_idcardpic1'=>'people_idcardpic999999',
            'gobeijing_path'=>'长途客运',
            'content'=>'有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访',
            'gotype'=>'赴省上访',
            'action_name'=>'扬言报复',
            'action_desn'=>'扬言报复扬言报复扬言报复',
            'work_content'=>'正常33',
            'live_photos'=>[
                ['id'=>0,'src'=>'live_photos-11'],
                ['id'=>0,'src'=>'live_photos-22'],
                ['id'=>0,'src'=>'live_photos33'],
            ],
            'life_photos'=>[
                ['id'=>0,'src'=>'life_photo-11'],
                ['id'=>0,'src'=>'life_photos-22'],
                ['id'=>0,'src'=>'life_photos-33'],
            ]
        ];


        $post = [
            'people_name' => '31212313',
    'people_idnumber' => '31231231',
    'people_mobile' => '31231231',
    'people_idcardpic0' => 'gongan/id/201902241254200.jpg',
        'people_idcardpic1' => 'gongan/id/201902241254250.jpg',
        'content' => '31231',
    'gobeijing_path_id' => 3,
    'gobeijing_path' => '自驾车',
        'gotype_id' => 2,
    'gotype' =>'赴省上访',
        'action_name_id' => 1,
    'action_name' => '外围查找',
        'action_desn' => '哦请问哦请问',
        'work_content' => '哦请问哦去',
        'live_photos' => '[{"id":"0","live_photo":"gongan/work/201902241254530.jpg"},{"id":"0","live_photo":"gongan/work/201902241254531.jpg"},{"id":"0","live_photo":"gongan/work/201902241254533.jpg"},{"id":"0","live_photo":"gongan/work/201902241254532.jpg"}]',
    'life_photos' => '[{"id":"0","life_photo":"gongan/life/201902241255001.jpg"},{"id":"0","life_photo":"gongan/life/201902241255000.jpg"},{"id":"0","life_photo":"gongan/life/201902241255003.jpg"},{"id":"0","life_photo":"gongan/life/201902241255002.jpg"}]'
        ];
        return $this->post($post);
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

        \app\common\library\Mylog::write($post,'daliys_data');

        $post['post_user_id'] = $this->user_id;
        $daliyworkValidate = new DaliyworkValidate();

        if(!$daliyworkValidate->check($post)){
            return $this->res([
                'code'=>201,
                'msg'=>$daliyworkValidate->getError()
            ]);
        }
        $status = 1;
        if(isset($post['id']) && $post['id']>0){
            $status = 2;
            $daliyworks = Daliyworks::get($post['id']);
        }else{
            $daliyworks = new Daliyworks();
        }
        $daliyworks->post_user_id = $this->user_id;
        $daliyworks->status = $status;
        $daliyworks->people_name = $post['people_name'];
        $daliyworks->people_idnumber = $post['people_idnumber'];
        $daliyworks->people_mobile = $post['people_mobile'];

        if(isset($post['people_idcardpic0'])){
            $daliyworks->people_idcardpic0 = $post['people_idcardpic0'];
        }
        if(isset($post['people_idcardpic1'])){
            $daliyworks->people_idcardpic1 = $post['people_idcardpic1'];
        }

        $kvname = function($key,$kv_key) use ($post){

            if(is_numeric($post[$key])){
                $gnamekv = config($kv_key);
                return isset($gnamekv[$post[$key]]) ? $gnamekv[$post[$key]] : '';
            }
            return $post[$key];
        };

        $daliyworks->gobeijing_path = $kvname('gobeijing_path','gobeijing_path_kv');//$post['gobeijing_path'];
        $daliyworks->content = $post['content'];
        $daliyworks->gotype = $kvname('gotype','gotype_kv');//$post['gotype'];
        $daliyworks->action_name = $kvname('action_name','action_names_kv');//$post['action_name'];
        $daliyworks->action_desn = $post['action_desn'];
        $daliyworks->work_content = $post['work_content'];

        $res = $daliyworks->save();

        if(!$res && !$daliyworks->id){
            return $this->res([
                'code'=>201,
                'msg'=>'上报信息失败'
            ]);
        }
        $wphoto = new WorksPhotos();

        $wphoto->where('work_id','=',$daliyworks->id)->update(['isdel'=>1]);

        $photo_data = [];
        if(!empty($post['live_photos'])){

            if(is_string($post['live_photos'])){
                $post['live_photos'] = json_decode($post['live_photos'],1);
            }

            foreach($post['live_photos'] as $k=>$lphoto){
                $save = [
//                    'id'=>isset($lphoto['id'])?$lphoto['id']:0,
                    'work_id'=>$daliyworks->id,
                    'type'=>1,
                    'sort'=>$k,
                    'path'=>$lphoto['src'],
                    'isdel'=>0
                ];
                if(isset($lphoto['id']) && $lphoto['id']>0){
                    $save['id'] = $lphoto['id'];
                }
                $photo_data[] = $save;
            }
        }

        if(!empty($post['life_photos'])){

            if(is_string($post['life_photos'])){
                $post['life_photos'] = json_decode($post['life_photos'],1);
            }

            foreach($post['life_photos'] as $k=>$lphoto){
                $save = [
//                    'id'=>isset($lphoto['id'])?$lphoto['id']:0,
                    'work_id'=>$daliyworks->id,
                    'type'=>2,
                    'sort'=>$k,
                    'path'=>$lphoto['src'],
                    'isdel'=>0
                ];

                if(isset($lphoto['id']) && $lphoto['id']>0){
                    $save['id'] = $lphoto['id'];
                }
                $photo_data[] = $save;
            }
        }

        if(!empty($photo_data)){
            $wphoto->saveAll($photo_data);
        }

//        dump($photo_data);
        return $this->res([
            'code'=>200,
            'msg'=>'上报信息成功'
        ]);
    }

}