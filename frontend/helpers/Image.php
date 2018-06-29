<?php 
namespace frontend\helpers;

use yii;
/**
* 图片处理类
*/
class Image
{
    public static function crop($imageurl, $time, $cropimg_w = 120, $img_quality = 100)
    {
        $imgurl = $imageurl;
        $imginfor = getimagesize($imgurl);
        $type = $imginfor['mime'];
        switch(strtolower($type))
        {
            case 'image/png':
                $img_r = imagecreatefrompng($imgurl);
                $source_image = imagecreatefrompng($imgurl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgurl);
                $source_image = imagecreatefromjpeg($imgurl);
                error_log("jpg");
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgurl);
                $source_image = imagecreatefromgif($imgurl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }
        $imgInitW = imagesx($source_image);
        $imgInitH = imagesy($source_image);
        $minlength = min($imgInitW, $imgInitH);
        if($minlength < $cropimg_w){
            $response = [
                'status' => 'error',
                'message' => '上传图片太小',
            ];
            return $response;
        }
        if($imgInitH <= $imgInitW){
            $cropx1 = ($imgInitW - $imgInitH) / 2;
            $cropy1 = 0;
            $cropw = $imgInitH;
            $croph = $imgInitH;
        }else{
            $cropy1 = ($imgInitH - $imgInitW) / 2;
            $cropx1 = 0;
            $cropw = $imgInitW;
            $croph = $imgInitW;
        }
        $croped_img = imagecrop($source_image, ['x' => $cropx1, 'y' => $cropy1, 'width' => $cropw, 'height' => $croph]);
        $final_image = imagecreatetruecolor($cropimg_w, $cropimg_w);
        imagecopyresampled($final_image, $croped_img, 0, 0, 0, 0, $cropimg_w, $cropimg_w, $cropw, $croph);
        $output_filename = 'statics/images/avatar/'.$time.'.jpg';
        if(imagejpeg($final_image, $output_filename, $img_quality)){
            $response = [
                'status' => 'success',
                'imgurl' => '/'.$output_filename,
            ];
            return $response;
        }
    }
    public static function qrCrop($imageurl, $time, $cropimg_w = 150, $img_quality = 100)
    {
        $imgurl = $imageurl;
        $imginfor = getimagesize($imgurl);
        $type = $imginfor['mime'];
        switch(strtolower($type))
        {
            case 'image/png':
                $img_r = imagecreatefrompng($imgurl);
                $source_image = imagecreatefrompng($imgurl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgurl);
                $source_image = imagecreatefromjpeg($imgurl);
                error_log("jpg");
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgurl);
                $source_image = imagecreatefromgif($imgurl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }
        $imgInitW = imagesx($source_image);
        $imgInitH = imagesy($source_image);
        $minlength = min($imgInitW, $imgInitH);
        if($minlength < $cropimg_w){
            $response = [
                'status' => 'error',
                'message' => '上传图片太小',
            ];
            return $response;
        }
        if($imgInitH <= $imgInitW){
            $cropx1 = ($imgInitW - $imgInitH) / 2;
            $cropy1 = 0;
            $cropw = $imgInitH;
            $croph = $imgInitH;
        }else{
            $cropy1 = ($imgInitH - $imgInitW) / 2;
            $cropx1 = 0;
            $cropw = $imgInitW;
            $croph = $imgInitW;
        }
        $croped_img = imagecrop($source_image, ['x' => $cropx1, 'y' => $cropy1, 'width' => $cropw, 'height' => $croph]);
        $final_image = imagecreatetruecolor($cropimg_w, $cropimg_w);
        imagecopyresampled($final_image, $croped_img, 0, 0, 0, 0, $cropimg_w, $cropimg_w, $cropw, $croph);
        $output_filename = 'statics/images/qrcode/'.$time.'.jpg';
        if(imagejpeg($final_image, $output_filename, $img_quality)){
            $response = [
                'status' => 'success',
                'imgurl' => '/'.$output_filename,
            ];
            return $response;
        }
    }
    public static function cropSubject($imageurl, $time, $cropimg_w = 100, $img_quality = 100)
    {
        $imgurl = $imageurl;
        $imginfor = getimagesize($imgurl);
        $type = $imginfor['mime'];
        switch(strtolower($type))
        {
            case 'image/png':
                $img_r = imagecreatefrompng($imgurl);
                $source_image = imagecreatefrompng($imgurl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgurl);
                $source_image = imagecreatefromjpeg($imgurl);
                error_log("jpg");
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgurl);
                $source_image = imagecreatefromgif($imgurl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }
        $imgInitW = imagesx($source_image);
        $imgInitH = imagesy($source_image);
        $minlength = min($imgInitW, $imgInitH);
        if($minlength < $cropimg_w){
            $response = [
                'status' => 'error',
                'message' => '上传图片太小',
            ];
            return $response;
        }
        if($imgInitH <= $imgInitW){
            $cropx1 = ($imgInitW - $imgInitH) / 2;
            $cropy1 = 0;
            $cropw = $imgInitH;
            $croph = $imgInitH;
        }else{
            $cropy1 = ($imgInitH - $imgInitW) / 2;
            $cropx1 = 0;
            $cropw = $imgInitW;
            $croph = $imgInitW;
        }
        $croped_img = imagecrop($source_image, ['x' => $cropx1, 'y' => $cropy1, 'width' => $cropw, 'height' => $croph]);
        $final_image = imagecreatetruecolor($cropimg_w, $cropimg_w);
        if(imagecopyresampled($final_image, $croped_img, 0, 0, 0, 0, $cropimg_w, $cropimg_w, $cropw, $croph)){
            if(file_exists($imageurl)){
                unlink($imageurl);
            }
        }
        $output_filename = $imgurl;
        if(imagejpeg($final_image, $output_filename, $img_quality)){
            return true;
        }
    }
}
