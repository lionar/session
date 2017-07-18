<?php

namespace session\exceptions;

use RuntimeException as runtimeException;

class sessionKeyExistsException extends runtimeException
{
	public function __construct ( string $key )
	{
		$this->message = "The key: $key has already been registered in the session.";
	}
}