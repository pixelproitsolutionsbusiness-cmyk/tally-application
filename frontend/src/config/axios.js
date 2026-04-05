import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8080', // Backend API base URL
});

// Add a request interceptor to attach the token
instance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = token;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default instance;