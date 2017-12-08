<?php
namespace AppBundle\Controller;
use Common\DbBundle\Model\Base\UserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Common\DbBundle\Model\User;
use AppBundle\Form\Type\UserType;
use Common\DbBundle\Model\Customer;
use Common\DbBundle\Model\RoleAssign;

class RegisterController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $error = array();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $username = $form['username']->getData();
                $email = $form['email']->getData();

                $name = $form['name']->getData();
                $phone = $form['phone']->getData();

                $user_one = UserQuery::create()->filterByUsername($username)->findOne();
                if(!$user_one){
                    $user_one2 = UserQuery::create()->filterByEmail($email)->findOne();
                    if(!$user_one2){
                        if($form['password']->getData() == $_POST['comfirm_password']){

                            $user->setPassword($this->encodePassword($user, $form['password']->getData()));
                            if ($user->save()){
                                $role_assign = new RoleAssign();
                                $role_assign->setUserId($user->getId());
                                $role_assign->setRoleId(6);
                                $role_assign->save();
                                // Thêm vào customer
                                $customer = new Customer();
                                $customer->setEmail($email);
                                $customer->setUsername($username);
                                $customer->setName($username);
                                $customer->setPhone($phone);
                                $customer->setType('customer');
                                $customer->save();
                            }

                            return $this->redirect($this->generateUrl('app_register_notification'));
                        } else{
                            $request->getSession()->getFlashBag()->add('error', 'Mật khẩu không khớp!');
                        }
                    }else{
                        $request->getSession()->getFlashBag()->add('error', 'Email đã tồn tại!');
                    }
                } else{
                    $request->getSession()->getFlashBag()->add('error', 'Tài khoản đã tồn tại!');
                }
            }
        }

        return $this->render('AppBundle:Register:index.html.twig',array(
            'form'      =>  $form->createView(),
            'error'     =>  $error,
        ));
    }

    private function encodePassword(User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }

    public function notificationAction(Request $request){

        return $this->render('AppBundle:Register:notification.html.twig',array(

        ));
    }

    /**
     *  Reset Password Is Email
     */
    public function forgotAction(Request $request){

        if ($request->getMethod() == 'POST') {
            $error = array();

            $email = $request->request->get('email');
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $user = UserQuery::create()->filterByEmail($email)->findOne();
                if($user){
                    $url = $this->get('request')->getSchemeAndHttpHost().$this->container->get('router')->getContext()->getBaseUrl();
                    $token_forgot = md5(uniqid($email.time(), true));
                    $user->setForgot($token_forgot);

                    // Send mail
                    $link_send = $url.'/forgotcomfirm?email='.$email.'&code='.$token_forgot;
                    $message = \Swift_Message::newInstance('Forgot Password Symfony')
                        ->setFrom(array('symfony@account.com' => 'Forgot PasswordSymfony'))
                        ->setTo(array($email))
                        ->setBody('<a href="'.$link_send.'">You click here to forgot password</a>', 'text/html');
                    $result = $this->get('mailer')->send($message);

                    // Save
                    $user->save();

                    $request->getSession()->getFlashBag()->add('success', 'Truy cập email để khôi phục mật khẩu!');
                }else{
                    $request->getSession()->getFlashBag()->add('error', 'Không có email trong hệ thống');
                }
            }else{
                $request->getSession()->getFlashBag()->add('error', 'Không đúng định dạng email!');
            }
        }

        return $this->render('AppBundle:Register:forgot.html.twig', array(

        ));
    }

    /**
     *  Forgot comfirm
     */
    public function forgotcomfirmAction(Request $request){
        $email = $request->query->get('email');
        $token_forgot = $request->query->get('code');

        $user = UserQuery::create()->filterByArray(array('email' =>  $email, 'forgot' => $token_forgot ))->findOne();
        if(!$user)
            return $this->redirect($this->generateUrl('advertiser_login'));
        if ($request->getMethod() == 'POST') {

            $password = $request->request->get('password');
            $password_comfirm = $request->request->get('password_comfirm');
            if(strlen($password) >= 3 && strlen($password_comfirm) >= 3){
                if($password == $password_comfirm){
                    $user->setPassword($this->encodePassword($user, $password));
                    $user->setForgot(null);
                    $user->save();

                    $request->getSession()->getFlashBag()->add('success', 'Khôi phục mật khẩu thành công!');
                }else{
                    $request->getSession()->getFlashBag()->add('error', 'Mật khẩu không khớp!');
                }
            }else{
                $request->getSession()->getFlashBag()->add('error', 'Độ dài mật khẩu quá ngắn!');
            }
        }
        return $this->render('AppBundle:Register:forgotcomfirm.html.twig');
    }
}