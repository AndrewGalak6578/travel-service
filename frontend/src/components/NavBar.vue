<template>
  <nav class="navbar">
    <div class="container nav-content">
      <router-link to="/" class="brand">EcoTravel</router-link>
      <div class="nav-links">
        <router-link to="/explore">Destinations</router-link>
        <router-link to="/planner">Itinerary Planner</router-link>
        <router-link to="/budget">Budget</router-link>
        <router-link to="/saved">Saved Trips</router-link>
        <router-link to="/contact">Contact</router-link>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.navbar {
  background-color: #2c974b;
  padding: 1rem 0;
  color: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.nav-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.brand {
  font-size: 1.5rem;
  font-weight: bold;
  color: white;
  text-decoration: none;
}

.nav-links {
  display: flex;
  gap: 1.5rem;
}

.nav-links a {
  color: #e6fffa;
  text-decoration: none;
  font-weight: 500;
}

.nav-links a:hover, .nav-links a.router-link-active {
  color: white;
  text-decoration: underline;
}
</style>
