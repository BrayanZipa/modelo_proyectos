<?php

namespace App\Repository;

use App\Entity\Tarea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function getTareasByUsuario(int $usuarioId, array $parmas = [], int $start = 0, int $length = 10): array
    {
       $qb = $this->createQueryBuilder('t')
            ->select('t.id, t.descripcion, e.estado, p.nombre AS proyecto, up.tarifa, t.createdAt')
            ->join('t.proyecto', 'p')
            ->join('t.estado', 'e')
            ->join('p.usuarioProyectos', 'up')
            ->join('up.usuario', 'u')
            ->where('t.usuario = :usuarioId')
            ->andWhere('u.id = :usuarioId')
            ->setParameter('usuarioId', $usuarioId)
            ->setFirstResult($start)
            ->setMaxResults($length)
            ->orderBy('t.createdAt', 'DESC')
            ->addOrderBy('t.id', 'DESC');

        if (!empty($parmas['search'])) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('t.descripcion', ':search'),
                    $qb->expr()->like('p.nombre', ':search'),
                    $qb->expr()->like('e.estado', ':search'),
                    $qb->expr()->like('up.tarifa', ':search')
                )
            )
            ->setParameter('search', '%' . $parmas['search'] . '%');
        }

        $paginator = new Paginator($qb);

        $recordsTotal = (int) $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.usuario = :usuarioId')
            ->setParameter('usuarioId', $usuarioId)
            ->getQuery()
            ->getSingleScalarResult();

        return [
            'data' => iterator_to_array($paginator->setUseOutputWalkers(false)),
            'recordsFiltered' => $paginator->count(),
            'recordsTotal' => $recordsTotal
        ];
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
