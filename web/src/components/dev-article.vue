<template>
    <Layout>
        <Header class="header header-height">
            <Row class="">
                <i-col span="4" style="height: 64px; text-align: center;">
                    <img src="../assets/logo.png" alt="" class="logo">
                </i-col>
                <i-col span="20">
                    <Row>
                        <i-col span="21" class="title">
                            <Menu mode="horizontal" :active-name="activeName">
                                <MenuItem name="/vuehome" to="/vuehome" replace>
                                    首页
                                </MenuItem>
                                <MenuItem name="/vueabout" to="/vueabout" replace>
                                    介绍
                                </MenuItem>
                                <MenuItem name="/vuedata" to="/vuedata" replace>
                                    数据采集
                                </MenuItem>
                            </Menu>
                        </i-col>
                        <i-col span="3">
                            <Row>
                                <i-col span="12">
                                    <Dropdown @on-click="downMenuClick">
                                        <Avatar :src="userHead"/>
                                        <DropdownMenu slot="list">
                                            <DropdownItem name="set">
                                                设置
                                                <Badge status="error"></Badge>
                                            </DropdownItem>
                                            <DropdownItem name="logout" divided>退出登录</DropdownItem>
                                        </DropdownMenu>
                                    </Dropdown>
                                </i-col>
                                <i-col span="12">
                                    <Badge :count="count" :offset="[20,4]">
                                        <Icon type="md-notifications-outline" size="24"/>
                                    </Badge>
                                </i-col>
                            </Row>
                        </i-col>
                    </Row>
                </i-col>
            </Row>
        </Header>
        <Layout>
            <Sider
                    class="sider"
                    v-model="isCollaped"
                    :width="leftWidth"
                    :class="{'sider-hide': isCollaped}"
                    @on-collapse="siderCollapse"
                    collapsible
            >
                <Menu
                        class="sider-menu"
                        theme="dark"
                        :width="leftWidth"
                        :active-name="activeName"
                >
                    <MenuGroup v-for="menu in menus" :title="menu.title" :key="menu.title">
                        <MenuItem v-for="item in menu.items" :name="item.name" :to="item.to" :key="item.name" replace>
                            <Icon :type="item.icon"/>
                            <span>{{ item.title }}</span>
                        </MenuItem>
                    </MenuGroup>
                </Menu>
            </Sider>
            <Content class="content" :class="{'content-expand': isCollaped}">
                <slot></slot>
            </Content>
        </Layout>
    </Layout>
</template>

<script>
    export default {
        data() {
            return {
                userHead: '',
                activeName: this.$route.path,
                count: 62,
                isCollaped: this.$store.isCollaped,
                menuDark: false,
                leftWidth: '200',
                menus: [
                    {
                        title: '系统设置',
                        items: [
                            {
                                name: '/vuehome',
                                to: '/vuehome',
                                icon: 'md-document',
                                title: '权限分配'
                            },
                            {
                                name: '/vueabout',
                                to: '/vueabout',
                                icon: 'md-chatbubbles',
                                title: '表单设计'
                            },
                        ]
                    },
                    {
                        title: '数据采集',
                        items: [
                            {
                                name: '/vuedata',
                                to: '/vuedata',
                                icon: 'md-calendar',
                                title: '数据列表'
                            },
                        ]
                    },
                    {
                        title: '税费测算',
                        items: [
                            {
                                name: '/vuecount',
                                to: '/vuecount',
                                icon: 'md-analytics',
                                title: '测算列表'
                            },
                        ]
                    },
                    {
                        title: '协作成果',
                        items: [
                            {
                                name: '/vueresult',
                                to: '/vueresult',
                                icon: 'md-barcode',
                                title: '成果列表'
                            },
                        ]
                    },
                ]
            };
        },

        methods: {
            siderCollapse(val) {
                this.$store.isCollaped = val;
            },
            downMenuClick(name) {
                switch (name) {
                    case 'set':

                        break;
                    case 'logout': {
                        this.$Message.info('退出登录');
                        window.location.replace('https://x5on.cn/app/logout');
                        break;
                    }
                }

            }
        },

        created() {
            let that = this;
            // 一、菜单活动页面记录
            this.activeName = this.$route.path;

            // 二、请求微信登录头像
            that.$.all([that.$.gets('/app/user'), that.$.gets('/app/menus')])
                .then(that.$.spread(function (res_head, res_menu) {
                    window.console.log(res_head)
                    window.console.log(res_menu)
                    // 登录头像
                    let imgurl = res_head.headimgurl;
                    that.userHead = imgurl ? imgurl.replace('http://', 'https://') : '';
                    // 菜单数据
                    that.menus = res_menu;
                }))
                .catch(() => {
                    that.$Message.info('网络是否畅通？');
                })
        },
    }
</script>

<style>
    html {
        height: 100%;
    }

    body {
        height: 100%;
        background: #f8f8f9;
    }

    .header {
        width: 100%;
        position: fixed;
        background: #fff;
        box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        padding: 0;
        top: 0;
        left: 0;
        z-index: 2;
    }

    .header-height {
        height: 64px;
    }

    .logo {
        height: 50px;
        position: fixed;
        left: 75px;
        top: 7px;
    }

    .title {
        font-size: 24px;
        white-space: nowrap;
    }

    .header-margin-top {
        margin-top: 8px;
    }

    .ivu-menu-horizontal {
        height: 64px;
        line-height: 64px;
    }

    .ivu-menu-horizontal.ivu-menu-light:after {
        display: none;
    }

    .sider {
        position: fixed;
        height: 100%;
        left: 0;
        overflow: auto;
        z-index: 1;
    }

    .sider-menu {
        margin-top: 64px;
    }

    .sider-hide .ivu-menu-submenu-title span {
        display: none;
    }

    .sider-hide .ivu-menu-item-group-title {
        display: none;
    }

    .sider-hide .ivu-menu-submenu-title-icon {
        display: none;
    }

    .sider-hide .ivu-menu-item span {
        display: none;
    }

    .content {
        margin-left: 200px;
        margin-top: 64px;
        padding: 16px;
        transition: all .2s ease-in-out;
    }

    .content-expand {
        margin-left: 64px;
    }

    .hidden-nowrap {
        overflow: hidden;
        white-space: nowrap;
    }

    .align-left {
        text-align: left;
    }

    .align-right {
        text-align: right;
    }

    .align-center {
        text-align: center;
    }

    .margin-left8 {
        margin-left: 8px;
    }

    .margin-left16 {
        margin-left: 16px;
    }

    .margin-left32 {
        margin-left: 32px;
    }

    .margin-top8 {
        margin-top: 8px;
    }

    .margin-top16 {
        margin-top: 16px;
    }

    .margin-bottom8 {
        margin-bottom: 8px;
    }

    .margin-bottom16 {
        margin-bottom: 16px;
    }

    .margin-bottom22 {
        margin-bottom: 22px;
    }

    .margin-bottom24 {
        margin-bottom: 24px;
    }

    .margin-bottom32 {
        margin-bottom: 32px;
    }
</style>