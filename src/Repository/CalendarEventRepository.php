<?php

namespace App\Repository;

use App\Entity\CalendarEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method CalendarEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendarEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendarEvent[]    findAll()
 * @method CalendarEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarEventRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendarEvent::class);

    }

    public function getAllCalendarEvents($orderBy = 'Desc')
    {
        return $this->createQueryBuilder('ce')
            ->select('ce.id', 'ce.username', 'ce.event_date', 'ce.event_type')
            ->orderBy('ce.id', $orderBy)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    // /**
    //  * @return CalendarEvent[] Returns an array of CalendarEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CalendarEvent
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
