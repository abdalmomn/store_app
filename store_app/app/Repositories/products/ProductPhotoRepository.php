<?php
namespace App\Repositories\products;
use App\Models\ProductPhoto;
use Illuminate\Support\Facades\Auth;

class ProductPhotoRepository implements ProductPhotoRepositoryInterface
{
    public function create(array $data, int $productId)
    {    if (Auth::check() && Auth::user()->hasRole('admin')){
        $photos = [];
        foreach ($data['photos'] as $photo) {
            $path = $photo->store('product_photos', 'public');
            $photos[] = ProductPhoto::create([
                'product_photo_path' => $path,
                'product_id' => $productId,
            ]);
        }
        $message='photoes add successfully';
    }else{
        $photos = null;
        $message = 'you do not have access';
    }
        return [
            'product' => $photos,
            'message' => $message,
        ];


<<<<<<< HEAD

=======
        return $photos;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
    }

       public function update(int $id, array $data)
    {
<<<<<<< HEAD
        $productPhoto = ProductPhoto::query()->find($id);
=======
        $productPhoto = ProductPhoto::find($id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        $productPhoto->update($data);
        return $productPhoto;
    }

    public function delete(int $id)
    {
        $productPhoto = ProductPhoto::find($id);
        if ($productPhoto){
            if(Auth::check() && Auth::user()->hasRole('admin')){
                $productPhoto->delete();
                $message='delete successfully ';
            }else{
                $productPhoto=null;
                $message='you dont have access';
            }

        }else{
            $message='not found';
        }
        return [
            'photoies'=> $productPhoto,
            'message'=>$message
        ];

    }

    public function getById(int $id)
    {
<<<<<<< HEAD
      $photo=   ProductPhoto::query()->find($id);
=======
      $photo=   ProductPhoto::find($id);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
      $photo ? $message='get success fully': $message='not found';
        return [
            'photo'=> $photo,
            'message'=>$message
        ];
    }
    public function getPhotosByProductId(int $productId)
    {
<<<<<<< HEAD
        $photo= ProductPhoto::query()->where('product_id', $productId)->get();
=======
        $photo= ProductPhoto::where('product_id', $productId)->get();
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        $photo ? $message='get photo successfully':$message="there are not found for this product  ";
        return [
            'photo'=> $photo,
            'message'=>$message
        ];
    }
}
