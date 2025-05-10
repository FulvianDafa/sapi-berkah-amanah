// frontend/src/services/axiosConfig.js
import axios from "axios";

// Create axios instance
const axiosInstance = axios.create({
  baseURL: "https://adminsapiberkahamanahadmin.sapiberkahamanah.com/api",
  withCredentials: false,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
    "X-Requested-With": "XMLHttpRequest",
  },
});

export default axiosInstance;