<?php

namespace Yaw\Controller;

use Yaw\Form\UserForm;
use Yaw\Form\UserLoginForm;
use Yaw\Model\User;
use Yaw\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Db\Adapter\Adapter as DbAdapter;

class UserController extends AbstractActionController
{
	private $table;
	private $auth;

	public function __construct(\Yaw\Model\UserTable $table)
	{
		$this->table = $table;
		$this->auth = new AuthenticationService();
	}

	public function indexAction()
	{
		$user = $this->auth->getStorage()->read();
		var_dump($user);
		die;
	}

	public function loginAction()
	{
		$form = new UserLoginForm();
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

		// Create a SQLite database connection
		$dbAdapter = new DbAdapter(array(
				'driver' => 'Pdo_Mysql',
				'hostname' => '192.168.100.100',
				'database' => 'yaware',
				'username' => 'root',
				'password' => '123456'
		));

		$authAdapter = new AuthAdapter($dbAdapter,
				'user',
				'username',
				'password',
				'MD5(?)'
				);

		$authAdapter
		->setIdentity($user->username)
		->setCredential($user->password);

		$result = $this->auth->authenticate($authAdapter);

		if ($result->isValid()) {
			$storage = $this->auth->getStorage();
			$storage->write($authAdapter->getResultRowObject());

			$this->redirect()->toUrl('/user/index');
		}
	}

	public function registerAction()
	{
		$form = new UserForm();
		$form->get('submit')->setValue('Sign Up');

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
		$this->redirect()->toUrl('/user/login');
	}
}