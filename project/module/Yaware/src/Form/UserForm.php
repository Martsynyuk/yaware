<?php
namespace Yaware\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UserForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('user');

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
				'name' => 'status',
				'type' => 'Zend\Form\Element\Select',
				'options' => [
						'label' => 'status',
						'value_options' => [
								'admin' => 'admin',
								'employee' => 'employee',
						],
				],
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