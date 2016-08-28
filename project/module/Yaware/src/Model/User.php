<?php
namespace Yaware\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class User implements InputFilterAwareInterface
{
	public $id;
	public $username;
	public $password;
	public $status;
	private $inputFilter;
	
	public function exchangeArray(array $data)
	{
		$this->id     = !empty($data['id']) ? $data['id'] : null;
		$this->username = !empty($data['username']) ? $data['username'] : null;
		$this->status = !empty($data['status']) ? $data['status'] : null;
		$this->password  = !empty($data['password']) ? $data['password'] : null;
	}
	
	public function getArrayCopy()
	{
		return [
				'id'     => $this->id,
				'username' => $this->username,
				'password'  => $this->password,
				'status' => $this->status,
		];
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new DomainException(sprintf(
				'%s does not allow injection of an alternate input filter',
				__CLASS__
				));
	}
	
	public function getInputFilter()
	{
		if ($this->inputFilter) {
			return $this->inputFilter;
		}
	
		$inputFilter = new InputFilter();
	
		$inputFilter->add([
				'name' => 'id',
				'required' => true,
				'filters' => [
						['name' => ToInt::class],
				],
		]);
	
		$inputFilter->add([
				'name' => 'username',
				'required' => true,
				'filters' => [
						['name' => StripTags::class],
						['name' => StringTrim::class],
				],
				'validators' => [
						[
								'name' => StringLength::class,
								'options' => [
										'encoding' => 'UTF-8',
										'min' => 3,
										'max' => 6,
								],
						],
				],
		]);
	
		$inputFilter->add([
				'name' => 'password',
				'required' => true,
				'filters' => [
						['name' => StripTags::class],
						['name' => StringTrim::class],
				],
				'validators' => [
						[
								'name' => StringLength::class,
								'options' => [
										'encoding' => 'UTF-8',
										'min' => 6,
										'max' => 12,
								],
						],
				],
		]);
	
		$this->inputFilter = $inputFilter;
		
		return $this->inputFilter;
	}
}