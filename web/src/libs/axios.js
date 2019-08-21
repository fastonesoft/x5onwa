import axios from 'axios';

let axio = axios.create();

let axio_local = axios.create({
    withCredentials: true,
    baseURL: 'https://x5on.cn/',
});

let ajax = location.hostname === 'localhost' ? axio_local : axio;

ajax.gets = function (url, data) {

    if (!data) {
        return new Promise(function (resolve, reject) {
            ajax.get(url).then(res => {
                if (res.data && res.data.code) {
                    // code != 0 => error
                    reject(res.data.data)
                } else {
                    resolve(res.data.data)
                }
            }).catch(() => {
                reject('数据请求失败')
            })
        })
    } else {
        return new Promise(function (resolve, reject) {
            ajax.get(url, {params: data}).then(res => {
                if (res.data && res.data.code) {
                    // code != 0 => error
                    reject(res.data.data)
                } else {
                    resolve(res.data.data)
                }
            }).catch(() => {
                reject('数据请求失败')
            })
        })
    }
};

ajax.posts = function (url, data) {
    let param = data || {};
    return new Promise(function (resolve, reject) {
        ajax.post(url, param).then(res => {
            if (res.data && res.data.code) {
                // code != 0 => error
                reject(res.data.data)
            } else {
                resolve(res.data.data)
            }
        }).catch(() => {
            reject('数据提交失败')
        })
    })
};

let all = axios.all;
let spread = axios.spread;

export default {ajax, all, spread};