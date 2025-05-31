import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import '@fortawesome/fontawesome-free/css/all.min.css'
import './style.css'

// Create Vue app
const app = createApp(App)

// Use router
app.use(router)

// Mount app
app.mount('#app')
