<?php

/** The Collabra Market Project
  *   Part of the Collabra Commercial Collaboration Platform
  *
  * Copyright(c) 2011 Theodore R. Smith <theodore@phpexperts.pro>
  * All rights reserved.
 **/

interface ViewI
{
	public function displayView();
	public function displayMissingView();
	public function displayErrorView();
}

