<?php
namespace Yaware\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Yaware\Model\UserTable;
use Yaware\Form\LoginForm;
use Yaware\Form\RegistrationForm;

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
	
		/*$album->exchangeArray($form->getData());
		$this->table->save();
		return $this->redirect()->toRoute('album');*/
	}
	
	public function registrationAction()
	{
		$form = new RegistrationForm();
		$form->get('submit')->setValue('registration');
		
		$request = $this->getRequest();
		
		if (! $request->isPost()) {
			return ['form' => $form];
		}
		
	}
}