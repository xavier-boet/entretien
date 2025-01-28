<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private array $categoriesArrayFromDb = [];
    private array $categories = [];

    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
        $this->categoriesArrayFromDb = $this->fetchCategories();
    }

    /**
     * Récupère toutes les catégories depuis la base de données.
     */
    private function fetchCategories(): array
    {
        $conn = $this->em->getConnection();

        try {
            return $conn->fetchAllAssociative('SELECT * FROM category');
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Construit un tableau hiérarchique de catégories.
     */
    public function buildCategoryTree(?int $parentId = null): array
    {
        $subcategory = [];

        foreach ($this->categoriesArrayFromDb as $category) {
            if ($category['parent_id'] === $parentId) {
                $children = $this->buildCategoryTree($category['id']);
                if (!empty($children)) {
                    $category['children'] = $children;
                }
                $subcategory[] = $category;
            }
        }

        return $subcategory;
    }

    /**
     * Génère un tableau d'options pour un menu déroulant avec indentation.
     */
    public function buildCategoryOptions(?array $categoriesArray = null, int $level = 0): array
    {
        $categoriesArray = $categoriesArray ?? $this->buildCategoryTree();

        foreach ($categoriesArray as $category) {
            $this->categories[] = [
                'id' => $category['id'],
                'name' => str_repeat('--', $level) . $category['name'],
            ];

            if (!empty($category['children'])) {
                $this->buildCategoryOptions($category['children'], $level + 1);
            }
        }

        return $this->categories;
    }
}
