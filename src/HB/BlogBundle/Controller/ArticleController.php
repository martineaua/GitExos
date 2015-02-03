<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Entity\Article;
use HB\BlogBundle\Form\ArticleType;

/**
 * 
 * @author Alain
 * @Route("/article")
 */
class ArticleController extends Controller {

    /**
     * Liste tous les articles
     * 
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        //on récupère le repository de l'article
        $repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");

        //on demande au repository tous les articles
        $articles = $repository->findAll();

        //on retourne tous les articles dans un tableau associatif
        return array('articles' => $articles);
    }

    /**
     * Ajoute un article avec formulaire
     * @Route("/add")
     * @Template()
     */
    public function addAction() {
        //on créé un fun objet formulaire    	
        $article = new Article();

        // passe la vue de formulaire à la vue 
        return $this->editAction($article);
    }

    /**
     * Affiche un article sp�cificique sur un id
     * @Route("/{id}", name="article_read")
     * @Template()
     */
    public function readAction($id) {
        //on r�cup�re le repository de l'article
        $repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");

        //on demande au repository l'article par id
        $article = $repository->find($id);

        //on transmet notre article à la vue
        return ['article' => $article];
    }

    /**
     * Edite un article avec formulaire
     * @Route("/{id}/edit")
     * @Template("HBBlogBundle:Article:add.html.twig")
     * 
     */
    public function editAction(Article $article) {

        // on créé un objet formulaire en lui précisant quel Type utiliser 
        $form = $this->createForm(new ArticleType, $article);

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
                // On l'enregistre notre objet $article dans la base de données 
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                // On redirige vers la page de visualisation de l'article nouvellement créé 
                return $this->redirect(
                                $this->generateUrl('article_read', array('id' => $article->getId()))
                );
            }
        }

        if ($article->getId() > 0) {
            $edition = true;
        } else {
            $edition = false;
        }

        // passe la vue de formulaire à la vue 
       return array('formulaire' => $form->createView(), 'edition' => $edition);
    }

    /**
     * Delete un article avec formulaire
     * @Route("/{id}/delete")
     * @Template()
     */
    public function deleteAction(Article $article) {
        //on récupère le repository de l'article
        $em = $this->getDoctrine()->getManager();

        //on supprime un article
        $em->remove($article);

        // on vide le cache
        $em->flush();

        //on transmet notre article à la vue
        return $this->redirect($this->generateUrl("hb_blog_article_index", array()));
    }

}

                
                