<?php
include('class/dump.php');

$file_to_read = "dump_abes_thesesfr.csv";

$dump = new dump();
$dump->readCSV($file_to_read);
// ESSAYER D'AFFICHER LA LISTE DE THESES
// PUIS AJOUTER LES THESES UNE PAR UNE A LA BDD

?>