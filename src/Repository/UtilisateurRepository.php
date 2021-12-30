<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Utilisateur|null find($userId, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }


    /**
     * @param string $token
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserByForgottenPasswordToken(string $token): ?Utilisateur
    {
        return $this->createQueryBuilder("u")
            ->where("u.forgottenPassword.token = :token")
            ->setParameter("token", $token)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
