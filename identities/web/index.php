<?php

// Revision 1 (31 March 2011) | Monica Chase (chase.mona@gmail.com)
//
// Type "i" to get into insert mode...

$bouncer = new SecurityManager();

$usher = new AuthenticationManager($bouncer);

