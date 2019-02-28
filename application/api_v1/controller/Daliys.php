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


        $xinfang_cates = ['','个访','集访'];
        $info['xinfang_cate'] = $xinfang_cates[$info['xinfang_cate_id']];


        $info['can_edit'] = 0;
        if($info['post_user_id'] == $this->user_id){
            $info['can_edit'] = 1;
        }

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
        'gotype_id' => 1,
    'gotype' =>'直达',
        'action_name_id' => 1,
            'action_name'=>'扬言报复',
            'xinfang_type_id'=>1,
            'xinfang_type'=>'sdf',
    'suqiu_type_id' => 2,
            'gobeijing_act_id'=>1,
            'suqiu_content'=>'上访诉求',
        'action_desn' => '哦请问哦请问',
        'work_content' => '哦请问哦去',
        'live_photos' => '[{"id":"0","src":"gongan/work/201902241254530.jpg"},{"id":"0","src":"gongan/work/201902241254531.jpg"},{"id":"0","src":"gongan/work/201902241254533.jpg"},{"id":"0","src":"gongan/work/201902241254532.jpg"}]',
    'life_photos' => '[{"id":"0","src":"gongan/life/201902241255001.jpg"},{"id":"0","src":"gongan/life/201902241255000.jpg"},{"id":"0","src":"gongan/life/201902241255003.jpg"},{"id":"0","src":"gongan/life/201902241255002.jpg"}]'
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

//        \app\common\library\Mylog::write($post,'daliys_data');

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

            //检查是否是编辑本人的信息
            if($daliyworks->post_user_id != $this->user_id){
                return $this->res([
                    'code'=>201,
                    'msg'=>'当前账号无权修改'
                ]);
            }



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
        $gobj_path = $kvname('gobeijing_path','gobeijing_path_kv');
        $daliyworks->gobeijing_path_id = $gobj_path[0];
        $daliyworks->gobeijing_path = $gobj_path[1];
        //进京方式
        $gotype = $kvname('gotype','gobeijing_types_kv');
        $daliyworks->gotype_id = $gotype[0];
        $daliyworks->gotype = $gotype[1];
        //绕道
        $raodao = $kvname('raodao','raodaos_kv');
        $daliyworks->raodao_id = $raodao[0];
        $daliyworks->raodao = $raodao[1];

        //过激行为
        $action_name = $kvname('action_name','action_names_kv');
        $daliyworks->action_name_id = $action_name[0];
        $daliyworks->action_name = $action_name[1];
        //信访诉求
        $suqiu_type = $kvname('suqiu_type','suqiu_types_kv');

        $daliyworks->suqiu_type_id = $suqiu_type[0];
        $daliyworks->suqiu_type = $suqiu_type[1];
        //信访行为
        $xinfang_type = $kvname('xinfang_type','gotype_kv');
        //print_r($xinfang_type);exit;
        $daliyworks->xinfang_type_id = $xinfang_type[0];
        $daliyworks->xinfang_type = $xinfang_type[1];
        //进京行为类型
        $gobeijing_act = $kvname('gobeijing_act','acttype_inbeijing_kv');
        $daliyworks->gobeijing_act_id = $gobeijing_act[0];
        $daliyworks->gobeijing_act = $gobeijing_act[1];

        //详细诉求
        $daliyworks->content = $post['content'];
        //上访诉求
        $daliyworks->suqiu_content = $post['suqiu_content'];
        //行为描述
        $daliyworks->action_desn = $post['action_desn'];
        //走访工作
        $daliyworks->work_content = $post['work_content'];

        $daliyworks->xinfang_cate_id = $post['xinfang_cate_id'];


        //exit;
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