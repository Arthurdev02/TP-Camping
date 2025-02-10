<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Hebergement;
use App\Entity\Reservation;
use App\Entity\Type;
use App\Entity\Equipement;
use App\Entity\EquipementHebergement;
use App\Entity\Tarification;
use App\Entity\Saison;
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

    /**
     * Charge toutes les données initiales dans la base de données.
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadUser($manager);
        $this->loadType($manager);
        $this->loadHebergements($manager);
        $this->loadEquipements($manager);
        $this->loadReservations($manager);
        $this->loadSaison($manager);
        $this->loadTarification($manager);
        $manager->flush();
    }

    /**
     * Méthode pour générer des user avec des rôles spécifiques et les sauvegarder dans la base de données.
     * @param ObjectManager $manager
     * @return void
     */
    public function loadUser(ObjectManager $manager): void
    {
        $user = [
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
                'nom' => 'utilisateur',
                'prenom' => 'Caz'
            ]
        ];

        // Parcourt les user définis pour les créer et les persister.
        foreach ($user as $value) {
            $user = new user();
            $user->setemail($value['email']);
            $user->setpassword($this->encoder->hashPassword($user, $value['password']));
            $user->setRoles($value['roles']);
            $user->setNumeroTelephone($value['numero_telephone']);
            $user->setNom($value['nom']);
            $user->setPrenom($value['prenom']);
            $manager->persist($user);
        }
    }

    /**
     * Méthode pour créer et sauvegarder les types d'hébergements.
     * @param ObjectManager $manager
     * @return void
     */
    public function loadType(ObjectManager $manager): void
    {
        $type= [
            ['nom' => 'Emplacement nu'],
            ['nom' => 'Tente meublée'],
            ['nom' => 'Mobil-home']
        ];

        // Parcourt les types d'hébergements pour les créer et les persister.
        foreach ($type as $value) {
            $type = new Type();
            $type->setNom($value['nom']);
            $manager->persist($type);
        }
    }

    
    /**
     * Méthode pour créer et sauvegarder les équipements disponibles pour les hébergements.
     * @param ObjectManager $manager
     * @return void
     */
    public function loadEquipements(ObjectManager $manager): void
    {
        $equipements = [
            ['nom' => 'Table'],
            ['nom' => 'Chaise'],
            ['nom' => 'Lit']
        ];
        
        // Parcourt les équipements pour les ajouter à la base de données.
        foreach ($equipements as $value) {
            $equipement = new Equipement();
            $equipement->setNom($value['nom']);
            $manager->persist($equipement);
        }
    }
    /**
     * Méthode pour créer et sauvegarder les hébergements.
     * Chaque hébergement est associé à un type spécifique.
     * @param ObjectManager $manager
     * @return void
     */
    public function loadHebergements(ObjectManager $manager): void
    {
        $hebergements = [
            ['id_type' => 1, 'capacite' => 6, 'superficie' => 30.0, 'image' => 'emplacement.jpg'],
            ['id_type' => 2, 'capacite' => 4, 'superficie' => 20.0, 'image' => 'tente.jpg'],
            ['id_type' => 3, 'capacite' => 6, 'superficie' => 35.0, 'image' => 'mobilhome.jpg']
        ];

        // Parcourt les hébergements pour les créer et les persister dans la base de données.
        foreach ($hebergements as $value) {
            $hebergement = new Hebergement();
            $hebergement->setCapacite($value['capacite']);
            $hebergement->setSuperficie($value['superficie']);
            $hebergement->setImage($value['image']);
            $manager->persist($hebergement);
        }
    }
    
    /**
     * Méthode pour créer et sauvegarder les différentes saisons avec leurs périodes spécifiques.
     * @param ObjectManager $manager
     * @return void
     */
    public function loadSaison(ObjectManager $manager): void
    {
        $saison = [
            ['nom' => 'Haute saison', 'date_debut' => '2024-06-01', 'date_fin' => '2024-09-30'],
            ['nom' => 'Basse saison', 'date_debut' => '2024-04-01', 'date_fin' => '2024-05-31']
        ];

        // Parcourt les saisons définies pour les créer et les sauvegarder.
        foreach ($saison as $value) {
            $saison = new Saison();
            $saison->setNom($value['nom']);
            $saison->setDateDebut(new \DateTime($value['date_debut']));
            $saison->setDateFin(new \DateTime($value['date_fin']));
            $manager->persist($saison);
        }
    }
    /**
     * Méthode pour créer et sauvegarder une réservation associée à un user et un hébergement.
     * @param ObjectManager $manager
     * @return void
     */
    public function loadReservations(ObjectManager $manager): void
    {
        $reservation = new Reservation();
        $user = $manager->getRepository(user::class)->findOneBy(['email' => 'user@user.com']);
        $hebergement = $manager->getRepository(Hebergement::class)->findOneBy(['id' => 3]);
        
        $reservation->setDateArrive(new \DateTime('2024-06-15'));
        $reservation->setDateDepart(new \DateTime('2024-06-20'));
        $reservation->setNombrePersonne(4);
        $manager->persist($reservation);
    }


    /**
     * Méthode pour créer et sauvegarder les tarifications en fonction des hébergements et des saisons.
     * @param ObjectManager $manager
     * @return void
     */
    public function loadTarification(ObjectManager $manager): void
    {
        $tarification = [
            ['id_hebergement' => 1, 'id_saison' => 1, 'tarif' => 50.00, 'date_debut' => '2024-06-01', 'date_fin' => '2024-09-30'],
            ['id_hebergement' => 2, 'id_saison' => 2, 'tarif' => 30.00, 'date_debut' => '2024-04-01', 'date_fin' => '2024-05-31']
        ];

        // Parcourt les tarifications pour les associer aux hébergements et aux saisons.
        foreach ($tarification as $value) {
            $tarification = new Tarification();
            $tarification->setTarif($value['tarif']);
            $tarification->setDateDebut(new \DateTime($value['date_debut']));
            $tarification->setDateFin(new \DateTime($value['date_fin']));
            $manager->persist($tarification);
        }
    }
}
