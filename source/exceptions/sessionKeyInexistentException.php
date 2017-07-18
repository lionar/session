<?php

namespace session\exceptions;

use RuntimeException as runtimeException;

class sessionKeyInexistentException extends runtimeException
{
	public function __construct ( string $key )
	{
		$this->message = "The key: $key has not been registered in the session.";
	}
}