<?php
namespace Yaware\Auth;

//session_start();

class Auth 
{
	public function auth($id, $status)
	{
		$_SESSION['id'] = $id;
		$_SESSION['status'] = $status;
	}
	
	public function getUserId()
	{
		if(isset($_SESSION['id'])) {
			return $_SESSION['id'];
		}
		return false;
	}
	
	public function getUserStatus()
	{
		if(isset($_SESSION['status'])) {
			return $_SESSION['status'];
		}
		return 'guest';
	}
	
	public function logout()
	{
		unset($_SESSION['status']);
		unset($_SESSION['id']);
	}
}