<template>
  <div class="contact container page-padding">
    <h1>Contact & Travel Assistance</h1>
    <p>Have questions about your sustainable journey? Reach out to us.</p>
    
    <div class="card contact-form-card">
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label>Name</label>
          <input v-model="form.name" type="text" class="form-control" placeholder="Your Name">
        </div>
        
        <div class="form-group">
          <label>Email <span class="text-danger">*</span></label>
          <input v-model="form.email" type="email" class="form-control" placeholder="email@example.com" :class="{ 'is-invalid': errors.email }">
          <span v-if="errors.email" class="error-msg">{{ errors.email }}</span>
        </div>
        
        <div class="form-group">
          <label>Message <span class="text-danger">*</span></label>
          <textarea v-model="form.message" class="form-control" rows="5" placeholder="How can we help?" :class="{ 'is-invalid': errors.message }"></textarea>
          <span v-if="errors.message" class="error-msg">{{ errors.message }}</span>
        </div>
        
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
  name: '',
  email: '',
  message: ''
})

const errors = ref({})

const validate = () => {
  errors.value = {}
  let isValid = true
  
  if (!form.value.email) {
    errors.value.email = "Email is required."
    isValid = false
  } else if (!/\S+@\S+\.\S+/.test(form.value.email)) {
    errors.value.email = "Please enter a valid email."
    isValid = false
  }
  
  if (!form.value.message) {
    errors.value.message = "Message is required."
    isValid = false
  }
  
  return isValid
}

const submitForm = () => {
  if (validate()) {
    alert("Thank you! Your message has been sent. We will contact you shortly.")
    form.value = { name: '', email: '', message: '' }
  }
}
</script>

<style scoped>
.contact-form-card {
  max-width: 600px;
  margin: 2rem auto;
}

.error-msg {
  color: #dc2626;
  font-size: 0.85rem;
  margin-top: 0.25rem;
  display: block;
}

.is-invalid {
  border-color: #dc2626;
}
</style>
