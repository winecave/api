<?php

function getConnection() {
  $dsn = 'pgsql:dbname=winecave host=localhost port=5432';
  $user = 'winecaveadmin';
  $password = 'fbdc1234';

  try {
    $dbh = new PDO($dsn, $user, $password);
    //$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    print('Error:'.$e->getMessage());
    die();
  }

  return $dbh;

}

function insert($type, $value) {
    $dbh = getConnection();
    $stmt = $dbh->prepare('insert into sensorvalues(type, value, yyyy, mm, dd, hh, time)
                           values(:type, :value, :yyyy, :mm, :dd, :hh, :time)');
    $yyyy = (int)date('Y');
    $mm   = (int)date('m');
    $dd   = (int)date('d');
    $hh   = (int)date('H');
    $time = date('Y-m-d H:i:s');

    $stmt->bindParam(':type' , $type , PDO::PARAM_STR);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    $stmt->bindParam(':yyyy' , $yyyy , PDO::PARAM_INT);
    $stmt->bindParam(':mm'   , $mm   , PDO::PARAM_INT);
    $stmt->bindParam(':dd'   , $dd   , PDO::PARAM_INT);
    $stmt->bindParam(':hh'   , $hh   , PDO::PARAM_INT);
    $stmt->bindParam(':time' , $time , PDO::PARAM_STR);
    if ($stmt->execute()) {
        return True;
    } else { 
        return False;
    }
}

function insert2($type, $value, $timestamp) {
    $dbh = getConnection();
    $stmt = $dbh->prepare('insert into sensorvalues(type, value, yyyy, mm, dd, hh, time)
                           values(:type, :value, :yyyy, :mm, :dd, :hh, :time)');
    $d = date_create_from_format('Y-m-d H:i:s', $timestamp);
    $yyyy = (int)$d->format('Y');
    $mm   = (int)$d->format('m');
    $dd   = (int)$d->format('d');
    $hh   = (int)$d->format('H');

    $stmt->bindParam(':type' , $type     , PDO::PARAM_STR);
    $stmt->bindParam(':value', $value    , PDO::PARAM_STR);
    $stmt->bindParam(':yyyy' , $yyyy     , PDO::PARAM_INT);
    $stmt->bindParam(':mm'   , $mm       , PDO::PARAM_INT);
    $stmt->bindParam(':dd'   , $dd       , PDO::PARAM_INT);
    $stmt->bindParam(':hh'   , $hh       , PDO::PARAM_INT);
    $stmt->bindParam(':time' , $timestamp, PDO::PARAM_STR);
    if ($stmt->execute()) {
        return True;
    } else {
        return False;
    }
}
?>
