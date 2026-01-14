<template>
  <div class="destinations container page-padding">
    <h1>Explore Destinations</h1>
    
    <div class="filters">
      <div class="form-group">
        <label>Region:</label>
        <select v-model="filters.region" class="form-control">
          <option value="">All Regions</option>
          <option value="Asia">Asia</option>
          <option value="Europe">Europe</option>
          <option value="Americas">Americas</option>
        </select>
      </div>

      <div class="form-group">
        <label>Experience Type:</label>
        <select v-model="filters.type" class="form-control">
          <option value="">All Types</option>
          <option value="Adventure">Adventure</option>
          <option value="Relaxation">Relaxation</option>
          <option value="Culture">Culture</option>
        </select>
      </div>
    </div>

    <div class="grid-3">
      <div v-for="dest in filteredDestinations" :key="dest.id" class="card destination-card">
        <div class="card-header">
          <h3>{{ dest.name }}</h3>
          <span class="badge">{{ dest.region }}</span>
        </div>
        <div class="card-body">
          <p>{{ dest.description }}</p>
          
          <div class="section">
            <strong>Highlights:</strong>
            <ul>
              <li v-for="highlight in dest.highlights" :key="highlight">{{ highlight }}</li>
            </ul>
          </div>
          
          <div class="section sustainability-note">
            <strong>💚 Sustainability Note:</strong>
            <p>{{ dest.sustainability }}</p>
          </div>
          
          <div class="card-actions">
            <span class="tag">{{ dest.type }}</span>
            <button @click="addToPlan(dest)" class="btn btn-sm btn-primary">Add to Itinerary</button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="filteredDestinations.length === 0" class="no-results">
      <p>No destinations found matching your criteria.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const filters = ref({
  region: '',
  type: ''
})

const destinations = ref([
  {
    id: 1,
    name: "Kyoto, Japan",
    region: "Asia",
    type: "Culture",
    description: "Experience the ancient capital with reduced tourist footprint initiatives.",
    highlights: ["Bamboo Forest", "Historic Temples", "Tea Ceremonies"],
    sustainability: "Promotes strict waste recycling and preservation of historic districts."
  },
  {
    id: 2,
    name: "Costa Rica",
    region: "Americas",
    type: "Adventure",
    description: "A paradise for eco-tourism and wildlife observation.",
    highlights: ["Cloud Forests", "Volcano Hikes", "Wildlife Sanctuaries"],
    sustainability: "98% renewable energy usage and extensive national park protection."
  },
  {
    id: 3,
    name: "Ljubljana, Slovenia",
    region: "Europe",
    type: "Relaxation",
    description: "One of Europe's greenest capitals with car-free city center.",
    highlights: ["Tivoli Park", "River Cruise", "Castle Views"],
    sustainability: "Awarded European Green Capital for waste management and green spaces."
  }
])

const filteredDestinations = computed(() => {
  return destinations.value.filter(dest => {
    const matchRegion = !filters.value.region || dest.region === filters.value.region
    const matchType = !filters.value.type || dest.type === filters.value.type
    return matchRegion && matchType
  })
})

const addToPlan = (dest) => {
  // In a real app, this might use Pinia/Vuex
  alert(`Added ${dest.name} to your potential itinerary! Visit the Planner to organize.`)
}
</script>

<style scoped>
.filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  padding: 1rem;
  background: #f9fafb;
  border-radius: 8px;
}

.destination-card {
  display: flex;
  flex-direction: column;
}

.section {
  margin-top: 1rem;
  font-size: 0.9rem;
}

.sustainability-note {
  color: #166534;
  background: #f0fdf4;
  padding: 0.5rem;
  border-radius: 4px;
}

.badge {
  background: #e5e7eb;
  padding: 2px 8px;
  border-radius: 12px;
  font-size: 0.8rem;
}

.tag {
  color: #6b7280;
  font-size: 0.85rem;
  font-style: italic;
}

.card-actions {
  margin-top: auto;
  padding-top: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
