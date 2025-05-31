import axiosInstance from '../utils/axios';

export interface LoginData {
    email: string;
    password: string;
}

export interface OrganizationData {
    id: number;
    organization_name: string;
    official_email: string;
    official_phone: string;
    office_address: string;
    field_of_work: string;
}

export interface ApiResponse<T> {
    status: 'success' | 'error';
    message: string;
    data?: T;
}

export interface LoginResponseData {
    token: string;
    organization: OrganizationData;
}

class AuthService {
    async login(data: LoginData): Promise<ApiResponse<LoginResponseData>> {
        try {
            console.log('AuthService: Attempting login with:', { email: data.email });
            const response = await axiosInstance.post<ApiResponse<LoginResponseData>>('/organization/login', data);
            console.log('AuthService: Raw response:', response);
            
            // Parse the response data if it's a string
            let responseData: ApiResponse<LoginResponseData>;
            if (typeof response.data === 'string') {
                // Remove any trailing 'null' and trim whitespace
                const cleanData = (response.data as string).replace(/null\s*$/, '').trim();
                console.log('AuthService: Cleaned response string:', cleanData);
                responseData = JSON.parse(cleanData);
            } else {
                responseData = response.data;
            }
            
            console.log('AuthService: Processed response data:', responseData);
            
            if (responseData.status === 'success' && responseData.data?.token) {
                console.log('AuthService: Storing token and organization data');
                localStorage.setItem('token', responseData.data.token);
                localStorage.setItem('organization', JSON.stringify(responseData.data.organization));
            } else {
                console.log('AuthService: Invalid response format or missing token');
                throw new Error(responseData.message || 'Invalid response format');
            }
            
            return responseData;
        } catch (error: any) {
            console.error('AuthService: Login error:', error);
            if (error.response?.data) {
                console.log('AuthService: Error response data:', error.response.data);
                const errorData = typeof error.response.data === 'string' 
                    ? JSON.parse(error.response.data.replace(/null\s*$/, '').trim())
                    : error.response.data;
                throw new Error(errorData.message || 'Login failed');
            }
            throw new Error(error.message || 'Login failed');
        }
    }

    logout() {
        console.log('AuthService: Logging out');
        localStorage.removeItem('token');
        localStorage.removeItem('organization');
        window.location.href = '/login';
    }

    getCurrentOrganization(): OrganizationData | null {
        try {
            const org = localStorage.getItem('organization');
            return org ? JSON.parse(org) : null;
        } catch (error) {
            console.error('AuthService: Error parsing organization data:', error);
            return null;
        }
    }

    getToken(): string | null {
        return localStorage.getItem('token');
    }

    isAuthenticated(): boolean {
        const token = this.getToken();
        if (!token) {
            console.log('AuthService: No token found');
            return false;
        }

        try {
            // Basic token validation
            const payload = JSON.parse(atob(token.split('.')[1]));
            const expirationTime = payload.exp * 1000; // Convert to milliseconds
            const isValid = Date.now() < expirationTime;
            console.log('AuthService: Token validation result:', isValid);
            return isValid;
        } catch (error) {
            console.error('AuthService: Error validating token:', error);
            return false;
        }
    }

    // Method untuk mengecek apakah token akan expired dalam waktu tertentu (misal 5 menit)
    isTokenExpiringSoon(minutes: number = 5): boolean {
        const token = this.getToken();
        if (!token) return true;

        try {
            const payload = JSON.parse(atob(token.split('.')[1]));
            const expirationTime = payload.exp * 1000;
            const currentTime = Date.now();
            const timeUntilExpiry = expirationTime - currentTime;
            
            // Return true if token will expire in less than specified minutes
            return timeUntilExpiry < (minutes * 60 * 1000);
        } catch (error) {
            console.error('AuthService: Error checking token expiration:', error);
            return true;
        }
    }
}

export default new AuthService(); 