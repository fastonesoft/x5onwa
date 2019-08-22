<template>
    <dev-article>
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
                            <Button type="primary" :loading="isPrint" @click="studPrint">打印</Button>

                        </i-col>
                        <i-col span="12" class="hidden-nowrap align-right">
                            <Page :total="datas.length" :page-size="50" :page-size-opts="[50,100]" show-sizer transfer/>
                        </i-col>
                    </Row>
                </TabPane>
                <!--表头附加相关操作：-->
                <template slot="extra">
                    <Row class="hidden-nowrap">
                        <Select v-model="grade_id" placeholder="年级选择..." style="width:100px" transfer>
                            <Option
                                v-for="item in gradeList"
                                :value="item.grade_id"
                                :key="item.grade_id">{{ item.grade_name }}
                            </Option>
                        </Select>
                        <Select v-model="cls_id" placeholder="班级选择..." style="width:130px; margin-left: 8px;" transfer>
                            <Option
                                v-for="item in clsList"
                                :value="item.cls_id"
                                :key="item.cls_id">{{ item.cls_name }}
                            </Option>
                        </Select>
                    </Row>
                </template>
            </Tabs>

        </Card>
    </dev-article>
</template>

<script>
    export default {
        name: "Myadjust",
        data() {
            return {
                isPrint: false,
                tableLoading: false,
                form: {
                    stud_name: '',
                },
                cls_id: '',
                clsList: [
                    {
                        cls_id: 'a1',
                        cls_name: '九年级（1）班'
                    },
                    {
                        cls_id: 'a2',
                        cls_name: '九年级（2）班'
                    },
                    {
                        cls_id: 'a3',
                        cls_name: '九年级（3）班'
                    },
                    {
                        cls_id: 'a4',
                        cls_name: '九年级（4）班'
                    },
                    {
                        cls_id: 'a5',
                        cls_name: '九年级（5）班'
                    },
                    {
                        cls_id: 'a6',
                        cls_name: '九年级（6）班'
                    },
                    {
                        cls_id: 'a7',
                        cls_name: '九年级（7）班'
                    },
                    {
                        cls_id: 'a8',
                        cls_name: '九年级（8）班'
                    },
                    {
                        cls_id: 'a9',
                        cls_name: '九年级（9）班'
                    },
                    {
                        cls_id: 'a10',
                        cls_name: '九年级（10）班'
                    },
                    {
                        cls_id: 'a11',
                        cls_name: '九年级（11）班'
                    },
                    {
                        cls_id: 'a12',
                        cls_name: '九年级（12）班'
                    },
                ],
                grade_id: '',
                gradeList: [
                    {
                        grade_id: 'g1',
                        grade_name: '七年级'
                    },
                    {
                        grade_id: 'g2',
                        grade_name: '八年级'
                    },
                    {
                        grade_id: 'g3',
                        grade_name: '九年级'
                    },
                ],
                cols: [
                    {
                        width: 50,
                        type: 'index',
                        align: 'center',
                    },
                    {
                        title: '原班级',
                        key: 'cls_name_old'
                    },
                    {
                        title: '姓名',
                        key: 'stud_name',
                    },
                    {
                        title: '性别',
                        key: 'stud_sex'
                    },
                    {
                        title: '现班级',
                        key: 'cls_name'
                    },
                ],
                datas: [
                    {
                        cls_name: '九年级（1）班',
                        stud_name: '陈可毅',
                        stud_sex: '男',
                        cls_name_old: '八年级（1）班',
                    },
                    {
                        cls_name: '九年级（1）班',
                        stud_name: '石彧诚',
                        stud_sex: '男',
                        cls_name_old: '八年级（2）班',
                    },
                ]
            }
        },
        methods: {
            studPrint() {
                if (this.isPrint) return;

                if (this.grade_id === '') {
                    this.$Message.error('请选择对应年级');
                    return;
                }

                this.isPrint = true;
            },

        }

    }
</script>

<style scoped>
    .formline {
        display: inline;
        width: 400px;
    }

    .formline >>> .ivu-form-item-label {
        display: none;
    }

</style>