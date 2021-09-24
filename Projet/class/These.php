<?php

class These
{
    private $auteur;
    private $id_auteur;
    private $titre;
    private $directeur_these_pn;
    private $directeur_these_np;
    private $id_directeur;
    private $etablissement_soutenance;
    private $id_etablissement;
    private $discipline;
    private $statut;
    private $date_inscription;
    private $date_soutenance;
    private $langue_these;
    private $id_these;
    private $accessible_online;
    private $date_publication_site;
    private $date_maj_site;

    /**
     * @param $auteur
     * @param $id_auteur
     * @param $titre
     * @param $directeur_these_pn
     * @param $directeur_these_np
     * @param $id_directeur
     * @param $etablissement_soutenance
     * @param $id_etablissement
     * @param $discipline
     * @param $statut
     * @param $date_inscription
     * @param $date_soutenance
     * @param $langue_these
     * @param $id_these
     * @param $accessible_online
     * @param $date_publication_site
     * @param $date_maj_site
     */
    public function __construct($auteur, $id_auteur, $titre, $directeur_these_pn, $directeur_these_np, $id_directeur, $etablissement_soutenance, $id_etablissement, $discipline, $statut, $date_inscription, $date_soutenance, $langue_these, $id_these, $accessible_online, $date_publication_site, $date_maj_site)
    {
        $this->auteur = $auteur;
        $this->id_auteur = $id_auteur;
        $this->titre = $titre;
        $this->directeur_these_pn = $directeur_these_pn;
        $this->directeur_these_np = $directeur_these_np;
        $this->id_directeur = $id_directeur;
        $this->etablissement_soutenance = $etablissement_soutenance;
        $this->id_etablissement = $id_etablissement;
        $this->discipline = $discipline;
        $this->statut = $statut;
        $this->date_inscription = $date_inscription;
        $this->date_soutenance = $date_soutenance;
        $this->langue_these = $langue_these;
        $this->id_these = $id_these;
        $this->accessible_online = $accessible_online;
        $this->date_publication_site = $date_publication_site;
        $this->date_maj_site = $date_maj_site;
    }

    /**
     * @return mixed
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * @return mixed
     */
    public function getIdAuteur()
    {
        return $this->id_auteur;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @return mixed
     */
    public function getDirecteurThesePn()
    {
        return $this->directeur_these_pn;
    }

    /**
     * @return mixed
     */
    public function getDirecteurTheseNp()
    {
        return $this->directeur_these_np;
    }

    /**
     * @return mixed
     */
    public function getIdDirecteur()
    {
        return $this->id_directeur;
    }

    /**
     * @return mixed
     */
    public function getEtablissementSoutenance()
    {
        return $this->etablissement_soutenance;
    }

    /**
     * @return mixed
     */
    public function getIdEtablissement()
    {
        return $this->id_etablissement;
    }

    /**
     * @return mixed
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @return mixed
     */
    public function getDateInscription()
    {
        return $this->date_inscription;
    }

    /**
     * @return mixed
     */
    public function getDateSoutenance()
    {
        return $this->date_soutenance;
    }

    /**
     * @return mixed
     */
    public function getLangueThese()
    {
        return $this->langue_these;
    }

    /**
     * @return mixed
     */
    public function getIdThese()
    {
        return $this->id_these;
    }

    /**
     * @return mixed
     */
    public function getAccessibleOnline()
    {
        return $this->accessible_online;
    }

    /**
     * @return mixed
     */
    public function getDatePublicationSite()
    {
        return $this->date_publication_site;
    }

    /**
     * @return mixed
     */
    public function getDateMajSite()
    {
        return $this->date_maj_site;
    }


}
?>