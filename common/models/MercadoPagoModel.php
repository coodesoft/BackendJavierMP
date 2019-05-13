<?php
namespace common\models;

require_once __DIR__.'/../../vendor/autoload.php';

class MercadoPagoModel{

	//{"id":390670389,"nickname":"TT627698","password":"qatest3734","site_status":"active","email":"test_user_65024816@testuser.com"}
    //{"id":392676655,"nickname":"TETE7474578","password":"qatest8322","site_status":"active","email":"test_user_19598607@testuser.com"}

    private static $MP_ACCESS_TOKEN  = 'APP_USR-1458084322274995-042202-71463ba5d19471910e03b226cfae02be-405086612';

    public static $MODE = 'PRODUCTION'; // SANDBOX o PRODUCTION

    private static $MP_TEST_ACCESS_TOKEN = 'TEST-1458084322274995-042202-e2d5230587f2828cba715e63849f9a6b-405086612';
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
