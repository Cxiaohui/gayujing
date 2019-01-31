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

        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'info'=>$daliyworks->toArray(),
//                'user'=>$daliyworks->sysuser()->field('id,name')->find(),
                'live_photos'=>$daliyworks->photos()->field('id,path')->where('type','=',1)->order('sort asc')->select(),
                'life_photos'=>$daliyworks->photos()->field('id,path')->where('type','=',2)->order('sort asc')->select(),

            ]
        ]);
    }

    public function test(){
        $this->user_id = 1;
        $post = [
            'id'=>1,
            'people_name'=>'陈生',
            'people_idnumber'=>'00000000000',
            'people_mobile'=>'2423432424',
            'people_idcardpic0'=>'people_idcardpic000000',
            'people_idcardpic1'=>'people_idcardpic111111',
            'gobeijing_path'=>'长途客运',
            'content'=>'有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访有人要上访',
            'gotype'=>'赴省上访',
            'action_name'=>'扬言报复',
            'action_desn'=>'扬言报复扬言报复扬言报复',
            'work_content'=>'正常33',
            'live_photos'=>[
                ['id'=>1,'src'=>'live_photos-11'],
                ['id'=>2,'src'=>'live_photos-22'],
                ['id'=>3,'src'=>'live_photos33'],
            ],
            'life_photos'=>[
                ['id'=>4,'src'=>'life_photo-11'],
                ['id'=>5,'src'=>'life_photos-22'],
                ['id'=>6,'src'=>'life_photos-33'],
            ]
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

        $post['post_user_id'] = $this->user_id;
        $daliyworkValidate = new DaliyworkValidate();

        if(!$daliyworkValidate->check($post)){
            return $this->res([
                'code'=>201,
                'msg'=>$daliyworkValidate->getError()
            ]);
        }

        if(isset($post['id']) && $post['id']>0){
            $daliyworks = Daliyworks::get($post['id']);
        }else{
            $daliyworks = new Daliyworks();
        }
        $daliyworks->post_user_id = $this->user_id;
        $daliyworks->status = 1;
        $daliyworks->people_name = $post['people_name'];
        $daliyworks->people_idnumber = $post['people_idnumber'];
        $daliyworks->people_mobile = $post['people_mobile'];
        $daliyworks->people_idcardpic0 = $post['people_idcardpic0'];
        $daliyworks->people_idcardpic1 = $post['people_idcardpic1'];
        $daliyworks->gobeijing_path = $post['gobeijing_path'];
        $daliyworks->content = $post['content'];
        $daliyworks->gotype = $post['gotype'];
        $daliyworks->action_name = $post['action_name'];
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
        foreach($post['live_photos'] as $k=>$lphoto){
            $save = [
                'id'=>$lphoto['id'],
                'work_id'=>$daliyworks->id,
                'type'=>1,
                'sort'=>$k,
                'path'=>$lphoto['src'],
                'isdel'=>0
            ];
            /*if($lphoto['id']>0){
                $save['id'] =
                $wphoto->
            }*/
            $photo_data[] = $save;
        }

        foreach($post['life_photos'] as $k=>$lphoto){
            $photo_data[] = [
                'id'=>$lphoto['id'],
                'work_id'=>$daliyworks->id,
                'type'=>2,
                'sort'=>$k,
                'path'=>$lphoto['src'],
                'isdel'=>0
            ];
        }


        $wphoto->saveAll($photo_data);

//        dump($photo_data);
        return $this->res([
            'code'=>200,
            'msg'=>'上报信息成功'
        ]);
    }

}