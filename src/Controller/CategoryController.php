<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface $em
    ){}

    #[Route('/detail/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $this->categoryRepository->find($id),
        ]);
    }
    
    #[Route('/modifier/{id}', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $category = $this->categoryRepository->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $this->em->persist($category);
            $this->em->flush();

            $this->addFlash('success', Category::UPDATE_MESSAGE);
            return $this->redirectToRoute('category_show', ['id'=>$category->getId()]);
        }

        return $this->renderForm('category/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
