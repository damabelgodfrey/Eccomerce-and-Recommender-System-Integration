<?php
/**
 * Class creates connection to SQLiteDatabase
 *@return database connection object
 */
class DBh{
  private $dbHost = "127.0.0.1";
  private static $dbUser = "root";
  private static $dbPassword= "";
  private $dbName = "store";
  protected function getConnection(){
    try {
      $dns = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
      $pdo = new PDO($dns, self::$dbUser, self::$dbPassword);
      //$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      return $pdo;
    } catch (\Exception $e) {
      debugfilewriter("Database Connection Error: ".$e);
      echo "Error occured";
      die();
    }
  }
}
 ?>
