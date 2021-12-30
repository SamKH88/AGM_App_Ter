<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Produit
 * @package App\Entity
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=20)
     */
    private $refPro;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desPro;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $condPro;

    /**
     * @ORM\Column(type="integer")
     */
    private $qteSt;

    /**
     * @ORM\Column(type="integer")
     */
    private $seuil;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datePer;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $typePro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fournPro;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $position;


    public function getRefPro(): ?string
    {
        return $this->refPro;
    }

    public function setRefPro(string $refPro): self
    {
        $this->refPro = $refPro;

        return $this;
    }

    public function getDesPro(): ?string
    {
        return $this->desPro;
    }

    public function setDesPro(string $desPro): self
    {
        $this->desPro = $desPro;

        return $this;
    }

    public function getCondPro(): ?string
    {
        return $this->condPro;
    }

    public function setCondPro(?string $condPro): self
    {
        $this->condPro = $condPro;

        return $this;
    }

    public function getQteSt(): ?int
    {
        return $this->qteSt;
    }

    public function setQteSt(int $qteSt): self
    {
        $this->qteSt = $qteSt;

        return $this;
    }

    public function getSeuil(): ?int
    {
        return $this->seuil;
    }

    public function setSeuil(int $seuil): self
    {
        $this->seuil = $seuil;

        return $this;
    }

    public function getDatePer(): ?\DateTimeInterface
    {
        return $this->datePer;
    }

    public function setDatePer(?\DateTimeInterface $datePer): self
    {
        $this->datePer = $datePer;

        return $this;
    }

    public function getTypePro(): ?string
    {
        return $this->typePro;
    }

    public function setTypePro(string $typePro): self
    {
        $this->typePro = $typePro;

        return $this;
    }

    public function getFournPro(): ?string
    {
        return $this->fournPro;
    }

    public function setFournPro(?string $fournPro): self
    {
        $this->fournPro = $fournPro;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }
}
