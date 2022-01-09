<?php

//include('../class/Dump.php');
//include('../connexion.php');
//Remove le warning du port

$db_host = 'sqletud.u-pem.fr';
$db_user = 'leforestier';
$db_password = 'Chaton2402.';
$db_db = 'leforestier_db';

try {
    $dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_db.';charset=utf8;port=3306', $db_user, $db_password);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}




//Requête préparée
$sth = $dbh->prepare('SELECT DISTINCT id_etablissement,etablissement_soutenance FROM these2;');

//Résultats de la requête
if ($sth->execute()) {
    //Si ça se passe bien alors on crée la ligne du tableau
    $result = $sth->fetchAll();
    $lstCodes = array();
    foreach ($result as $row) {
        if ($row[0] == "") continue;

        $lstCoords = array();
        //Pour chaque code détablissement...
        $codeEtablissement = (string) $row[0];
        if (!in_array($codeEtablissement, $lstCodes)) {     //Si on a déjà fait pour ce code on passe
            //Récupération du json
            $content = file_get_contents("https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&q={$codeEtablissement}&rows=10&fileds=identifiant_idref&fields=identifiant_idref,coordonnees");
            $json = json_decode($content, true);
            //Récupération des coordonnées à partir du json
            if ($json['nhits'] == 0) continue;
            $coordX = $json['records'][0]['fields']['coordonnees'][0];
            $coordY = $json['records'][0]['fields']['coordonnees'][1];
            $etablissement = $row[1];

            $sql = "INSERT INTO coordonnees VALUES ('$codeEtablissement',$coordX,$coordY,'$etablissement');";
            $req = $dbh->prepare($sql);

            if ($req->execute()) {
                continue;
            }
        }
        array_push($lstCodes, $codeEtablissement);
    }
}

?>