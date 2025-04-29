import api from '../utils/axios';
import router from '../router';

// Test connection to backend
export const testConnection = async () => {
  try {
    const response = await api.get('/test');
    return response.data;
  } catch (error) {
    console.error('Error testing backend connection:', error);
    throw error;
  }
};

// Auth APIs
export const login = (credentials) => api.post('/login', credentials);
export const register = (userData) => api.post('/register', userData);
export const logout = async () => {
  try {
    const token = localStorage.getItem('token');
    if (token) {
      await api.post('/logout', null, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
    }
  } catch (error) {
    console.error('Error during logout API call:', error);
  } finally {
    // Clear local storage and redirect regardless of API call success
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    router.push('/');
  }
};

// User APIs
export const getUserProfile = () => api.get('api/users/profile');
export const updateUserProfile = (data) => api.put('api/users/profile', data);

// Activity APIs
export const getActivities = () => api.get('api/activities');
export const getActivityById = (id) => api.get(`api/activities/${id}`);
export const createActivity = (activityData) => api.post('api/activities', activityData);
export const updateActivity = (id, activityData) => api.put(`api/activities/${id}`, activityData);
export const deleteActivity = (id) => api.delete(`api/activities/${id}`);

// Volunteer APIs
export const getVolunteers = () => api.get('api/relawan');
export const getVolunteerById = (id) => api.get(`api/relawan/${id}`);
export const registerVolunteer = (volunteerData) => api.post('api/relawan', volunteerData);
export const updateVolunteerStatus = (id, status) => api.put(`api/relawan/${id}/status`, { status });

// Donation APIs
export const getDonations = () => api.get('api/donations');
export const createDonation = (donationData) => api.post('api/donations', donationData);
export const getDonationById = (id) => api.get(`api/donations/${id}`);
