<?php
namespace ApiBundle\Helper;

class Base64Helper
{
    private $str;
    private $type;
    private $base;

    public function __construct($str)
    {
        $this->str = $str;
        $code = explode(',', $this->str);
        $this->type = isset($code[0]) ? $code[0] : '';
        $this->base = isset($code[1]) ? $code[1] : '';
    }

    public function isBase64()
    {
        
        if(preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $this->base)){
            return true;
        }
        return false;
    }

    public function isImage()
    {
        $type = array('data:image/jpeg;base64', 'data:image/png;base64', 'data:image/jpg;base64', 'data:image/gif;base64');
        if(in_array($this->type, $type)){
            return true;
        }
        return false;
    }

    public function getType()
    {
        $data =  explode(',', $this->str);
        $ini =  substr($data[0], 11);
        $type = explode(';', $ini);

    }

    public function getSizeMB()
    {
        $bytes = strlen(base64_decode($this->base));
        return number_format($bytes / 1048576, 2);
    }

    public function Image($root = null, $dir = null, $filename = null)
    {   
        if($dir != null){
            $duoi = explode(';', $this->type); $duoi = explode('/', $duoi[0]); $duoi = $duoi[1];

            $decoded_string = base64_decode($this->base);
        
            $image_name = $dir.(md5($filename.time())).".".$duoi;

            $path = $root.$image_name;
            
            $file = fopen($path, 'wb');
            
            $is_written = fwrite($file, $decoded_string);

            $file = fopen($path, 'rb');
            list($width, $height, $type, $attr) = getimagesize($path);
            
            fclose($file);

            $data = array(
                'filename'  =>  $image_name,
                'width'     =>  $width != null ? $width : 0,
                'height'    =>  $height != null ? $height : 0,
            );
            return $data;
        }
    }
}