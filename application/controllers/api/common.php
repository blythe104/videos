<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: lindsey
 * Date: 2016/8/10
 * Time: 12:00
 */
class common extends CI_Controller {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->config->load('multiconfig');
        //导入类文件
        $this->load->library('PictureCut/UploadFile');
        $this->load->library('PictureCut/JcropImage');
        //获取配置信息
        $this->config->load('Upfile');
    }



    /**
     * 获取适合年龄配置信息
     * @author lindsey
     * createTime 2016.08.10
     */
    public function ProperAge()
    {
        $AppropriateAge = $this->config->item('age-appropriate');
        json_return(array('ProperAge' => $AppropriateAge));
    }


    /**
     * 上传图片页面显示
     * @author lindsey
     * 时间：2016.08.09
     */
    public function uploadFile()
    {
        $this->load->view('admin/Images.html');
    }

    /**
     * 上传视频页面显示
     * @author lindsey
     * 时间：2016.08.09
     */
    public function uploadVideoHtml()
    {
        $this->load->view('admin/Videos.html');
    }

    /**
     * 图片裁剪
     * @author lindsey
     * 时间：2016.08.09
     */
    public function upload(){
        ob_end_clean();
        if(empty($_FILES)){
            echo "<script> alert('0|文件不存在或超过最大上传限制（2M）');</script>";
            exit;
        }

        $UploadConfig = $this->config->item('upload');

        $maxSize   = $UploadConfig['max_size']; //2M 设置附件上传大小
        $allowExts = $UploadConfig['allowed_types']; // 设置附件上传类型
        $file_save = $UploadConfig['upload_path'].date('Y-m-d')."/";
        if(!is_dir($file_save)){
            mkdir($file_save, 0777, true);
        }
        $upload = new \UploadFile(); // 实例化上传类
        $upload->maxSize    = $maxSize;
        $upload->allowExts  = $allowExts;
        $upload->savePath   = $file_save; // 设置附件
        $upload->saveRule   = time() . sprintf('%04s', mt_rand(0, 1000));
        if (!$upload->upload()) {// 上传错误提示错误信息
            $errormsg = $upload->getErrorMsg();
            $res_str = '0|'.$errormsg;
            echo "<script> alert('".$res_str."');</script>";
        } else {// 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();
            $imgurl = $info[0]['savename'];

            $x = $_POST['x1'];
            $y = $_POST['y1'];
            $w = $_POST['w'];
            $h = $_POST['h'];

            // 图片裁剪
            $pic_name = $file_save . $imgurl;
            $crop = new \JcropImage($file_save, $pic_name, $x, $y, $w, $h, $w, $h);
            $file = $crop->crop();
            // 删除原图
            @unlink($pic_name);
        }
        echo "<script> parent.cutback('".$file."');</script>";
    }


    /**
     * 上传小广告
     */
    public function uploadLittleAdv()
    {
        $UploadConfig = $this->config->item('uploadLAdv');
        $thumbWidth   = $UploadConfig['thumbMaxWidth'];
        $thumbHeight  = $UploadConfig['thumbMaxHeight'];
        $filename = $this->makeThumb($thumbWidth,$thumbHeight);
        echo "<script> parent.cutback('".$filename."');</script>";
    }

    /**
     * 上传大广告
     */
    public function uploadBigAdv()
    {
        $UploadConfig = $this->config->item('uploadLAdv');
        $thumbWidth   = $UploadConfig['thumbMaxWidth'];
        $thumbHeight  = $UploadConfig['thumbMaxHeight'];
        $filename = $this->makeThumb($thumbWidth,$thumbHeight);
        echo "<script> parent.cutback('".$filename."');</script>";
    }

    /**
     * 上传音乐图
     */
    public function uploadMusicImg()
    {
        $UploadConfig = $this->config->item('uploadLAdv');
        $thumbWidth   = $UploadConfig['thumbMaxWidth'];
        $thumbHeight  = $UploadConfig['thumbMaxHeight'];
        $filename = $this->makeThumb($thumbWidth,$thumbHeight);
        echo "<script> parent.cutback('".$filename."');</script>";
    }

    /**
     * 上传电影图片
     */
    public function uploadVideoImg()
    {
        $UploadConfig = $this->config->item('uploadLAdv');
        $thumbWidth   = $UploadConfig['thumbMaxWidth'];
        $thumbHeight  = $UploadConfig['thumbMaxHeight'];
        $filename = $this->makeThumb($thumbWidth,$thumbHeight);
        echo "<script> parent.cutback('".$filename."');</script>";
    }

    /**
     * 缩略图通用方法
     * @param $thumbWidth
     * @param $thumbHeight
     */
    public function makeThumb($thumbWidth,$thumbHeight)
    {
        ob_end_clean();
        if(empty($_FILES)){
            echo "<script> alert('0|文件不存在或超过最大上传限制（8M）');</script>";
            exit;
        }
        $UploadConfig = $this->config->item('upload');

        $maxSize   = $UploadConfig['max_size']; //2M 设置附件上传大小
        $allowExts = $UploadConfig['allowed_types']; // 设置附件上传类型
        $file_save = $UploadConfig['upload_path'].date('Y-m-d')."/";

        if(!is_dir($file_save)){
            mkdir($file_save, 0777, true);
        }
        $upload = new \UploadFile(); // 实例化上传类
        $upload->maxSize    = $maxSize;
        $upload->allowExts  = $allowExts;
        $upload->savePath   = $file_save; // 设置附件
        $upload->saveRule   = time() . sprintf('%04s', mt_rand(0, 1000));
        $upload->thumbMaxWidth = $thumbWidth;
        $upload->thumbMaxHeight = $thumbHeight;
        if (!$upload->upload()) {// 上传错误提示错误信息
            $errormsg = $upload->getErrorMsg();
            $res_str = '0|'.$errormsg;
            echo "<script> alert('".$res_str."');</script>";
        } else {// 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();
            return $info[0]['savename'];
        }
    }

    /**
     * 上传视频文件
     * @author lindsey
     * create_time 2016.08.12
     */
    public function uploadVideos()
    {
        error_reporting(0);
        if(empty($_FILES)){
            echo "<script> alert('0|文件不存在或超过最大上传限制（8M）');</script>";
            exit;
        }

        //导入类文件
        $this->load->library('PictureCut/UploadFile');

        //获取配置信息
        $this->config->load('Upfile');
        $UploadConfig = $this->config->item('uploadVideos');

        $maxSize   = $UploadConfig['max_size']; //2M 设置附件上传大小
        $allowExts = $UploadConfig['allowed_types']; // 设置附件上传类型
        $file_save = $UploadConfig['upload_path'].date('Y-m-d')."/";
        if(!is_dir($file_save)){
            mkdir($file_save, 0777, true);
        }
        $upload = new \UploadFile(); // 实例化上传类
        $upload->maxSize    = $maxSize;
        $upload->allowExts  = $allowExts;
        $upload->savePath   = $file_save; // 设置附件
        $upload->saveRule   = time() . sprintf('%04s', mt_rand(0, 1000));

        $res_str = '';
        if (!$upload->upload()) {// 上传错误提示错误信息
            $errormsg = $upload->getErrorMsg();
            $res_str = '0|'.$errormsg;
            echo "<script> alert('".$res_str."');</script>";
        } else {// 上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();
            $imgurl = $info[0]['savename'];
        }
        echo "<script> parent.uploadBack('".$file_save.$imgurl."');</script>";
    }

}