<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Entity\User;
use App\Form\UploadType;
use Doctrine\ORM\EntityManager;
use PHPUnit\Runner\Phpt\Renderer;
use App\Repository\DetailRepository;
use App\Repository\UploadRepository;
use App\Repository\CategoryRepository;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dom\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class HomeController extends AbstractController {

    #[Route('/', name:'home')]
    function index(Request $request, UploadRepository $uploadRepository, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response {

       
        $form = $this->createForm(UploadType::class);
        $upload = $uploadRepository->findAll();
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'image' => $upload
        ]);
    }

    #[Route('/upload', name:'upload.create')]
    function upload(Request $request, UploadRepository $uploadRepository, EntityManagerInterface $em): Response {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                /** @var UploadedFile $file */
                $file = $form->get('filename')->getData();
                $filename = $upload->getId(). $file->getClientOriginalName();
                $file->move($this->getParameter('kernel.project_dir').'/public/home/images', $filename);
                $upload->setFilename($filename);

                $em->persist($upload);
                $em->flush();

                $this->addFlash('success', 'Les détails ont bien été créés');
                return $this->redirectToRoute('detail.findall');
            }

        return $this->render('home/create.html.twig', [
            'form' => $form->createView(),
            'upload' => $upload
        ]);
    }

 #[Route('/upload/{id}/edit', name: 'upload.edit', methods: ['GET', 'POST'] )]

    public function edit( Request $request, Upload $upload, EntityManagerInterface $em)

    {       $form = $this->createForm(UploadType::class, $upload);
            $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {

           $em->flush();

           $this->addFlash('success', 'Le service a bien été modifié');
            return $this->redirectToRoute('services.findall');
        }
             return $this->render('home/edit.html.twig', [

            'upload' => $upload,
            'form' => $form

        ]);
    }

    #[Route('/upload/{id}/delete', name: 'upload.delete', methods: ['DELETE'])]
    public function delete(Upload $upload, Request $request, EntityManagerInterface $em): Response {
        $em->remove($upload);
        $em->flush();
        $this->addFlash('success', 'Le téléchargement a bien été supprimé');
        return $this->redirectToRoute('detail.findall');
    }


    #[Route('/admin', name:'admin')]
    function admin(Request $request, ServicesRepository $servicesRepository, CategoryRepository $categoryRepository, DetailRepository $detailRepository, UploadRepository $uploadRepository): Response {


        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        $services = $servicesRepository->findAll();
        $categories = $categoryRepository->findAll();
        $detail = $detailRepository->findAll();
        $upload = $uploadRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'services' => $services,
            'categories' => $categories,
            'detail' => $detail,
            'upload' => $upload
        ]);
    }
}
