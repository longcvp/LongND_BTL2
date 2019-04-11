<?php
namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
	public function getCategoryUser($id);

	public function getRootCategoryUser($data);

	public function changeCateType($data);

	public function saveCategory($data);

	public function updateCategory($data);

	public function deleteCategory($id);

	public function getRootCatgory($userId);

	public function getChildId($userId, $id);
	
}