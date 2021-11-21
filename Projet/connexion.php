<?php
//Remove le warning du port
error_reporting(E_ALL ^ E_WARNING);

$db_host = 'sqletud.u-pem.fr';
$db_user = 'leforestier';
$db_password = '';
$db_db = 'leforestier_db';

try {
    $dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_db.';charset=utf8;port=3306', $db_user, $db_password);
    $dbh = null;
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>