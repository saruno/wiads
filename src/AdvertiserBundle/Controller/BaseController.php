<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{	
	private $model; 
	public $view_data = [];

	function __construct() {
		@session_start();
    }	

    public function index(){
    	$this->view_data['json_data'] = $this->getModel()->json_data();
        $this->view_data['column_search'] = $this->getModel()->json_data(1);
    }

    /**
	 *	@param string $model
	 */
	protected function setModel($model){
		$this->model = $model;
	}

	/**
	 *	@return object
	 */
	protected function getModel(){
		$model = "\AdvertiserBundle\Datatables\\".$this->model;
		return new $model();
	}
}
