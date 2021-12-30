<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $etagere = "eta1";
        $fourn = "fournisseur A";
        for ($i = 0; $i < 30; $i++) {

            $produit = new Produit();
            $produit->setRefPro('product '.$i);
            $produit->setDesPro('description du produit numero '.$i);
            $produit->setCondPro('boite de '.$i);
            $produit->setQteSt(mt_rand(10, 100));
            $produit->setSeuil(44 + $i);
            $produit->setTypePro('PL');
            $produit->setPosition($etagere++);
            $produit->setFournpro($fourn++);
            $manager->persist($produit);

        }



        $manager->flush();
    }
}