<?php
namespace ApiBundle\Helper;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;

class AdvertiserHelper
{
    static function getDomain()
    {
        return 'http://enter.wiads.vn';
    }

    /*static function convetBase64ToImage($encoded, $file_name, $dir)
    {
    	$decoded_string = base64_decode($encoded);

    	$path = 'images/'.$image_name;
	
		$file = fopen($path, 'wb');
	
		$is_written = fwrite($file, $decoded_string);
		fclose($file);
    }*/
}