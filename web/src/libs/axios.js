import axios from 'axios';

let axio = axios.create({
    withCredentials: true,
    baseURL: 'https://x5on.cn/',
    timeout: 30000,
});

export default axio;