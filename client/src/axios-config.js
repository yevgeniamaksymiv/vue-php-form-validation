import axios from 'axios';

const axiosInstance = axios.create({
  method: 'POST',
  baseURL: 'http://localhost:81/vue-php-form-validation/server/validation.php',
  timeout: 5000,
  headers: {
    'Content-Type': 'application/json',
  },
  crossdomain: true,
});

export default axiosInstance;