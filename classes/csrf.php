<?php defined('SYSPATH') or die('No direct script access.');

class CSRF {

	// Session instance
	public static $session = 'default';

	// Name of the CSRF token
	public static $token = 'csrf-token';

	/**
	 * Returns the token in the session or generates a new one
	 *
	 * @param   string  $namespace - semi-unique name for the token (support for multiple forms)
	 * @return  string
	 */
	public static function token()
	{
		$token = Session::instance(CSRF::$session)->get(CSRF::$token);

		// Generate a new token if no token is found
		if ( ! $token)
		{
			$token = Text::random('alnum', rand(20, 30));
			Session::instance(CSRF::$session)->set(CSRF::$token, $token);
		}

		return $token;
	}

	/**
	 * Validation rule for checking a valid token
	 *
	 * @param   string  $token - the token string to check for
	 * @return  bool
	 */
	public static function valid($token)
	{
		return $token === self::token();
	}

	/**
	 * Clears the token from the session
	 *
	 * @return  null
	 */
	public static function clear()
	{
		return Session::instance(CSRF::$session)->delete(CSRF::$token);
	}
}
