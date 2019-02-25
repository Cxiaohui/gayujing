<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function create_log_pwd($pwd,$stat){
    return md5($stat.md5($pwd.$stat));
}

function tostring($data){
    if(empty($data)){
        return $data;
    }
    if(is_string($data)){
        return $data;
    }
    foreach($data as $k=>$da){
        if(is_array($da)){
            $data[$k] = tostring($da);
        }else if(is_object($da)){
            $data[$k] = $da;
        }else if(!is_string($da)){
            $data[$k] = (string) $da;
        }
    }
    return $data;
}

function qnimg($src){
    return config('app.qiniu.host').$src;
}