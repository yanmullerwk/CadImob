<script setup>
    import { Link } from '@inertiajs/vue3';
</script>

<template>
   <div class="flex items-center space-x-4">
    <!-- Logout -->
    <Link :href="route('logout')" method="post">
      <v-icon>mdi-exit-to-app</v-icon>
    </Link>
  </div>
</template>
