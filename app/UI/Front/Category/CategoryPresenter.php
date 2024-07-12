<?php

namespace App\UI\Front\Category;

use Nette;
use App\Model\CategoryFacade;
use App\Model\ModFacade;

final class CategoryPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private CategoryFacade $facade,
        private ModFacade $mfacade,
    ) {
    }

    public function renderDefault(): void
    {
        $categories = $this->facade
            ->getAllCategories()
            ->limit(5);

        bdump($categories);

        $this->template->categories = $categories;
    }

    public function renderShow(int $id): void
    {
        $category = $this->facade
            ->getCategoryById($id);
        if (!$category) {
            $this->error('Category not found');
        }

        // Get mods by category ID
        $mods = $this->mfacade->getModsByCategoryId($id);

        $this->template->category = $category;
        $this->template->mods = $mods;
    }
}
