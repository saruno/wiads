<?php
namespace ApiBundle\Controller;

use FOS\OAuthServerBundle\Controller\TokenController as BaseController;
use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\Request;
use OAuth2\OAuth2ServerException;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends BaseController {

	const CONFIG_RESPONSE_EXTRA_HEADERS = 'response_extra_headers'; // Add extra headers to the response

    /**
     * @var OAuth2
     */
    protected $server;

    /**
     * @param OAuth2 $server
     */
    public function __construct(OAuth2 $server)
    {
        $this->server = $server;
    }

    /**
     * @param Request $request
     * @return type
     */
    public function tokenAction( Request $request )
    {
        try
        {
            
	    	$token = $this->server->grantAccessToken( $request ); 
	    	$result = json_decode($token->getContent());  

	    	$obj = new \stdClass();

	    	$obj->code = 1; $obj->message = 'Success';
	    	$data = array();

	    	$data['access_token'] 	= 	$result->access_token;
	    	$data['expires_in']		=	$result->expires_in;
	    	$data['token_type']		=	$result->token_type;
	    	$data['scope']			=	$result->scope;
	    	$data['refresh_token']	=	$result->refresh_token;

	    	$obj->data = $data;


            return new Response(json_encode($obj), 200, $this->getJsonHeaders());
        }
        catch( OAuth2ServerException $e )
        {
            $ex = $e->getHttpResponse();
            $code = json_decode($ex->getContent());

            $obj = new \stdClass();

            if($code->error_description == 'The client credentials are invalid'){
            	$obj->code = -2;
            	$obj->message = 'Client id hoặc client secret không đúng';
            }else{
            	$obj->code = -3;
            	$obj->message = 'Tài khoản hoặc mật khẩu không đúng';
            }

            return new Response(json_encode($obj), 200, $this->getJsonHeaders());
        }
    }

    /**
     * Returns HTTP headers for JSON.
     *
     * @return array
     *
     * @ingroup oauth2_section_5
     */
    private function getJsonHeaders()
    {
        $headers = $this->getVariable(self::CONFIG_RESPONSE_EXTRA_HEADERS, array());
        $headers += array(
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-store',
            'Pragma' => 'no-cache',
        );
        return $headers;
    }

    public function getVariable($name, $default = null)
    {
        $name = strtolower($name);

        return isset($this->conf[$name]) ? $this->conf[$name] : $default;
    }
}