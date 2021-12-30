<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Magasinier
 * @package App\Entity
 * @ORM\Entity
 */
class Magasinier extends Utilisateur
{
    public const ROLE = "Magasinier";


    /**
     * Magasinier constructor.
     */
    public function __construct()
    {
        parent::__construct();      
    }


    /**
     * @return array|string[]
     */
    public function getRoles(): array
    {
        return ['ROLE_Magasinier'];
    }

}