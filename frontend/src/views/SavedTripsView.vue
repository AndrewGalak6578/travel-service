<template>
  <div class="saved-trips container page-padding">
    <h1>Your Saved Trips</h1>
    
    <div v-if="savedTrips.length === 0" class="empty-state">
      <p>No trips saved yet. Go to the <router-link to="/planner">Planner</router-link> to create one.</p>
    </div>

    <div class="trips-grid grid-2" v-else>
      <div v-for="trip in savedTrips" :key="trip.id" class="card trip-card">
        <h3>{{ trip.name }}</h3>
        <p><strong>Duration:</strong> {{ trip.duration }} days</p>
        <p><strong>Estimated Budget:</strong> ${{ trip.budget || 'TBD' }}</p>
        
        <div class="card-actions">
           <label>
             <input type="checkbox" :value="trip" v-model="selectedForComparison" :disabled="selectedForComparison.length >= 2 && !selectedForComparison.includes(trip)"> 
             Select to Compare
           </label>
           <button @click="deleteTrip(trip.id)" class="btn-text text-danger">Delete</button>
        </div>
      </div>
    </div>

    <div v-if="selectedForComparison.length === 2" class="comparison-section card">
      <h2>Trip Comparison</h2>
      <table class="comparison-table">
        <thead>
          <tr>
            <th>Feature</th>
            <th>{{ selectedForComparison[0].name }}</th>
            <th>{{ selectedForComparison[1].name }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Duration</td>
            <td>{{ selectedForComparison[0].duration }} Days</td>
            <td>{{ selectedForComparison[1].duration }} Days</td>
          </tr>
          <tr>
            <td>Est. Budget</td>
            <td>${{ selectedForComparison[0].budget || 0 }}</td>
            <td>${{ selectedForComparison[1].budget || 0 }}</td>
          </tr>
          <tr>
            <td>Highlights</td>
            <td>{{ selectedForComparison[0].days?.length || 0 }} Activities Planned</td>
            <td>{{ selectedForComparison[1].days?.length || 0 }} Activities Planned</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const savedTrips = ref([])
const selectedForComparison = ref([])

onMounted(() => {
  const local = localStorage.getItem('savedTrips')
  if (local) {
    savedTrips.value = JSON.parse(local).map(t => ({
        ...t,
        // Mock budget if missing for demonstration
        budget: t.budget || Math.floor(Math.random() * 2000) + 500
    }))
  } else {
    // Add some dummy data if empty for review
    savedTrips.value = [
        { id: 1, name: "Summer in Japan", duration: 10, budget: 3500 },
        { id: 2, name: "Weekend in Paris", duration: 3, budget: 1200 }
    ]
  }
})

const deleteTrip = (id) => {
  savedTrips.value = savedTrips.value.filter(t => t.id !== id)
  localStorage.setItem('savedTrips', JSON.stringify(savedTrips.value))
}
</script>

<style scoped>
.trip-card {
  border-left: 4px solid #2c974b;
}

.comparison-section {
  margin-top: 3rem;
  background: white;
  border: 1px solid #ddd;
}

.comparison-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.comparison-table th, .comparison-table td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.comparison-table th {
  background-color: #f9fafb;
}
</style>
