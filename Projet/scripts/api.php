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
    <script>
        let columnDefs = [
            {headerName: "Make", field: "make"},
            {headerName: "Model", field: "model"},
            {headerName: "Price", field: "price"}
        ];


        let rowData = <?php
            $test = array(0=> array("make"=>"toto", "model"=>"titi", "price"=>"tata"));
            echo json_encode($test);
        ?>;

        // let the grid know which columns and what data to use
        let gridOptions = {
            columnDefs: columnDefs,
            rowData: rowData
        };

        // setup the grid after the page has finished loading
        document.addEventListener('DOMContentLoaded', function() {
            let gridDiv = document.querySelector('#myGrid');
            new agGrid.Grid(gridDiv, gridOptions);
        });
    </script>
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

        <div id="myGrid" style="height: 200px; width:500px;"></div>

    </section>
</main>

</body>
</html>
