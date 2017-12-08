<?php
namespace WifiBundle\Library;
class ReCaptcha
{
    
    private $response;

    /**
     * Constructor.
     *
     * @param string $secret shared secret between site and ReCAPTCHA server.
     */
    function __construct($response)
    {
        $this->response = $response;
    }

    public function verifyResponse(){ 
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => '6LcPyhkUAAAAAC78CZTE2aJEL6Nij07oJLBXtCFw',
            'response' => $this->response
        );
        $options = array(
            'http' => array (
                'header' => "Content-Type: application/x-www-form-urlencoded",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);

        return $captcha_success;
    }
}
?>