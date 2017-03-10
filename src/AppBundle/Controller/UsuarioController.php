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

        $form = $this->createForm(ProfesorType::class, $usuario, [
            'es_admin' => $this->isGranted('ROLE_ADMIN')
        ]);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $clave = $this->get('security.password_encoder')
                ->encodePassword($usuario, $form->get('nueva')->getData());

            $usuario->setClave($clave);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('usuario/perfil.html.twig', [

            'form' => $form->createView()
        ]);
    }
}
