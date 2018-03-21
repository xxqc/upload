<?php
/**
图片压缩操作类
v1.0
 */
class Image{

    private $src;
    private $imageinfo;
    private $image;
    public  $percent = 0.1;
    public function __construct($src){

        $this->src = $src;

    }
    /**
    打开图片
     */
    public function openImage(){

        list($width, $height, $type, $attr) = getimagesize($this->src);
        $this->imageinfo = array(

            'width'=>$width,
            'height'=>$height,
            'type'=>image_type_to_extension($type,false),
            'attr'=>$attr
        );
        $fun = "imagecreatefrom".$this->imageinfo['type'];
        $this->image = $fun($this->src);
    }
    /**
    操作图片
     */
    public function thumpImage(){

        $new_width = $this->imageinfo['width'] * $this->percent;
        $new_height = $this->imageinfo['height'] * $this->percent;
        $image_thump = imagecreatetruecolor($new_width,$new_height);
        //将原图复制带图片载体上面，并且按照一定比例压缩,极大的保持了清晰度
        imagecopyresampled($image_thump,$this->image,0,0,0,0,$new_width,$new_height,$this->imageinfo['width'],$this->imageinfo['height']);
        imagedestroy($this->image);
        $this->image =   $image_thump;
    }
    /**
    输出图片
     */
    public function showImage(){

        header('Content-Type: image/'.$this->imageinfo['type']);
        $funcs = "image".$this->imageinfo['type'];
        $funcs($this->image);

    }
    /**
    保存图片到硬盘
     */
    public function saveImage($name){

        $funcs = "image".$this->imageinfo['type'];
        $funcs($this->image,$name.'.'.$this->imageinfo['type']);

    }
    /**
    销毁图片
     */
    public function __destruct(){

        imagedestroy($this->image);
    }

}


?>