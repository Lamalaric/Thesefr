<?php

// Par exemple : nom='bibi'   -->    affiche toutes les theses au nom de bibi.

?>

<?php
//include('../class/Dump.php');
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
    <section class="research">
        <form action="" method="post" class="searchbar">
            <input type="text" name="searchbar" placeholder="Rechercher une thèse...">
            <input type="submit" name="submit-search" value="Rechercher">
        </form>
    </section>
    <section class="results">
        <?php
        //Résultat de la recherche
        if (isset($_POST['searchbar'])) {
            echo '
                <table>
                    <caption>Résultat de la recherche</caption>
                    <thead>
                        <tr>
                            <th class="empty_cell" colspan="6"></th>
                            <th colspan="2">Dates</th>
                            <th colspan="2">Sur these.fr</th>
                        </tr>
                        <tr>
                            <th scope="col">Titre</th>
                            <th scope="col">Auteur</th>
                            <th scope="col">Directeur</th>
                            <th scope="col">Établissement</th>
                            <th scope="col">Discipline</th>
                            <th scope="col">Statut</th>
                            <th scope="col">D\'inscription</th>
                            <th scope="col">De soutenance</th>
                            <th scope="col">Publié le</th>
                            <th scope="col">Mis à jour le</th>
                        </tr>
                    </thead>
                    <tbody>
                 ';
            //On récupère toutes les thèses comportant le résultat de la recherche dans "auteur"
            $query = "SELECT * FROM these WHERE LOWER(auteur) LIKE LOWER('%".$_POST['searchbar']."%');";
            $result = $mysqli->query($query);

            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $row) {
                //On affiche les lignes une par une dans le tableau
//                echo $row["auteur"]."<br>";
                echo '
                    <tr>
                        <th>'.$row["titre"].'</th>
                        <th>'.$row["auteur"].'</th>
                        <th>'.$row["directeur_these_pn"].'</th>
                        <th>'.$row["etablissement_soutenance"].'</th>
                        <th>'.$row["discipline"].'</th>
                        <th>'.$row["statut"].'</th>
                        <th>'.$row["date_inscription"].'</th>
                        <th>'.$row["date_soutenance"].'</th>
                        <th>'.$row["date_publication_site"].'</th>
                        <th>'.$row["date_maj_site"].'</th>
                    </tr>
                    ';
            }

            $query = "SELECT * FROM these WHERE LOWER(auteur) LIKE LOWER(?);";
            $req = $mysqli->prepare($query);
            $req->bind_param("s", $_POST['searchbar']);
            // Insertion de la requête SQL dans la BDD
            if ($req->execute()) {
                //Si ça se passe bien alors on créer la ligne du tableau comme au dessus.
                //C'est la méthode à utiliser (prepare), donc on enlevera ce qu'il y a avant
                echo "<br>La requête numéro à correctement été effectuée.";
            } else {
                echo "<br>Une erreur est survenue sur la requête numéro xxx";
            }

            echo '</tbody></table>';
        }
        ?>
    </section>
</main>

</body>
</html>
