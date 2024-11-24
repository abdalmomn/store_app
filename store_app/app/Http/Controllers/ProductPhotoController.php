<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPhotoRequest;
<<<<<<< HEAD
use App\Http\Responses\Response;
use App\Repositories\products\ProductPhotoRepositoryInterface;
use Exception;

class ProductPhotoController extends Controller
{
    protected ProductPhotoRepositoryInterface $productPhotoRepository;
=======
use App\Repositories\products\ProductPhotoRepositoryInterface;

class ProductPhotoController extends Controller
{
    protected $productPhotoRepository;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

    public function __construct(ProductPhotoRepositoryInterface $productPhotoRepository)
    {
        $this->productPhotoRepository = $productPhotoRepository;
    }

<<<<<<< HEAD
    public function CreatePhotoesProduct(ProductPhotoRequest $request,$productId)
    {
        $data=[];
        try {
            $data = $request->validated();
            $productPhoto = $this->productPhotoRepository->create($data, $productId);
            return Response::Success($data['productPhoto'],$data['message']);

        } catch (Exception $e) {
            $message = $e->getMessage();
            return Response::Error($data,$message);

=======
    public function create(ProductPhotoRequest $request,$productId)
    {
        try {
            $data = $request->validated();
            $productPhoto = $this->productPhotoRepository->create($data, $productId);
            return response()->json($productPhoto, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product photo', 'message' => $e->getMessage()], 500);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        }

    }

<<<<<<< HEAD
    public function UpdatePhotoesProduct(ProductPhotoRequest $request, $id)
=======
    public function update(ProductPhotoRequest $request, $id)
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        try {
            $data = $request->validated();
            $productPhoto = $this->productPhotoRepository->update($id, $data);
            return response()->json($productPhoto);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product photo', 'message' => $e->getMessage()], 500);
        }
    }

<<<<<<< HEAD
    public function DeletePhotoesProduct($id)
=======
    public function destroy($id)
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        try {
            $this->productPhotoRepository->delete($id);
            return response()->json(['message' => 'Product photo deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product photo', 'message' => $e->getMessage()], 500);
        }
    }

<<<<<<< HEAD
    public function ShowOnePhotoesProduct($id)
=======
    public function show($id)
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        try {
            $productPhoto = $this->productPhotoRepository->getById($id);
            return response()->json($productPhoto);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve product photo', 'message' => $e->getMessage()], 500);
        }

    }
<<<<<<< HEAD
    public function GetPhotosByProduct($productId)
=======
    public function getPhotosByProduct($productId)
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    {
        try {
            $photos = $this->productPhotoRepository->getPhotosByProductId($productId);
            return response()->json($photos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve product photos', 'message' => $e->getMessage()], 500);
        }
    }
}
