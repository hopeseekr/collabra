<?php

// CREATED BY: Monica Chase (chase.mona@gmail.com) | 30 March 2011
// Revision 1 (31 March 2011) | Monica Chase (chase.mona@gmail.com)
//
// @purpose to determine whether any given user has read access to any given URL
//
// SecurityManager (e.g. "The Bouncer") is responsible for allowing in approved people, and turning away all the rabble.

class SecurityManager
{
	protected function determineClearance()     // DEFAULT: Hide from ALL
	{
		throw new RuntimeException("You are not authorized.");
	}
}

