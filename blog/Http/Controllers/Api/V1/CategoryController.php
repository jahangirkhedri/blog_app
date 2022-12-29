<?php

namespace Blog\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use Blog\Http\Request\CategoryRequest;
use Blog\Models\Category;
use Blog\Repository\CategoryRepository;


class CategoryController extends BaseController
{
    public $category;

    public function __construct(Category $category)
    {
        $this->category = new CategoryRepository($category);
    }

    public function index()
    {
        try {
            $data = $this->category->all();
            return $this->sendResponse($data, 'all categories');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }


    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->all();
            $response = $this->category->create($data);
            return $this->sendResponse($response, 'Category created successfully.');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }

    public function show($id)
    {
        try {
            $response = $this->category->show($id);
            return $this->sendResponse($response, 'Show category');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $data = $request->all();
            $this->category->update($data, $id);
            $response = $this->category->show($id);
            return $this->sendResponse($response, 'Category updated successfully.');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }


    public function destroy($id)
    {
        try {
            $response = $this->category->delete($id);
            return $this->sendResponse($response, 'Category deleted successfully.');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }
}
