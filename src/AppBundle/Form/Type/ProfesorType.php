<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Alumno;
use AppBundle\Entity\Profesor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'form.nombre'
            ])
            ->add('apellidos', null, [
                'label' => 'form.apellidos'
            ])
            ->add('dni', null, [
                'label' => 'form.dni'
            ])
            ->add('administrador', null, [
                'label' => 'form.administrador'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profesor::class,
            'translation_domain' => 'profesor'
        ]);
    }
}