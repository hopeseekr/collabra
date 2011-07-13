<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

class GenericController implements CommandI
{
	public function execute($action)
	{
		if ($action == '' || $action == ActionsList::SHOW_HOME)
		{
			require CMARKET_LIB_PATH . '/views/home.tpl.php';
		}
		else if ($action == ActionsList::SHOW_404)
		{
			header('HTTP/1.0 404 FILE NOT FOUND');
			require CMARKET_LIB_PATH . '/views/404.tpl.php';
		}

        return true;
	}
}
