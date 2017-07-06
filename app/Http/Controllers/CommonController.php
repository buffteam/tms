<?php

namespace App\Http\Controllers;
use Knp\Snappy\Pdf;
use App\Notes;
use Dompdf\Dompdf;
use App\Libs\upload;
use Illuminate\Http\Request;

class CommonController extends BaseController
{


    public function mdEditorUpload () {
        if (!isset($_FILES['editormd-image-file'])) {
            return $this->error('参数错误');
        }
        $upload = new upload('editormd-image-file','uploads');
        $param = $upload->uploadFile();
        if ( $param['status'] ) {
            return response()->json(array('success'=>1,'message'=>'上传成功','url'=>$param['data'],'data'=>[$param['data']]));
        }
        return response()->json(array('success'=>0,'message'=>'上传失败','url'=>$param['data'],'data'=>$param['data']));


    }
    public function wangEditorUpload () {
        if (!isset($_FILES['image-file'])) {
            return $this->error('参数错误');
        }
        $upload = new upload('image-file','uploads');
        $param = $upload->uploadFile();
        if ( $param['status'] ) {
            return response()->json(array('errno'=>0,'message'=>'上传成功','data'=>[$param['data']]));
        }
        return response()->json(array('errno'=>1,'message'=>'上传失败','data'=>$param['data']));


    }

    public function export (Request $request)
    {

        $params = $request->input();
        // instantiate and use the dompdf class
        $data = Notes::find(19);





        $myProjectDirectory = '/path/to/my/project';

        $snappy = new Pdf($myProjectDirectory . '/vendor/h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386');

// or

        $snappy = new Pdf($myProjectDirectory . '/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64');

        $snappy = new Pdf('/path/to/binary');

        $snappy->setOption('toc', true);
        $snappy->setOption('xsl-style-sheet', 'http://path/to/stylesheet.xsl');//or local file;

        $snappy->generateFromHtml('<p>Some content</p>', 'test.pdf');

        $dompdf = new Dompdf();
//        var_dump($data->content);
//        return;
        $dompdf->loadHtml(utf8_decode($data->content),'UTF-8');

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();


        // Output the generated PDF to Browser
        $dompdf->stream($data->title);
    }
    public function index ()
    {
        return view('test');
    }
}
