//index.js
var qcloud = require('../../vendor/wafer2-client-sdk/index')
var config = require('../../config')
var util = require('../../utils/util.js')
var x5on = require('../../utils/x5on.js')

var app = getApp();

Page({
    data: {
        cores: [],
        can_use: false,
        imgUrls: [
            'http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg',
            'http://img06.tooopen.com/images/20160818/tooopen_sy_175866434296.jpg',
            'http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg'
        ],
        indicatorDots: true,
        autoplay: true,
        interval: 5000,
        duration: 1000
    },

    onShow: function() {
        var that = this;

        qcloud.request({
            url: config.service.roleUrl,
            login: true,
            success(result) {
                that.setData({
                    cores: result.data.data
                })
            },

            fail(error) {
                util.showModel('查询过期', '请转到“我的”页面下拉刷新')
            }
        })
    }

});