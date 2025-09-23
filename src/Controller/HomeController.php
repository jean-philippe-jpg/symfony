<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\DetailRepository;
use App\Repository\ServicesRepository;
use PHPUnit\Runner\Phpt\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController {

    #[Route('/', name:'home')]
    function index(Request $request): Response {

        return $this->render('home/index.html.twig' );
    }


    #[Route('/admin', name:'admin')]
    function admin(Request $request, ServicesRepository $servicesRepository, CategoryRepository $categoryRepository, DetailRepository $detailRepository): Response {

        $services = $servicesRepository->findAll();
        $categories = $categoryRepository->findAll();
        $detail = $detailRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'services' => $services,
            'categories' => $categories,
            'detail' => $detail
        ]);
    }
}
