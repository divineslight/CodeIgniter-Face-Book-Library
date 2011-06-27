<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter FB oAuth Class
 *
 * Eases up the confusing process of wokring with Facebook, Authorizing and generating token
 *
 * @package		CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author		Black Divine
 * @created		1/05/2011
 * @license		Do whatever you please, and if you add usefull stuff please be sure to send me so I can add it here.
 * @link		http://github.com/blackdivine/Code-Igniter-Face-Book-oAuth-Library
 */

class FB
{
	protected $_CI;
	
	protected $_app_id, $_app_secret, $_app_permissions;
	
	protected $_token;	// the holy grail
    
	function __construct( $config = array() )
	{
		$this->_CI =& get_instance();


		$this->_app_id 					= $config['app_id'];
		$this->_app_secret 			= $config['app_secret'];
		$this->_app_permissions	= $config['permissions'];
		
		$this->_token = NULL;
	}
	
	function get_auth_url( $redirect_url )
	{
		return 'https://www.facebook.com/dialog/oauth?client_id='.$this->_app_id.'&redirect_uri='.urlencode($redirect_url).'&scope='.$this->_app_permissions;
	}
	
	function generate_token( $redirect_url = '' )
	{
		$error	= $this->_CI->input->get('error_reason');

		// if the user denied your app for permissions or some other error
		if ( $error )
			return $error;
			
		$code		= $this->_CI->input->get('code');
		$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->_app_id.'&redirect_uri='.urlencode($redirect_url).'&client_secret='.$this->_app_secret.'&code='.$code;
		$this->_token = str_replace( 'access_token=','', file_get_contents($token_url) );
		
		return true;
	}
	
	function get_token()
	{
		if ( $this->_token )
			return $this->_token;
			
		return false;
	}
	
}
