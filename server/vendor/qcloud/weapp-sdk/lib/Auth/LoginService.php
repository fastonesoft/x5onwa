<?php
namespace QCloud_WeApp_SDK\Auth;

use \Exception;

use \QCloud_WeApp_SDK\Helper\Util as Util;
use \QCloud_WeApp_SDK\Constants as Constants;

class LoginService {
    public static function login() {
      $code = Util::getHttpHeader(Constants::WX_HEADER_CODE);
      $encryptedData = Util::getHttpHeader(Constants::WX_HEADER_ENCRYPTED_DATA);
      $iv = Util::getHttpHeader(Constants::WX_HEADER_IV);

      if (!$code) {
        throw new Exception("请求头未包含 code");
      }
      // login，check返回结果userinfor结构不同
      return AuthAPI::login($code, $encryptedData, $iv);
    }

    public static function check() {
      $skey = Util::getHttpHeader(Constants::WX_HEADER_SKEY);
      return AuthAPI::checkLogin($skey);
      }

}
