<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Utilisateur
 * @package App\Entity
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"magasinier"="App\Entity\Magasinier", "client"="App\Entity\Client", "teamleader"="App\Entity\TeamLeader"})
 * @UniqueEntity(fields="userId", message="vous êtes déjà inscrit.", entityClass="App\Entity\Utilisateur")
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $userNm;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $userPre;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $mdp;

    /**
     * @Assert\NotBlank(groups={"mdp"})
     * @Assert\Length(min=8, groups={"mdp"})
     */
    private ?string $pPassword = null;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $userType;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     */
    private $userLocImb;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $userlocEtage;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     */
    private $userlocPorte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $team;



    public function __construct()
    {
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

    public function getUserNm(): ?string
    {
        return $this->userNm;
    }

    public function setUserNm(string $userNm): self
    {
        $this->userNm = $userNm;

        return $this;
    }

    public function getUserPre(): ?string
    {
        return $this->userPre;
    }

    public function setUserPre(string $userPre): self
    {
        $this->userPre = $userPre;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->mdp;
    }

    /**
     * @param string $password
     */
    public function setMdp(string $mdp): void
    {
        $this->mdp = $mdp;
    }

    /**
     * @return string|null
     */
    public function getPPassword(): ?string
    {
        return $this->pPassword;
    }

    /**
     * @param string|null $pPassword
     */
    public function setPPassword(?string $pPassword): void
    {
        $this->pPassword = $pPassword;
    }

    public function getUserType(): ?int
    {
        return $this->userType;
    }

    public function setUserType(int $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    public function getUserLocImb(): ?string
    {
        return $this->userLocImb;
    }

    public function setUserLocImb(string $userLocImb): self
    {
        $this->userLocImb = $userLocImb;

        return $this;
    }

    public function getUserlocEtage(): ?int
    {
        return $this->userlocEtage;
    }

    public function setUserlocEtage(int $userlocEtage): self
    {
        $this->userlocEtage = $userlocEtage;

        return $this;
    }

    public function getUserlocPorte(): ?string
    {
        return $this->userlocPorte;
    }

    public function setUserlocPorte(string $userlocPorte): self
    {
        $this->userlocPorte = $userlocPorte;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(?string $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->userId;
    }

    public function getUserIdentifier(): string
    {
        return $this->userId;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_Utilisateur';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        $this->pPassword = null;
    }



}
