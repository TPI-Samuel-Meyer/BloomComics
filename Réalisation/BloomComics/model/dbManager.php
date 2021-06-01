<?php
/*
 * User: Samuel Meyer
 * Date: 21.01.20
 * Updated by:
 * - 15.02.21 - Samuel Meyer
 *  Security against quotes function optimisation.
 * - 22.03.21 - Samuel Meyer
 *  Update secured function added and insert function securing.
 */

/**
 * This function is designed for sql select query construction from params. It directly send the query with bdConnector.php select function.
 * @param $targetedDatas : must be database targeted data columns.
 * @param $table : must be targeted table in database.
 * @param $targetedElements : must be a string array [field => value] ex. "WHERE <field> = <value>"  (multiple "WHERE" is managed, auto-separated with "AND")..
 * @return array|false|null
 */
function select($targetedDatas, $table, $targetedElements = []){
  global $db;
  $query = 'SELECT '. sqlTextSELECT_Constructor($targetedDatas) .' FROM '. $table;
  if(!empty($targetedElements)){
    $query .= ' WHERE '. sqlTextWHERE_Constructor($targetedElements);
  }

  $params = array_values($targetedElements);

  return $db->select($query,$params);
}

/**
 * This function is designed for sql insert query construction from params. It directly send the query with bdConnector.php insert function.
 * @param $table : must be targeted table in database.
 * @param $newDatas [field => value] : must be a string array containing sql field and data to insert in. <field> as sql field and <value> as data to insert.
 * @return int : $statement->execute() returns last inserted id if the insert was successful.
 */
function insert($table, $newDatas = []){
  global $db;

  $query = 'INSERT INTO '. $table .' (';

  foreach($newDatas as $field => $newData){
    $fieldList[] = '`'. $field .'`';
    $dataTags[] = '?';
    $dataList[] = $newData;
  }

  $query .= implode(', ', $fieldList) .') VALUES ('. implode(', ', $dataTags). ')';
  $params = array_values($dataList);

  return $db->insert($query,$params);
}

/**
 * This function is designed for sql update query construction from params. It directly send the query with bdConnector.php update function.
 * @param $table : must be targeted table in database.
 * @param $id : must be targeted element id that data will be updated.
 * @param $newDatas [field => value] : must be a string array containing sql field and new data. <field> as sql field and <value> as new data.
 * @return int : $statement->execute() returns the last inserted id if the insert was successful.
**/
function update($table, $id, $newDatas = []){
  global $db;
  $update = $params = [];

  foreach($newDatas as $field => $newData){
    $update[] = $field ." = ?";
    $params[] = $newData;
  }
  $params[] = $id;
  $query = 'UPDATE '. $table .' SET '. implode(', ', $update) .' WHERE id = ?';

  return $db->update($query,$params);
}

/**
 * This function is designed for sql delete query construction from params. It directly send the query with bdConnector.php update function.
 * @param $table : must be targeted table in database.
 * @param $targetedElements : must be a string array [field => value] ex. "WHERE <field> = <value>"  (multiple "WHERE" is managed, auto-separated with "AND")..
 * @return int : $statement->execute() returns the last inserted id if the insert was successful.
 */
function delete($table, $targetedElements = []){
    global $db;
    $query = 'DELETE FROM '. $table;
    if(!empty($targetedElements)){
        $query .= ' WHERE '. sqlTextWHERE_Constructor($targetedElements);
    }

    $params = array_values($targetedElements);

    return $db->update($query,$params);
}

/**
 * This function is designed to construct sql query part between "SELECT" and "FROM" from params.
 * @param $targetedDatas : must be the database targeted data columns.
 * @return string : returns correctly implemented targeted data columns for sql query Place in query : "SELECT <string> FROM..."
 */
function sqlTextSELECT_Constructor($targetedDatas){
  $sqlTextDataSELECT = [];

  if(is_array($targetedDatas)){
    foreach($targetedDatas as $targetedData){
      $sqlTextDataSELECT[] = $targetedData;
    }
  }else{
    $sqlTextDataSELECT[] = $targetedDatas;
  }

  return implode(', ', $sqlTextDataSELECT);
}

/**
 * This function is designed to construct sql query for single of multiple "WHERE" conditions (multiple "WHERE" is managed, auto-separated with "AND").
 * @param $targetedElements : must be a string array [field => value] ex. "WHERE <field> = <value>".
 * @return string : returns correctly implemented targeted data columns for sql query. Place in query : "WHERE <string>...".
 */
function sqlTextWHERE_Constructor($targetedElements){
  $sqlTextDataWHERE = [];

  foreach($targetedElements as $field => $value){
    $sqlTextDataWHERE[] = $field .' = ?';
  }

  return implode(' AND ', $sqlTextDataWHERE);
}
