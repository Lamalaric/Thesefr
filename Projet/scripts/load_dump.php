<?php
include('../class/Dump.php');
include('../connexion.php');
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
            <li><a href="../index.php">Menu</a></li>
            <li><a href="api.php">Rechercher une thèse</a></li>
        </ul>
    </div>
</nav>

<main>
    <div>
        <?php
        $file_to_read = "../docs/dump_abes_thesesfr.csv";

        // On lit le fichier CSV, on stocke dans une liste toutes les thèses
        $dump = new Dump();
        $allTheses = $dump->readCSV($file_to_read);

        // VERIFIER SI CHAQUE LIGNE EST BIEN FORMATÉE
        for ($i=1, $iMax = count($allTheses); $i< $iMax; $i++) {
            $auteur = $allTheses[$i]->getAuteur();
            $id_auteur = $allTheses[$i]->getIdAuteur();
            $titre = $allTheses[$i]->getTitre();
            $directeur_these_pn = $allTheses[$i]->getDirecteurThesePn();
            $directeur_these_np = $allTheses[$i]->getDirecteurTheseNp();
            $id_directeur = $allTheses[$i]->getIdDirecteur();
            $etablissement_soutenance = $allTheses[$i]->getEtablissementSoutenance();
            $id_etablissement = $allTheses[$i]->getIdEtablissement();
            $discipline = $allTheses[$i]->getDiscipline();
            $statut = $allTheses[$i]->getStatut();
            $date_inscription = $allTheses[$i]->getDateInscription();
            $date_soutenance = $allTheses[$i]->getDateSoutenance();
            $langue_these = $allTheses[$i]->getLangueThese();
            $id_these = $allTheses[$i]->getIdThese();
            $accessible_online = $allTheses[$i]->getAccessibleOnline();
            $date_publication_site = $allTheses[$i]->getDatePublicationSite();
            $date_maj_site = $allTheses[$i]->getDateMajSite();
            // Requête préparée
            $sql = "INSERT INTO these VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $req = $mysqli->prepare($sql);
            $req->bind_param("sssssssssssssssss", $auteur, $id_auteur, $titre, $directeur_these_pn, $directeur_these_np, $id_directeur, $etablissement_soutenance, $id_etablissement, $discipline, $statut, $date_inscription, $date_soutenance, $langue_these, $id_these, $accessible_online, $date_publication_site, $date_maj_site);
            // Insertion de la requête SQL dans la BDD
            /*if ($req->execute()) {
                echo "<br>La requête numéro ".$i." à correctement été effectuée.";
            } else {
                echo "<br>Une erreur est survenue sur la requête numéro ".$i;
            }*/
        }
        $req->close();

        try {
            $test = json_encode($allTheses, JSON_THROW_ON_ERROR);
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