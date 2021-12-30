<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Client
 * @package App\Entity
 * @ORM\Entity
 */
class Client extends Utilisateur
{
    public const ROLE = "Client";
    /**
     * Client constructor.
     */
    public function __construct()
    {
        parent::__construct();   
    }

    public function getRoles(): array
    {
        return ['ROLE_Client'];
    }


}
