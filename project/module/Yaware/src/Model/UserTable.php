<?php
namespace Yaware\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Yaware\Model\User;

class UserTable
{
	private $tableGateway;

	public function __construct(TableGatewayInterface $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function saveUser(User $user)
	{
		$data = [
				'username' => $user->username,
				'password'  => $user->password,
		];

		$this->tableGateway->insert($data);
	}
}