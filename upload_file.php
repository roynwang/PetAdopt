<?php

$uptypes = array (
    'image/jpg',
    'image/png',
    'image/jpeg',
    'image/pjpeg',
    'image/gif',
    'image/bmp',
    'image/x-png'
    );
$ID = $_POST['uid'];
$max_file_size = 20000000;               //上传文件大小限制，单位BYTE,20M
$destination_folder = "./photo/".$ID."/";     //上传文件路径
$imgpreview = 1;                         //是否生成预览图(1为生成,其他为不生成);
$imgpreviewsize = 1 / 2;                 //缩略图比例

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //判断是否有上传文件
    if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
        $upfile = $_FILES['upfile'];
        //print_r($_FILES['upfile']);
        $name = $upfile['name'];             //文件名
        $type = $upfile['type'];             //文件类型
        $size = $upfile['size'];             //文件大小
        $tmp_name = $upfile['tmp_name'];     //临时文件
        $error = $upfile['error'];         //出错原因

        if ($max_file_size < $size) {        //判断文件的大小
            echo 'upload file is too big';
            exit ();
        }

        if (!in_array($type, $uptypes)) {        //判断文件的类型
            echo 'the type of the file you upload is wrong' . $type;
            exit ();
        }

        if (file_exists($destination_folder . $name))
        { //if file already exist, rename the file then save it!
            $timeNow = date("Y-m-d _H-i-s", time()) . "\n";
            $name_extention = substr($name, strrpos($name, '.')+1); //jpg 
            $name_preface = str_replace("." . $extention, "" , $name);//testpic
            $path = $destination_folder . $name_preface . $timeNow . "." . $name_extention;
            if (!move_uploaded_file($tmp_name, $path)) {
              echo "fail to move file!!";
            exit ();
          }
        }
        else
        {
         if (!move_uploaded_file($tmp_name, $destination_folder . $name)) {
            echo "fail to move file!!";
            exit ();
        }
    }
}
}
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();

?>




