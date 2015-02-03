<?php

namespace HB\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilisateurType
 *
 * @author Alain
 */
class UtilisateurType extends AbstractType {

    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('login')
                ->add('password')
                //->add('dateCreation')
                ->add('nom')
                ->add('Creer', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'HB\BlogBundle\Entity\Utilisateur'
                )
        );
    }

    /**
     * @return string
     */
    public function getName() {
        return 'hb_blogbundle_utilisateur';
    }

}
