<template>
    <dev-article>
        <Row :gutter="16">
            <i-col span="6">
                <Card title="采集总数">
                    <!--数据采集完毕的数据 confirmed-->
                    <Tag color="green" slot="extra">数</Tag>
                    <Row class="data-collect hidden-nowrap">{{ count.collect.num }}%</Row>
                    <Divider size="small" dashed></Divider>
                    <Row class="hidden-nowrap">剩余总数 {{ count.collect.not }}</Row>
                </Card>
            </i-col>
            <i-col span="6">
                <Card title="税率测算">
                    <Tooltip content="税率测算说明" slot="extra" placement="top" transfer>
                        <Icon type="ios-alert-outline" size="18"/>
                    </Tooltip>
                    <Row class="data-collect hidden-nowrap">{{ count.count.num }}%</Row>
                    <Divider size="small" dashed></Divider>
                    <Progress status="success" :percent="count.count.num" hide-info></Progress>
                </Card>
            </i-col>
            <i-col span="6">
                <Card title="协作成果">
                    <Tooltip content="协作成果说明" slot="extra" placement="top" transfer>
                        <Icon type="ios-alert-outline" size="18"/>
                    </Tooltip>
                    <Row class="data-collect hidden-nowrap">{{ count.result.num }}%</Row>
                    <Divider size="small" dashed></Divider>
                    <Progress status="wrong" :percent="count.result.num" hide-info></Progress>
                </Card>
            </i-col>
            <i-col span="6">
                <Card title="快捷操作">
                    <Row class="data-collect hidden-nowrap align-center margin-bottom22">添加采集数据</Row>
                    <Button type="primary" icon="ios-add" @click="formAdd=true" long>添加</Button>
                </Card>
            </i-col>
        </Row>
        <Row class="margin-top16">
            <Card>
                <Tabs value="table">
                    <TabPane label="数据列表" name="table">
                        <Table
                            :columns="cols"
                            :data="datas"
                            :loading="tableLoading"
                            ref="selection"
                            size="small"
                            border stripe>
                        </Table>
                        <Row class="margin-top16">
                            <i-col span="12" class="hidden-nowrap align-left">
                                <Button type="primary" @click="updateCount">提交测算</Button>
                                <Button type="error" class="margin-left16" @click="delRecord">删除记录</Button>
                                <Icon type="md-arrow-round-down" title="数据下载" class="margin-left32" size="24" @click="downLoad" />
                            </i-col>
                            <i-col span="12" class="hidden-nowrap align-right">
                                <Page :total="datas.length" show-sizer transfer/>
                            </i-col>
                        </Row>
                    </TabPane>
                    <!--表头附加相关操作：-->
                    <template slot="extra">
                        <Row class="hidden-nowrap">
                            <RadioGroup v-model="dateType" @on-change="dateTypeChange">
                                <Radio label="day">今日</Radio>
                                <Radio label="week">周</Radio>
                                <Radio label="month">月</Radio>
                                <Radio label="year">年</Radio>
                            </RadioGroup>
                            <DatePicker
                                v-model="countDate"
                                type="daterange"
                                style="width: 180px"
                                @on-change="dateChange"
                                transfer>
                            </DatePicker>
                            <Button class="margin-left8" type="primary" @click="countDateClick">查询</Button>
                        </Row>
                    </template>
                </Tabs>
            </Card>
        </Row>
        <Modal
            title="数据采集"
            v-model="formAdd"
            :mask-closable="false"
            :loading="formLoading"
            @on-ok="formOk"
            @on-cancel="formCancel"
        >
            <Form label-position="top">
                <FormItem label="姓名">
                    <Input v-model="form.name" placeholder="输入学生姓名，2-4个中文字符"/>
                </FormItem>
                <FormItem label="性别">
                    <i-col></i-col>
                    <Input v-model="form.sex"/>
                </FormItem>
                <FormItem label="身份证号">
                    <Input v-model="form.idc"/>
                </FormItem>
                <FormItem label="父亲姓名">
                    <Input v-model="form.father_name"/>
                </FormItem>
                <FormItem label="母亲姓名">
                    <Input v-model="form.mother_name"/>
                </FormItem>
            </Form>
        </Modal>
    </dev-article>
</template>

<script>
    export default {
        name: "Data",
        data() {
            return {
                count: {
                    collect: {num: 30, not: 20},
                    count: {num: 60, not: 10},
                    result: {num: 90, not: 20}
                },
                formAdd: false,
                dateType: 'day',
                countDate: [new Date(), new Date()],     // 统计日期，默认：今日
                tableAllSelected: false,   // 全选状态
                tableLoading: true,  // 表格数据加载中
                formLoading: true,  // 表单加载中
                form: {
                    name: '',
                    sex: '',
                    idc: '',
                    father_name: '',
                    mother_name: '',
                },
                cols: [
                    {
                        width: 50,
                        type: 'selection',
                        align: 'center',
                    },
                    {
                        width: 50,
                        type: 'index',
                        align: 'center',
                    },
                    {
                        title: '名称',
                        key: 'name',
                    },
                    {
                        title: '测试',
                        key: 'value'
                    }
                ],
                datas: [
                    {
                        name: '第一行',
                        value: '数据是什么东西'
                    },
                    {
                        name: '第二行',
                        value: '数据是什么东西'
                    },
                    {
                        name: '第三行',
                        value: '数据是什么东西'
                    },
                    {
                        name: '第二行',
                        value: '数据是什么东西'
                    },
                ]
            }
        },
        methods: {
            countDateClick() {
                this.$Message.success('test！');
                window.console.log(this.countDate)
            },
            dateChange() {
                this.dateType = ''
                // 自定义日期列表，清除radio选项
            },
            dateTypeChange(val) {
                const today = (new Date()).getTime();
                let date;
                switch (val) {
                    case 'day':
                        date = today;
                        break;
                    case 'week':
                        date = today - 86400000 * 7;
                        break;
                    case 'month':
                        date = today - 86400000 * 30;
                        break;
                    case 'year':
                        date = today - 86400000 * 365;
                        break;
                }
                this.countDate = [new Date(date), new Date(today)]
            },
            formOk() {
                this.formLoading = false;
                this.formAdd = false;
                this.$Message.success('表单数据添加成功！');
            },
            formCancel() {
                this.$Message.warning('表单添加取消！');
            },
            updateCount() {

            },
            delRecord() {

            },
            downLoad() {
                this.$refs.selection.exportCsv({
                    filename: '数据采集'
                });
            },
        },
        created() {
            setTimeout(() => {
                this.tableLoading = false
            }, 3000)
        }
    }
</script>

<style scoped>
    .data-collect {
        font-size: 24px;
        font-weight: bold;
    }

    .ivu-divider-horizontal {
        margin: 16px 0;
    }
</style>