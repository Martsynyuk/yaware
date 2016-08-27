<?php
namespace Yaware\Auth;

session_start();

class Auth 
{
	public function auth($id)
	{
		$_SESSION['id'] = $id;
	}
	
	public function getUserId()
	{
		if(isset($_SESSION['id'])) {
			return $_SESSION['id'];
		}
		return false;
	}
}