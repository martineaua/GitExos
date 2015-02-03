<?php
namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Entity\Utilisateur;
use HB\BlogBundle\Form\UtilisateurType;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilisateurController
 *
 * @author Alain
 */

/**
 * 
 * @author Alain
 * @Route("/utilisateur")
 */
class UtilisateurController extends Controller {
    //put your code here
    
     /**
     * Liste tous les utilisateurs
     * 
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        //on récupère le repository de l'utilisateur
        $repository = $this->getDoctrine()->getRepository("HBBlogBundle:Utilisateur");

        //on demande au repository tous les utilisateur
        $utilisateurs = $repository->findAll();

        //on retourne tous les articles dans un tableau associatif
        return array('utilisateurs' => $utilisateurs);
    }

    /**
     * Ajoute un utilisateur avec formulaire
     * @Route("/add", name="utilisateur_add")
     * @Template()
     */
    public function addAction() {
        //on créé un fun objet formulaire    	
        $utilisateur = new Utilisateur();

        // passe la vue de formulaire à la vue 
        return $this->editAction($utilisateur);
    }

    /**
     * Affiche un article spécificique sur un id
     * @Route("/{id}", name="utilisateur_read")
     * @Template()
     */
    public function readAction($id) {
        //on récupère le repository de l'utilisateur
        $repository = $this->getDoctrine()->getRepository("HBBlogBundle:Utilisateur");

        //on demande au repository l'utilisateur par id
        $utilisateur = $repository->find($id);

        //on transmet notre article à la vue
        return ['utilisateur' => $utilisateur];
    }

    /**
     * Edite un article avec formulaire
     * @Route("/{id}/edit", name="utilisateur_edit")
     * @Template("HBBlogBundle:Utilisateur:add.html.twig")
     * 
     */
    public function editAction(Utilisateur $utilisateur) {

        // on créé un objet formulaire en lui précisant quel Type utiliser 
        $form = $this->createForm(new utilisateurType, $utilisateur);

        // On récupère la requête 
        $request = $this->get('request');

        // On vérifie qu'elle est de type POST pour voir si un formulaire a été soumis 
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire 
            // À partir de maintenant, la variable $article contient les valeurs entrées dans     		// le formulaire par le visiteur 
            $form->bind($request);
            // On vérifie que les valeurs entrées sont correctes 
            // (Nous verrons la validation des objets en détail dans le prochain chapitre) 
            if ($form->isValid()) {
                // On l'enregistre notre objet $utilisateur dans la base de données 
                $em = $this->getDoctrine()->getManager();
                $em->persist($utilisateur);
                $em->flush();

                // On redirige vers la page de visualisation de l'utilisateur nouvellement créé 
                return $this->redirect(
                                $this->generateUrl('utilisateur_read', array('id' => $utilisateur->getId()))
                );
            }
        }

        if ($utilisateur->getId() > 0) {
            $edition = true;
        } else {
            $edition = false;
        }

        // passe la vue de formulaire à la vue 
       return array('formulaire' => $form->createView(), 'edition' => $edition);
    }

    /**
     * Delete un utilisateur avec formulaire
     * @Route("/{id}/delete", name="utilisateur_delete")
     * @Template()
     */
    public function deleteAction(Utilisateur $utilisateur) {
        //on récupère le repository de l'article
        $em = $this->getDoctrine()->getManager();

        //on supprime un article
        $em->remove($utilisateur);

        // on vide le cache
        $em->flush();

        //on transmet notre article à la vue
        return $this->redirect($this->generateUrl("hb_blog_utilisateur_index", array()));
    }

}

