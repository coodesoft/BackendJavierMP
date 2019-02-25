<?php
namespace common\models;

require_once __DIR__.'/../../vendor/autoload.php';

class MercadoPagoModel{

	//{"id":390670389,"nickname":"TT627698","password":"qatest3734","site_status":"active","email":"test_user_65024816@testuser.com"}
    //{"id":392676655,"nickname":"TETE7474578","password":"qatest8322","site_status":"active","email":"test_user_19598607@testuser.com"}

    private static $MP_ACCESS_TOKEN  = 'APP_USR-8645777024694472-122918-3e5b36bede1274899271a37ddb4da529-390670389';

    public static $MODE = 'SANDBOX'; // SANDBOX o PRODUCTION

    private static $MP_TEST_ACCESS_TOKEN = 'TEST-8645777024694472-122918-ee1b7120d3c303401fc4143bd17b978c-390670389';
    public $mp = Null;

  	public function __construct($params = []){

  	}

  	public function setMP(){
      if (self::$MODE == 'SANDBOX'){
        \MercadoPago\SDK::setAccessToken(self::$MP_TEST_ACCESS_TOKEN);
      }
      else if(self::$MODE == 'PRODUCTION')
      {
        \MercadoPago\SDK::setAccessToken(self::$MP_ACCESS_TOKEN);
      }
    }

	public function getMP(){
		$this->setMP();
		return $this->mp;
	}
}
 ?>
