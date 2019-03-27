<?php

namespace QCloud_WeApp_SDK\Model;

use \QCloud_WeApp_SDK\Conf as Conf;
use \Exception;

class x5on
{
  // 系统管理员
  const GROUP_ADMIN = 999;
  // 地区管理
  const GROUP_ADMIN_AREA = 90;
  // 集团管理
  const GROUP_ADMIN_SCHOOLS = 80;
  // 学校管理员
  const GROUP_ADMIN_SCHOOL = 70;

  // 普通用户最高能分配的组号
  const GROUP_NORMAL_MAX = 3;
  // 学生家长
  const GROUP_STUDENT_PARENT = 2;
  // 临时用户组编号
  const GROUP_TEMP_USER = 1;

  // 学籍状态
  const STATUS_RETURN = 2;
  const STATUS_TEMP = 99;

  // 用户信息设置
  const USER_SET_MYSELF = 'user-set-myself';

  // 学校设置信息
  const SCHOOL_SET_CODE = 'school-set-code';

  // 报名设置
  const SCHOOL_STUD_REGED = 'school-stud-reged';

  // 给数组元素添加编号
  public static function addIndex($arr)
  {
    $index = 0;
    foreach ($arr as $value) {
      $value->index = $index++;
    }
    return $arr;
  }

  public static function getCurl($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  }

  public static function getAccessToken()
  {
    // 已经有了
    $res = xonToken::getToken('access_token');
    if ($res !== null) {
      return $res;
    }
    $res = xonSys::getRowById('myinfor');
    if ($res === null) {
      throw new Exception("缺少必要的参数");
    }
    $uid = $res->uid;
    $value = $res->value;
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$value&secret=$uid";
    $output = self::getCurl($url);
    $res = json_decode($output, true);
    // 保存access
    xonToken::saveToken('access_token', $res);
    return $res["access_token"];
  }

  public static function getQrcodeBase64($value)
  {
    $margin = 2;
    $errorLevel = 'H';
    $matrixSize = 10;
    // 字符串编码
    ob_start();
    QRcode::png($value, false, $errorLevel, $matrixSize, $margin);
    $imageString = base64_encode(ob_get_contents());
    ob_end_clean();
    return $imageString;
  }

  public static function checkArr($arrs, $keyName, $value) {
    return self::checkArrCustom($arrs, $keyName, $value, '找到编号对应记录');
  }

  public static function checkArrCustom($arrs, $keyName, $value, $message) {
    $res = false;
    $json_arrs = json_decode(json_encode($arrs), true);
    foreach ($json_arrs as $item) {
      if ($item[$keyName] === $value) {
        $res = true;
        return json_decode(json_encode($item));
      }
    }
    if (!$res) throw new Exception($message);
  }

  public static function checkIdc($idcard, $more_than, $less_than)
  {
    $idc = strtoupper($idcard);
    // 长度检测
    if (strlen($idc) != 18) {
      throw new Exception('身份证长度必须18位');
    }
    // 字符检测
    $idc_num = str_replace('X', '', $idc);
    if (!is_numeric($idc_num)) {
      throw new Exception('身份证号有非法字符');
    }
    // 地区检测
    $idc_addr = substr($idc, 0, 2);
    $idc_addrs = '11x12x13x14x15x21x22x23x31x32x33x34x35x36x37x41x42x43x44x45x46x50x51x52x53x54x61x62x63x64x65x71x81x82';
    if (!strpos($idc_addrs, $idc_addr)) {
      throw new Exception('身份证地区标识有误');
    }
    // 格式检测
    $idc_birth = substr($idc, 6, 8);
    $idc_date = strtotime($idc_birth);
    if (!$idc_date) {
      throw new Exception('身份证出生日期格式错误');
    }
    // 日期检测
    $year = (int)substr($idc_birth, 0, 4);
    $month = (int)substr($idc_birth, 4, 2);
    $day = (int)substr($idc_birth, 6, 2);
    if (!checkdate($month, $day, $year)) {
      throw new Exception('身份证出生日期验证出错');
    }
    // 年龄检测
    $current_year = (int)date('Y');
    if ($more_than) {
      if ($current_year - $year < $more_than) {
        throw new Exception('年龄不符要求');
      }
    }
    if ($less_than) {
      if ($current_year - $year > $less_than) {
        throw new Exception('岁数已超标');
      }
    }

    // 验证检测
    $idcard_base = substr($idc, 0, 17);
    $verify_code = substr($idc, 17, 1);
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    $total = 0;
    for ($i = 0; $i < 17; $i++) {
      $total += substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = $total % 11;
    if ($verify_code != $verify_code_list[$mod]) {
      throw new Exception('身份证号校验出错');
    }
  }

  public static function getUid()
  {
    return bin2hex(openssl_random_pseudo_bytes(16));
  }

  public static function getId($id, $prev, $right_bit)
  {
    if ($id === null) {
      return $prev . str_pad('1', $right_bit, '0', STR_PAD_LEFT);
    } else {
      $right = substr($id, -$right_bit);
      $right++;
      return $prev . str_pad($right, $right_bit, '0', STR_PAD_LEFT);
    }
  }

  public static function getLike($like)
  {
    if ($like) return '%' . $like . '%';
    return '%李%';
  }

  public static function getBool($true_string)
  {
    return $true_string === 'true' ? 1 : 0;
  }

}