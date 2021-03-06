<?php
namespace QCloud_WeApp_SDK\Mysql;

use \Exception;
use \PDO;

use QCloud_WeApp_SDK\Conf;
use QCloud_WeApp_SDK\Constants;

/**
 * 简单的使用 PDO 操作 MySQL 数据库类
 * 类为静态类，全部静态调用
 */
class Mysql
{
  private static $conn;

  public static function getInstance () {
    if (!self::$conn) {
      $mysql = Conf::getMysql();
      $_host = $mysql['host'];
      $_port = $mysql['port'];
      $_user = $mysql['user'];
      $_pass = $mysql['pass'];
      $_char = $mysql['char'];
      $_db = $mysql['db'];
      $dsn = "mysql:host=$_host;dbname=$_db;port=$_port;charset=$_char";

      try {
        self::$conn = new PDO($dsn, $_user, $_pass);
        self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        self::$conn->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
      } catch (PDOException $e) {
        throw new Exception(Constants::E_CONNECT_TO_DB . ': '. $e->getMessage());
      }
    }

    return self::$conn;
  }

  /**
   * 插入数据到数据库
   * @param string $tableName 数据库名
   * @param array  $data      要插入的数据
   */
  public static function insert ($tableName, $data) {
    if (gettype($tableName) !== 'string' || gettype($data) !== 'array') {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }

    $prepareData = self::prepare($data);
    $prepareFieldsStr = implode(', ', array_keys($prepareData));
    $fieldsStr = implode(', ', array_keys($data));
    $sql = "INSERT INTO `$tableName` ($fieldsStr) VALUES ($prepareFieldsStr)";

    // 执行 SQL 语句
    $query = self::raw($sql, $prepareData);
    return $query->rowCount();
  }

  /**
   * 查询多行数据
   * @param string        $tableName 数据库名
   * @param array         $columns   查询的列名数组
   * @param array         $condition 查询条件，若为字符串则会被直接拼接进 SQL 语句中，支持键值数组
   * @param string        $operator  condition 连接的操作符：and|or
   * @param string        $suffix    SQL 查询后缀，例如 order, limit 等其他操作
   * @return array
   */
  public static function select ($tableName, $columns = ['*'], $conditions = '', $operator = 'and', $suffix = '') {
    if (gettype($tableName)  !== 'string'
      || gettype($conditions) !== 'array' && gettype($conditions) !== 'string'
      || gettype($columns)    !== 'array'
      || gettype($operator)   !== 'string'
      || gettype($suffix)     !== 'string') {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }

    list($condition, $execValues) = array_values(self::conditionProcess($conditions, $operator));

    $column = implode(', ', $columns);
    // 拼接 SQL 语句
    $sql = "SELECT $column FROM `$tableName`";

    // 如果有条件则拼接 WHERE 关键则
    if ($condition) {
      $sql .= " WHERE $condition";
    }

    // 拼接后缀
    $sql .= " $suffix";

    // 执行 SQL 语句
    $query = self::raw($sql, $execValues);
    $allResult = $query->fetchAll(PDO::FETCH_OBJ);
    return $allResult === NULL ? [] : $allResult;
  }

  /**
   * @param $tableName
   * @param $funcName                     MAX,MIN...
   * @param $fieldName
   * @param string $conditions
   * @return null||value                  返回：空值||函数值
   * @throws Exception
   */
  public static function func ($tableName, $funcName, $fieldName, $conditions) {
    if (gettype($tableName)   !== 'string'
      || gettype($funcName)   !== 'string'
      || gettype($fieldName)  !== 'string'
      || gettype($conditions) !== 'array') {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }

    list($condition, $execValues) = array_values(self::conditionProcess($conditions, 'and'));

    // 拼接 SQL 语句
    $sql = "SELECT $funcName($fieldName) as value FROM `$tableName`";

    // 如果有条件则拼接 WHERE 关键则
    if ($condition) {
      $sql .= " WHERE $condition";
    }

    // 执行 SQL 语句
    $query = self::raw($sql, $execValues);
    $allResult = $query->fetchAll(PDO::FETCH_OBJ);
    return $allResult === NULL ? NULL : $allResult[0]->value;
  }

  private static function likeProcess ($conditions, $operator = 'or') {
    return self::customProcess($conditions, $operator, 'like');
  }

  public static function like ($tableName, $columns = ['*'], $conditions, $likes, $likes_opt = 'or', $suffix = '') {
    if (gettype($tableName) !== 'string'
      || gettype($columns) !== 'array'
      || gettype($conditions) !== 'array' && gettype($conditions) !== 'string'
      || gettype($likes) !== 'array'
      || gettype($likes_opt) !== 'string'
      || gettype($suffix) !== 'string') {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }
    // 处理条件
    list($condition, $execValues) = array_values(self::conditionProcess($conditions, 'and'));
    // 处理模糊条件
    list($like, $execLikesValues) = array_values(self::likeProcess($likes, $likes_opt));
    // 查询字段列表串
    $column = implode(', ', $columns);
    // 拼接 SQL 语句
    $sql = "SELECT $column FROM `$tableName`";
    // 如果有条件则拼接 WHERE
    if ($condition && $like) {
      $sql .= " WHERE $condition AND $like";
    } elseif ($condition) {
      $sql .= " WHERE $condition";
    } elseif ($like) {
      $sql .= " WHERE $like";
    }
    // 拼接后缀
    $sql .= " $suffix";
    // 执行 SQL 语句
    $query = self::raw($sql, array_merge($execValues, $execLikesValues));
    $allResult = $query->fetchAll(PDO::FETCH_OBJ);
    return $allResult === NULL ? [] : $allResult;
  }

  public static function custom ($tableName, $columns = ['*'], $conditions, $customs, $customs_condition, $customs_opt = 'and', $suffix = '') {
    if (gettype($tableName) !== 'string'
      || gettype($columns) !== 'array'
      || gettype($conditions) !== 'array' && gettype($conditions) !== 'string'
      || gettype($customs) !== 'array'
      || gettype($customs_condition) !== 'string'
      || gettype($customs_opt) !== 'string'
      || gettype($suffix) !== 'string')
    {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }
    // 处理条件
    list($condition, $execValues) = array_values(self::conditionProcess($conditions, 'and'));
    // 处理自定义条件
    list($custom, $execCustomValues) = array_values(self::customProcess($customs, $customs_opt, $customs_condition));
    // 查询字段列表串
    $column = implode(', ', $columns);
    // 拼接 SQL 语句
    $sql = "SELECT $column FROM `$tableName`";
    // 如果有条件则拼接 WHERE
    if ($condition && $custom) {
      $sql .= " WHERE $condition AND $custom";
    } elseif ($condition) {
      $sql .= " WHERE $condition";
    } elseif ($custom) {
      $sql .= " WHERE $custom";
    }
    // 拼接后缀
    $sql .= " $suffix";
    // 执行 SQL 语句
    $query = self::raw($sql, array_merge($execValues, $execCustomValues));
    $allResult = $query->fetchAll(PDO::FETCH_OBJ);
    return $allResult === NULL ? [] : $allResult;
  }

  /**
   * 查询单行数据
   * @param string        $tableName 数据库名
   * @param array         $columns   查询的列名数组
   * @param array|string  $condition 查询条件，若为字符串则会被直接拼接进 SQL 语句中，支持键值数组
   * @param string        $operator  condition 连接的操作符：and|or
   * @param string        $suffix    SQL 查询后缀，例如 order, limit 等其他操作
   * @return object
   */
  public static function row ($tableName, $columns = ['*'], $conditions = '', $operator = 'and', $suffix = '') {
    $rows = self::select($tableName, $columns, $conditions, $operator, $suffix);
    return count($rows) === 0 ? NULL : $rows[0];
  }

  /**
   * 更新数据库
   * @param string        $tableName 数据库名
   * @param array         $updates   更新的数据对象
   * @param array|string  $condition 查询条件，若为字符串则会被直接拼接进 SQL 语句中，支持键值数组
   * @param string        $operator  condition 连接的操作符：and|or
   * @param string        $suffix    SQL 查询后缀，例如 order, limit 等其他操作
   * @return number 受影响的行数
   */
  public static function update ($tableName, $updates, $conditions = '', $operator = 'and', $suffix = '') {
    if (gettype($tableName)  !== 'string'
      || gettype($updates)    !== 'array'
      || gettype($conditions) !== 'array'
      || gettype($operator)   !== 'string'
      || gettype($suffix)     !== 'string') {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }

    // 处理要更新的数据
    list($processedUpdates, $execUpdateValues) = array_values(self::conditionProcess($updates, ','));

    // 处理条件
    list($condition, $execValues) = array_values(self::conditionProcess($conditions, $operator));

    // 拼接 SQL 语句
    $sql = "UPDATE `$tableName` SET $processedUpdates";

    // 如果有条件则拼接 WHERE 关键则
    if ($condition) {
      $sql .= " WHERE $condition";
    }

    // 拼接后缀
    $sql .= " $suffix";

    // 执行 SQL 语句
    $query = self::raw($sql, array_merge($execUpdateValues, $execValues));
    return $query->rowCount();
  }

  /**
   * 删除数据
   * @param string        $tableName 数据库名
   * @param array|string  $condition 查询条件，若为字符串则会被直接拼接进 SQL 语句中，支持键值数组
   * @param string        $operator  condition 连接的操作符：and|or
   * @param string        $suffix    SQL 查询后缀，例如 order, limit 等其他操作
   * @return number 受影响的行数
   */
  public static function delete ($tableName, $conditions, $operator = 'and', $suffix = '') {
    if (gettype($tableName)  !== 'string'
      || gettype($conditions) !== 'array'
      || gettype($operator)   !== 'string'
      || gettype($suffix)     !== 'string') {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }

    // 处理条件
    list($condition, $execValues) = array_values(self::conditionProcess($conditions, $operator));

    // 拼接 SQL 语句
    $sql = "DELETE FROM `$tableName` WHERE $condition $suffix";

    // 执行 SQL 语句
    $query = self::raw($sql, $execValues);
    return $query->rowCount();
  }

  /**
   * 执行原生 SQL 语句
   * @param string $sql  要执行的 SQL 语句
   * @param array  $data SQL 语句的参数值
   */
  public static function raw ($sql, $execValues = []) {
    $query = self::getInstance()->prepare($sql);
    $result = $query->execute($execValues);
    if ($result) {
      return $query;
    } else {
      $error = $query->errorInfo();
      throw new Exception(Constants::E_EXEC_SQL_QUERY . ': ' . $error[2]);
    }
  }

  /**
   * 自定义规则处理条件数组
   * @example ['a' => 1, 'b' => 2] 会被转换为 ['a = :a and b = :b', [':a' => 1, ':b' => 2]]
   * @param array        $conditions 条件数组
   * @param string       $operator  condition 连接的操作符：and|or
   * @param string       $keyword 条件连接关键字 = <> like > <
   */
  private static function customProcess ($conditions, $operator = 'or', $keyword = '=') {
    if (gettype($conditions) !== 'array') {
      throw new Exception(Constants::E_CALL_FUNCTION_PARAM);
    }
    $condition = '';
    $execValues = [];

    $cdt = [];
    foreach ($conditions as $key => $value) {
      if (gettype($value) === 'number') {
        array_push($cdt, $value);
      } else {
        array_push($cdt, $key . " $keyword :" . $key);
        $execValues[$key] = $value;
      }
    }
    $condition = implode(' ' . $operator . ' ', $cdt);
    // 如果是or，则要加()，要是and，则不要加
    if ($condition && $operator === 'or') {
      $condition = '(' . $condition .')';
    }
    return [$condition, self::prepare($execValues)];
  }

  /**
   * 按照指定的规则处理条件数组
   * @example ['a' => 1, 'b' => 2] 会被转换为 ['a = :a and b = :b', [':a' => 1, ':b' => 2]]
   * @param array|string $conditions 条件数组或字符串
   * @param string       $operator  condition 连接的操作符：and|or
   */
  private static function conditionProcess ($conditions, $operator = 'and') {
    $condition = '';
    $execValues = [];
    if (gettype($conditions) === 'array') {
      $cdt = [];
      foreach ($conditions as $key => $value) {
        if (gettype($value) === 'number') {
          array_push($cdt, $value);
        } else {
          array_push($cdt, $key . ' = :' . $key);
          $execValues[$key] = $value;
        }
      }
      $condition = implode(' ' . $operator . ' ', $cdt);
    } else {
      $condition = $conditions;
    }
    return [$condition, self::prepare($execValues)];
  }

  /**
   * 转换数据为 PDO 支持的 prepare 过的数据
   * @example ['a' => 1] 会被转换为 [':a' => 1]
   * @param array $dataArray 要转换的数据
   */
  private static function prepare ($dataArray) {
    $prepareData = [];

    foreach ($dataArray as $field => $value) {
      $prepareData[':' . $field] = $value;
    }

    return $prepareData;
  }
}
