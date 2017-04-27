<?php

namespace InfoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Info
 *
 *
 * @ORM\Entity(repositoryClass="InfoBundle\Repository\InfoRepository")
 */
class Info
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="INV", type="string", length=255)
     */
    private $inv;

    /**
     * @var string
     *
     * @ORM\Column(name="TITRE", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="AUTEUR", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="COTE", type="string", length=255)
     */
    private $cote;

    /**
     * @var int
     *
     * @ORM\Column(name="EXPL", type="integer")
     */
    private $expl;

    /**
     * @var int
     *
     * @ORM\Column(name="code_bare", type="integer")
     */
    private $codeBare;

    /**
     * @var string
     *
     * @ORM\Column(name="exposan", type="string", length=255)
     */
    private $exposan;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set inv
     *
     * @param string $inv
     *
     * @return Info
     */
    public function setInv($inv)
    {
        $this->inv = $inv;

        return $this;
    }

    /**
     * Get inv
     *
     * @return string
     */
    public function getInv()
    {
        return $this->inv;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Info
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Info
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set cote
     *
     * @param string $cote
     *
     * @return Info
     */
    public function setCote($cote)
    {
        $this->cote = $cote;

        return $this;
    }

    /**
     * Get cote
     *
     * @return string
     */
    public function getCote()
    {
        return $this->cote;
    }

    /**
     * Set expl
     *
     * @param integer $expl
     *
     * @return Info
     */
    public function setExpl($expl)
    {
        $this->expl = $expl;

        return $this;
    }

    /**
     * Get expl
     *
     * @return int
     */
    public function getExpl()
    {
        return $this->expl;
    }

    /**
     * Set codeBare
     *
     * @param integer $codeBare
     *
     * @return Info
     */
    public function setCodeBare($codeBare)
    {
        $this->codeBare = $codeBare;

        return $this;
    }

    /**
     * Get codeBare
     *
     * @return int
     */
    public function getCodeBare()
    {
        return $this->codeBare;
    }

    /**
     * Set exposan
     *
     * @param string $exposan
     *
     * @return Info
     */
    public function setExposan($exposan)
    {
        $this->exposan = $exposan;

        return $this;
    }

    /**
     * Get exposan
     *
     * @return string
     */
    public function getExposan()
    {
        return $this->exposan;
    }
}

