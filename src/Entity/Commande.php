<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    private $numCom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $userId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stateCom;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $magId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnd;


    public function getNumCom(): ?int
    {
        return $this->numCom;
    }


    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getStateCom(): ?int
    {
        return $this->stateCom;
    }

    public function setStateCom(?int $stateCom): self
    {
        $this->stateCom = $stateCom;

        return $this;
    }

    public function getMagId(): ?string
    {
        return $this->magId;
    }

    public function setMagId(?string $magId): self
    {
        $this->magId = $magId;

        return $this;
    }

    public function getDateCom(): ?\DateTimeInterface
    {
        return $this->dateCom;
    }

    public function setDateCom(?\DateTimeInterface $dateCom): self
    {
        $this->dateCom = $dateCom;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }
}
