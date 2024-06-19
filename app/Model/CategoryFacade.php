<?php

namespace App\Model;

use Nette;

final class CategoryFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function insertCategory($data)
    {
        $category = $this->database
            ->table('categories')
            ->insert($data);

        return $category;
    }
    public function editCategory($categoryId, $data)
    {
        $category = $this->database
            ->table('categories')
            ->get($categoryId);
        $category->update($data);
        
        return $category;
    }

    public function deleteCategory($categoryId)
    {
        $category = $this->database
            ->table('categories')
            ->get($categoryId);
    
        if ($category) {
            $category->delete();
            return true; // Return true to indicate successful deletion
        }
    
        return false; // Return false if the mod was not found
    }

    public function getAllCategories()
    {
        return $this->database
            ->table('categories')
            ->where('created_at < ', new \DateTime)
            ->order('created_at DESC');
    }

    public function getCategoryById(int $id)
    {
        $category = $this->database
            ->table('categories')
            ->get($id);
        return $category;
    }

    public function getAll()
    {
        return $this->database->table('categories')->fetchAll();
    }

}