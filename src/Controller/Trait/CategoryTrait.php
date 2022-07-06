<?php

namespace App\Controller\Trait;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use DateTimeZone;

/**
 * construct need:
 * - EntityManagerInterface
 */
Trait CategoryTrait
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ){}

    /**
     * @param string $categoryTitle
     * @return Category|null
     */
    protected function createCategory(string $categoryTitle): ?Category
    {
        if(empty($categoryTitle)){ 
            $this->addFlash(
                'warning',
                Category::ERROR_CREATE_MESSAGE
            );
            return null; 
        }
        $category = $this->categoryRepository->findOneBy(['title'=>$categoryTitle]);
        if(is_null($category)){ 
            $category = new Category(); 
        }
        $category
            ->setTitle($categoryTitle)
            ->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
        $this->em->persist($category);
        return $category;
    }
}