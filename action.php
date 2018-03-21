<?php
date_default_timezone_set("PRC");
//引入图片压缩类
require 'imgcompress.class.php';
//如果有数据就是当前数据，没有为空
$action=isset($_GET['act']) ? $action = $_GET['act']:'';
$filename=isset($_POST['imagename']) ? $_POST['imagename']:'';

if($action=='delimg'){

    if(!empty($filename)){
        //删除图片
        unlink($filename);
        //向页面回调参数
        echo 'delete';
    }else{
        echo '删除失败.';
    }
 }else{
    //获取图片名字和原数据
    $picname = $_FILES['mypic']['name'];
    //获取图片大小
    $picsize = $_FILES['mypic']['size'];


    if ($picname != "") {

        /**
         *
         * 注释代码为是否限制用户上传图片大小和用户上传文件格式
         */
//        if ($picsize > 512000) { //限制上传大小
//            echo '图片大小不能超过500k';
//            exit;
//        }
//        $type = strstr($picname, '.'); //限制上传格式
//         if ($type != ".gif" && $type != ".jpg") {
//                         echo '图片格式不对！';
//             exit;
//         }
//        $rand = rand(100, 999);
//        $pics = date("YmdHis") . $rand . $type; //命名图片名称

      //防止上传图片名中文乱码
        $name=iconv("UTF-8","gb2312", $picname);
        //上传路径
        $pic_path = "files/". $name;
        //移动图片位置
        move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
    }
    //图片地址  拿到图片地址可以传递到数据库
    $source = "files/". $picname;
    $size = round($picsize/1024,2); //转换成kb
    $arr = array(
        'name'=>$picname,
        'pic'=>$source,
        'size'=>$size
    );
    echo json_encode($arr); //输出json数据


    $dst_img = $picname;
    $percent = 1;  //原图压缩，不缩放
    /**
     * 方法一
     * 压缩图片传递三个参数
     * 1.资源文件
     * 2.压缩图片质量 1是最高，从0.1开始
     * 3.图片压缩名字
     */
    (new Compress($source,$percent))->compressImg($dst_img);

    /**
     * 方法二
     * 1.资源文件
     * 2.压缩图片质量
     * 3.图片名字
     */
//    require 'image.class.php';
//    $src = "001.jpg";
//    $image = new Image($src);··············
//    $image->percent = 0.2;
//    $image->saveImage(md5("aa123"));
}