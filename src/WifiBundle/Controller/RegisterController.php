<?php

namespace WifiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\DbBundle\Model\UserQuery;
use Common\DbBundle\Model\User;
use WifiBundle\Library\ReCaptcha;

class RegisterController extends Controller
{
    public function indexAction(Request $request)
    {
        $submit         = $request->request->get('submit', 0); 

        $email          = $request->request->get('Email',  '');
        $passwd         = $request->request->get('Passwd',  '');
        $passwdAgain    = $request->request->get('PasswdAgain',  '');
        $fullname       = $request->request->get('FullName',  '');
        $phone          = $request->request->get('Phone',  '');
        $address        = $request->request->get('Address',  '');
        $gender         = $request->request->get('Gender',  '');

        $g_recaptcha    = $request->request->get('g-recaptcha-response', '');

        $email          = strip_tags($email);
        $fullname       = strip_tags($fullname);
        $phone          = strip_tags($phone);
        $address        = strip_tags($address);
        $gender         = strip_tags($gender);

        $error          = array();
        $value          = array(
            'email'         =>  $email,
            'passwd'        =>  $passwd,
            'passwdAgain'   =>  $passwdAgain,
            'fullname'      =>  $fullname,
            'phone'         =>  $phone,
            'address'       =>  $address,
            'gender'        =>  $gender
        );

        $locale = $request->getLocale();

        if($submit){ 

            $reCaptcha = new ReCaptcha($g_recaptcha);
            $captcha_success = $reCaptcha->verifyResponse();
            if ($captcha_success->success == false) {
                $error['captcha'] = $this->get('translator')->trans('error.captcha');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = $this->get('translator')->trans('validation2.email1');
            }

            if(strlen($passwd) < 6){
                $error['password'] = $this->get('translator')->trans('validation2.password1');
            }else{
                if($passwd !== $passwdAgain){
                    $error['password2'] = $this->get('translator')->trans('validation2.password2');
                }
            }


            if(empty($fullname)){
                $error['fullname'] = $this->get('translator')->trans('validation2.fullname2');
            }


            if(!is_numeric($phone)){
                $error['phone'] = $this->get('translator')->trans('validation2.phone1');
            }

            if(empty($fullname)){
                $error['address'] = $this->get('translator')->trans('validation2.address2');
            }

            $sex = array('male', 'female');
            if(!in_array($gender, $sex)){
                $error['gender'] = $this->get('translator')->trans('validation2.gender1');
            }

            if(empty($error)){
                $user = UserQuery::create()->findOneByEmail($email);
                if(!empty($user)){
                    $error['email'] = $this->get('translator')->trans('validation2.email2');
                }else{
                    //save
                    $acc = new User();

                    $acc->setUsername($email);
                    $acc->setPassword($this->encodePassword($acc, $passwd));
                    $acc->setName($fullname);
                    $acc->setEmail($email);
                    $acc->setPhone($phone);
                    $acc->setType('register');
                    $acc->setIsActive(0);
                    $acc->setLocked(1);
                    $acc->setConfirm(md5($email));
                    $acc->save();

                    $url = $this->get('request')->getSchemeAndHttpHost().$this->container->get('router')->getContext()->getBaseUrl();

                    // Send mail
                    $link_send = $url.'/wifi/user/active?email='.$email.'&code='.md5($email);
                    $message = \Swift_Message::newInstance($this->get('translator')->trans('notification.register_active_emai'))
                        ->setFrom(array('wiads@gmail.com' => $this->get('translator')->trans('notification.register_active_emai2')))
                        ->setTo(array($email))
                        ->setBody(
                            $this->renderView(
                                "WifiBundle:Register:send_mail_{$locale}.html.twig",
                                array(
                                    'email'         =>  $email,
                                    'fullname'      =>  $fullname,
                                    'url_active'    =>  $link_send,
                                    'code'          =>  md5($email)
                                )
                            ),
                            'text/html'
                        );
                    $result = $this->get('mailer')->send($message);

                    return $this->redirectToRoute('wifi_register_success', array('register'=> md5($email)));
                }
            }
        }

        return $this->render('WifiBundle:Register:index.html.twig', array(
            'error'     =>  $error,
            'value'     =>  $value
        ));
    }

    public function successAction(Request $request){
        $register  = $request->get('register', '');
        $message = '';
        if(!empty($register)) {
            $user = UserQuery::create()->findOneByConfirm($register);
            if($user){
                $message = $this->get('translator')->trans('notification.register1');
            }else{
                $message = $this->get('translator')->trans('validation.register_fail');
            }
        }else{
            $message = $this->get('translator')->trans('validation.register_fail');
        }
        return $this->render('WifiBundle:Register:success.html.twig', array(
            'message'     =>  $message
        ));
    }

    private function encodePassword(User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }

    
}
