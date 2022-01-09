<?php
set_time_limit(0);
ini_set('memory_limit', '-1');

//include('../class/Dump.php');
//include('../connexion.php');
//include('coord.php');
//include('load_dump.php');
//Remove le warning du port
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

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

    <script src="https://kit.fontawesome.com/45e38e596f.js" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

</head>

<body onload="displayButton()">

<header>
    <img src="../images/logo.png" alt="Thesesfr" class="logo">
    <form action="" method="post" class="searchbar" id="form-search">
        <span class="searchbar-and-select">
            <input type="text" name="searchbar" placeholder="Rechercher une thèse...">
            <select name="choice-search" form="form-search">
                <option value="all" selected>Tout</option>
                <option value="auteur">Auteur</option>
                <option value="titre">Titre</option>
                <option value="id_these">ID thèse</option>
                <option value="discipline">Discipline</option>
                <option value="directeur_these_pn">Directeur</option>
            </select>
        </span>

        <input type="submit" name="submit-search" value="Rechercher">
    </form>
</header>


<main id="main" style="min-height: 100vh;">

    <section id="welcome" style="display:block;">
        <h1>Thesesfr</h1>
        <div>
            <div class="suggest">
                <h2>Présentation</h2>
                <p>
                    Theses.fr est un projet réalisé dans le cadre d'un projet PHP pour mon 3ème semestre en DUT Informatique de Marne-la-Vallée.<br><br>
                    Commencez par rechercher une thèse selon le critère de votre choix dans la barre de recherche en haut a droite
                </p>
            </div>
            <div class="notice">
                <h2>Recommandation</h2>
                <p>
                    Il se peut que vous rencontriez un problème concernant le tableau des résultats lors de votre première recherche, pour cause d'un problème côté serveur.<br><br>
                    Prenez le temps d'aller voir le README associé à ce projet, et prendre pleinement connaissance de ce projet ainsi que de la façon pour corriger ce problème !<br>
                    Voir le README : <a href="https://github.com/Lamalaric/Thesefr/tree/master/Projet" target="_blank">GitHub Repository</a>
                </p>
            </div>
            <div class="mentionsL">
                <h2>Mentions légales</h2>
                <p>
                    Vous trouverez les mentions légales en cliquant sur <a href="../mentions.html" target="_blank">ce lien</a>
                </p>
            </div>
            <div class="me">
                <h2>Auteur</h2>
                <p>
                    N'hésitez pas à visiter mon Portfolio pour voir d'autres de mes créations ou me contacter!<br>
                    <a href="https://amalaric.dev" target="_blank">amalaric.dev</a>
                </p>
            </div>
        </div>

    </section>

    <section id="results" class="results" style="display: flex;">
        <div class="title" onclick="toggleFold('container-results')">
            <h2>Résultats </h2>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="grid-wrapper" id="container-results" style="display: flex;">
            <p id="nbResultats" style="display: block;"></p>
            <div id="myGrid" class="ag-theme-alpine" style="display: block;"></div>
            <div id="buttons">
                <button onclick="imprimer()">Imprimer</button>
                <button onclick="downloadCSV()">Exporter le csv</button>
                <a href="../docs/results.json" download="Résultats">
                    <button>Exporter le json</button>
                </a>
            </div>
        </div>
    </section>

    <section id="stats" class="stats" style="display: flex;">
        <div class="title" onclick="toggleFold('container-stats')">
            <h2>Statistiques</h2>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div id="container-stats" style="display: block;">
            <h3>Graphiques</h3>
            <div id="container-graphs">
                <figure class="highcharts-figure">
                    <div id="nbTheses"></div>
                    <div class="camamberts">
                        <div id="nbOnline"></div>
                        <div id="nbSoutenance"></div>
                        <div id="topDisciplines"></div>
                        <div id="topLangues"></div>
                    </div>
                </figure>
            </div>

            <h3>Cartographie</h3>
            <div id="container-carto" class="map-container">
                <div id="map"></div>
            </div>
        </div>

    </section>

    <script>
        //Initialisation de la carte
        let map = L.map('map').setView([47.009, 2.538], 6);
        let osmLayer = L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        });

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
                            return "<a href='http://www.theses.fr/"+params.data.id+"' target='_blank' style='color: #0000EE;'>"+params.data.titre+"</a>";
                        }
                        return params.data.titre;
                    }
                }},
            {field: "id", hide: true},
            {field: "auteur", flex: 1.3},
            {field: "Directeur", flex: 1.5},
            {field: "Établissement", flex: 1.5},
            {field: "online", flex: .8, cellClassRules: ragCellClassRules, cellRenderer: ragRenderer},
            {field: "Statut", flex: .8, cellClassRules: ragCellClassRules, cellRenderer: ragRenderer},
            {field: "Soutenance", flex: 1}
        ];


        //Calcul des résultats
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
        //Requête différente selon le type de recherche
        if ($type == 'all') {
            $sth = $dbh->prepare('SELECT * FROM these2 WHERE 
                      auteur LIKE :recherche OR
                      titre LIKE :recherche OR
                      id_these LIKE :recherche OR
                      auteur LIKE :recherche OR
                      directeur_these_pn LIKE :recherche;');
        } else $sth = $dbh->prepare('SELECT * FROM these2 WHERE '.$type.' LIKE :recherche;');
        $sth->bindParam(':recherche', $recherche);

        //Initialisation des variables
        $rows = array();
        $rowHCtheses = array();
        $rowHConline = array(
            array('Non', 0),
            array('Oui', 0)
        );
        $rowHCsoutenue = array(
            array('En cours', 0),
            array('Soutenue', 0)
        );
        $lstDiscipline = array();
        $lstLangues = array();
        $lstCoords = array();

        //Résultats de la requête
        if ($sth->execute()) {
            //Si ça se passe bien alors on va calculer différentes choses pour chaque ligne
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

                //Pour le graphe nb de thèses:
                if (mb_substr_count($row[11], "/") == 2) {  //Si la date est mal formatée next
                    $annee = explode("/", $row[11])[2];
                    $exist = false;
                    //Si une array avec [annee, nb] est déjà présente pour cette année, alors on incrémente nb
                    for ($i=0; $i<count($rowHCtheses); $i++) {
                        if ($rowHCtheses[$i][0] == $annee) {
                            $rowHCtheses[$i][1] += 1;
                            $exist = true;
                        }
                    }
                    //Sinon on crée l'array [annee, 1]
                    if ($exist == false) {
                        array_push($rowHCtheses, array($annee, 1));
                    }
                }


                //Pour le camambert thèses online
                $indexOnline = $row[14] == 'Oui' ? 1 : 0;
                //On incrémente le nombre de thèses correspondant à online Oui ou Non
                $rowHConline[$indexOnline][1] += 1;


                //Pour le camambert thèses soutenue
                $indexSoutenue = $row[9] == 'Soutenue' ? 1 : 0;
                //On incrémente le nombre de thèses correspondant à soutenue Oui ou Non
                $rowHCsoutenue[$indexSoutenue][1] += 1;


                //Pour le top 10 des disciplines
                $discipline = $row[8];
                $found = false;
                if ($discipline != "") {
                    //Si discipline est présent, alors on incrémente nb
                    for ($i=0; $i<count($lstDiscipline); $i++) {
                        if ($lstDiscipline[$i]["name"] == $discipline) {
                            $lstDiscipline[$i]["y"] += 1;
                            $lstDiscipline[$i]["z"] += 1;
                            $found = true;
                        }
                    }
                    //On ajoute à l'array un array [discipline, nb] si discipline n'est pas encore présent
                    if ($found == false) {
                        array_push($lstDiscipline, array('name' => $discipline, 'y' => 1, 'z' => 1));
                    }
                }


                //Pour les langues les plus populaires
                $langue = $row[12];
                $added = false;
                if ($langue != "") {
                    //Si langue est présent, alors on incrémente nb
                    for ($i=0; $i<count($lstLangues); $i++) {
                        if ($lstLangues[$i]["name"] == strtoupper($langue)) {
                            $lstLangues[$i]["y"] += 1;
                            $added = true;
                        }
                    }
                    //On ajoute à l'array un array [langue, nb] si langue n'est pas encore présent
                    if ($added == false) {
                        array_push($lstLangues, array('name' => strtoupper($langue), 'y' => 1, 'selected' => false, 'sliced' => false));
                    }
                }





                // ----- PARTIE CARTOGRAPHIE -----
                //Récupération des coordonnées + nom d'établissement pour ajouter des marqueurs sur la carte
                $sql = "SELECT coord_x, coord_y, etablissement FROM coordonnees WHERE id_etablissement='$row[7]';";
                $req = $dbh->prepare($sql);

                if ($req->execute()) {
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        //Pas de doublons dans la liste des coord pour ne pas surcharger la map
                        if (!in_array(array($row['coord_x'], $row['coord_y'], $row['etablissement']), $lstCoords)) {
                            array_push($lstCoords, array($row['coord_x'], $row['coord_y'], $row['etablissement']));
                        }
                    }
                }
            }

            //Tri du graphe de nombre de thèses par année
            usort($rowHCtheses, function ($item1, $item2) {
                return $item1[0] <=> $item2[0];
            });

            //Top 10 des disciplines
            usort($lstDiscipline, function ($item1, $item2) {
                return $item2["y"] <=> $item1["y"];
            });
            $topDiscipline = array_slice($lstDiscipline, 0, 10);

            //Langues les plus populaires
            usort($lstLangues, function ($item1, $item2) {
                return $item2["y"] <=> $item1["y"];
            });
//            $lstLangues[0]['selected'] = true;
//            $lstLangues[0]['sliced'] = true;
        }

        //On écrit dans un .json les lignes résultées
        $response['posts'] = $rows;
        $fp = fopen('../docs/results.json', 'w');
        fwrite($fp, json_encode($rows));
        fclose($fp);
        ?>
        console.log(<?php echo json_encode($lstLangues); ?>)


        //Ajout des marker sur la map
        let lstCoords = <?php echo json_encode($lstCoords); ?>;
        lstCoords.forEach(elem => {
            let marker = L.marker([elem[0],elem[1]], {title: elem[2]}).addTo(map);
            marker.bindPopup(elem[2]);
        })


        map.addLayer(osmLayer);

        //Paramètres de l'AgGrid
        let gridOptions = {
            rowHeight: 100,
            columnDefs: columnDefs,
            defaultColDef: {
                flex: 2,
                filter: true,
                sortable: true,
                resizable: true,
                wrapText: true,
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
        let datasNbTheses = <?php echo json_encode($rowHCtheses); ?>;
        let datasNbOnline = <?php echo json_encode($rowHConline); ?>;
        let datasNbSoutenue = <?php echo json_encode($rowHCsoutenue); ?>;
        let datasTopDisciplines = <?php echo json_encode($topDiscipline); ?>;
        let datasLangues = <?php echo json_encode($lstLangues); ?>;



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
                    type: 'column',
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
                        data: datasNbTheses
                    }
                ],
            });
            Highcharts.chart('nbOnline', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: false,
                },
                title: {
                    text: 'Visible en ligne',
                    align: 'center',
                    verticalAlign: 'middle',
                    y: 60
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            enabled: true,
                            distance: -50,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif',
                                fontWeight: 'bold',
                                color: 'white'
                            }
                        },
                        startAngle: -90,
                        endAngle: 90,
                        center: ['50%', '75%'],
                        size: '110%'
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Proportion',
                    innerSize: '50%',
                    colorByPoint: true,
                    data: datasNbOnline
                }]
            });
            Highcharts.chart('nbSoutenance', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: false,
                },
                title: {
                    text: 'Statut des thèses',
                    align: 'center',
                    verticalAlign: 'middle',
                    y: 60
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            enabled: true,
                            distance: -50,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif',
                                fontWeight: 'bold',
                                color: 'white'
                            }
                        },
                        startAngle: -90,
                        endAngle: 90,
                        center: ['50%', '75%'],
                        size: '110%'
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Proportion',
                    innerSize: '50%',
                    colorByPoint: true,
                    data: datasNbSoutenue
                }]
            });
            Highcharts.chart('topDisciplines', {
                chart: {
                    type: 'variablepie'
                },
                title: {
                    text: 'Disciplines les plus populaires'
                },
                tooltip: {
                    headerFormat: '',
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                            'Thèses ayant comme discipline {point.name}: <b>{point.y}</b><br/>'
                },
                series: [{
                    minPointSize: 10,
                    innerSize: '20%',
                    zMin: 0,
                    name: 'discipline',
                    data: datasTopDisciplines
                }]
            });
            Highcharts.chart('topLangues', {
                chart: {
                    styledMode: true
                },
                title: {
                    text: 'Langues les plus populaires'
                },
                tooltip: {
                    pointFormat: 'Langue {point.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
                },
                series: [{
                    type: 'pie',
                    allowPointSelect: true,
                    keys: ['name', 'y', 'selected', 'sliced'],
                    data: datasLangues,
                    showInLegend: true
                }]
            });
        });



        //Affichage a l'utilisateur du résumé de la recherche
        <?php
            // On formate bien le texte du type de recherche
            switch($type) {
                case "all":
                    $type = "Tout";
                    break;

                case "auteur":
                    $type = "Auteur";
                    break;

                case "titre":
                    $type = "Titre";
                    break;

                case "discipline":
                    $type = "Discipline";
                    break;

                case "directeur_these_pn":
                    $type = "Directeur de la thèse";
                    break;
            }
        ?>
        document.getElementById("nbResultats").innerHTML = parseInt(<?php echo count($rows); ?>).toString()+
            " thèses trouvées pour la recherche \"<?php echo $_POST['searchbar']; ?>\" dans {<?php echo $type; ?>}";

    </script>

</main>

<footer>
    <p><a href="https://amalaric.dev" target="_blank"><i class="fas fa-user-graduate"></i> Amalaric Le Forestier</a></p>
    <p><a href="../mentions.html" target="_blank">Mentions légales <i class="fas fa-file-contract"></i></a></p>
</footer>

</body>
</html>