<?php
namespace Yaware\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Yaware\Model\UserTable;
use Yaware\Form\LoginForm;
use Yaware\Form\RegistrationForm;
use Yaware\Model\User;

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
		$form = new LoginForm();
		$form->get('submit')->setValue('Login');
		
		$request = $this->getRequest();
		
		if (! $request->isPost()) {
			return ['form' => $form];
		}
		
		$user = new User();
		$form->setInputFilter($user->getInputFilter());
		$form->setData($request->getPost());
		
		if (! $form->isValid()) {
			return ['form' => $form];
		}
		
		$user->exchangeArray($form->getData());
		if($this->table->getUser($user)) {
			return $this->redirect()->toUrl('/');
		}
		return ['form' => $form];
	}
	
	public function registrationAction()
	{
		$form = new RegistrationForm();
		$form->get('submit')->setValue('registration');
		
		$request = $this->getRequest();
		
		if (! $request->isPost()) {
			return ['form' => $form];
		}
		
		$user = new User();
		$form->setInputFilter($user->getInputFilter());
		$form->setData($request->getPost());
		
		if (! $form->isValid()) {
			return ['form' => $form];
		}

		$user->exchangeArray($form->getData());
		$this->table->saveUser($user);
		return $this->redirect()->toUrl('/user/login');
	}
}