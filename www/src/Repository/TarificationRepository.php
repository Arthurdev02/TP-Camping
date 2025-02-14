<?php

namespace App\Repository;

use App\Entity\Tarification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tarification>
 */
class TarificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarification::class);
    }

    //    /**
    //     * @return Tarification[] Returns an array of Tarification objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tarification
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;

    //    }
/**
     * Méthode qui récupère une habitation par son id
     * @param int $accomodationId
     * @return array
     */
    public function getAccomodationWithInfo(int $accomodationId): array
    {
        $entityManager = $this->getEntityManager();
 
        $qb = $entityManager->createQueryBuilder();
 
        $query = $qb->select([
            'a.id',
            'a.title',
            'a.description',
            'a.size',
            'a.nbre_bedroom',
            'a.isAvailable',
            'a.imagePath',
            't.price as price',
            'type.label as typeLabel'
        ])
        ->from(Accomodation::class, 'a')
        ->Join('a.tarifications', 't')
        ->Join('a.type_accomodation', 'type')
        ->where('a.id = :id')
        ->setParameter('id', $accomodationId)
        ->getQuery();
 
        $result = $query->getResult();
 
        return $result;
    }
}

