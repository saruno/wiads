<?php

namespace AdvertiserBundle\Twig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class AppExtension extends \Twig_Extension
{

    /**
     * @var Request 
     */
    protected $request;

    /**
     * @var Request 
     */
    protected $container;

   /**
    * @var \Twig_Environment
    */
    protected $environment;


    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('in_array', array($this, 'in_array')),
            new \Twig_SimpleFilter('active_menu', array($this, 'activeMenu')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function in_array($needle, $haystack){
        return in_array($needle, $haystack);
    }

    public function activeMenu($path, $arr = array(), $class = ''){
        $currentRoute = $this->request->attributes->get('_route');
        if(in_array($currentRoute, $arr)){
            return $class;
        }
    }

    public function getName()
    {
        return 'app_extension';
    }
}