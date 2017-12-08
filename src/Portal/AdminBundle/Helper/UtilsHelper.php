<?php
namespace Portal\AdminBundle\Helper;
use Symfony\Component\HttpFoundation\Request;

class UtilsHelper
{
    static public function extractFieldOnly($fields)
    {
        foreach($fields as $key=>$field)
        {
            $patterns = array();
            $patterns[0] = '/^[^_]*_/';
            $patterns[1] = '/_i18n/';

            $replacements = '';

            $new_key = preg_replace($patterns, $replacements, $key);

            if ($new_key != $key)
            {
                $fields[$new_key] = $fields[$key];
                unset($fields[$key]);
            }

        }
        return $fields;

    }
    public static function utf8_to_ascii($str) {
        $chars = array(
            'a' => array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
            'e' => array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
            'i' => array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
            'o' => array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
            'u' => array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
            'y' => array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
            'd' => array('đ','Đ','Ð'),
            '&' => array('#'),
            '-' => array(' ','\\','+','/','%20','.'),
            '' => array('%',',','?'),
        );
        foreach ($chars as $key => $arr)
            foreach ($arr as $val)
                $str = str_replace($val,$key,$str);

        return $str;
    }
    public static function getHostUrl()
    {
        $request = Request::createFromGlobals();
        $url  = 'http'.($request->isSecure() ? 's' : '').'://'. $request->getHost();
        return $url;
    }

    function strip_html_tags($string) {

        $string = str_replace("\r", ' ', $string);
        $string = str_replace("\n", ' ', $string);
        $string = str_replace("\t", ' ', $string);
        /*  $string = str_replace("<li>', "\n* ", $string);*/

        /* $pattern = "/<.*?>/"; */
        $pattern = '/<[^>]*>/';

        $string= preg_replace ($pattern, ' ', $string);

        $string= trim(preg_replace('/ {2,}/', ' ', $string));

        return $string;

    }
}