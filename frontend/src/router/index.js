import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import DestinationsView from '../views/DestinationsView.vue'
import ItineraryBuilderView from '../views/ItineraryBuilderView.vue'
import BudgetPlannerView from '../views/BudgetPlannerView.vue'
import SavedTripsView from '../views/SavedTripsView.vue'
import ContactView from '../views/ContactView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/explore',
      name: 'destinations',
      component: DestinationsView
    },
    {
      path: '/planner',
      name: 'planner',
      component: ItineraryBuilderView
    },
    {
      path: '/budget',
      name: 'budget',
      component: BudgetPlannerView
    },
    {
      path: '/saved',
      name: 'saved',
      component: SavedTripsView
    },
    {
      path: '/contact',
      name: 'contact',
      component: ContactView
    }
  ]
})

export default router
