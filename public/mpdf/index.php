<?php

include_once 'mpdf.php';

// 验证POST数据是否为空
//if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
//    echo json_encode(array('code'=>403,'msg'=>'非法请求','data'=>null));
//    return false;
//}

header('Content-Type: application/pdf');
$post = $_GET;
if(!isset($post['content'])) {
    echo json_encode(array('code'=>403,'msg'=>'参数不能为空','data'=>null));
    return false;
}



$config = [
    'header' => isset($post['header']) ? $post['header'] : '',
    'footer' => isset($post['footer']) ? $post['footer'] : '',
    'content' => $post['content'] ,
    'title' => isset($post['title']) ? $post['title'] : '',
    'author' => isset($post['author']) ? $post['author'] : ''
];

$mpdf = new mPDF('utf-8');
$mpdf->SetTitle($config['title']);
$mpdf->SetAuthor($config['author']);
$mpdf->SetHTMLFooter($config['footer']);
$mpdf->SetHTMLHeader($config['header']);

//$mpdf->progressBar = true;
// 设置自动配置语言字体
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($config['content']);

echo $mpdf->Output($config['title'].'.pdf',true);
exit();