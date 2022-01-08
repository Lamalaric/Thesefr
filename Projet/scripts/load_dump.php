<?php

//Remove le warning du port
//error_reporting(E_ALL ^ E_WARNING);

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
include('../class/Dump.php');
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <title>Projet PHP</title>
    <meta name="author" content="Amalaric Le Forestier" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../styles/style.css" type="text/css" />
</head>

<body>
<nav>
    <div class="navbar">
        <ul>
            <li><a href="">Test dump</a></li>
            <li><a href="api.php">Rechercher une thèse</a></li>
        </ul>
    </div>
</nav>

<main>
    <div>
        <?php
        $file_to_read = "../docs/all_theses.csv";

        // On lit le fichier CSV, on stocke dans une liste toutes les thèses
//        $dump = new Dump();
//        $allTheses = $dump->readCSV($file_to_read);

//        var_dump($allTheses);


//        exit();

        if (($handle = fopen($file_to_read, 'rb')) !== FALSE) {
            print "fichier chargé<br>";
            $i = 0;
            while (($data = fgetcsv($handle, 1025, ';')) !== FALSE) {
                if ($i == 0) {
                    $i++;
                    continue;
                }
                //Une thèse contient au minimum : Auteur / Titre / Discipline
                if (empty($data[0]) && empty($data[2]) && empty($data[8])) {
                    continue;
                }
                print "ici0";

                $auteur = $data[0];
                $id_auteur = $data[1];
                $titre = $data[2];
                $directeur_these_pn = $data[3];
                $directeur_these_np = $data[4];
                if ($data[5] == ",") {
                    $id_directeur = "";
                } else $id_directeur = $data[5];
                $etablissement_soutenance = $data[6];
                $id_etablissement = $data[7];
                $discipline = $data[8];
                $statut = $data[9];
                if (date('Y-m-d',strtotime($data[10])) == '1970-01-01') {
                    $date_inscription = null;
                } else $date_inscription = date('Y-m-d',strtotime($data[10]));
                if (date('Y-m-d',strtotime($data[11])) == '1970-01-01') {
                    $date_soutenance = null;
                } else $date_soutenance = date('Y-m-d',strtotime($data[11]));
                $langue_these = $data[12];
                $id_these = $data[13];
                $accessible_online = $data[14];
                if (date('Y-m-d',strtotime($data[15])) == '1970-01-01') {
                    $date_publication_site = null;
                } else $date_publication_site = date('Y-m-d',strtotime($data[15]));
                if (date('Y-m-d',strtotime($data[16])) == '1970-01-01') {
                    $date_maj_site = null;
                } else $date_maj_site = date('Y-m-d',strtotime($data[16]));

                print "ici1";
                // Requête préparée
                $sql = "INSERT INTO these2 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $req = $dbh->prepare($sql);
                print "ici2";

                // Insertion de la requête SQL dans la BDD
                if ($req->execute(array(
                    $auteur,
                    $id_auteur,
                    $titre,
                    $directeur_these_pn,
                    $directeur_these_np,
                    $id_directeur,
                    $etablissement_soutenance,
                    $id_etablissement,
                    $discipline,
                    $statut,
                    $date_inscription,
                    $date_soutenance,
                    $langue_these,
                    $id_these,
                    $accessible_online,
                    $date_publication_site,
                    $date_maj_site
                ))) {
                    echo "oui<br>";
                } else {
                    echo "<br>Une erreur est survenue sur la requête numéro ".$i;
                    echo "$auteur<br>
                    $id_auteur<br>
                    $titre<br>
                    $directeur_these_pn<br>
                    $directeur_these_np<br>
                    $id_directeur<br>
                    $etablissement_soutenance<br>
                    $id_etablissement<br>
                    $discipline<br>
                    $statut<br>
                    $date_inscription<br>
                    $date_soutenance<br>
                    $langue_these<br>
                    $id_these<br>
                    $accessible_online<br>
                    $date_publication_site<br>
                    $date_maj_site";
                    var_dump($dbh);
                    echo "<br><br>";
                    var_dump($date_inscription);
                }
                $i++;
            }
            fclose($handle);
        }


//        $nbTheses = count($allTheses);
//        $nbTheses = 2;
        // VERIFIER SI CHAQUE LIGNE EST BIEN FORMATÉE
//        for ($i=1<br>> $iMax = count($allTheses); $i< $iMax; $i++) {
//        for ($i=1; $i< $nbTheses; $i++) {
//            //Une thèse contient au minimum : Auteur / Titre / Discipline
//            if ($allTheses[$i]->getAuteur() != "" && $allTheses[$i]->getTitre() != "" && $allTheses[$i]->getDiscipline() != "") {
//                continue;
//            }
//            $auteur = $allTheses[$i]->getAuteur();
//            $id_auteur = $allTheses[$i]->getIdAuteur();
//            $titre = $allTheses[$i]->getTitre();
//            $directeur_these_pn = $allTheses[$i]->getDirecteurThesePn();
//            $directeur_these_np = $allTheses[$i]->getDirecteurTheseNp();
//            if ($allTheses[$i]->getIdDirecteur() == ",") {
//                $id_directeur = "";
//            }
//            $id_directeur = $allTheses[$i]->getIdDirecteur();
//            $etablissement_soutenance = $allTheses[$i]->getEtablissementSoutenance();
//            $id_etablissement = $allTheses[$i]->getIdEtablissement();
//            $discipline = $allTheses[$i]->getDiscipline();
//            $statut = $allTheses[$i]->getStatut();
//            if ($allTheses[$i]->getDateInscription() == '1970-01-01') {
//                $date_inscription = "";
//            } else $date_inscription = $allTheses[$i]->getDateSoutenance();
//            if ($allTheses[$i]->getDateSoutenance() == '1970-01-01') {
//                $date_soutenance = "";
//            } else $date_soutenance = $allTheses[$i]->getDateSoutenance();
//            $langue_these = $allTheses[$i]->getLangueThese();
//            $id_these = $allTheses[$i]->getIdThese();
//            $accessible_online = $allTheses[$i]->getAccessibleOnline();
//            if ($allTheses[$i]->getDatePublicationSite() == '1970-01-01') {
//                $date_publication_site = "";
//            } else $date_publication_site = $allTheses[$i]->getDatePublicationSite();
//            if ($allTheses[$i]->getDatePublicationSite() == '1970-01-01') {
//                $date_publication_site = "";
//            } else $date_publication_site = $allTheses[$i]->getDatePublicationSite();
//            if ($allTheses[$i]->getDateMajSite() == '1970-01-01') {
//                $date_maj_site = "";
//            } else $date_maj_site = $allTheses[$i]->getDateMajSite();
//
//            // Requête préparée
//            $sql = "INSERT INTO these2 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
//            $req = $dbh->prepare($sql);
//
//            // Insertion de la requête SQL dans la BDD
//            if ($req->execute(array(
//                    $auteur,
//                    $id_auteur,
//                    $titre,
//                    $directeur_these_pn,
//                    $directeur_these_np,
//                    $id_directeur,
//                    $etablissement_soutenance,
//                    $id_etablissement,
//                    $discipline,
//                    $statut,
//                    $date_inscription,
//                    $date_soutenance,
//                    $langue_these,
//                    $id_these,
//                    $accessible_online,
//                    $date_publication_site,
//                    $date_maj_site
//            ))) {
//                echo "oui<br>";
//                continue;
//            } else {
//                echo "<br>Une erreur est survenue sur la requête numéro ".$i;
//            }
//        }

//        try {
//            $test = json_encode($allTheses);
//            $theseArray = json_decode(json_encode($allTheses), true);
//        } catch (JsonException $e) {
//            echo "tran";
//        }
//        var_dump($allTheses);
        ?>

    </div>
</main>
</body>

</html>