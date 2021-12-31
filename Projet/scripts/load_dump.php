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
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $file_to_read = "../docs/all_theses.csv";

        // On lit le fichier CSV, on stocke dans une liste toutes les thèses
        $dump = new Dump();
        $allTheses = $dump->readCSV($file_to_read);

        var_dump($allTheses);


        exit();


        // VERIFIER SI CHAQUE LIGNE EST BIEN FORMATÉE
        for ($i=1, $iMax = count($allTheses); $i< $iMax; $i++) {
            //Une thèse contient au minimum : Auteur / Titre / Discipline
            if ($allTheses[$i]->getAuteur() != "" && $allTheses[$i]->getTitre() != "" && $allTheses[$i]->getDiscipline() != "") {
                continue;
            }
            $auteur = $allTheses[$i]->getAuteur();
            $id_auteur = $allTheses[$i]->getIdAuteur();
            $titre = $allTheses[$i]->getTitre();
            $directeur_these_pn = $allTheses[$i]->getDirecteurThesePn();
            $directeur_these_np = $allTheses[$i]->getDirecteurTheseNp();
            if ($allTheses[$i]->getIdDirecteur() == ",") {
                $id_directeur = "";
            }
            $id_directeur = $allTheses[$i]->getIdDirecteur();
            $etablissement_soutenance = $allTheses[$i]->getEtablissementSoutenance();
            $id_etablissement = $allTheses[$i]->getIdEtablissement();
            $discipline = $allTheses[$i]->getDiscipline();
            $statut = $allTheses[$i]->getStatut();
            if ($allTheses[$i]->getDateInscription() == '1970-01-01') {
                $date_inscription = "";
            } else $date_inscription = $allTheses[$i]->getDateSoutenance();
            if ($allTheses[$i]->getDateSoutenance() == '1970-01-01') {
                $date_soutenance = "";
            } else $date_soutenance = $allTheses[$i]->getDateSoutenance();
            $langue_these = $allTheses[$i]->getLangueThese();
            $id_these = $allTheses[$i]->getIdThese();
            $accessible_online = $allTheses[$i]->getAccessibleOnline();
            if ($allTheses[$i]->getDatePublicationSite() == '1970-01-01') {
                $date_publication_site = "";
            } else $date_publication_site = $allTheses[$i]->getDatePublicationSite();
            if ($allTheses[$i]->getDatePublicationSite() == '1970-01-01') {
                $date_publication_site = "";
            } else $date_publication_site = $allTheses[$i]->getDatePublicationSite();
            if ($allTheses[$i]->getDateMajSite() == '1970-01-01') {
                $date_maj_site = "";
            } else $date_maj_site = $allTheses[$i]->getDateMajSite();
            // Requête préparée
            $sql = "INSERT INTO these2 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $req = $dbh->prepare($sql);
            $req->bindParam("sssssssssssssssss", $auteur, $id_auteur, $titre, $directeur_these_pn, $directeur_these_np, $id_directeur, $etablissement_soutenance, $id_etablissement, $discipline, $statut, $date_inscription, $date_soutenance, $langue_these, $id_these, $accessible_online, $date_publication_site, $date_maj_site);
            // Insertion de la requête SQL dans la BDD
            if ($req->execute()) {
                continue;
            } else {
                echo "<br>Une erreur est survenue sur la requête numéro ".$i;
            }
        }

        try {
            $test = json_encode($allTheses);
            $theseArray = json_decode(json_encode($allTheses), true);
        } catch (JsonException $e) {
            echo "tran";
        }
        var_dump($allTheses);
        ?>

    </div>
</main>
</body>

</html>