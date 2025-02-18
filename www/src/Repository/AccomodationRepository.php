<?php
namespace App\Repository;

use App\Entity\Accomodation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Accomodation>
 */
class AccomodationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accomodation::class);
    }

    /**
     * Ajouter une nouvelle entité en base de données.
     */
    public function save(Accomodation $accomodation, bool $flush = true): void
    {
        $this->getEntityManager()->persist($accomodation);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Supprimer une entité de la base de données.
     */
    public function remove(Accomodation $accomodation, bool $flush = true): void
    {
        $this->getEntityManager()->remove($accomodation);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
