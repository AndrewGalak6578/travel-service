<script setup>
import NavBar from './components/NavBar.vue'
</script>

<template>
  <header>
    <NavBar />
  </header>

  <main>
    <router-view />
  </main>
  
  <footer>
    <div class="container">
      <p>&copy; 2026 Sustainable Travel Planner. All Rights Reserved.</p>
    </div>
  </footer>
</template>

<style scoped>
footer {
  text-align: center;
  padding: 2rem 0;
  margin-top: 4rem;
  color: #6b7280;
  border-top: 1px solid #e5e7eb;
}
</style>
