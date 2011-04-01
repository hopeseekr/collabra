<?php

// Monica Chase (chase.mona@gmail.com) | 30 March 2011
//
// AuthenticationManager (e.g. "The Usher") is responsible for validating people are who they say they are, or referring them to The Bouncer.

class AuthenticationManager
	{
        public function __construct(SecurityManager $bouncer)
        {
            
        }

        public function authenticateUser(User $user)
        {
            // TODO: Build this out.
			// MOCK: Hard code to reply that "test/test" is a valid person.

			if ($user->username == "test" && $user->password == "test")
			{
				return true;
			}

			throw new RuntimeException("You have not been properly validated.");
        }
	}

