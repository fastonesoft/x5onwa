import axios from 'axios';

let axio = axios.create();

let axio_local = axios.create({
    withCredentials: true,
    baseURL: 'https://x5on.cn/',
});

export default { axio, axio_local };