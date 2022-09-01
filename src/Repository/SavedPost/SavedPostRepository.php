<?php

declare(strict_types=1);

namespace App\Repository\SavedPost;

use App\Entity\SavedPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<SavedPost>
 *
 * @method SavedPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavedPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavedPost[]    findAll()
 * @method SavedPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavedPostRepository extends ServiceEntityRepository implements SavedPostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavedPost::class);
    }

    public function save(SavedPost $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(SavedPost $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function getSavedPostsByUserId(Uuid $userId): array
    {
        return $this->findBy(['userId' => $userId]);
    }

    public function getSavedPostByPostId(Uuid $postId): array
    {
        return $this->findBy(['post' => $postId]);
    }

    public function getByPostIdUserId(Uuid $postId, Uuid $userId): ?SavedPost
    {
        return $this->findOneBy(['post' => $postId, 'userId' => $userId]);
    }

    //    /**
    //     * @return SavedPost[] Returns an array of SavedPost objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SavedPost
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
