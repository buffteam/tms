<?php
/**
 * 页面配置信息
 */
return [
    //分页数量
    'pagesize'=> 15,
    // 导航栏入口列表
    'column' => [
        [
            'name' => 'Gitlab',
            'url' => 'http://172.28.1.116:9999'
        ],
        [
            'name' => 'Jekins持续集成平台',
            'url' => 'http://172.28.1.171:8080/jenkins/'
        ],
        [
            'name' => '敏捷项目管理平台',
            'url' => 'http://172.28.1.4/plmweb/scrum.nsf/scrummain?open'
        ],
        [
            'name' => '大数据查询平台',
            'url' => 'http://172.28.199.58:9380/openbdp/resources/page/checkdata.html#'
        ],
        [
            'name' => 'IM查询',
            'url' => 'http://admin.eebbk.com/webadmin-cas/login?service=http%3A%2F%2Fadmin.eebbk.com%3A10000%2Fwebadmin-authority%2Fauthority%2Fauthorization%2Fnavigation'
        ],
    ],
    'avatar' => 'uploads/avatar/default/avatar02.png'
];