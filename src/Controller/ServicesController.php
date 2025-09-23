<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ServicesType;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServicesController extends AbstractController
{
    #[Route('/services', name: 'services.findall')]
    public function index(Request $request, ServicesRepository $repository, EntityManagerInterface $em ): Response
    {

        $services = $repository->findAll();
       
        return $this->render('services/index.html.twig', [
            'services' => $services,
        ]);

    }

     #[Route('/show/{slug}-{id}', name: 'service.show')]
    public function show(Request $request, string $slug, int $id): Response
    {
        return $this->render('services/show.html.twig', [

            'slug' => $slug,
            'id' => $id,
           
        ] );
    }

     #[Route('/services/{id}/edit', name: 'services.edit', methods: ['GET', 'POST'] )]

    public function edit(Services $services, Request $request, EntityManagerInterface $em)

    {       $form = $this->createForm(ServicesType::class, $services);
            $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {

           $em->flush();

           $this->addFlash('success', 'Le service a bien été modifié');
            return $this->redirectToRoute('services.findall');
        }
             return $this->render('services/edit.html.twig', [

            'services' => $services,
            'form' => $form

        ]);
    }

     #[Route('/services/create', name: 'services.create')]

    public function create( Request $request, EntityManagerInterface $em)

    {       $services = new Services();
            $form = $this->createForm(ServicesType::class, $services);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em->persist($services);
                $em->flush();

                $this->addFlash('success', 'Le service a bien été créé');
                return $this->redirectToRoute('services.findall');
            }

            return $this->render('services/create.html.twig', [
                'form' => $form
            ]);
    }

             #[Route('/services/{id}/edit', name: 'services.delete', methods: ['DELETE'])]

            public function delete(Services $services, Request $request, EntityManagerInterface $em)

    {       $em->remove($services);
            $em->flush();
            $this->addFlash('success', 'Le service a bien été supprimé');
            return $this->redirectToRoute('services.findall');
    }
       

}
