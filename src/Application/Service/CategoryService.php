<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\Category;
use App\Infrastructure\Repository\CategoryRepository;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    /** @return array<Category> */
    public function getAllPositioned(): array
    {
        $categories = $this->categoryRepository->findAll();

        usort($categories, fn (Category $a, Category $b) => $a->getPosition() <=> $b->getPosition());

        return $categories;
    }
}
