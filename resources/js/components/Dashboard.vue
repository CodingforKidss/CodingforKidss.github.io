<template>
    <div>
        <div class = "row" id = "mainSection">
            <template v-if = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Admin')">
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "far fa-address-card text-primary"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Total Students</p>
                                        <p>{{dataTable['data']['user_count']}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "fas fa-border-all"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "far fa-address-card text-secondary"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Total Parents</p>
                                        <p>{{dataTable['data']['donor_count']}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "far fa-calendar-alt"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "far fa-times-circle text-danger"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Total Course</p>
                                        <p>{{dataTable['data']['food_count']}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "far fa-calendar-alt"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "fas fa-suitcase-rolling text-success"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Enrolment Total</p>
                                        <p>{{dataTable['data']['enrolment_count']}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "far fa-calendar-alt"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-if = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Parent')">
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "far fa-address-card text-primary"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Student Name</p>
                                        <p>{{dataTable['data']['student'] ? dataTable['data']['student']['name'] : '-'}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "fas fa-border-all"></i>
                                As Parent
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "far fa-address-card text-secondary"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Total Enrolements</p>
                                        <p>{{dataTable['data']['student_enrolment_count']}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "far fa-calendar-alt"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "far fa-times-circle text-danger"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Total Course</p>
                                        <p>{{dataTable['data']['food_count']}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "far fa-calendar-alt"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "fas fa-suitcase-rolling text-success"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Student Total</p>
                                        <p>{{dataTable['data']['user_count']}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "far fa-calendar-alt"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "fas fa-suitcase-rolling text-success"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Last Login</p>
                                        <p>{{dataTable['data']['student'] && dataTable['data']['student']['login_sessions'] ? dataTable['data']['student']['login_sessions'][dataTable['data']['student']['login_sessions'].length - 1]['time_login'] : '-'}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "far fa-calendar-alt"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-body ">
                            <div class = "row">
                                <div class = "col-5 col-md-4">
                                    <div class = "icon-big text-center icon-warning">
                                        <i class = "fas fa-suitcase-rolling text-success"></i>
                                    </div>
                                </div>
                                <div class = "col-7 col-md-8">
                                    <div class = "numbers">
                                        <p class = "card-category">Last Logout</p>
                                        <p>{{dataTable['data']['student'] && dataTable['data']['student']['login_sessions'] ? dataTable['data']['student']['login_sessions'][dataTable['data']['student']['login_sessions'].length - 1]['time_logout'] : '-'}}</p>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card-footer ">
                            <hr>
                            <div class = "stats">
                                <i class = "far fa-calendar-alt"></i>
                                Overall
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';
    import moment from 'moment';

    export default {
        mixins: [FormMixin],
        data() {
            return {
                page    : {
                    title      : 'Dashboard',
                    subTitle   : 'View Various Data',
                    vuexKey    : 'dashboard',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    ItemGetUrl : '/api/v1/auth/dashboard-info',
                },
                paginate: ['items'],
            }
        },

        created() {
            // this.setLayout('layout-dashboard');
            this.onLoadPageData(this.page.ItemGetUrl, null, this.page.vuexKey, 'loading', false, null);
            console.log('created: ', this.page.title, ': ', this.$route.params, this.timer);
        },
        mounted() {
        },
        computed: {
            dataTable() {
                let data = this.$store.getters.dataTable(this.page.vuexKey);
                if (data && data['data'] && data['data'].length > 0) {
                    data['data'].forEach((d, i) => {
                        data['data'][i] = {
                            'id': d['id'],
                        }
                    });
                }
                console.log('computed: dataTable: ', this.page.vuexKey, data);
                return data;
            },
            user() {
                let data = this.$store.getters.user;
                console.log('computed: user: ', data);
                return data;
            },
            emptyArray() {
                return this.dataTable['data'].length == 0
            }
        },
        watch   : {
            emptyArray(newVal, oldVal) {
                console.log('watch: emptyArray: ');
                if (newVal === false && oldVal === true) {
                    setTimeout(() => {
                        if (this.$refs.paginator) {
                            this.$refs.paginator.goToPage(1)
                        }
                    }, 100)
                }
            }
        },
        methods : {
            updateTime() {
            },
        }
    }
</script>
