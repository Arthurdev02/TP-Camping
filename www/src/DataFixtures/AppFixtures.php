<?php

namespace App\DataFixtures;

use App\Entity\Accomodation;
use App\Entity\Booking;
use App\Entity\Equipement;
use App\Entity\Season;
use App\Entity\Tarification;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    //propriété pour encoder le mdp 
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->LoadUsers($manager);
        $this->LoadEquipements($manager);
        $this->LoadSeasons($manager);
        $this->LoadTypes($manager);
        $this->LoadAccomodations($manager);
        $this->LoadTarifications($manager);
        $this->LoadBookings($manager);

        $manager->flush();
    }

    /**
     * méthode pour générer des utilisateurs
     * @param ObjectManager $manager
     * @return void
     */
    public function LoadUsers(ObjectManager $manager): void
    {
        //on crée un tableau avec les infos des users
        $array_user = [
            [
                'email' => "admin@admin.com",
                'password' => "admin",
                'roles' => ['ROLE_ADMIN'],
                'username' => 'administrateur'
            ],
            [
                'email' => "user@user.com",
                'password' => "user",
                'roles' => ['ROLE_USER'],
                'username' => 'utilisateur'
            ]
        ];
        //on va boucler sur le tableau pour créer des users
        foreach ($array_user as $key => $value) {
            //on instancie un user
            $user = new User();
            $user->setEmail($value['email']);
            $user->setPassword($this->encoder->hashPassword($user, $value['password']));
            $user->setRoles($value['roles']);
            $user->setUsername($value['username']);
            //on persiste les données
            $manager->persist($user);

            $this->addReference('user_'.$key + 1, $user);
        } //on crée un tableau avec les infos des users
    }

    /**
     * méthode pour générer les types de logements
     * @param ObjectManager $manager
     * @return void
     */
    public function LoadTypes(ObjectManager $manager): void
    {
        //on crée un tableau avec les types de logements
        $array_type = [
            "Mobil-home",
            "Tente équipée",
            "Emplacement de camping"
        ];
        //on va boucler sur le tableau pour créer des types de logements
        foreach ($array_type as $key => $value) {
            //on instancie un user
            $type = new Type();
            $type->setLabel($value);
            //on persiste les données
            $manager->persist($type);

            $this->addReference('type_'.$key + 1, $type);
        } //on crée un tableau avec les infos des types de logements
        
    }

    /**
     * méthode pour générer les types de logements
     * @param ObjectManager $manager
     * @return void
     */
    public function LoadEquipements(ObjectManager $manager): void
    {
        //on crée un tableau avec les équipements
        $array_equipements = [
            "Réfrigérateur",
            "Plaques de cuisson",
            "Micro-ondes",
            "Cafetière",
            "Bouilloire",
            "Vaisselle et couverts",
            "Lave-vaisselle",
            "Télévision",
            "Climatisation",
            "Chauffage",
            "Douche",
            "Lavabo",
            "Toilettes",
            "Sèche-cheveux",
            "Wi-Fi",
        ];
        //on va boucler sur le tableau pour créer des équipements
        foreach ($array_equipements as $key => $value) {
            //on instancie un user
            $equipement = new Equipement();
            $equipement->setLabel($value);
            //on persiste les données
            $manager->persist($equipement);

            $this->addReference('equipement_'.$key + 1, $equipement);
        } //on crée un tableau avec les infos des équipements

        
    }

    /**
     * méthode pour générer les saisons
     * @param ObjectManager $manager
     * @return void
     */
    public function LoadSeasons(ObjectManager $manager): void
    {
        //on crée un tableau avec les équipements
        $array_season = [
            [
                'label' => "Haute saison",
                'date_start' => new \DateTime('2025-06-01'), // 1er juin 2025
                'date_end' => new \DateTime('2025-08-31')   // 31 août 2025
            ],
            [
                'label' => "Basse saison",
                'date_start' => new \DateTime('2025-09-01'), // 1er septembre 2025
                'date_end' => new \DateTime('2025-05-31')   // 31 mai 2026
            ]
        ];
        //on va boucler sur le tableau pour créer des saisons
        foreach ($array_season as $key => $value) {
            //on instancie une saison
            $season = new Season();
            $season->setLabel($value['label']);
            $season->setDateStart($value['date_start']);
            $season->setDateEnd($value['date_end']);
            //on persiste les données
            $manager->persist($season);

            $this->addReference('season_' .$key + 1, $season);
        } //on crée un tableau avec les infos des saisons
    }

    /**
     * méthode pour générer les tarif
     * @param ObjectManager $manager
     * @return void
     */
    public function LoadTarifications(ObjectManager $manager): void
    {
        //on crée un tableau avec les tarifs
        $array_tarification = [
            [
                'season_id' => 1,
                'accomodation_id' => 1,
                'price' => 50
            ],
            [
                'season_id' => 2,
                'accomodation_id' => 2,
                'price' => 30
            ]
        ];
        //on va boucler sur le tableau pour créer des équipements
        foreach ($array_tarification as $key => $value) {
            //on instancie une saison
            $tarification = new Tarification();
            $tarification->setPrice($value['price']);

            // Gestion des relations OneToMany ou ManyToOne pour Accomodation
            $tarification->setAccomodations($this->getReference('accomodation_' . $value['accomodation_id'], Accomodation::class));

            // Gestion des relations OneToMany ou ManyToOne pour Season
            $tarification->setSeason($this->getReference('season_' . $value['season_id'], Season::class));

            //on persiste les données
            $manager->persist($tarification);
        } //on crée un tableau avec les infos des saisons
    }

    /**
     * méthode pour générer les annonces
     * @param ObjectManager $manager
     * @return void
     */
    public function LoadAccomodations(ObjectManager $manager): void
    {
        //on crée un tableau avec les équipements
        $array_accomodation = [
            [
                'title' => "Petit Mobil-home",
                'description' => "Un mobil-home confortable et tout équipé, offrant un espace convivial avec cuisine, salle de bain, chambres et terrasse, idéal pour un séjour en pleine nature.",
                'size' => 5,
                'nbre_bedrooms' => 2,
                'is_avaliable' => true,
                'image_path' => "mobil-home.jpg",
                'type_accomodation_id' => 1,
                'equipement' => [1,2,3]
            ],
            [
                'title' => "Tente équipée",
                'description' => "Une tente équipée alliant confort et nature, avec lits, espace cuisine et coin repas, pour une expérience de camping authentique sans renoncer au bien-être.",
                'size' => 3,
                'nbre_bedrooms' => 1,
                'is_avaliable' => false,
                'image_path' => "tente-equipee.jpg",
                'type_accomodation_id' => 2,
                'equipement' => [4,5,6]
            ]
        ];
        //on va boucler sur le tableau pour créer des annonces
        foreach ($array_accomodation as $key => $value) {
            //on instancie une saison
            $accomodation = new Accomodation();
            $accomodation->setTitle($value['title']);
            $accomodation->setDescription($value['description']);
            $accomodation->setSize($value['size']);
            $accomodation->setNbreBedrooms($value['nbre_bedrooms']);
            $accomodation->setisAvaliable($value['is_avaliable']);
            $accomodation->setImagePath($value['image_path']);

            // Gestion des relations OneToMany ou ManyToOne pour Type
            $accomodation->setTypeAccomodation($this->getReference('type_' . $value['type_accomodation_id'], Type::class));
            
            // Gestion des relations ManyToMany pour Equipement
            foreach($value['equipement'] as $equipement) {
                $accomodation->addEquipement($this->getReference('equipement_' .$equipement, Equipement::class));
            }
            //on persiste les données
            $manager->persist($accomodation);

            $this->addReference('accomodation_' .$key + 1, $accomodation);
        
        } //on crée un tableau avec les infos des annonces
    }

    /**
     * méthode pour générer les réservations
     * @param ObjectManager $manager
     * @return void
     */
    public function LoadBookings(ObjectManager $manager): void
    {
        //on crée un tableau avec les tarifs
        $array_booking = [
            [
                'user_id' => 1,
                'accomodation_id' => 1,
                'date_start' => new \DateTime("2025-06-22"),
                'date_end' => new \DateTime("2025-06-01"),
                'nbre_adult' => '2',
                'nbre_children' => '0'
            ],
            [
                'user_id' => 2,
                'accomodation_id' => 2,
                'date_start' => new \DateTime("2025-07-22"),
                'date_end' => new \DateTime("2025-05-01"),
                'nbre_adult' => '1',
                'nbre_children' => '1'
            ]
        ];
        //on va boucler sur le tableau pour créer des équipements
        foreach ($array_booking as $key => $value) {
            //on instancie une saison
            $booking = new Booking();
            $booking->setDateStart($value['date_start']);
            $booking->setDateEnd($value['date_end']);
            $booking->setNbreAdults($value['nbre_adult']);
            $booking->setNbreChildrens($value['nbre_children']);

            // Gestion des relations OneToMany ou ManyToOne pour User
            $booking->setUsers($this->getReference('user_' . $value['user_id'], User::class));

            // Gestion des relations OneToMany ou ManyToOne pour Accomodation
            $booking->setAccomodation($this->getReference('accomodation_' . $value['accomodation_id'], Accomodation::class));

            //on persiste les données
            $manager->persist($booking);
        } //on crée un tableau avec les infos des saisons
    }



}