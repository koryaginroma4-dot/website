<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Application\Service\CategoryService;
use App\Domain\Entity\Category;
use App\Infrastructure\Repository\CategoryRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CategoryServiceTest extends TestCase
{
    private CategoryRepository|MockObject $categoryRepository;

    private CategoryService $categoryService;

    public static function provideCategories(): array
    {
        return [
            [
                [
                    new Category()
                        ->setPosition(1),

                    new Category()
                        ->setPosition(3),
                
                    new Category()
                        ->setPosition(2),
                ]
            ]
        ];
    }

    #[DataProvider('provideCategories')]
    public function testGetCategories(array $categories): void
    {
        $this->categoryRepository
            ->expects(self::once())
            ->method('findAll')
            ->willReturn($categories);

        $result = $this->categoryService->getAllPositioned();

        self::assertCount(count($categories), $result);

        self::assertSame($result[0]->getPosition(), 1);
        self::assertSame($result[1]->getPosition(), 2);
        self::assertSame($result[2]->getPosition(), 3);
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryService = new CategoryService(
            $this->categoryRepository = $this->createMock(CategoryRepository::class),
        );
    }
}
