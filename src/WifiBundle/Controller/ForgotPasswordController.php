<?php

namespace WifiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\DbBundle\Model\UserQuery;
use Common\DbBundle\Model\User;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\RememberMeToken;
use WifiBundle\Library\ReCaptcha;

class ForgotPasswordController extends Controller
{
    public function indexAction(Request $request)
    {
        $submit         = $request->request->get('submit', 0); 
        $email          = $request->request->get('email',  '');
        $g_recaptcha    = $request->request->get('g-recaptcha-response', '');

        $error = array();
        $param = array(
            'email' =>  $email
        );

        $locale = $request->getLocale(); 
        if($submit){
         
            $reCaptcha = new ReCaptcha($g_recaptcha);
            $captcha_success = $reCaptcha->verifyResponse();

            if ($captcha_success->success == true) {
                $user = UserQuery::create()->findOneByEmail($email);
                if($user){
                    $url = $this->get('request')->getSchemeAndHttpHost().$this->container->get('router')->getContext()->getBaseUrl();
                    // Send mail
                    $link_send = $url.'/wifi/forgot/confirm?email='.$email.'&code='.md5($email);
                    $message = \Swift_Message::newInstance($this->get('translator')->trans('button.restore_pass'))
                        ->setFrom(array('wiads@gmail.com' => $this->get('translator')->trans('button.restore_pass')))
                        ->setTo(array($email))
                        ->setBody(
                            $this->renderView(
                                "WifiBundle:ForgotPassword:send_mail_{$locale}.html.twig",
                                array(
                                    'email'         =>  $user->getEmail(),
                                    'fullname'      =>  $user->getName(),
                                    'url_active'    =>  $link_send,
                                    'code'          =>  md5($email)
                                )
                            ),
                            'text/html'
                        );
                    $result = $this->get('mailer')->send($message);
                    if($result){
                        $user->setForgot(md5($email));
                        $user->save();
                        $param['success'] = $this->get('translator')->trans('notification.restore_pass_success');
                    }
                }else{
                    $error['email'] = $this->get('translator')->trans('validation2.email1');
                }
            } else if ($captcha_success->success == false) {
                $error['captcha']   =   $this->get('translator')->trans('error.captcha');
            }
        }
        
        return $this->render('WifiBundle:ForgotPassword:index.html.twig', array(
            'error'     =>  $error,
            'param'     =>  $param
        ));
    }

    public function confirmAction(Request $request)
    {
        $email  = $request->get('email', '');
        $code  = $request->get('code', '');

        $status = 0;

        $param = array(
            'email'     =>  $email,
            'code'      =>  $code
        );

        if(!empty($email) && !empty($code)){
            $user = UserQuery::create()->findOneByEmail($email);
            if($user){
                if($user->getForgot() === $code && !empty($user->getForgot())){
                    $pass_new = rand(100000,900000);
                    $user->setPassword($this->encodePassword($user, $pass_new));
                    $user->setForgot(null);
                    $user->save();
                    $status = 1;
                    $param['password'] = $pass_new;
                }else{
                    return $this->redirectToRoute('wifi_homepage');
                }
            }else{
                $status = -1;
            }
        }else{
            return $this->redirectToRoute('wifi_homepage');
        }

        return $this->render('WifiBundle:ForgotPassword:confirm.html.twig', array(
            'status'    =>  $status,
            'param'     =>  $param
        ));
    }

    private function encodePassword(User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }
}