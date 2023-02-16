import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://localhost:81/vue-php-form-validation/server',
  timeout: 5000,
  headers: {
    'Content-Type': 'application/json',
  },
  crossdomain: true,
});

export default axiosInstance