<?php

namespace AdvertiserBundle\Helper;


class FileHelper
{
    static public function uploadFile($file = null, $options = null){
        if($file['name'] != NULL){ // Đã chọn file
            if(in_array($file['type'], $options['type_file'])){
                $bytes = number_format($file['size'] / 1024,0);
                $access = 0;
                if(!isset($options['size_file'])){  // dung lượng cho phép mặc định là 2048kb
                    $access = 2048;
                } else {
                    $access = $options['size_file'];
                }
                if($bytes <= $access){ // File size nhỏ hơn 2048 thì cho upload

                    // file hợp lệ, tiến hành upload
                    $path = $options['root_dir'].$options['url_file']; // file sẽ lưu vào thư mục data
                    $tmp_name = $file['tmp_name'];
                    $info_img = getimagesize($tmp_name);

                    // đổi tên file
                    $temp = explode(".",basename($file["name"]));
                    $newfilename = md5(uniqid(microtime(true))). '.' . end($temp);

                    // Upload file
                    if(!file_exists($path.$newfilename)){
                        if(move_uploaded_file($tmp_name,$path.$newfilename)){

	                        exec("rsync -au -e 'ssh -p 2012' /var/www/enter.wiads.vn/web/media/uploads/$newfilename root@125.212.233.60:/var/www/enter.wiads.vn/web/media/uploads/$newfilename");
                            $data = array(
                                'name'  =>  $options['url_file'].$newfilename,
                                'width' =>  $info_img[0],
                                'height'=>  $info_img[1],
                                'type'  =>  $info_img['mime']
                            );
                            return $data;
                        }
                    }
                }
            }
        }
        return 0;
    }
}