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
                    <div v-for="(activity, aIndex) in day.activities" :key="`${day.id}-${aIndex}`" class="activity-item">
                        <div v-if="activity.isEditing" class="edit-mode">
                            <input
                                v-model="activity.tempName"
                                placeholder="Activity Name"
                                class="form-control activity-input"
                                @click.stop
                                @focus="$event.target.select()"
                            />
                            <input
                                v-model="activity.tempTime"
                                type="time"
                                class="form-control time-input"
                                @click.stop
                            />
                            <button @click.stop="saveActivity(day.id, aIndex)" class="btn btn-sm btn-success">Save</button>
                            <button @click.stop="cancelEdit(day.id, aIndex)" class="btn btn-sm btn-secondary">Cancel</button>
                        </div>
                        <div v-else class="view-mode">
                            <span class="time">{{ activity.time }}</span>
                            <span class="name">{{ activity.name }}</span>
                            <div class="actions">
                                <button @click.stop="editActivity(day.id, aIndex)" class="btn-text edit-btn">✏️ Edit</button>
                                <button @click.stop="removeActivity(day.id, aIndex)" class="btn-text delete-btn">🗑️ Delete</button>
                            </div>
                        </div>
                    </div>

                    <div v-if="day.activities.length === 0" class="empty-activities">
                        <p>No activities yet. Click "Add Activity" to start planning!</p>
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
            { name: "Arrival & Check-in", time: "10:00", isEditing: false, tempName: "", tempTime: "" }
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
    if (confirm('Are you sure you want to remove this day?')) {
        days.value.splice(index, 1)
    }
}

const addNewActivity = (dayId) => {
    const day = days.value.find(d => d.id === dayId)
    if (day) {
        day.activities.push({
            name: "New Activity",
            time: "09:00",
            tempName: "New Activity",
            tempTime: "09:00",
            isEditing: true
        })
    }
}

const saveActivity = (dayId, activityIndex) => {
    const day = days.value.find(d => d.id === dayId)
    if (day) {
        const act = day.activities[activityIndex]
        if (act.tempName.trim()) {
            act.name = act.tempName
            act.time = act.tempTime
            act.isEditing = false
        } else {
            alert('Please enter an activity name')
        }
    }
}

const editActivity = (dayId, activityIndex) => {
    const day = days.value.find(d => d.id === dayId)
    if (day) {
        const act = day.activities[activityIndex]
        act.tempName = act.name
        act.tempTime = act.time
        act.isEditing = true
    }
}

const cancelEdit = (dayId, activityIndex) => {
    const day = days.value.find(d => d.id === dayId)
    if (day) {
        const act = day.activities[activityIndex]
        // If the activity has no name, remove it (it was just added)
        if (!act.name || act.name === "") {
            day.activities.splice(activityIndex, 1)
        } else {
            act.isEditing = false
        }
    }
}

const removeActivity = (dayId, activityIndex) => {
    if (confirm('Are you sure you want to delete this activity?')) {
        const day = days.value.find(d => d.id === dayId)
        if (day) {
            day.activities.splice(activityIndex, 1)
        }
    }
}

const saveItinerary = () => {
    // Check if all activities have names
    const hasEmptyActivities = days.value.some(day =>
        day.activities.some(act => !act.name || act.name.trim() === '')
    )

    if (hasEmptyActivities) {
        alert('Please complete all activity names before saving')
        return
    }

    const trip = {
        id: Date.now(),
        name: `My Trip ${new Date().toLocaleDateString()}`,
        duration: days.value.length,
        days: days.value
    }

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

.empty-state {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 8px;
    color: #6b7280;
}

.days-container {
    margin-bottom: 2rem;
}

.day-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.day-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f3f4f6;
    padding-bottom: 1rem;
    margin-bottom: 1rem;
}

.day-header h2 {
    margin: 0;
    font-size: 1.5rem;
    color: #1f2937;
}

.activities-list {
    min-height: 50px;
}

.activity-item {
    padding: 0.75rem 0;
    border-bottom: 1px dashed #e5e7eb;
}

.activity-item:last-child {
    border-bottom: none;
}

.empty-activities {
    text-align: center;
    padding: 2rem;
    color: #9ca3af;
    font-style: italic;
}

.view-mode {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.time {
    font-family: 'Courier New', monospace;
    background: #f3f4f6;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.9rem;
    font-weight: 600;
    min-width: 70px;
    text-align: center;
}

.name {
    flex-grow: 1;
    font-size: 1rem;
    color: #374151;
}

.actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-text {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px 12px;
    font-size: 0.9rem;
    transition: all 0.2s;
    border-radius: 4px;
    font-weight: 500;
}

.btn-text:hover {
    transform: translateY(-1px);
}

.edit-btn {
    color: #3b82f6;
}

.edit-btn:hover {
    background: #eff6ff;
    color: #2563eb;
}

.delete-btn {
    color: #ef4444;
}

.delete-btn:hover {
    background: #fef2f2;
    color: #dc2626;
}

.edit-mode {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    flex-wrap: wrap;
}

.form-control {
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 0.95rem;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: white;
    position: relative;
    z-index: 10;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-control:hover {
    border-color: #9ca3af;
}

.activity-input {
    flex: 1;
    min-width: 200px;
    cursor: text;
}

.time-input {
    width: 120px;
    cursor: pointer;
}

.add-activity {
    margin-top: 1rem;
    text-align: center;
}

.save-actions {
    margin-top: 2rem;
    text-align: right;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-outline {
    background: white;
    border: 1px dashed #d1d5db;
    color: #6b7280;
}

.btn-outline:hover {
    background: #f9fafb;
    border-color: #3b82f6;
    color: #3b82f6;
}

.text-white {
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .edit-mode {
        flex-direction: column;
        align-items: stretch;
    }

    .activity-input,
    .time-input {
        width: 100%;
    }

    .header-action {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
}
</style>
