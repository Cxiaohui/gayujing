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
        $event = EventsModel::get($id);

        if(!$event){
            return $this->res([
                'code'=>201,
                'msg'=>'该信息不存在或被删除'
            ]);
        }

        $info = $event->toArray();
        $info['can_edit'] = 0;
        if($info['post_user_id'] == $this->user_id){
            $info['can_edit'] = 1;
        }

//        $peoples = $event->peopleList;

        /*if(!empty($peoples)){
            foreach($peoples as $k=>$peo){
                $peoples['']
            }
        }*/

        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'info'=>$info,
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
            'group_name_id'=>3,
            'group_name'=>'军队退役人员',
            'event_cate_id'=>2,
            'event_cate'=>'极端行为',
            'happen_time'=>date('Y-m-d H:i:s'),
            'address'=>'在那很远的地方',
            'people_number'=>2,
            'content'=>'闲的没事干',
            'do_unit_name'=>'那个单位的',
            'people_list'=>[
                ['id'=>0,'name'=>'王五5','idnumber'=>'5555555555','mobile'=>'1115555'],
                ['id'=>0,'name'=>'赵六6','idnumber'=>'66666666','mobile'=>'1116666'],
                ['id'=>0,'name'=>'胡八8','idnumber'=>'8888888888','mobile'=>'1118888'],
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

//        \app\common\library\Mylog::write($post,'events_data');
        /*if(is_string($post['people_list'])){
            $post['people_list'] = json_decode($post['people_list'],1);
        }
        print_r($post);exit;*/
        $post['post_user_id'] = $this->user_id;

        $eventValidate = new EventValidate();

        if(!$eventValidate->check($post)){
            return $this->res([
                'code'=>201,
                'msg'=>$eventValidate->getError()
            ]);
        }
        $status = 1;
        if(isset($post['id']) && $post['id']>0){
            $status = 2;
            $event = EventsModel::get($post['id']);
        }else{
            $event = new EventsModel();
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

        $event->post_user_id = $this->user_id;
        $event->status = $status;
        $event->type = $post['type'];
        //涉及人群处
        $group_name = $kvname('group_name','event_groups_kv');
        $event->group_name_id = $group_name[0];
        $event->group_name = $group_name[1];
        //事件类别处
        $event_cate = $kvname('event_cate','event_cates_kv');
        $event->event_cate_id = $event_cate[0];
        $event->event_cate = $event_cate[1];
        //人数规模处
        $people_number = $kvname('people_number','people_nums_kv');
        $event->people_number_id = $people_number[0];
        $event->people_number = $people_number[1];

        $event->happen_time = $post['happen_time'];
        $event->address = $post['address'];
        $event->content = $post['content'];
        $event->do_unit_name = isset($post['do_unit_name'])?$post['do_unit_name']:'';

        $res = $event->save();

        if(!$res && !$event->id){
            return $this->res([
                'code'=>201,
                'msg'=>'保存信息失败'
            ]);
        }

        $event_people = new EventPeoples();

        $event_people->where('event_id','=',$event->id)->update(['isdel'=>1]);


        if(is_string($post['people_list'])){
            $post['people_list'] = json_decode($post['people_list'],1);
        }

        if(empty($post['people_list'])){
            return $this->res([
                'code'=>200,
                'msg'=>'保存信息成功'
            ]);
        }

        $people_data = [];
        if(!empty($post['people_list'])){

            foreach($post['people_list'] as $peo){
                $save = [
//                'id'=>isset($peo['id'])?$peo['id']:0,
                    'event_id'=>$event->id,
                    'name'=>$peo['name'],
                    'idnumber'=>isset($peo['idnumber'])? $peo['idnumber']:'',
                    'mobile'=>$peo['mobile'],
                    'isdel'=>0
                ];

                if(isset($peo['id']) && $peo['id']>0){
                    $save['id'] = $peo['id'];
                }
                $people_data[] = $save;
            }
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