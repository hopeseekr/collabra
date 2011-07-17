<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

class ControllerException extends LogicException
{
	const INVALID_ACTION     = 601;
	const INVALID_USER_INPUT = 602;
}

class ControllerCommander
{
	// @codeCoverageIgnoreStart
	private function __construct() { }
	// @codeCoverageIgnoreStop

	protected static function fetchAction()
	{
		$action = fRequest::get('action', 'string');

		// I want to make the default action to show the home page...
		if (empty($action))
		{
			// By having an actionslist class, I can avoid the dreaded
			// "Magic Constant". E.g. instead of having to worry about whether it's
			// "home", "index", "showHome",etc, i just rely on ActionList.
			$action = ActionsList::SHOW_HOME;
		}
		elseif (!is_string($action))
		{
			throw new ControllerException("Invalid action", ControllerException::INVALID_ACTION);
		}

		return $action;
	}

	/** Dispatches actions out to the controllers and returns the output, if any.
	  * @return string Output from the Views.
	 **/
	public static function dispatch($action = null)
	{
		$action = ($action !== null) ? $action : self::fetchAction();
		
		$controllers = array('LoanController', 'PaymentController', 'GenericController');
		$output = '';
		foreach ($controllers as $c)
		{
			$controller = new $c;
			if (($result = $controller->execute($action)) != null)
			{
				$output .= $result;
			}
		}

		if (empty($output))
		{
			throw new ControllerException('No implementation found for ' . $action, ControllerException::INVALID_ACTION);
		}

		return $output;
	}
}


