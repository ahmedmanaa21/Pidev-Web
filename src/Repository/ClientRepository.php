<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
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

    public function loadUserByIdentifier(string $usernameOrEmail): ?Client
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
                'SELECT u
                FROM App\Entity\Client u
                WHERE u.cin = :query
                OR u.email = :query'
            )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }

     /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $client, string $newHashedPassword): void
    {
        if (!$client instanceof client) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($client)));
        }

        $client->setPassword($newHashedPassword);
        $this->_em->persist($client);
        $this->_em->flush();
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
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
    public function findOneBySomeField($value): ?Client
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
