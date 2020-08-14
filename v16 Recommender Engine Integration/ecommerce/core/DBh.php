<?php
class DBh{
  private $dbHost = "127.0.0.1";
  private static $dbUser = "root";
  private static $dbPassword= "";
  private $dbName = "store";

  protected function getConnection(){
    $dns = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
    $pdo = new PDO($dns, self::$dbUser, self::$dbPassword);
    //$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  }

}
 ?>
