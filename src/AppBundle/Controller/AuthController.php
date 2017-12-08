<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_login_check'))
            ->setMethod('POST')
            ->getForm();

        return $this->render('AppBundle:Auth:login.html.twig', array(
            // last username entered by the user
            //'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


}