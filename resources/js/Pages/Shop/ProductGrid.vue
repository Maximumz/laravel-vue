<template>
  <div class="flex flex-col w-full p-3 sm:p-3" style="background-color:  #a437db;">
    <h2 class="text-xl font-semibold text-white">FREE SHIPPING - <span class="text-sm">(ON ITEMS OVER $40)</span></h2>
  </div>
  <div v-if="products" class="container" ref="shop">
    <div class="flex flex-wrap justify-around w-full">
      <div v-for="product in products" class="w-full sm:w-1/3 md:w-1/5 bg-white shadow-lg rounded-lg overflow-hidden my-10 m-0.5 hover:opacity-70 transition">
        <div class="px-4 py-2 bg-green-500">
          <h1 class="text-white font-bold text-lg uppercase truncate">{{ product.title }}</h1>
          <p class="text-white truncate">{{ product.description }}</p>
        </div>
        <img class="h-50 w-50 object-cover mt-2" :src="product.product_photo_path" :alt="product.title">
        <div class="flex items-center justify-between px-4 py-2 bg-gray-500 hover:bg-gray-400 transition">
          <h1 class="text-gray-200 font-bold text-xl">${{ product.price }}</h1>
          <button v-on:click="addToCart(product.id, $event)" class="px-1 py-1 text-xs bg-indigo-100 text-indigo-700 font-semibold rounded transition">ADD TO CART</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductGrid',

  props: {
    products: Object
  },

  methods: {
      async addToCart(productId, event) {
        const response = await axios.get(route('addToCart', {
            id: productId,
        }));

        if (response.status == 200) {
          event.target.innerText = 'ADDED!';
          setTimeout(function(){
            event.target.innerText = 'ADD TO CART';
          }, 1500);
        }
      },
  },
}
</script>
