<?php

namespace App\Repository;

use App\Entity\Admin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method Admin |null find($id, $lockMode = null, $lockVersion = null)
 * @method Admin |null findOneBy(array $criteria, array $orderBy = null)
 * @method Admin []    findAll()
 * @method Admin []    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Admin::class);
    }

    public function findallwithpagination()
    {
        return $this->createQueryBuilder('v')
            ->getQuery();

    }
    public function findallwithpaginationVerif()
    {
        return $this->createQueryBuilder('v')
            ->where('v.status = 2')
            ->getQuery();

    }
    public function loadUserByUsername($email) {

        return $this->createQueryBuilder('u')
            ->where('u.email = :query')
            ->andWhere('u.status = 1')
            ->setParameter('query', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loadUserByIdentifier(string $usernameOrEmail): ?Admin
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\Admin u
                WHERE u.id = :query
                OR u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $admin, string $newHashedPassword): void
    {
        if (!$admin instanceof admin) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($admin)));
        }

        $admin->setPassword($newHashedPassword);
        $this->_em->persist($admin);
        $this->_em->flush();
    }

    public function findByNom($nom)
    {
        return $this->createQueryBuilder('e')
                ->where('e.nom LIKE :nom')
                ->setParameter('nom', '%' . $nom . '%')
                ->getQuery()
                ->getResult();
    }

    // /**
    //  * @return Admin[] Returns an array of Admin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Admin
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
