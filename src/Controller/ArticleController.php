<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 *  @Route("/article", name="article_")
 */
class ArticleController extends AbstractController
{
    // BREAD = Browse Read Edit Add Delete

    /**
     * @Route("/browse", name="browse")
     */
    public function browse( ArticleRepository $articleRepository): Response
    {
        

        return $this->render('article/browse.html.twig', [
            'articles'  => $articleRepository->findAll()
        ]);
        
    }

    /**
     * @Route("/add", name="add")
     */
    public function add( 
        EntityManagerInterface $entityManager,
        Request $request 
    ): Response
    {
        //On crée un nouvel article
        $article = new Article();

        // On créée le form avec le formulaire correspondant etle nouvel article 
        $form = $this->createForm( ArticleType::class, $article );
        

        //todo: Submit the form




        return $this->render('article/add.html.twig', [
            // Générer le formulaire exploitable par la vue
            "articleForm"      => $form->createView()
        ]);
    }


    // Todo: Edit / Read / delete

}
