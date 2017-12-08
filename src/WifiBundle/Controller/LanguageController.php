<?php

namespace WifiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends Controller
{
    public function englishAction(Request $request)
    {
        $locale = 'en';
        $this->get('session')->set('_locale', $locale);
        $request = $this->getRequest();
        $request->setLocale($locale);

        return $this->redirect($request->headers->get('referer'));
    }

    public function vietnamAction(Request $request)
    {
        $locale = 'vi';
        $this->get('session')->set('_locale', $locale);
        $request = $this->getRequest();
        $request->setLocale($locale);
        return $this->redirect($request->headers->get('referer'));
    }
}
