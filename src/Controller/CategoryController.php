<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ){}

    #[Route('/detail/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $this->categoryRepository->find($id),
        ]);
    }
}
