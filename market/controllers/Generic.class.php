<?php

class GenericController implements CommandI
{
	public function execute($action)
	{
		if ($action == ActionsList::SHOW_HOME)
		{
			require '../views/home.tpl.php';
		}
		else if ($action == ActionsList::SHOW_404)
		{
			header('HTTP/1.0 404 FILE NOT FOUND');
			require '../views/404.tpl.php';
		}
	}
}
