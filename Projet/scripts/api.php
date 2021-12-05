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

        <div class="grid-wrapper">
            <div class="buttons">
                <button onclick="onBtPrint()">Imprimer</button>
                <button onclick="onBtnExport()">Exporter en csv</button>
            </div>
            <div id="myGrid" class="ag-theme-alpine"></div>
        </div>


        <script>
            let columnDefs = [
                {field: "Titre"},
                {field: "Auteur"},
                {field: "Directeur"},
                {field: "Établissement"},
                {field: "Statut"},
                {
                    headerName: 'Dates',
                    children: [
                        {field: "Inscription"},
                        {field: "Soutenance"},
                        {field: "Publication"}
                    ]
                }
            ];

            //Ajout d'une ligne
            let rowData = <?php
                //Formate la date en jour/mois/annee
                function formatDate($date): string
                {
                    $date = explode("-", $date);
                    return $date[2]."/".$date[1]."/".$date[0];
                }

                //Exécute une requête préparée en passant un tableau de valeurs
                $recherche = $_POST['searchbar'];
                $recherche = "%".$recherche."%";
                $sth = $dbh->prepare('SELECT * FROM these WHERE auteur LIKE :recherche;');
                $sth->bindParam(':recherche', $recherche);

                // Insertion de la requête SQL dans la BDD
                $rows = array();
                if ($sth->execute()) {
                    //Si ça se passe bien alors on crée la ligne du tableau
                    $result = $sth->fetchAll();
                    foreach ($result as $row) {
                        //Formatage des lignes nécessaires
                        $toExclude = array(",", ".");
                        str_replace($toExclude,"", $row[0]);
                        str_replace($toExclude,"", $row[2]);
                        if (count(explode("-", $row[10])) == 3) $row[10] = formatDate($row[10]);
                        if (count(explode("-", $row[11])) == 3) $row[11] = formatDate($row[11]);
                        if (count(explode("-", $row[15])) == 3) $row[15] = formatDate($row[15]);
                        if ($row[9]=='enCours') $row[9] = 'En cours';
                        else if ($row[9]=='soutenue') $row[9] = 'Soutenue';
                        //Création de la ligne à donner à l'AgGrid
                        $formatedRow = array(
                            "Titre"=>$row[2],
                            "Auteur"=>$row[0],
                            "Directeur"=>$row[3],
                            "Établissement"=>$row[6],
                            "Statut"=>$row[9],
                            "Inscription"=>$row[10],
                            "Soutenance"=>$row[11],
                            "Publication"=>$row[15]
                        );
                        array_push($rows, $formatedRow);
                    }
                }
                $searchResult = json_encode($rows);

                //On écrit dans un .json les lignes retournées
                $response['posts'] = $rows;
                $fp = fopen('../docs/results.json', 'w');
                fwrite($fp, json_encode($rows));
                fclose($fp);


                $emptyRow = array(0=> array(
                    "Titre"=>"",
                    "Auteur"=>"",
                    "Directeur"=>"",
                    "Établissement"=>"",
                    "Statut"=>"",
                    "Inscription"=>"",
                    "Soutenance"=>"",
                    "Publication"=>""));
                echo json_encode($emptyRow);
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
                paginationPageSize: 15,
                popupParent: document.body,
                overlayLoadingTemplate:
                    '<span class="ag-overlay-loading-center">Chargement des lignes...</span>',

                //Chargement des lignes optimisé
                rowBuffer: 0,
                rowSelection: 'multiple',
                // tell grid we want virtual row model type
                rowModelType: 'infinite',
                // how big each page in our page cache will be, default is 100
                cacheBlockSize: 100,
                // how many extra blank rows to display to the user at the end of the dataset,
                // which sets the vertical scroll and then allows the grid to request viewing more rows of data.
                // default is 1, ie show 1 row.
                cacheOverflowSize: 2,
                // how many server side requests to send at a time. if user is scrolling lots, then the requests
                // are throttled down
                maxConcurrentDatasourceRequests: 1,
                // how many rows to initially show in the grid. having 1 shows a blank row, so it looks like
                // the grid is loading from the users perspective (as we have a spinner in the first col)
                infiniteInitialRowCount: 1000,
                // how many pages to store in cache. default is undefined, which allows an infinite sized cache,
                // pages are never purged. this should be set for large data to stop your browser from getting
                // full of data
                maxBlocksInCache: 10
            };

            //Fonction pour exporter le tableau en CSV
            function onBtnExport() {
                gridOptions.api.exportDataAsCsv();
            }

            //Fonctions pour imprimer le tableau
            function onBtPrint() {
                const api = gridOptions.api;

                setPrinterFriendly(api);

                setTimeout(function () {
                    print();
                    setNormal(api);
                }, 2000);
            }
            function setPrinterFriendly(api) {
                const eGridDiv = document.querySelector('#myGrid');
                eGridDiv.style.height = '';
                api.setDomLayout('print');
            }
            function setNormal(api) {
                const eGridDiv = document.querySelector('#myGrid');
                eGridDiv.style.width = '700px';
                eGridDiv.style.height = '200px';

                api.setDomLayout(null);
            }

            // setup the grid after the page has finished loading
            document.addEventListener('DOMContentLoaded', function() {
                let gridDiv = document.querySelector('#myGrid');
                new agGrid.Grid(gridDiv, gridOptions);

                fetch('../docs/results.json')
                    .then((response) => response.json())
                    .then(function (data) {
                        let dataSource = {
                            rowCount: null, // behave as infinite scroll

                            getRows: function (params) {
                                console.log('asking for ' + params.startRow + ' to ' + params.endRow);

                                // At this point in your code, you would call the server, using $http if in AngularJS 1.x.
                                // To make the demo look real, wait for 500ms before returning
                                // take a slice of the total rows
                                let rowsThisPage = data.slice(params.startRow, params.endRow);
                                // if on or after the last page, work out the last row.
                                let lastRow = -1;
                                if (data.length <= params.endRow) {
                                    lastRow = data.length;
                                }
                                // call the success callback
                                params.successCallback(rowsThisPage, lastRow);
                            },
                        };

                        gridOptions.api.setDatasource(dataSource);
                    });
            });
        </script>
    </section>
</main>

</body>
</html>
