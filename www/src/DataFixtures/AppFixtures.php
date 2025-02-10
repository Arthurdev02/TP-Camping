<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    //proriété pour encodre le MDP
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager):void
    {
//On crée les utilisateurs (admins et utilisateurs)
    //On crée l'admin
        //on instancie la classe 
        $user = new User();
        // on set les valeur que l'on souhaite ajouter
        $user->setEmail("admin@admin.com")
            ->setPassword($this->encoder->encodePassword($user, "admin"))
            ->setRoles(["ROLE_ADMIN"])
            ->setPrenom("Zac")        
            ->setNom("Caz")
            ->setNumeroTelephone(0606060606);
            //persit premet de préparer les datas
            $manager->persist($user);
            //flush permet d'exécuter
            $manager->flush();

    //On crée l'utilisateur N°1
        //on instancie la classe
        $user->setEmail ("user@user.com")
            //on set les valeur que l'on souhaite ajouter
            ->setPassword($this->encoder->encodePassword($user, "user"))
            ->setRoles(["ROLE_USER"])
            ->setPrenom("Zac")        
            ->setNom("Caz")
            ->setNumeroTelephone(0606060606);
            //persit premet de préparer les datas
            $manager->persist($user);
            //flush permet d'exécuter
            $manager->flush();
    }
}