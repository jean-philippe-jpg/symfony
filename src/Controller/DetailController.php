<?php

namespace App\Controller;

use App\Entity\Detail;
use App\Form\DetailType;
use App\Entity\Commentaires;
#use Symfony\Component\BrowserKit\Request;
use App\Form\CommentairesType;
use Doctrine\ORM\EntityManager;
use App\Repository\DetailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dom\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DetailController extends AbstractController
{
    #[Route('/detail', name: 'detail.findall')]
    public function index(Request $request, DetailRepository $repository, EntityManagerInterface $em ): Response
    {

        $services = $repository->findAll();
       
        return $this->render('detail/index.html.twig', [
            'detail' => $services,
        ]);

    }


     #[Route('/detail/findOne/{slug}-{id}', name: 'detail.findOne')]
    public function findOne(Request $request, string $slug, int $id, DetailRepository $repository, EntityManagerInterface $em): Response
    {
        
         $commentaires = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaires);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            

            $em->persist($commentaires);
            $em->flush();
            $this->addFlash('success', 'Commentaire soumis avec succès !');
            
        }


        $detail = $repository->findOneById($id);

        return $this->render('detail/find.html.twig', [
            'slug' => $slug,
            'id' => $id,
            'detail' => $detail,
            'form' => $form,
        ] );
    
}


     #[Route('/detail/show/{slug}-{id}', name: 'detail.show')]
    public function show(Request $request, string $slug, int $id, DetailRepository $repository, EntityManagerInterface $em): Response
    {
        
         $commentaires = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaires);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            

            $em->persist($commentaires);
            $em->flush();
            $this->addFlash('success', 'Commentaire soumis avec succès !');
            
        }


        $detail = $repository->findByExampleField($id);

        if (!$detail) {
            throw $this->createNotFoundException('Detail not found');
        }
    {
        return $this->render('detail/show.html.twig', [
            'slug' => $slug,
            'id' => $id,
            'details' => $detail,
            'form' => $form,
        ] );
    }
}
     #[Route('/detail/{id}/edit', name: 'detail.edit', methods: ['GET', 'POST'] )]

    public function edit(Detail $detail, Request $request, EntityManagerInterface $em)

    {       $form = $this->createForm(DetailType::class, $detail);
            $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {

           $em->flush();

           $this->addFlash('success', 'Le service a bien été modifié');
            return $this->redirectToRoute('services.findall');
        }
             return $this->render('detail/edit.html.twig', [

            'detail' => $detail,
            'form' => $form

        ]);
    }

     #[Route('/detail/create', name: 'detail.create')]

    public function create( Request $request, EntityManagerInterface $em)

    {       $detail = new Detail();
            $form = $this->createForm(DetailType::class, $detail);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                dd($form->get('filename')->getData());
                $em->persist($detail);
                $em->flush();

                $this->addFlash('success', 'Les detials ont bien été créé');
                return $this->redirectToRoute('detail.findall');
            }

            return $this->render('detail/create.html.twig', [
                'form' => $form
            ]);
    }

             #[Route('/detail/{id}/edit', name: 'detail.delete', methods: ['DELETE'])]

            public function delete(Detail $detail, Request $request, EntityManagerInterface $em)

    {       $em->remove($detail);
            $em->flush();
            $this->addFlash('success', 'Le service a bien été supprimé');
            return $this->redirectToRoute('detail.findall');
    }
       

}
