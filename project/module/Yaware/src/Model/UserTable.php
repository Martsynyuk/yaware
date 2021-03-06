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
		if(!$user->status) {
			$user->status = 'owner';
		}
		
		$data = [
				'username' => $user->username,
				'password'  => md5($user->password),
				'status' => $user->status,
		];

		$this->tableGateway->insert($data);
	}
	
	public function getUser(User $user)
	{
		$data = [
				'username' => $user->username,
				'password'  => md5($user->password),
		];
		
		$rowset = $this->tableGateway->select($data);
		$row = $rowset->current();
		
		return $row;
	}
}