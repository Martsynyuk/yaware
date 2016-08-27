<?php
namespace Yaware\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Yaware\Model\UserTable;

class UserController extends AbstractActionController
{
	private $table;
	
	public function __construct(UserTable $table)
	{
		$this->table = $table;
	}
	
	public function indexAction()
	{
		return new ViewModel();
	}
	
	public function loginAction()
	{
		
	}
	
	public function registrationAction()
	{
	
	}
}