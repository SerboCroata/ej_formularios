<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ProfesorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller
{
    /**
     * @Route("/entrar", name="entrar")
     */
    public function indexAction()
    {
        $helper = $this->get('security.authentication_utils');

        // replace this example code with whatever you need
        return $this->render('usuario/login.html.twig', [
            'error' => $helper->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/comprobar", name="comprobar")
     * @Route("/salir", name="salir")
     */
    public function comprobarAction() {
    }

    /**
     * @Route("/perfil", name="perfil")
     */
    public function cambiarPerfilAction(Request $request) {
        $usuario = $this->getUser();
        $form = $this->createForm(ProfesorType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('usuario/perfil.html.twig', [

            'form' => $form->createView()
        ]);
    }
}
