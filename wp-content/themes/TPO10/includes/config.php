<?php
	define('BASE_PATH',dirname(__FILE__));

	class Config {
			
		// Xero API authentication
		const XERO_KEY					= 'LIWR9GZMSUGRXBQYX5CZ59F5WTTRAD';
		const XERO_SECRET				= '8OCKYRLE50I7FDVPNX2UKCCVDKJC2I';
		const XERO_PATH_PUBLIC_CERT		= 'D:\\inetpub\\live\\wwwroot\\classes\\xero-certs\\publickey.cer';
		const XERO_PATH_PRIVATE_KEY		= 'D:\\inetpub\\live\\wwwroot\\classes\\xero-certs\\privatekey.pem';

		
		// Xero settings
		static $XERO_SUBMISSION_TYPE_MAP= array(
											"submit-nsf.php" => "NSF",
											"submit-coy.php" => "COY",
											"submit-nsfcoy.php" => "NSFCOY" 
										);

	// API Authentication
		static $AUTH_IP_ADDRESSES = array( "", "127.0.0.1", "::1", "54.252.160.33", "203.219.221.82", "172.31.12.215", "172.31.13.104", "172.31.1.21", "172.31.15.147", "172.31.11.87", "172.31.11.88", "172.31.11.89", "172.31.11.90", "54.252.171.147", "172.31.5.172" );
		
		// API tokens, match with their specific Xero data references
		static $AUTH_TOKENS = array ( 
			"token" => array (
				"contactName" => "TimFoster",
				"itemNumbers" => array(
					"NSF" => array(
						"ED" => "NSF-ED",
						"PD" => "NSF-PD",
						"PS" => "NSF-PS"),
					"COY" => array(
						"ED" => "COY-ED",
						"PD" => "COY-PD",
						"PS" => "COY-PS"),
					"NSFCOY" => array(
						"ED" => "NSFCO-ED",
						"PD" => "NSFCO-PD",
						"PS" => "NSFCO-PS")
				),
				//"fundTemplate" => "[todo]",
				//"fundTemplate2" => "[todo]"
			)
		);
		
	}

?>