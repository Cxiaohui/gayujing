<?php
namespace app\api_v1\controller;
use app\common\model\Tielu as TieluModel;

class Tielu extends Common
{

    public function __construct($need_check = false)
    {
        parent::__construct(true);
    }

    public function index()
    {

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
        if(!isset($post['content']) || !$post['content']){

            return $this->res([
                'code'=>201,
                'msg'=>'请填写预警内容'
            ]);

        }

        if(isset($post['id']) && $post['id']>0){

            $tielu = TieluModel::find($post['id']);
            //检查是否是编辑本人的信息
            if($tielu->post_user_id != $this->user_id){
                return $this->res([
                    'code'=>201,
                    'msg'=>'当前账号无权修改'
                ]);
            }
        }else{
            $tielu = new TieluModel();

        }
        $tielu->post_user_id = $this->user_id;
        $tielu->content = $post['content'];

        $res = $tielu->save();


        if($res){
            return $this->res([
                'code'=>200,
                'msg'=>'预警信息提交成功'
            ]);
        }
        return $this->res([
            'code'=>201,
            'msg'=>'预警信息提交失败'
        ]);
    }

}