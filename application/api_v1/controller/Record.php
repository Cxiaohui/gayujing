<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/2/1
 * Time: 20:41
 */
namespace app\api_v1\controller;
use think\Db;
use app\common\model\Daliyworks,
    app\common\model\Events,
    app\common\model\Tehuworks;

class Record extends Common{

    public function __construct($need_check=false)
    {
        parent::__construct(true);
    }

    public function index(){

        $where = '';

        if($this->cur_user['type']==3){
            $where = " and post_user_id={$this->user_id}";
        }
        $sql = "select * from 
(select id,'d' as name,gotype as type,post_user_id,update_time from ga_daliyworks where status>0 and isdel=0 {$where}
union 
select id,'e' as name,type,post_user_id,update_time from ga_events where status>0 and isdel=0 {$where}
union 
select id,'t' as name,'' as type,post_user_id,update_time from ga_tehuworks where status>0 and isdel=0 {$where}) as tmp
order by update_time desc
";
        $data = Db::query($sql);

        if(!$data){
            return $this->res([
                'code'=>202,
                'msg'=>'暂无数据'
            ]);
        }

        $names = [
            'd'=>'日常性工作',
            'e'=>'事件',
            't'=>'特护期工作',
        ];
        foreach($data as $k=>$da){
            if($da['name']=='e'){
                $data[$k]['name'] = $da['type']==1?'事件数据采集':'事件预警采集';
            }else{
                $data[$k]['name'] = $names[$da['name']].($da['type']?'-'.$da['type']:'');
            }
            $data[$k]['timestring'] = date('Y年m月d日 H:i',strtotime($da['update_time']));
            $data[$k]['type'] =  $da['name'];
        }


        return $this->res([
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'list'=>$data
            ]
        ]);
    }

    public function cancelReport(){
        if(!$this->request->isPost()){
            return $this->res([
                'code'=>201,
                'msg'=>'访问错误'
            ]);
        }

        $type = $this->request->post('type','','trim');
        $id = $this->request->post('id',0,'int');

        if(!$id || !in_array($type,['d','e','t'])){
            return $this->res([
                'code'=>201,
                'msg'=>'访问错误'
            ]);
        }
        $model = '';
        if($type=='d'){
            $model = new Daliyworks();
        }
        if($type=='e'){
            $model = new Events();
        }

        if($type=='t'){
            $model = new Tehuworks();
        }

        $info = $model->get($id);
//        print_r($info);
        if(!$info){
            return $this->res([
                'code'=>201,
                'msg'=>'数据不存在'
            ]);
        }

        if($info->status==0){
            return $this->res([
                'code'=>200,
                'msg'=>'撤销成功'
            ]);
        }
        $info->status = 0;
        if($info->save()){
            return $this->res([
                'code'=>200,
                'msg'=>'撤销成功'
            ]);
        }

        return $this->res([
            'code'=>201,
            'msg'=>'撤销失败'
        ]);
    }
}