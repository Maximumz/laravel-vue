<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The directory for product images.
     *
     * @var string
     */
    public $imageBasePath = 'storage/products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'title',
        'description',
        'price',
        'product_photo_path'
    ];

    public function getProduct($id)
    {
      return Product::find($id);
    }

    public static function getProducts()
    {
      return Product::all();
    }

    public function saveProduct($productData)
    {
      $product = Product::create([
        'name'                => $productData['name'],
        'title'               => $productData['title'],
        'description'         => $productData['description'],
        'price'               => $productData['price'],
        'product_photo_path'  => $productData['photo']
      ]);

      return $this->store($product);
    }

    /**
     * Store a new product in the database.
     */
    private function store(Product $product)
    {
      return $product->save();
    }

    public function validateRequest(Request $request) {
      return $request->validate([
          'name'        => 'required|max:120',
          'title'       => 'required|max:120',
          'description' => 'required|max:255',
          'price'       => 'required',
          'photo'       => 'required|image',
      ]);
    }

    public function processRequest(Request $request)
    {
      $productData = $request->all();

      $file = $request->file('photo');

      $fileName = time() . '_' . $request->get('name') . '.' . $file->getClientOriginalExtension();
      $fileName = str_replace(' ', '_', $fileName);

      $path = $this->imageBasePath . '/' . $fileName;

      $file->move($this->imageBasePath, $fileName);

      $productData['photo'] = $path;

      return $productData;
    }
}
