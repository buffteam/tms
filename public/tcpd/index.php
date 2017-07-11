<?php
//use Illuminate\Support\Facades\DB;
//use App\Notes;
require_once('./tcpdf.php');
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
//$data= DB::table('notes')->find(19);
//var_dump($data);
$post = $_POST ? $_POST : $_GET;
//var_dump($post['content']);
//exit();
$title = isset($post['title']) ? $post['title'] : 'test';

if (!isset($post['content'])) {
    echo  json_encode(['code'=>403,'msg'=>'请传入导出内容']);
    exit();
}
// 设置文档信息
$pdf->SetCreator('Helloweba');
$pdf->SetAuthor('yueguangguang');
$pdf->SetTitle($title);
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, PHP');

// 设置页眉和页脚信息
//$pdf->SetHeaderData('logo.png', 30, 'Helloweba.com', '致力于WEB前端技术在中国的应用',
//    array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// 设置页眉和页脚字体
$pdf->setHeaderFont(Array('stsongstdlight', '', '10'));
$pdf->setFooterFont(Array('helvetica', '', '8'));

// 设置默认等宽字体
$pdf->SetDefaultMonospacedFont('courier');

// 设置间距
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// 设置分页
$pdf->SetAutoPageBreak(TRUE, 25);

// set image scale factor
$pdf->setImageScale(1.25);

// set default font subsetting mode
$pdf->setFontSubsetting(true);

//设置字体
$pdf->SetFont('stsongstdlight', '', 14);

$pdf->AddPage();

header('Content-Type: application/pdf');

$pdf->writeHTML($post['content'], true, false, true, false, '');

//输出PDF
echo $pdf->Output($title.'.pdf', 'I');