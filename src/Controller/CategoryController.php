<?php

namespace App\Controller;

use App\Entity\Detail;
use App\Entity\Category;
use App\Entity\Services;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManager;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
#use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'categories.findall')]
    public function index(int $id,Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $em): Response
    {
         

        $categories = $categoryRepository->findAll();
       

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'cat' => $categories
        ]);

    }

     #[Route('/show/{slug}-{id}', name: 'categories.show')]
    public function show(int $id, Request $request, string $slug, CategoryRepository $repository, EntityManagerInterface $em): Response
    {
       

        $category = $repository->findAll($id);
        $category = $repository->findOneBySomeField($id);
        
        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        return $this->render('category/show.html.twig', [

            'slug' => $slug,
            'id' => $id,
            'category' => $category,
            'services' => $category->getServiceId(),
           

        
        ]);
    }

     #[Route('/categorie/{id}/edit', name: 'categories.edit', methods: ['GET', 'POST'] )]

    public function edit(Category $category, Request $request, EntityManagerInterface $em)

    {       $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {

           $em->flush();

           $this->addFlash('success', 'Le service a bien été modifié');
            return $this->redirectToRoute('services.findall');
        }
             return $this->render('category/edit.html.twig', [

            'categories' => $category,
            'form' => $form

        ]);
    }

     #[Route('/categories/create', name: 'categories.create')]

    public function create( Request $request, EntityManagerInterface $em)

    {       $category = new Category();
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em->persist($category);
                $em->flush();

                $this->addFlash('success', 'La catégorie a bien été créée');
                return $this->redirectToRoute('categories.findall');
            }

            return $this->render('category/create.html.twig', [
                'form' => $form,
                
            ]);
    }

             #[Route('/categories/{id}/edit', name: 'categories.delete', methods: ['DELETE'])]

            public function delete(Category $category, Request $request, EntityManagerInterface $em)

    {       $em->remove($category);
            $em->flush();
            $this->addFlash('success', 'La catégorie a bien été supprimée');
            return $this->redirectToRoute('categories.findall');
    }
       

}
