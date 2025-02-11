<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Hebergement;
use App\Entity\Reservation;
use App\Entity\Type;
use App\Entity\Equipement;
use App\Entity\Tarification;
use App\Entity\Saison;
use App\Entity\Statut;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUser($manager);
        $this->loadType($manager);
        $this->loadStatut($manager);
        $this->loadHebergements($manager);
        $this->loadEquipements($manager);
        $this->loadSaison($manager);
        $this->loadTarification($manager);
        $this->loadReservations($manager);
        
        $manager->flush();
    }

    public function loadUser(ObjectManager $manager): void
    {
        $users = [
            [
                'email' => 'admin@admin.com',
                'password' => 'admin',
                'roles' => ['ROLE_ADMIN'],
                'numero_telephone' => '0606060606',
                'nom' => 'Administrateur',
                'prenom' => 'Zac'
            ],
            [
                'email' => 'user@user.com',
                'password' => 'user',
                'roles' => ['ROLE_USER'],
                'numero_telephone' => '0707070707',
                'nom' => 'Utilisateur',
                'prenom' => 'Caz'
            ]
        ];

        foreach ($users as $value) {
            $user = new User();
            $user->setEmail($value['email']);
            $user->setPassword($this->encoder->hashPassword($user, $value['password']));
            $user->setRoles($value['roles']);
            $user->setNumeroTelephone($value['numero_telephone']);
            $user->setNom($value['nom']);
            $user->setPrenom($value['prenom']);
            $manager->persist($user);
        }
    }

    public function loadType(ObjectManager $manager): void
    {
        $types = [
            ['nom' => 'Emplacement nu'],
            ['nom' => 'Tente meublée'],
            ['nom' => 'Mobil-home']
        ];

        foreach ($types as $value) {
            $type = new Type();
            $type->setNom($value['nom']);
            $manager->persist($type);
        }
    }

    public function loadStatut(ObjectManager $manager): void
    {
        $statuts = [
            ['id' => 1, 'nom' => 'Nettoyage'],
            ['id' => 2, 'nom' => 'Occupée'],
            ['id' => 3, 'nom' => 'Disponible'],
            ['id' => 4, 'nom' => 'Réservée'],
        ];

        foreach ($statuts as $value) {
            $statut = new Statut();
            $statut->setNom($value['nom']);
            $manager->persist($statut);
        }
    }

    public function loadEquipements(ObjectManager $manager): void
    {
        $equipements = [
            ['nom' => 'Table'],
            ['nom' => 'Chaise'],
            ['nom' => 'Lit']
        ];

        foreach ($equipements as $value) {
            $equipement = new Equipement();
            $equipement->setNom($value['nom']);
            $manager->persist($equipement);
        }
    }

    public function loadHebergements(ObjectManager $manager): void
    {
        $hebergements = [
            ['capacite' => 6, 'superficie' => 30.0, 'image' => 'emplacement.jpg', 'nom' => 'terrain nu'],
            ['capacite' => 4, 'superficie' => 20.0, 'image' => 'tente.jpg', 'nom' => 'tente meublée'],
            ['capacite' => 6, 'superficie' => 35.0, 'image' => 'mobilhome.jpg', 'nom' => 'mobil-home']
        ];

        foreach ($hebergements as $value) {
            $hebergement = new Hebergement();
            $hebergement->setNom($value['nom']);
            $hebergement->setCapacite($value['capacite']);
            $hebergement->setSuperficie($value['superficie']);
            $hebergement->setImage($value['image']);
            $manager->persist($hebergement);
        }
    }

    public function loadSaison(ObjectManager $manager): void
    {
        $saisons = [
            ['nom' => 'Haute saison', 'date_debut' => '2024-06-01', 'date_fin' => '2024-09-30'],
            ['nom' => 'Basse saison', 'date_debut' => '2024-04-01', 'date_fin' => '2024-05-31']
        ];

        foreach ($saisons as $value) {
            $saison = new Saison();
            $saison->setNom($value['nom']);
            $saison->setDateDebut(new \DateTime($value['date_debut']));
            $saison->setDateFin(new \DateTime($value['date_fin']));
            $manager->persist($saison);
        }
    }

    public function loadReservations(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'user@user.com']);
        $hebergement = $manager->getRepository(Hebergement::class)->find(3);
        $statut = $manager->getRepository(Statut::class)->find(1);

        if (!$user || !$hebergement || !$statut) {
            return;
        }

        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setHebergement($hebergement);
        $reservation->setStatut($statut);
        $reservation->setDateArrive(new \DateTime('2024-06-15'));
        $reservation->setDateDepart(new \DateTime('2024-06-20'));
        $reservation->setNombrePersonne(4);

        $manager->persist($reservation);
    }

    public function loadTarification(ObjectManager $manager): void
    {
        $tarifications = [
            ['id_hebergement' => 1, 'id_saison' => 1, 'tarif' => 50.00, 'date_debut' => '2024-06-01', 'date_fin' => '2024-09-30'],
            ['id_hebergement' => 2, 'id_saison' => 2, 'tarif' => 30.00, 'date_debut' => '2024-04-01', 'date_fin' => '2024-05-31']
        ];

        foreach ($tarifications as $value) {
            $hebergement = $manager->getRepository(Hebergement::class)->find($value['id_hebergement']);
            $saison = $manager->getRepository(Saison::class)->find($value['id_saison']);

            if (!$hebergement || !$saison) {
                continue;
            }

            $tarification = new Tarification();
            $tarification->setHebergement($hebergement);
            $tarification->setSaison($saison);
            $tarification->setTarif($value['tarif']);
            $tarification->setDateDebut(new \DateTime($value['date_debut']));
            $tarification->setDateFin(new \DateTime($value['date_fin']));
            $manager->persist($tarification);
        }
    }
}
