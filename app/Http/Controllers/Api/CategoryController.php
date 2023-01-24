<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try {
            $result = $this->categoryRepository->findAll();
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            $result = $this->categoryRepository->findById($id);
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $result = $this->categoryRepository->store($request->only('name'));
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = [
                'name' => $request->name
            ];
            $result = $this->categoryRepository->update($data, $id);
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->categoryRepository->findById($id);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'error' => "data not found"
                ], 404);
            }
            $result = $this->categoryRepository->delete($id);
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
