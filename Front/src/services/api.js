import api from '../utils/axios';

// Test connection to backend
export const testConnection = async () => {
  try {
    const response = await api.get('test');
    console.log('Test connection response:', response);
    return response.data;
  } catch (error) {
    console.error('Error testing backend connection:', error);
    throw error;
  }
};

// Auth APIs
export const login = (credentials) => api.post('/login', credentials);
export const register = (userData) => api.post('/register', userData);
export const logout = () => api.post('/auth/logout');

// User APIs
export const getUserProfile = () => api.get('/users/profile');
export const updateUserProfile = (data) => api.put('/users/profile', data);

// Event APIs
export const getEvents = () => api.get('/events');
export const getEventById = (id) => api.get(`/events/${id}`);
export const createEvent = (eventData) => api.post('/events', eventData);
export const updateEvent = (id, eventData) => api.put(`/events/${id}`, eventData);
export const deleteEvent = (id) => api.delete(`/events/${id}`);

// Volunteer APIs
export const getVolunteers = () => api.get('/controllers/RelawanController.php');
export const getVolunteerById = (id) => api.get(`/volunteers/${id}`);
export const registerVolunteer = (volunteerData) => api.post('/controllers/RelawanController.php', volunteerData);
export const updateVolunteerStatus = (id, status) => api.put(`/volunteers/${id}/status`, { status });

// Donation APIs
export const getDonations = () => api.get('/donations');
export const createDonation = (donationData) => api.post('/donations', donationData);
export const getDonationById = (id) => api.get(`/donations/${id}`); 