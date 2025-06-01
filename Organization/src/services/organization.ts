import axiosInstance from '../utils/axios';

export interface OrganizationProfile {
  id: number;
  organization_name: string;
  official_email: string;
  official_phone: string;
  office_address: string;
  field_of_work: string;
  description: string;
  photo_url: string | null;
  status: string;
  created_at: string;
}

export interface OrganizationStats {
  totalActivities: number;
  totalVolunteers: number;
  activeActivities: number;
}

export interface UpdateProfileData {
  organization_name: string;
  official_email: string;
  official_phone: string;
  office_address: string;
  field_of_work: string;
  description: string;
}

class OrganizationService {
  // Mendapatkan profil organisasi
  async getProfile(): Promise<OrganizationProfile> {
    try {
      const response = await axiosInstance.get('/organization/profile');
      if (response.data.status === 'success') {
        return response.data.data;
      }
      throw new Error(response.data.message || 'Failed to fetch organization profile');
    } catch (error) {
      console.error('Error fetching organization profile:', error);
      throw error;
    }
  }

  // Update profil organisasi
  async updateProfile(data: UpdateProfileData): Promise<void> {
    try {
      const response = await axiosInstance.put('/organization/profile', data);
      if (response.data.status !== 'success') {
        throw new Error(response.data.message || 'Failed to update organization profile');
      }
    } catch (error) {
      console.error('Error updating organization profile:', error);
      throw error;
    }
  }

  // Upload foto profil
  async uploadPhoto(file: File): Promise<string> {
    try {
      const formData = new FormData();
      formData.append('photo', file);

      const response = await axiosInstance.post('/organization/upload-photo', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });

      if (response.data.status === 'success') {
        return response.data.photo_url;
      }
      throw new Error(response.data.message || 'Failed to upload photo');
    } catch (error) {
      console.error('Error uploading photo:', error);
      throw error;
    }
  }

  // Mendapatkan statistik organisasi
  async getStats(): Promise<OrganizationStats> {
    try {
      const response = await axiosInstance.get('/organization/stats');
      if (response.data.status === 'success') {
        return response.data.data;
      }
      throw new Error(response.data.message || 'Failed to fetch organization stats');
    } catch (error) {
      console.error('Error fetching organization stats:', error);
      throw error;
    }
  }
}

export default new OrganizationService(); 