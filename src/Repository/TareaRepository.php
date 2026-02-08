<?php

namespace App\Repository;

use App\Entity\Tarea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tarea>
 */
class TareaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarea::class);
    }

    public function getTareasByUsuario(int $usuarioId, int $page = 1, int $limit = 10): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.id, t.descripcion, e.estado, p.nombre AS proyecto, up.tarifa, t.createdAt')
            ->join('t.proyecto', 'p')
            ->join('t.estado', 'e')
            ->join('p.usuarioProyectos', 'up')
            ->join('up.usuario', 'u')
            ->where('t.usuario = :usuarioId')
            ->andWhere('u.id = :usuarioId')
            ->setParameter('usuarioId', $usuarioId)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('t.createdAt', 'DESC')
            ->addOrderBy('t.id', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }


//    /**
//     * @return Tarea[] Returns an array of Tarea objects
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

//    public function findOneBySomeField($value): ?Tarea
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
