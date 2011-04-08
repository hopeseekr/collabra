<?php

// Monica Chase (monica@phpexperts.pro) | 30 March 2011
// UserManager (e.g. "Personal Assistant") is responsible for fulfilling
// all of the personal needs of the user, from logging in, changing settings,
// etc.

class UserManager
{


	/**
	  @return User Returns the user's datatype or throws exception.
	 */
	public function login($username, $password)
	{
		// TODO: Build out.
		// MOCK: Hard code to only allow the test/test account.

		// 1. See if this is a valid user...
		if ($username == "test" && $password == "test")
		{
			// 3. Load the user data from the DB
			// TODO: Build out.
			// MOCK: Hard codes it to test/test.
			$user = new User;
			$user->username = "test";
			$user->password = "test";
		}
		else
		{
			// 2. If not, throw an exception
			throw new RuntimeException('Invalid username/password');
		}

		return $user;
	}
}

