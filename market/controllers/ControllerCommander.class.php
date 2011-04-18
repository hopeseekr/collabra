<?php
/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
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
		$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

		if (empty($action) || is_string($action))
		{
			throw new ControllerException("Invalid action", ControllerException::INVALID_ACTION);
		}
	}

	/** Dispatches actions out to the controllers and returns the output, if any.
	  * @return string Output from the Views.
	 **/
    public static function dispatch()
    {
		$action = self::fetchAction();
        
        $controllers = array('LoanController', 'PaymentController');
		$output = '';
        foreach ($controllers as $c)
        {
            $controller = new $c;
            if (($result = $controller->execute($action)) !== false)
            {
                $output .= $result;
            }
        }

		if (empty($output))
		{
        	throw new ControllerException('No implementation found for ' . $action, ControllerException::ERROR_INVALID_ACTION);
		}

		return $output;
    }
}


