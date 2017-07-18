<?php

namespace session;

use session\exceptions\sessionKeyExistsException;
use session\exceptions\sessionKeyInexistentException;
use function compact as with;

class session
{
	public function __construct ( string $name = 'php-session' )
	{
		session_start ( with ( 'name' ) );
	}

	public function set ( string $key, $value )
	{
		if ( ! $this->has ( $key ) )
			throw new sessionKeyExistsException ( $key );
		$_SESSION [ 'stored' ][ $key ] = $value;
	}

	public function flash ( string $key, $value )
	{
		if ( $this->has ( $key ) )
			throw new sessionKeyExistsException ( $key );
		$_SESSION [ 'flashed' ] [ $key ] = $value;
	}

	public function get ( string $key )
	{
		if ( $this->flashed ( $key ) )
			return $this->flashing ( $key );
		if ( $this->stored ( $key ) )
			return [ $_SESSION [ 'store' ] [ $key ] ];
		throw new sessionKeyInexistentException ( $key );
	}

	public function remove ( string $key )
	{
		if ( $this->flashed ( $key ) )
			unset ( $_SESSION [ 'flashed' ] [ $key ] );
		else if ( $this->stored ( $key ) )
			unset ( $_SESSION [ 'stored' ] [ $key ] );
		else
			throw new sessionKeyInexistentException ( $key );
	}

	public function flashed ( string $key ) : bool
	{
		return ( isset ( $_SESSION [ 'flashed' ] [ $key ] ) );
	}

	public function stored ( string $key ) : bool
	{
		return ( isset ( $_SESSION [ 'stored' ] [ $key ] ) );
	}

	public function has ( string $key )
	{
		return ( $this->stored ( $key ) or $this->flashed ( $key ) );
	}

	private function flashing ( string $key )
	{
		$result = $_SESSION [ 'flashed' ] [ $key ];
		$this->remove ( $key );
		return $result; 
	}
}