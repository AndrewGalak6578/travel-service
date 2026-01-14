<template>
  <div class="budget container page-padding">
    <h1>Budget Planner</h1>
    
    <div class="grid-2">
      <div class="card bg-white">
        <h3>Estimate Your Costs</h3>
        <form @submit.prevent>
          <div class="form-group">
            <label>Travel Cost ($)</label>
            <input type="number" v-model.number="costs.travel" min="0" class="form-control" placeholder="0.00">
          </div>
          
          <div class="form-group">
            <label>Accommodation Cost ($)</label>
            <input type="number" v-model.number="costs.accommodation" min="0" class="form-control" placeholder="0.00">
          </div>
          
          <div class="form-group">
            <label>Activity Cost ($)</label>
            <input type="number" v-model.number="costs.activity" min="0" class="form-control" placeholder="0.00">
          </div>
          
          <div class="form-group">
            <label>Food & Misc ($)</label>
            <input type="number" v-model.number="costs.misc" min="0" class="form-control" placeholder="0.00">
          </div>
        </form>
      </div>

      <div class="card summary-card">
        <h3>Budget Summary</h3>
        
        <div class="summary-item">
          <span>Travel:</span>
          <span>${{ costs.travel || 0 }}</span>
        </div>
        <div class="summary-item">
          <span>Accommodation:</span>
          <span>${{ costs.accommodation || 0 }}</span>
        </div>
        <div class="summary-item">
          <span>Activities:</span>
          <span>${{ costs.activity || 0 }}</span>
        </div>
        <div class="summary-item">
          <span>Misc:</span>
          <span>${{ costs.misc || 0 }}</span>
        </div>
        
        <div class="total-line">
          <span>Total Estimated:</span>
          <span class="total-amount">${{ totalBudget }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const costs = ref({
  travel: 0,
  accommodation: 0,
  activity: 0,
  misc: 0
})

const totalBudget = computed(() => {
  return (costs.value.travel || 0) + 
         (costs.value.accommodation || 0) + 
         (costs.value.activity || 0) +
         (costs.value.misc || 0)
})
</script>

<style scoped>
.summary-card {
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px dotted #bbf7d0;
}

.total-line {
  margin-top: 1.5rem;
  padding-top: 1rem;
  border-top: 2px solid #166534;
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  font-size: 1.25rem;
  color: #166534;
}
</style>
