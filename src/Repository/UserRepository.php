<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // Méthode pour persister l'utilisateur
    public function save(User $user): void
    {
        $this->_em->persist($user); // Marque l'entité pour être persistée
        $this->_em->flush();        // Exécute réellement la persistance
    }
}
