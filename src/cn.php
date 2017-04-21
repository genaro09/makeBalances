<?php
function NameDataBase(){
  $myDB="balances_db";
  return $myDB;
}
function cnx(){
    $host="localhost";
    $dbUser="root";
    $dbPass="";
    $myDB="balances_db";
    $cnx=mysqli_connect($host,$dbUser,$dbPass,$myDB);
    return $cnx;
}

function pruebaCnx(){
    $host="localhost";
    $dbUser="root";
    $dbPass="";
    $myDB="balances_db";
    $cnx=mysqli_connect($host,$dbUser,$dbPass,$myDB);
    $flag=0;
    if (mysqli_connect_errno()) {
        $flag=0;
    }

    if (mysqli_ping($cnx)) {
        $flag=1;
    } else {
        $flag=0;
    }
    mysqli_close($cnx);
    return $flag;
}

?>
