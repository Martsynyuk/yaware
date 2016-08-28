<?php
namespace Yaware\Controller;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Yaware\Model\UserTable;
use Yaware\Form\LoginForm;
use Yaware\Form\RegistrationForm;
use Yaware\Form\UserForm;
use Yaware\Model\User;
use Yaware\Auth\Auth;

class UserController extends AbstractActionController
{
	private $table;
	
	public function __construct(UserTable $table)
	{
		$this->table = $table;
	}
	
	public function indexAction()
	{
		$this->autorization('index');
		return new ViewModel();
	}
	
	public function loginAction()
	{
		$this->autorization('login');
		
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
			$auth = new Auth();
			$auth->auth($this->table->getUser($user)->id,
						$this->table->getUser($user)->status
					);
			return $this->redirect()->toUrl('/');
		}
		return ['form' => $form];
	}
	
	public function registrationAction()
	{
		$this->autorization('registration');
		
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
	
	public function createUserAction()
	{
		$this->autorization('createUser');
		
		$form = new UserForm();
		$form->get('submit')->setValue('New User');
		
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
		return $this->redirect()->toUrl('/');
	}
	
	public function dashboardAction()
	{
		$this->autorization('dashboard');
		return new ViewModel();
	}
	
	public function reportsAction()
	{
		$this->autorization('reports');
		return new ViewModel();
	}
	
	public function configurationAction()
	{
		$this->autorization('configuration');
		return new ViewModel();
	}
	
	public function autorizationRules()
	{	
		$acl = new Acl();
		
		$acl->addRole(new Role('guest'));
		$acl->addRole(new Role('owner'));
		$acl->addRole(new Role('employee'));
		$acl->addRole(new Role('admin'));
		
		$acl->allow('guest', null, ['login', 'registration']);
		$acl->allow('owner', null, ['index', 'createUser', 'dashboard', 'configuration', 'reports']);
		$acl->allow('employee', null, ['index', 'dashboard', 'reports']);
		$acl->allow('admin', null, ['index', 'dashboard', 'configuration']);

		return $acl;
	}
	
	public function autorization($action)
	{
		$acl = $this->autorizationRules();
		
		$status = new Auth();
		$status = $status->getUserStatus();
		
		if(!$acl->isAllowed($status, null, $action)) {
			if($status == 'guest') {
				return $this->redirect()->toUrl('/user/login'); 
			}
			return $this->redirect()->toUrl('/');
		}
	}
	
	public function logoutAction()
	{
		$auth = new Auth();
		$auth->logout();
		return $this->redirect()->toUrl('/user/login');
	}
}