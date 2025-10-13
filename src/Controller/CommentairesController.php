<?php

namespace App\Controller;

use Dom\Entity;
use App\Entity\Commentaires;
use App\Entity\Detail;
use App\Form\CommentairesType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CommentairesController extends AbstractController
{
    #[Route('/commentaires', name: 'app_commentaires')]
    public function index(Request $request, EntityManagerInterface $em, Detail $detail): Response
    {
        $commentaires = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaires);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            

            $em->persist($commentaires);
            $em->flush();
            $this->addFlash('success', 'Commentaire soumis avec succès !');
            
        }

        return $this->render('commentaires/index.html.twig', [
            
            'form' => $form->createView(),
            
        ]);
    }
}
