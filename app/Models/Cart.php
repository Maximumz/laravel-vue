<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_ids'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_activity' => 'datetime',
    ];

    public function addProduct(Product $product)
    {
        $cart = session('cart');

        if (empty($cart)) {
          $cart = [
            $product->id => [
              "name"                => $product->name,
              "title"               => $product->title,
              "description"         => $product->description,
              "quantity"            => 1,
              "price"               => $product->price,
              "product_photo_path"  => $product->product_photo_path,
              "total"               => $product->price,
            ]
          ];
        } elseif (isset($cart[$product->id])) {
          $cart[$product->id]["quantity"]++;
          $cart[$product->id]["total"] = round($product->price * $cart[$product->id]["quantity"], 2);
        } else {
          $cart[$product->id] = [
            "name"                => $product->name,
            "title"               => $product->title,
            "description"         => $product->description,
            "quantity"            => 1,
            "price"               => $product->price,
            "product_photo_path"  => $product->product_photo_path,
            "total"               => $product->price,
          ];
        }

        $cart = $this->updateCartTotals($cart);

        return $this->updateCart($cart);
    }

    public function removeProduct(Product $product)
    {
        $cart = session('cart');

        if (empty($cart)) {
          return false;
        } elseif (isset($cart[$product->id]) && $cart[$product->id]["quantity"] > 1) {
          $cart[$product->id]["quantity"]--;
          $cart[$product->id]["total"] = round($product->price * $cart[$product->id]["quantity"], 2);
        } else {
          unset($cart[$product->id]);
        }

        $cart = $this->updateCartTotals($cart);

        return $this->updateCart($cart);
    }

    /**
     * Update the cart totals
     */
    private function updateCartTotals($cart) {

        if (!empty($cart["total"])) {
            unset($cart["total"]);
        }

        $cartTotal = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                if (!empty($item["price"]) && !empty($item["quantity"])) {
                    $cartTotal = $cartTotal + ($item["price"] * $item["quantity"]);
                }
            }
        }

        $cart["total"] = round($cartTotal, 2);

        return $cart;
    }

    /**
     * Update the cart within the session & store
     */
    private function updateCart($cart)
    {
      session(['cart' => $cart]);
      $userId = session('user_id');

      if (!empty($userId)) {

        $productIds = [];

        foreach ($cart as $key => $index) {
          $productIds[$key] = $index['quantity'];
        }

        $productIds = json_encode($productIds);

        $currentCart = Cart::find($userId);

        if(empty($currentCart)) {

          $cart = Cart::create([
            'user_id'     => $userId,
            'product_ids' => $productIds
          ]);

          return $cart->save();

        } else {

          $currentCart->product_ids = $productIds;
          return $currentCart->save();
        }
      }
    }
}
