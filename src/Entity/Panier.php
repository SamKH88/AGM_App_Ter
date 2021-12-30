<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $numPanier;

    /**
     * @ORM\Column(type="integer")
     */
    private $numCom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $refPro;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $qtePro;



    public function getNumPanier(): ?int
    {
        return $this->numPanier;
    }


    public function getNumCom(): ?int
    {
        return $this->numCom;
    }

    public function setNumCom(int $numCom): self
    {
        $this->numCom = $numCom;

        return $this;
    }

    public function getRefPro(): ?string
    {
        return $this->refPro;
    }

    public function setRefPro(string $refPro): self
    {
        $this->refPro = $refPro;

        return $this;
    }

    public function getQtePro(): ?string
    {
        return $this->qtePro;
    }

    public function setQtePro(string $qtePro): self
    {
        $this->qtePro = $qtePro;

        return $this;
    }
}
