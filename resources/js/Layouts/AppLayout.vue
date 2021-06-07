<template>
    <div>
        <jet-banner />
        <div class="min-h-screen bg-gray-100">
            <main-menu />
            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
    import JetBanner from '@/Components/Banner'
    import MainMenu from '@/Menu/MainMenu'

    export default {
      components: {
          JetBanner,
          MainMenu,
      }
    }
</script>
