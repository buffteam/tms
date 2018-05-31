<?php

/**
 * Created by PhpStorm.
 * User: gaoliang
 * Date: 2018/5/23
 * Time: 下午4:07
 */
class ConvertJob
{
    public function perform()
    {
        $filename = $this->args["filename"];

        # copy the office file
        fwrite(STDOUT, "start coping ". $filename. "\n");
        shell_exec("cp ../../../files/{$filename} ../uploaded_files/");
        fwrite(STDOUT, "coped ". $filename. " finished\n");

        # Convert the pdf
        fwrite(STDOUT, "start converting ". $filename. "\n");
        shell_exec("unoconv -f pdf ../uploaded_files/{$filename}");
        fwrite(STDOUT, "converted ". $filename. " finished\n");

        # remove the office file
        fwrite(STDOUT, "start removing ". $filename. "\n");
        shell_exec("rm -f ../uploaded_files/{$filename}");
        fwrite(STDOUT, "removed ". $filename. " success\n");
    }
}