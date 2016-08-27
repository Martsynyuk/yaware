<?php
namespace Yaware\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('login');

		$this->add([
				'name' => 'id',
				'type' => 'hidden',
		]);
		$this->add([
				'name' => 'username',
				'type' => 'text',
				'options' => [
						'label' => 'username',
				],
		]);
		$this->add([
				'name' => 'password',
				'type' => 'password',
				'options' => [
						'label' => 'password',
				],
		]);
		$this->add([
				'name' => 'access',
				'type' => 'hidden',
		]);
		$this->add([
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => [
						'value' => 'Login',
						'id'    => 'submitbutton',
				],
		]);
	}
}