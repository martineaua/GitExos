<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
 * @author Alain
 * @Route("/article")
 */


class ArticleController extends Controller
{
    /**
     * Liste tous les articles
     * 
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * Ajoute un article avec formulaire
     * @Route("/add")
     * @Template()
     */
    public function addAction()
    {
    	return array();
    }
    
    /**
     * Affiche un article spécificique sur un id
     * @Route("/{id}")
     * @Template()
     */
    public function readAction($id)
    {
    	//on récupère le repository de l'article
    	$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
    	
    	//on demande au repository l'article par id
    	$article = $repository->find($id);
    	
    	//on transmet notre article à la vue
    	return array('article' => $article);
    }
        
    /**
     * Edite un article avec formulaire
     * @Route("/{id}/edit")
     * @Template()
     */
    public function editAction($id)
    {
    	return array();
    }
    
    /**
     * Delete un article avec formulaire
     * @Route("/{id}/delete")
     * @Template()
     */
    public function deleteAction($id)
    {
    	return array();
    }
}
