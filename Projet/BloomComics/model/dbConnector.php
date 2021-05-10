<?php
/*
 * User: Samuel Meyer
 * Date: 25.11.2019
 * Updated by:
 * - 26.10.20 - Samuel Meyer
 *  Function params entries optimisation.
 *
 */

class Db
{
    private $dbConnection;
    public function __construct()
    {
      $this->openDBConnection();
    }
    /**
     * This function is designed to execute a query received with its params and it's protected against sql injections.
     * @param $query : must be build in sql syntax and "?" instead data fields.
     * @param $params : must be a string or a string array containing sql database targeted data columns.
     * @return array|null : get the query result (can be null).
     * Source : http://php.net/manual/en/pdo.prepare.php
     */
    public function select($query, $params = []){
      try{
        $statement = $this->dbConnection->prepare($query);//prepare query
        $statement->execute($params);
        $result = $statement->fetchAll();
      }catch(PDOException $e){
        echo $e->getMessage() .' '. $query;
        var_dump($params);
        return false;
      }
      return $result;
    }

    /**
     * This function is designed to insert values in database.
     * @param $query : must be build in sql syntax and "?" instead data fields.
     * @param $params : must be a string or a string array with data that will be inserted in database.
     * @return int : $statement->execute() returns the last inserted id if the insert was successful.
     * @throws PDOException
     */
    public function insert($query, $params = []){
      try{
        $statement = $this->dbConnection->prepare($query);//prepare query
        $statement->execute($params);
      }catch(PDOException $e){
        echo $e->getMessage() .' '. $query;
        var_dump($params);
        return false;
      }
      return $this->dbConnection->lastInsertId();
    }

    /**
     * This function is designed to update value in database
     * @param $query : must be build in sql syntax and "?" instead data fields.
     * @param $params : must be a string or a string array with data that will be updated in database.
     * @return int : $statement->execute() returns the last inserted id if the insert was successful.
     * @throws PDOException
     */
    public function update($query, $params = []){
      try{
        $statement = $this->dbConnection->prepare($query);//prepare query
        $statement->execute($params);
      }catch(PDOException $e){
        echo $e->getMessage() .' '. $query;
        var_dump($params);
        return false;
      }
      return $statement->rowCount();
    }

    /**
     * This function is designed to manage the database connexion. The client is responsible of closing.
     * @return PDO|null
     * Source : http://php.net/manual/en/pdo.construct.php
     */
    private function openDBConnection(){
        $sqlDriver = 'mysql';
        $hostname = 'localhost';
        $port = 3360;
        $charset = 'utf8';
        $dbName = 'bloomcomics';
        $userName = 'root';
        $userPwd = '';
        $dsn = $sqlDriver . ':host=' . $hostname . ';dbname=' . $dbName . ';port=' . $port . ';charset=' . $charset;

        $this->dbConnection = new PDO($dsn, $userName, $userPwd);
        $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
