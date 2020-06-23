<?php

namespace App\Repository;

use App\Entity\Campaigns;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Campaigns|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campaigns|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campaigns[]    findAll()
 * @method Campaigns[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campaigns::class);
    }

    public function get($id) :?Campaigns
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->andWhere('c.actif = :actif')
            ->setParameter('actif', true)
            ->andWhere('c.start_date <= :start_date')
            ->orWhere('c.start_date is null')
            ->setParameter('start_date', new \DateTime('now'))
            ->andWhere('c.stop_date >= :stop_date')
            ->orWhere('c.stop_date is null')
            ->setParameter('stop_date', new \DateTime('now'))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getAllCampaignsActiveNow() :array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.actif = :actif')
            ->setParameter('actif', true)
            ->andWhere('c.start_date <= :start_date')
            ->orWhere('c.start_date is null')
            ->setParameter('start_date', new \DateTime('now'))
            ->andWhere('c.stop_date >= :stop_date')
            ->orWhere('c.stop_date is null')
            ->setParameter('stop_date', new \DateTime('now'))
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
