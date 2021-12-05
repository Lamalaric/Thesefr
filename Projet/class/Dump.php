<?php
include('These.php');
set_time_limit(0);
ini_set('memory_limit', '-1');
class Dump
{

    // Récupération CSV
    // Création these
    // Envoi BDD

    // On créer un JSON en fonction de chaque auteur
    // En demandant le nom d'un auteur, on renvoie toutes les informations de la thèse de l'auteur.

    // Vérifier si les champs sont les bons (au cas où si client boulet qui modifie ou enlève des colonnes)

    public function readCSV($csv): array  {
        $theseList = [];
        if (($handle = fopen($csv, 'rb')) !== FALSE) {
            while (($data = fgetcsv($handle, 1025, ';')) !== FALSE) {
                $these = new These($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], date('Y-m-d',strtotime($data[10])), date('Y-m-d',strtotime($data[11])), $data[12], $data[13], $data[14], date('Y-m-d',strtotime($data[15])), date('Y-m-d',strtotime($data[16])));
                $theseList[] = $these;
            }
            fclose($handle);
        }
        return $theseList;
    }
}