<?php

/******ETAPE 1******/
function readEntry(){
  $stdin = fopen("php://stdin","r");
  $entry = fgets($stdin);
  fclose($stdin);
  return trim($entry);
}

/******ETAPE 2******/
$user = 'root';
$pass = 'root';
$table = 'cinema';
try{
  $bdd = new PDO('mysql:host=localhost;dbname='.$table.'charset=utf8', $user, $pass);
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
        die('Erreur '.$e->getMessage());
    }

/******ETAPE 3******/
$req = readEntry();

/******ETAPE 4******/
$cmd = explode(" ",$req)[0];

/***SHOW***/
if($cmd = 'show'){
  $res = "+ - - - - - - - - - - - - - - - - - - - -+\n";
  $table = str_replace(";","",explode(" ",$req)[1]);
  $reqShow = "SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME=".$table;
  $show = $bdd->query($reqShow);
  while($showR = $show->fetch()){
    $res .= "| ".$show['COLUMN_NAME']." |\n";
  }
  $res .= "+ - - - - - - - - - - - - - - - - - - - -+\n";
  echo $res;
}

/***SELECT***/
if($cmd = 'select'){
  $champ = explode(" ",$req)[1];
  $res = "+ - - - - - - - - - - - - - - - - - - - -+\n";
  $res.= " ".$champ."                              |\n";
  $len = strlen($req);
  $table = str_replace(";","",explode(" ",$req)[$len-1]);
  $reqSelect = "SELECT ".$champ." FROM ".$table.";";
  $select = $bdd->query($reqSelect);
  while($selectR = $select->fetch()){
    $res .= "| ".$selectR[$champs]." |\n";
  }
  $res .= "+ - - - - - - - - - - - - - - - - - - - -+\n";
  echo $res;
}
?>