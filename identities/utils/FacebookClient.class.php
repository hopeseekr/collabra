<?php

require_once realpath(dirname(__FILE__) . '/../../lib/facebook-php-sdk/src/facebook.php');

class FacebookClient
{
	/** @var Facebook **/
	private $fbClient;

	public function __construct(Facebook $client)
	{
		$this->fbClient = $client;
		$this->bootstrap();
	}

	protected function bootstrap()
	{

	}

	public function requestAppPermission()
	{
	}
}
	
