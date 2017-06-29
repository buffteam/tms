<?php
namespace App\Libs;

class upload {
	protected $fileName;
	protected $maxSize;
	protected $allowMime;
	protected $allowExt;
	protected $uploadPath;
	protected $imgFlag;
	protected $fileInfo;
	protected $error;
	protected $ext;
	/**
	 * @param string $fileName
	 * @param string $uploadPath
	 * @param string $imgFlag
	 * @param number $maxSize
	 * @param array $allowExt
	 * @param array $allowMime
	 */
	public function __construct($fileName='myFile',$uploadPath='./uploads',$imgFlag=true,$maxSize=5242880,$allowExt=array('jpeg','jpg','png','gif'),$allowMime=array('image/jpeg','image/png','image/gif')){
		$this->fileName=$fileName;
		$this->maxSize=$maxSize;
		$this->allowMime=$allowMime;
		$this->allowExt=$allowExt;
		$this->uploadPath=$uploadPath;
		$this->imgFlag=$imgFlag;
		$this->fileInfo=$_FILES[$this->fileName];
	}
	/**
	 * �?测上传文件是否出�?
	 * @return boolean
	 */
	protected function checkError(){
		if(!is_null($this->fileInfo)){
			if($this->fileInfo['error']>0){
				switch($this->fileInfo['error']){
					case 1:
						$this->error='超过了PHP配置文件中upload_max_filesize选项的�??';
						break;
					case 2:
						$this->error='超过了表单中MAX_FILE_SIZE设置的�??';
						break;
					case 3:
						$this->error='文件部分被上�?';
						break;
					case 4:
						$this->error='没有选择上传文件';
						break;
					case 6:
						$this->error='没有找到临时目录';
						break;
					case 7:
						$this->error='文件不可�?';
						break;
					case 8:
						$this->error='由于PHP的扩展程序中断文件上�?';
						break;
						
				}
				return false;
			}else{
				return true;
			}
		}else{
			$this->error='文件上传出错';
			return false;
		}
	}
	/**
	 * �?测上传文件的大小
	 * @return boolean
	 */
	protected function checkSize(){
		if($this->fileInfo['size']>$this->maxSize){
			$this->error='上传文件过大';
			return false;
		}
		return true;
	}
	/**
	 * �?测扩展名
	 * @return boolean
	 */
	protected function checkExt(){
		$this->ext=strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
		if(!in_array($this->ext,$this->allowExt)){
			$this->error='不允许的扩展�?';
			return false;
		}
		return true;
	}
	/**
	 * �?测文件的类型
	 * @return boolean
	 */
	protected function checkMime(){
		if(!in_array($this->fileInfo['type'],$this->allowMime)){
			$this->error='不允许的文件类型';
			return false;
		}
		return true;
	}
	/**
	 * �?测是否是真实图片
	 * @return boolean
	 */
	protected function checkTrueImg(){
		if($this->imgFlag){
			if(!@getimagesize($this->fileInfo['tmp_name'])){
				$this->error='不是真实图片';
				return false;
			}
			return true;
		}
	}
	/**
	 * �?测是否�?�过HTTP POST方式上传上来�?
	 * @return boolean
	 */
	protected function checkHTTPPost(){
		if(!is_uploaded_file($this->fileInfo['tmp_name'])){
			$this->error='文件不是通过HTTP POST方式上传上来�?';
			return false;
		}
		return true;
	}
	/**
	 *显示错误 
	 */
	protected function showError(){
		exit('<span style="color:red">'.$this->error.'</span>');
	}
	/**
	 * �?测目录不存在则创�?
	 */
	protected function checkUploadPath(){
		if(!file_exists($this->uploadPath)){
			mkdir($this->uploadPath,0777,true);
		}
	}
	/**
	 * 产生唯一字符�?
	 * @return string
	 */
	protected function getUniName(){
		return md5(uniqid(microtime(true),true));
	}
	/**
	 * 上传文件
	 * @return string
	 */
	public function uploadFile(){
		if($this->checkError()&&$this->checkSize()&&$this->checkExt()&&$this->checkMime()&&$this->checkTrueImg()&&$this->checkHTTPPost()){
			$this->checkUploadPath();
			$this->uniName=$this->getUniName();
			$this->destination=$this->uploadPath.'/'.$this->uniName.'.'.$this->ext;
			if(@move_uploaded_file($this->fileInfo['tmp_name'], $this->destination)){
				return  $this->destination;
			}else{
				$this->error='文件移动失败';
				$this->showError();
			}
		}else{
			$this->showError();
		}
	}
}



