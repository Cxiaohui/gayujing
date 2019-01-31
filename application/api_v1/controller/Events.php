<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/31
 * Time: 01:05
 */
namespace app\api_v1\controller;
use app\common\model\Events as EventsModel;
use app\common\model\EventPeoples;
use app\common\validate\Event as EventValidate;

class Events extends Common{


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
        $event = EventsModel::get($id);

        if(!$event){
            return $this->res([
                'code'=>201,
                'msg'=>'该信息不存在或被删除'
            ]);
        }

        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'info'=>$event->toArray(),
//                'user'=>$daliyworks->sysuser()->field('id,name')->find(),
                'peoples'=>$event->peopleList
            ]
        ]);
    }

    public function test(){
        $this->user_id = 1;
        $post = [
            'id'=>1,
            'type'=>1,
            'group_name'=>'军队退役人员',
            'event_cate'=>'极端行为',
            'happen_time'=>date('Y-m-d H:i:s'),
            'address'=>'在那很远的地方',
            'people_number'=>'20-50人',
            'content'=>'闲的没事干',
            'do_unit_name'=>'那个单位的',
            'people_list'=>[
                ['id'=>1,'name'=>'王五5','idnumber'=>'5555555555','mobile'=>'1115555'],
                ['id'=>2,'name'=>'赵六6','idnumber'=>'66666666','mobile'=>'1116666'],
                ['id'=>3,'name'=>'胡八8','idnumber'=>'8888888888','mobile'=>'1118888'],
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

        $eventValidate = new EventValidate();

        if(!$eventValidate->check($post)){
            return $this->res([
                'code'=>201,
                'msg'=>$eventValidate->getError()
            ]);
        }

        if(isset($post['id']) && $post['id']>0){
            $event = EventsModel::get($post['id']);
        }else{
            $event = new EventsModel();
        }

        $event->post_user_id = $this->user_id;
        $event->status = 1;
        $event->type = $post['type'];
        $event->group_name = $post['group_name'];
        $event->event_cate = $post['event_cate'];
        $event->happen_time = $post['happen_time'];
        $event->address = $post['address'];
        $event->people_number = $post['people_number'];
        $event->content = $post['content'];
        $event->do_unit_name = $post['do_unit_name'];

        $res = $event->save();

        if(!$res && !$event->id){
            return $this->res([
                'code'=>201,
                'msg'=>'保存信息失败'
            ]);
        }

        $event_people = new EventPeoples();

        $event_people->where('event_id','=',$event->id)->update(['isdel'=>1]);

        if(empty($post['people_list'])){
            return $this->res([
                'code'=>202,
                'msg'=>'保存信息成功'
            ]);
        }

        $people_data = [];

        foreach($post['people_list'] as $peo){
            $save = [
//                'id'=>isset($peo['id'])?$peo['id']:0,
                'event_id'=>$event->id,
                'name'=>$peo['name'],
                'idnumber'=>$peo['idnumber'],
                'mobile'=>$peo['mobile'],
                'isdel'=>0
            ];

            if(isset($peo['id']) && $peo['id']>0){
                $save['id'] = $peo['id'];
            }
            $people_data[] = $save;
        }

        if(!empty($people_data)){
            $event_people->saveAll($people_data);
//            print_r($people_data);
        }


//        dump($people_data);

        return $this->res([
            'code'=>200,
            'msg'=>'保存信息成功'
        ]);
    }
}