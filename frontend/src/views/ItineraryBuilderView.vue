<template>
  <div class="itinerary container page-padding">
    <div class="header-action">
      <h1>Itinerary Builder</h1>
      <button @click="addDay" class="btn btn-primary">+ Add Day</button>
    </div>

    <div v-if="days.length === 0" class="empty-state">
      <p>Start planning your trip by adding a day!</p>
    </div>

    <div class="days-container">
      <div v-for="(day, index) in days" :key="day.id" class="day-card">
        <div class="day-header">
          <h2>Day {{ index + 1 }}</h2>
          <button @click="removeDay(index)" class="btn btn-sm btn-danger text-white">Remove Day</button>
        </div>

        <div class="activities-list">
          <div v-for="(activity, aIndex) in day.activities" :key="aIndex" class="activity-item">
            <div v-if="activity.isEditing" class="edit-mode">
              <input v-model="activity.tempName" placeholder="Activity Name" class="form-control" />
              <input v-model="activity.tempTime" type="time" class="form-control" />
              <button @click="saveActivity(day.id, aIndex)" class="btn btn-sm btn-success">Save</button>
            </div>
            <div v-else class="view-mode">
              <span class="time">{{ activity.time }}</span>
              <span class="name">{{ activity.name }}</span>
              <div class="actions">
                <button @click="editActivity(day.id, aIndex)" class="btn-text">Edit</button>
                <button @click="removeActivity(day.id, aIndex)" class="btn-text text-danger">x</button>
              </div>
            </div>
          </div>
        </div>

        <div class="add-activity">
          <button @click="addNewActivity(day.id)" class="btn btn-sm btn-outline">+ Add Activity</button>
        </div>
      </div>
    </div>

    <div v-if="days.length > 0" class="save-actions">
      <button class="btn btn-primary" @click="saveItinerary">Save Itinerary</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const days = ref([
  {
    id: 1,
    activities: [
      { name: "Arrival & Check-in", time: "10:00", isEditing: false }
    ]
  }
])

const addDay = () => {
  days.value.push({
    id: Date.now(),
    activities: []
  })
}

const removeDay = (index) => {
  days.value.splice(index, 1)
}

const addNewActivity = (dayId) => {
  const day = days.value.find(d => d.id === dayId)
  day.activities.push({
    name: "",
    time: "09:00",
    tempName: "",
    tempTime: "09:00",
    isEditing: true
  })
}

const saveActivity = (dayId, activityIndex) => {
  const day = days.value.find(d => d.id === dayId)
  const act = day.activities[activityIndex]
  if (act.tempName.trim()) {
    act.name = act.tempName
    act.time = act.tempTime
    act.isEditing = false
  }
}

const editActivity = (dayId, activityIndex) => {
  const day = days.value.find(d => d.id === dayId)
  const act = day.activities[activityIndex]
  act.tempName = act.name
  act.tempTime = act.time
  act.isEditing = true
}

const removeActivity = (dayId, activityIndex) => {
  const day = days.value.find(d => d.id === dayId)
  day.activities.splice(activityIndex, 1)
}

const saveItinerary = () => {
    // Save to local storage for the Saved Trips page to pick up (demo purposes)
    const trip = {
        id: Date.now(),
        name: `My Trip ${new Date().toLocaleDateString()}`,
        duration: days.value.length,
        days: days.value
    }
    
    // Get existing
    const existing = JSON.parse(localStorage.getItem('savedTrips') || '[]')
    existing.push(trip)
    localStorage.setItem('savedTrips', JSON.stringify(existing))
    
    alert('Itinerary saved successfully!')
}
</script>

<style scoped>
.header-action {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.day-card {
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
}

.day-header {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #f3f4f6;
  padding-bottom: 1rem;
  margin-bottom: 1rem;
}

.activity-item {
  padding: 0.5rem 0;
  border-bottom: 1px dashed #e5e7eb;
}

.view-mode {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.time {
  font-family: monospace;
  background: #f3f4f6;
  padding: 2px 6px;
  border-radius: 4px;
}

.name {
  flex-grow: 1;
}

.edit-mode {
  display: flex;
  gap: 0.5rem;
}

.add-activity {
  margin-top: 1rem;
  text-align: center;
}

.save-actions {
    margin-top: 2rem;
    text-align: right;
}
</style>
