<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductPhotoRequest;
use App\Repositories\products\ProductPhotoRepositoryInterface;
use Illuminate\Http\Request;

class ProductPhotoController extends Controller
{
    protected $productPhotoRepository;

    public function __construct(ProductPhotoRepositoryInterface $productPhotoRepository)
    {
        $this->productPhotoRepository = $productPhotoRepository;
    }

    public function create(ProductPhotoRequest $request,$productId)
    {
        try {
            $data = $request->validated();
            $productPhoto = $this->productPhotoRepository->create($data, $productId);
            return response()->json($productPhoto, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product photo', 'message' => $e->getMessage()], 500);
        }

    }

    public function update(ProductPhotoRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $productPhoto = $this->productPhotoRepository->update($id, $data);
            return response()->json($productPhoto);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product photo', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->productPhotoRepository->delete($id);
            return response()->json(['message' => 'Product photo deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product photo', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $productPhoto = $this->productPhotoRepository->getById($id);
            return response()->json($productPhoto);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve product photo', 'message' => $e->getMessage()], 500);
        }

    }
    public function getPhotosByProduct($productId)
    {
        try {
            $photos = $this->productPhotoRepository->getPhotosByProductId($productId);
            return response()->json($photos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve product photos', 'message' => $e->getMessage()], 500);
        }
    }
}
