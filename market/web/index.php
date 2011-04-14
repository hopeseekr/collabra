<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * Copyright(c) 2011 Monica A. Chase <monica@phpexperts.pro>
  * All rights reserved.
 **/

// Front controller

session_start();

// 0. Initialize the Market library.
require '../Market.php';
Market::init();

$output = ControllerCommander::dispatch();

echo $output;

