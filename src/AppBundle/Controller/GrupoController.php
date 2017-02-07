<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GrupoController extends Controller
{
    /**
     * @Route("/grupos", name="listar_grupos")
     */
    public function indexAction()
    {
        return $this->render('grupo/listar.html.twig');
    }
}
