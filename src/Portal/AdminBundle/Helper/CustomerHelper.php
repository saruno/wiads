<?php
namespace Portal\AdminBundle\Helper;
use Common\DbBundle\Model\App;
use Common\DbBundle\Model\Customer;
use Common\DbBundle\Model\CustomerQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;
class CustomerHelper{
	static public function getAllCustomer_Admin(){
		$customers=CustomerQuery::create()
		->find();
		return $customers;
	}
}