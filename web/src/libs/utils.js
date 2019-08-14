import axios from 'axios';

let util = {};
util.ajax = axios.create({
    baseURL: 'https://x5on.cn/',
    timeout: 30000,
});

export default util;