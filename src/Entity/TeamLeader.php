<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class teamLeader
 * @package App\Entity
 * @ORM\Entity
 */
class TeamLeader extends Utilisateur
{
    public const ROLE = "TeamLeader";


    /**
     * TeamLeader constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getRoles(): array
    {
        return ['ROLE_TeamLeader'];
    }


}
