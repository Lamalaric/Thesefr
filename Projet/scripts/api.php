<?php

// Par exemple : nom='bibi'   -->    affiche toutes les theses au nom de bibi.

?>

<?php
//include('../class/Dump.php');
//include('../connexion.php');
//Remove le warning du port
error_reporting(E_ALL ^ E_WARNING);

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
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <title>Projet PHP</title>
    <meta name="author" content="Amalaric Le Forestier" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../styles/style.css" type="text/css" />
    <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.js"></script>
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
        /*if (isset($_POST['searchbar'])) {
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


            //Exécute une requête préparée en passant un tableau de valeurs
            $sth = $dbh->prepare('SELECT * FROM these WHERE auteur LIKE '%Saeed%';');
            $sth->bindParam(":recherche", $_POST['searchbar']);

            // Insertion de la requête SQL dans la BDD
            if ($sth->execute()) {
                //Si ça se passe bien alors on crée la ligne du tableau comme au-dessus.
                $result = $sth->fetchAll();
                foreach ($result as $row) {
                    //On affiche les lignes une par une dans le tableau
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
            } else {
                echo "<br>Une erreur est survenue sur la requête numéro xxx";
            }
            echo '</tbody></table>';



            //On récupère toutes les thèses comportant le résultat de la recherche dans "auteur"
            $query = "SELECT * FROM these;";
            $result = $dbh->query($query);

            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $row) {
                //On affiche les lignes une par une dans le tableau
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
        }*/
        ?>

        <div class="grid-wrapper">
            <div id="myGrid" class="ag-theme-material"></div>
        </div>


        <script>
            let columnDefs = [
                {field: "Titre"},
                {field: "Auteur"},
                {field: "Directeur"},
                {field: "Établissement"},
                {field: "Discipline"},
                {field: "Statut"},
                {field: "Date inscription"},
                {field: "Date de soutenance"},
                {field: "Publié le"},
                {field: "Mis à jour le"},
            ];


            //Ajout d'une ligne
            let rowData = <?php

                //Exécute une requête préparée en passant un tableau de valeurs
                $sth = $dbh->prepare('SELECT * FROM these WHERE auteur LIKE '%Saeed%';');
                $sth->bindParam(":recherche", $_POST['searchbar']);

                // Insertion de la requête SQL dans la BDD
                if ($sth->execute()) {
                    //Si ça se passe bien alors on crée la ligne du tableau comme au-dessus.
                    $result = $sth->fetchAll();
                    foreach ($result as $row) {
                        //On affiche les lignes une par une dans le tableau
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
                } else {
                    echo "<br>Une erreur est survenue sur la requête numéro xxx";
                }
                echo '</tbody></table>';

                $test = array(0=> array("Titre"=>"Le credit documentaire et l'onopposabilite des exceptions",
                    "Auteur"=>"Saeed Al marri",
                    "Directeur"=>"Philippe Delebecque",
                    "Établissement"=>"Paris 1",
                    "Discipline"=>"Driot prive",
                    "Statut"=>"enCours",
                    "Date inscription"=>"2011-09-30",
                    "Date de soutenance"=>"1970-01-01",
                    "Publié le"=>"2012-01-26",
                    "Mis à jour le"=>"2012-01-26",));
                echo json_encode($test);
                ?>;

            let gridOptions = {
                columnDefs: columnDefs,
                defaultColDef: {
                    flex: 1,
                    minWidth: 150,
                    filter: true,
                    sortable: true,
                    resizable: true,
                },

                rowData: rowData,

                rowGroupPanelShow: 'always',
                pagination: true,
                overlayLoadingTemplate:
                    '<span class="ag-overlay-loading-center">Please wait while your rows are loading</span>',
            };

            // setup the grid after the page has finished loading
            document.addEventListener('DOMContentLoaded', function() {
                let gridDiv = document.querySelector('#myGrid');
                new agGrid.Grid(gridDiv, gridOptions);
            });
        </script>

    </section>
</main>

</body>
</html>
