<?php
require_once('./tcpdf.php');

$post = $_POST ? $_POST : $_GET;

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);


$title = isset($post['title']) ? $post['title'] : 'stip';
$author = isset($post['author']) ? $post['author'] : 'stip';
if (!isset($post['content'])) {
    echo json_encode(['code' => 403, 'msg' => '请传入导出内容']);
    exit();
}
// 设置文档信息
$pdf->SetCreator($title);
$pdf->SetAuthor('小天才电话手表客户端团队');
$pdf->SetTitle($title);
$pdf->SetSubject($title);
$pdf->SetKeywords('stip, PDF, PHP');
// 设置页眉和页脚信息
$pdf->SetHeaderData(false, 0, 'http://www.omwteam.com', '小天才电话手表客户端团队',
    array(0,64,255), array(0,64,128));
$pdf->setFooterData(false, 0, 'http://www.omwteam.com', '小天才移动Web团队',array(0, 64, 0), array(0, 64, 128));
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
echo $pdf->Output($title . '.pdf', 'I');