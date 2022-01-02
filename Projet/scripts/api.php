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
    <title>Thèses</title>
    <meta name="author" content="Amalaric Le Forestier"/>
    <meta charset="utf-8"/>
    <link rel="icon" href="../images/favicon.png" />
    <link rel="stylesheet" href="../styles/style.css" type="text/css"/>
    <script type="text/javascript" src="main.js"></script>

    <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/data.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
</head>

<body onload="displayButtons()">

<header>
    <img src="../images/logo.png" alt="Thesesfr" class="logo">
    <form action="" method="post" class="searchbar" id="form-search">
        <span class="searchbar-and-select">
            <input type="text" name="searchbar" placeholder="Rechercher une thèse...">
            <select name="choice-search" form="form-search">
                <option value="all" selected>Tout</option>
                <option value="auteur">Auteur</option>
                <option value="titre">Titre</option>
                <option value="discipline">Discipline</option>
                <option value="directeur_these_pn">Directeur</option>
            </select>
        </span>

        <input type="submit" name="submit-search" value="Rechercher">
    </form>
</header>

<!--TODO
Intégrer mes charts
    - cartographie
    - les disciplines qui ressortent le plus souvent
    - nb de thèses en ligne
    - nb de thèses En cours par rapport aux Soutenues

Faire une map avec Leaflet, affichant le lieux des thèses. Il faut récupérer la localisation X,Y en s'aidant de l'ID thsèe ou je sais plus
-->

<main>

    <section class="results">

        <div class="grid-wrapper">
            <div id="buttons">
                <button onclick="imprimer()">Imprimer</button>
                <button onclick="downloadCSV()">Exporter le csv</button>
                <a href="../docs/results.json" download="Résultats">
                    <button>Exporter le json</button>
                </a>
            </div>
            <div id="myGrid" class="ag-theme-alpine"></div>
        </div>

        <script>
            //Styles pour la couleur des cellules
            const ragCellClassRules = {
                'rag-green': (params) => params.value === 'Oui' || params.value === 'Soutenue',
                'rag-amber': (params) => params.value === 'Non' || params.value === 'En cours'
            };

            function ragRenderer(params) {
                return '<span class="rag-element">' + params.value + '</span>';
            }
            //Changer la couleur de la case Online selon Oui ou Non
            function cellClass(params) {
                return params.value === 'Oui' ? 'rag-green' : 'rag-amber';
            }
            //Fonction pour exporter le tableau en CSV
            function downloadCSV() {
                gridOptions.api.exportDataAsCsv();
            }

            //Fonctions pour imprimer le tableau
            function imprimer() {
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

            //Définition des colonnes
            let columnDefs = [
                {field: "titre", flex: 3, cellRenderer: function(params) {
                    //Si le site est mis en ligne, alors on met le site en lien sur le titre
                    if (params.data) {
                        if (params.data.online === "Oui") {
                            // return "<a href='http://www.theses.fr/"+params.data.id+"/document' target='_blank' style='color: #0000EE;'>"+params.data.titre+"</a>";
                            return "<a href='http://www.theses.fr/"+params.data.id+"' target='_blank' style='color: #0000EE;'>"+params.data.titre+"</a>";
                        }
                        return params.data.titre;
                    }
                }},
                {field: "id", hide: true},
                {field: "auteur", flex: 2},
                {field: "Directeur", flex: 1.5},
                {field: "Établissement", flex: 1},
                {field: "online", flex: .8, cellClassRules: ragCellClassRules, cellRenderer: ragRenderer},
                {field: "Statut", flex: .8, cellClassRules: ragCellClassRules, cellRenderer: ragRenderer},
                {field: "Soutenance", flex: 1}
            ];

            //Ajout des lignes
            <?php
            // ----- PARTIE AGGRID -----

            //Formate la date en jour/mois/annee
            function formatDate($date): string
            {
                $date = explode("-", $date);
                return $date[2]."/".$date[1]."/".$date[0];
            }

            //Requête préparée
            $recherche = $_POST['searchbar'];
            $recherche = "%".$recherche."%";
            $type = $_POST['choice-search'];
            if ($type == 'all') {
                $sth = $dbh->prepare('SELECT * FROM these WHERE 
                      auteur LIKE :recherche OR
                      titre LIKE :recherche OR
                      auteur LIKE :recherche OR
                      directeur_these_pn LIKE :recherche;');
            } else $sth = $dbh->prepare('SELECT * FROM these WHERE '.$type.' LIKE :recherche;');
            $sth->bindParam(':recherche', $recherche);

            // Insertion de la requête SQL dans la BDD
            $rows = array();
            $rowHC = array();
            $test = 0;
            if ($sth->execute()) {
                //Si ça se passe bien alors on crée la ligne du tableau
                $result = $sth->fetchAll();
                foreach ($result as $row) {
                    //Formatage des lignes nécessaires
                    $toExclude = array(",", ".");
                    str_replace($toExclude,"", $row[0]);
                    str_replace($toExclude,"", $row[2]);
                    if (count(explode("-", $row[11])) == 3) $row[11] = formatDate($row[11]);
                    if ($row[9]=='enCours') $row[9] = 'En cours';
                    else if ($row[9]=='soutenue') $row[9] = 'Soutenue';
                    $row[14] = ucfirst($row[14]);
                    //Création de la ligne à donner à l'AgGrid
                    $formatedRow = array(
                        "titre"=>$row[2],
                        "id"=>$row[13],
                        "auteur"=>$row[0],
                        "Directeur"=>$row[3],
                        "Établissement"=>$row[6],
                        "Statut"=>$row[9],
                        "online"=>$row[14],
                        "Soutenance"=>$row[11],
                    );
                    array_push($rows, $formatedRow);



                    // ----- PARTIE HIGHCHARTS -----
                    //Construction des datas pour les graphiques HighCharts :
                    $annee = explode("/", $row[11])[2];
                    $exist = false;
                    for ($i=0; $i<count($rowHC); $i++) {
                        if ($rowHC[$i][0] == $annee) {
                            $rowHC[$i][1] += 1;
                            $exist = true;
                        }
                    }
                    if ($exist == false) {
                        array_push($rowHC, array($annee, 1));
                    }
                }
            }

            //On écrit dans un .json les lignes résultées
            $response['posts'] = $rows;
            $fp = fopen('../docs/results.json', 'w');
            fwrite($fp, json_encode($rows));
            fclose($fp);
            ?>

            //Paramètres de l'AgGrid
            let gridOptions = {
                columnDefs: columnDefs,
                defaultColDef: {
                    flex: 2,
                    filter: true,
                    sortable: true,
                    resizable: true,
                },

                rowGroupPanelShow: 'always',
                pagination: true,
                paginationPageSize: 20,
                popupParent: document.body,
                overlayLoadingTemplate: '<span class="ag-overlay-loading-center">Chargement des lignes...</span>',

                //Chargement des lignes optimisé
                rowBuffer: 0,
                rowSelection: 'multiple',
                rowModelType: 'infinite',
                cacheBlockSize: 100,
                cacheOverflowSize: 2,
                maxConcurrentDatasourceRequests: 1,
                infiniteInitialRowCount: 1000,
                maxBlocksInCache: 10
            };

            //Data pour les graphiques HighCharts
            let datas = <?php echo json_encode($rowHC); ?>;



            //Affichage du tableau / graphiques
            document.addEventListener('DOMContentLoaded', function() {
                //-----AgGrid-----
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

                //-----HighCharts-----
                Highcharts.chart('nbTheses', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Nombre de thèse par an'
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: -45,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Nombre de thèse'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y}'
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> thèses<br/>'
                    },
                    series: [
                        {
                            name: "Détails",
                            colorByPoint: true,
                            data: datas
                        }
                    ],
                });
            });

        </script>
    </section>

    <section class="stats">
        <figure class="highcharts-figure">
            <div id="nbTheses"></div>
        </figure>
    </section>
</main>

<footer>
    <p>Amalaric Le Forestier</p>
</footer>

</body>
</html>