<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GrupoController extends Controller
{
    /**
     * @Route("/grupos", name="listar_grupos")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $grupos = $em->createQueryBuilder()
            ->select('g')
            ->addSelect('SIZE(g.alumnado)')
            ->addSelect('t')
            ->from('AppBundle:Grupo', 'g')
            ->join('g.tutor', 't')
            ->orderBy('g.descripcion')
            ->getQuery()
            ->getResult();

        return $this->render('grupo/listar.html.twig', [
            'grupos' => $grupos
        ]);
    }
}
