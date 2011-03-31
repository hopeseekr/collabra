<?php

// CREATED BY: Monica Chase (chase.mona@gmail.com) | 30 March 2011
// Revision 1 (31 March 2011) | Monica Chase (chase.mona@gmail.com)

class SecurityManager
	{
        protected function determineClearance()     // DEFAULT: Hide from ALL
        {
            throw new RuntimeException("You are not authorized.");
        }
	}

?>