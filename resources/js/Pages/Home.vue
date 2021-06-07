<template>
    <MainMenu />
    <Hero />
    <ProductGrid :products="products" />
</template>

<script>
  import AppLayout from '@/Layouts/AppLayout'
  import JetNavLink from '@/Components/NavLink'
  import Hero from '@/Components/Hero'
  import ProductGrid from '@/Pages/Shop/ProductGrid'
  import MainMenu from '@/Menu/MainMenu'

  export default {

    components: {
      AppLayout,
      JetNavLink,
      Hero,
      MainMenu,
      ProductGrid,
    },

    props: ['products'],
    
  }
</script>
