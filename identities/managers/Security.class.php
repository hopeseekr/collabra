<?php

// CREATED BY: Monica Chase (monica@phpexperts.pro) | 30 March 2011
// Revision 1 (31 March 2011) | Monica Chase (monica@phpexperts.pro)
//
// @purpose to determine whether any given user has read access to any given URL
//
// SecurityManager (e.g. "The Bouncer") is responsible for allowing in approved people, and turning away all the rabble.

class SecurityManager
{
	/**
	  * @return boolean
	 **/
	protected function determineClearance(User $user, $url)
	{
		// DEFAULT: Hide from ALL
		return false;
	}

	protected function ensureHasClearance(User $user, $url)
	{
		if ($this->determineClearance($user, $url) === false)
		{
			throw new RuntimeException("You are not authorized.");
		}
	}

    protected function ensureValidURL($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) == false)
        {
            throw new RuntimeException("Invalid URL.");
        }
    }
    
	public function guardEntrance(User $user, $url)
	{
		$this->ensureValidURL($url);
		$this->ensureHasClearance($user, $url);
	}
}

