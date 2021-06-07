<template>
    <MainMenu />
    <ProductGrid :products="products" />
</template>

<script>
  import AppLayout from '@/Layouts/AppLayout'
  import JetNavLink from '@/Components/NavLink'
  import ProductGrid from '@/Pages/Shop/ProductGrid'
  import MainMenu from '@/Menu/MainMenu'

  export default {

    components: {
      AppLayout,
      JetNavLink,
      MainMenu,
      ProductGrid,
    },

    props: ['products'],

  }
</script>
