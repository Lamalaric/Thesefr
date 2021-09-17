<?php
inlude("these.php");
class dump
{
    private array $theses = array();

    // Récupération CSV
    // Création these
    // Envoi BDD

    public function readCSV($csv): void  {
        $row = 1;
        if (($handle = fopen($csv, 'rb')) !== FALSE) {
            while (($data = fgetcsv($handle, 1025, ';')) !== FALSE) {
                $row++;
                $these = new these($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16]);
                $theses = $these;
                echo "------------------------------------------------------<br>";
            }
            fclose($handle);
        }
    }

    /**
     * @return array
     */
    public function getTheses(): array
    {
        return $this->theses;
    }


}