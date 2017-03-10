<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Alumno;
use AppBundle\Form\Type\AlumnoType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_TUTOR')")
 * @Route("/alumnado")
 */
class AlumnoController extends Controller
{
    /**
     * @Route("/", name="listar_alumnado")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $alumnos = $em->createQueryBuilder()
            ->select('a')
            ->addSelect('g')
            ->from('AppBundle:Alumno', 'a')
            ->join('a.grupo', 'g')
            ->orderBy('a.apellidos')
            ->addOrderBy('a.nombre')
            ->getQuery()
            ->getResult();

        return $this->render('alumno/listar.html.twig', [
            'alumnos' => $alumnos
        ]);
    }

    /**
     * @Route("/nuevo", name="nuevo_alumno", methods={"GET", "POST"})
     * @Route("/modificar/{id}", name="modificar_alumno", methods={"GET", "POST"})
     */
    public function formAlumnoAction(Request $request, Alumno $alumno = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $alumno) {
            $alumno = new Alumno();
            $em->persist($alumno);
        }

        $form = $this->createForm(AlumnoType::class, $alumno);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('listar_alumnado');
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }

        }

        return $this->render('alumno/form.html.twig', [
            'alumno' => $alumno,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/eliminar/{id}", name="borrar_alumnado", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarAction(Alumno $alumno)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        return $this->render('alumno/borrar.html.twig', [
            'alumno' => $alumno
        ]);
    }

    /**
     * @Route("/eliminar/{id}", name="confirmar_borrar_alumnado", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarDeVerdadAction(Alumno $alumno)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            foreach($alumno->getPartes() as $parte) {
                $em->remove($parte);
            }
            $em->remove($alumno);
            $em->flush();
            $this->addFlash('estado', 'Alumno eliminado con éxito');
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se han podido eliminar');
        }

        return $this->redirectToRoute('listar_alumnado');
    }
}
