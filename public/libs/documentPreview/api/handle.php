<?php

date_default_timezone_set('GMT');
require_once __DIR__."/../vendor/autoload.php";
require_once "config.php";

$file=$_POST['trans_data'];

/**
 * JSON Response
 * @param $code
 * @param $msg
 * @param $data
 */
function json_response($code, $msg, $data) {
    echo json_encode([
        'code' => $code,
        'msg' => $msg,
        'data' => $data
    ]);
    exit(0);
}

/**
 * 添加转换事件到redis然后等待工作结束
 * @param $filename
 * @return bool
 */
function wait_conversion($filename) {
    Resque::setBackend(REDIS_BACKEND);

    $args = array(
        'filename' => $filename
    );

    $jobId = Resque::enqueue('default', "ConvertJob", $args, true);

    $status = new Resque_Job_Status($jobId);
    if(!$status->isTracking()) {
        return false;
    }

    do {
        $code = $status->get();
        sleep(1);
    }while($code != 4 && $code != 3);
    return $code == 4;
}

// 转换文档
$is_success = wait_conversion($file);

// 返回结果
if ($is_success) {
    $href = "http://127.0.0.1:8000/libs/documentPreview/uploaded_files/{$file}.pdf";
    json_response(0, "success", ["href" => $href]);
} else {
    json_response(1, "conversion failed", "");
}
