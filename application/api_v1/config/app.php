<?php
/**
 * Created by PhpStorm.
 * User: chenxh
 * Date: 2019/1/30
 * Time: 23:00
 */
return [
    'is_test' => true,
    'default_return_type'    => 'json',
    //
    'api_cache_key'=>[
        'cur_user'=>'curuser:',
        'app_token'=>'gaapitoken:'
    ],

    //
    'gobeijing_path'=>[
        ['id'=>1,'name'=>'铁路'],
        ['id'=>2,'name'=>'民航'],
        ['id'=>3,'name'=>'自驾车'],
        ['id'=>4,'name'=>'物流车'],
        ['id'=>5,'name'=>'长途客运'],
        ['id'=>6,'name'=>'不详'],
    ],
    'acttype_inbeijing'=>[
        ['id'=>1,'name'=>'外围查找'],
        ['id'=>2,'name'=>'北京分流'],
        ['id'=>3,'name'=>'非访登记']
    ],
    'gotype'=>[
        ['id'=>1,'name'=>'进京上访'],
        ['id'=>2,'name'=>'赴省上访'],
        ['id'=>3,'name'=>'到市上访'],
        ['id'=>4,'name'=>'县区上访'],
        ['id'=>5,'name'=>'其他上访'],
    ],
    'action_names'=>[
        ['id'=>1,'name'=>'扬言自杀'],
        ['id'=>2,'name'=>'扬言爆炸'],
        ['id'=>3,'name'=>'扬言报复'],
    ],
    'event_groups'=>[
        ['id'=>1,'name'=>'拆迁'],
        ['id'=>2,'name'=>'军队退役人员'],
        ['id'=>3,'name'=>'企业改制'],
        ['id'=>4,'name'=>'投资参与受损'],
        ['id'=>5,'name'=>'涉法涉诉'],
        ['id'=>6,'name'=>'其他社会面']
    ],
    'event_cates'=>[
        ['id'=>1,'name'=>'上访'],
        ['id'=>2,'name'=>'堵塞公共道路\场所'],
        ['id'=>3,'name'=>'罢工/罢运'],
        ['id'=>4,'name'=>'极端行为'],
    ],

    //role
    'role'=>[
        1=>'超级用户',//超级用户,对所有数据均可添，删，改查
        2=>'浏览权限用户',//浏览权限用户，可查看所有账号上传的内容。不能进行删除和重新编辑，仅支持浏览。
        3=>'个人权限用户'//个人权限账号：查看本账号所上传的内容。可以进行删除和重新编辑
    ]
];