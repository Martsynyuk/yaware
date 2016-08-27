<?php
namespace Yaware\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('registration');

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
				'name' => 'cofirmpassword',
				'type' => 'password',
				'options' => [
						'label' => 'cofirm password',
				],
		]);
		$this->add([
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => [
						'value' => 'registration',
						'id'    => 'submitbutton',
				],
		]);
	}
}