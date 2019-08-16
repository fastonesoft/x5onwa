module.exports = {
    publicPath: '/',
    devServer: {
        proxy: {
            '': {
                target: 'https://x5on.cn',
                changeOrigin: true,
                pathRewrite: {}
            }
        },
    }
}

