<script setup>
import { ref } from 'vue'

const popularDestinations = ref([
  { id: 1, name: "Japan", description: "Ancient traditions meet sustainable modern living.", color: "#fca5a5" },
  { id: 2, name: "Norway", description: "Majestic fjords and leading green energy practices.", color: "#93c5fd" },
  { id: 3, name: "Costa Rica", description: "A world leader in conservation and eco-tourism.", color: "#86efac" }
])
</script>

<template>
  <div class="home">
    <section class="hero">
      <div class="container">
        <h1>Travel Sustainably, Experience Locally</h1>
        <p class="subtitle">
          Discover eco-friendly destinations and build your perfect itinerary that respects the planet.
        </p>
        <div class="cta-group">
          <router-link to="/explore" class="btn btn-primary">Explore Destinations</router-link>
          <router-link to="/planner" class="btn btn-secondary">Start Planning</router-link>
        </div>
      </div>
    </section>

    <section class="features container">
      <h2>Why EcoTravel?</h2>
      <div class="grid-3">
        <div class="card">
          <h3>Eco-Friendly</h3>
          <p>We curate destinations that prioritize environmental conservation.</p>
        </div>
        <div class="card">
          <h3>Local Experiences</h3>
          <p>Connect with local communities and support local economies.</p>
        </div>
        <div class="card">
          <h3>Smart Budgeting</h3>
          <p>Plan your trip within your means with our integrated budget tools.</p>
        </div>
      </div>
    </section>

    <section class="popular-destinations container">
      <h2>Popular Destinations</h2>
      <div class="grid-3">
        <div v-for="dest in popularDestinations" :key="dest.id" class="card destination-card">
          <div class="card-image-placeholder" :style="{ backgroundColor: dest.color }"></div>
          <div class="card-content">
            <h3>{{ dest.name }}</h3>
            <p>{{ dest.description }}</p>
            <router-link to="/explore" class="btn-text">Explore &rarr;</router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.hero {
  background-color: #f0fdf4;
  padding: 4rem 0;
  text-align: center;
  margin-bottom: 3rem;
}

.subtitle {
  font-size: 1.25rem;
  color: #4b5563;
  margin-bottom: 2rem;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.cta-group {
  display: flex;
  gap: 1rem;
  justify-content: center;
}

.features h2 {
  text-align: center;
  margin-bottom: 2rem;
}

.popular-destinations {
  margin-top: 4rem;
  margin-bottom: 4rem;
}

.popular-destinations h2 {
  text-align: center;
  margin-bottom: 2rem;
}

.destination-card {
  padding: 0;
  overflow: hidden;
}

.card-image-placeholder {
  height: 150px;
  width: 100%;
  background-color: #ddd;
}

.card-content {
  padding: 1.5rem;
}
</style>
