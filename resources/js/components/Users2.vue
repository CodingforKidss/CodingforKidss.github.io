<template>
    <div>
        <div class = "row" id = "mainSection">
            <div class = "col-md-12">
                <div class = "card">
                    <div class = "card-header">
                        <h4 class = "card-title">{{page.title}}</h4>
                        <p class = "card-category">{{page.subTitle}}</p>
                    </div>
                    <div class = "row ml-1 mr-1">
                        <div class = "col-md-4 paper-form">
                            <div class = "form-group">
                                <input @input = "searchPageItem($event, page.searchType, page.searchText, page.headers)"
                                        class = "form-control"
                                        id = "searchPageItem"
                                        name = "searchPageItem"
                                        :placeholder = "page.searchTitle"
                                        type = "text"
                                        v-model = "page.searchText">
                                <i @click.prevent = "clearSearch()"
                                        class = "far fa-times-circle search-cancel-button"
                                        v-if = "page.searchText && page.searchText.length > 0 && page.searching === false"></i>
                                <i class = "fas fa-spinner fa-pulse search-loading-icon" v-if = "page.searching"></i>
                            </div>
                        </div>
                        <div class = "col-md-8">
                            <div class = "btn-group pull-right" data-toggle = "buttons">
                                <button @click.prevent = "printDiv(page.print, page.print.printType, dataTable['data'])" class = "btn btn-outline-info group-btn-1 btn-12" type = "button">
                                    <i class = "fas fa-print"></i>&nbsp;Print
                                </button>
                                <button @click.prevent = "addModal()" class = "btn btn-outline-danger group-btn-2 btn-12" data-toggle = "modal" type = "button">
                                    <i class = "fas fa-plus"></i>&nbsp;Add New
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class = "table-description" v-if = "$refs.paginator && !page.searchText.length > 0">
                        Showing
                        <span v-if = "dataTable['data'] && dataTable['data'].length > 0"><b>{{$refs.paginator.pageItemsCount}}</b></span>
                        <span v-else><b>0</b></span>
                        results
                    </div>
                    <div class = "table-description" v-if = "page.searchText && page.searchText.length > 0">
                        Search of <b>{{page.searchText}}</b> returned <b>{{dataTable['data'].length}}</b> results.
                    </div>
                    <div class = "card-body">
                        <div class = "table-responsive">
                            <paginate :list = "dataTable['data']" :per = "perPage" name = "items" ref = "paginator" tag = "div">
                                <table class = "table table-striped table-hover">
                                    <thead>
                                    <template v-for = "(item, index) of page.headers">
                                        <th :class = "item.class" :style = "item.style" v-if = "item.title && item.title.length > 0" @click.prevent = "sortTableData(item, dbQuery, page.vuexKey)">
                                            {{item.title}}
                                            <i class = "fas"
                                                    :class = "[dbQuery.sortBy.desc === true ? 'fa-sort-alpha-up-alt' : '', dbQuery.sortBy.desc === false ? 'fa-sort-alpha-down' : '']"
                                                    v-if = "item.field && item.field.length > 0 && dbQuery.sortBy.relation === item.relation && dbQuery.sortBy.field === item.field"></i>
                                        </th>
                                        <!--<th :class = "item.class" :style = "item.style" @click.prevent = "onLoadPageData(ItemGetUrl, dbQuery, item.sortByKey, dbQuery.direction === 'desc' ? dbQuery.direction = 'asc' : dbQuery.direction = 'desc', null)">
                                            {{item.title}}
                                        </th>-->
                                    </template>
                                    </thead>
                                    <tbody>
                                    <tr :key = "index" class = "" v-for = "(item, index) in paginated('items')" v-if = "dataTable && dataTable['data'] && dataTable['data'].length > 0">
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['id']}}</td>
                                        <td @click.prevent = "viewModal(item)">
                                            <img :src = "'/uploads/avatar/' + item['TableViewData']['photo']" onerror = "src='/img/avatar.png'" style = "width: 72px;">
                                        </td>
                                        <td @click.prevent = "viewModal(item)">
                                            {{item['TableViewData']['employee_no']}}
                                        </td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['name']}}</td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['phone']}}</td>
                                        <td @click.prevent = "viewModal(item)">
                                            <span :class = "[item.active == 0 ? 'badge-warning' : 'badge-success']" class = "badge">{{item['TableViewData']['active']}}</span>
                                        </td>
                                        <td class = "text-center">
                                            <div class = "dropdown">
                                                <button class = "btn btn-outline-secondary btn-sm dropdown-toggle"
                                                        data-toggle = "dropdown"
                                                        style = "border: 1px solid #4A4A4A5E !important;"
                                                        type = "button">
                                                    Action
                                                </button>
                                                <div class = "dropdown-menu dropdown-menu-right dropdown-menu-table">
                                                    <button @click.prevent = "viewModal(item)" class = "dropdown-item dropdown-info" type = "button">
                                                        View &nbsp;<i class = "far fa-eye"></i>
                                                    </button>
                                                    <button @click.prevent = "editModal(item)" class = "dropdown-item dropdown-yellow" type = "button">
                                                        Edit &nbsp;<i class = "fas fa-edit"></i>
                                                    </button>
                                                    <button @click.prevent = "removeModal(item)" class = "dropdown-item dropdown-red" type = "button">
                                                        Delete &nbsp;<i class = "far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if = "dataTable && dataTable['data'] && dataTable['data'].length === 0">
                                        <td :colspan = "page.headers.length">
                                            <div style = "text-align: center;">
                                                <div class = "alert alert-info alert-with-icon" v-if = "!page.loading">
                                                    <i class = "fas fa-info-circle"></i>
                                                    <span><b>EMPTY</b> - Table has no data to show.</span>
                                                </div>
                                                <div class = "data-table-spinner" v-if = "page.loading">
                                                    <i class = "fas fa-circle-notch fa-spin"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </paginate>
                            <div class = "container">
                                <div class = "row">
                                    <div class = "col-auto">
                                        <multiselect :allow-empty = "false"
                                                :close-on-select = "true"
                                                :options = "perPageList"
                                                :preselectFirst = "true"
                                                :searchable = "false"
                                                :show-labels = "false"
                                                class = "dropdown multiselect-in-pagination"
                                                id = "perPage"
                                                name = "perPage"
                                                placeholder = "Select Items Per Page"
                                                style = "display: inline-block; width: 90px;"
                                                v-model = "perPage"></multiselect>
                                        <span> per page</span>
                                    </div>
                                    <div class = "col">
                                        <paginate-links :limit = "2"
                                                :show-step-links = "true"
                                                class = "pagination custom-pagination"
                                                for = "items"
                                                :async = "true"
                                                @change = "onPageChange"></paginate-links>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    const {required, email, minLength, maxLength, minValue, maxValue, numeric, decimal} = require('vuelidate/lib/validators');
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';
    import ModalDelete from './modals/ModalDelete.vue'

    export default {
        mixins: [FormMixin],

        data() {
            class Errors {
                /**
                 * Create a new Errors instance.
                 */
                constructor() {
                    this.errors = {};
                }

                /**
                 * Determine if an errors exists for the given field.
                 *
                 * @param {string} field
                 */
                has(field) {
                    return this.errors.hasOwnProperty(field);
                }

                /**
                 * Determine if we have any errors.
                 */
                any() {
                    return Object.keys(this.errors).length > 0;
                }

                /**
                 * Retrieve the error message for a field.
                 *
                 * @param {string} field
                 */
                get(field) {
                    if (this.errors[field]) {
                        return this.errors[field][0];
                    }
                }

                /**
                 * Record the new errors.
                 *
                 * @param {object} errors
                 */
                record(errors) {
                    this.errors = errors;
                }

                /**
                 * Clear one or all error fields.
                 *
                 * @param {string|null} field
                 */
                clear(field) {
                    if (field) {
                        delete this.errors[field];
                        return;
                    }
                    this.errors = {};
                }
            }

            class Form {
                /**
                 * Create a new Form instance.
                 *
                 * @param {object} data
                 */
                constructor(data) {
                    this.originalData = data;
                    for (let field in data) {
                        this[field] = data[field];
                    }
                    this.errors = new Errors();
                }

                /**
                 * Fetch all relevant data for the form.
                 */
                data() {
                    let data = {};
                    for (let property in this.originalData) {
                        data[property] = this[property];
                    }
                    return data;
                }

                hasData() {
                    for (let property in this.originalData) {
                        if (this[property] && this[property].length > 0) {
                            return true;
                        }
                    }
                    return false;
                }

                setData(newData) {
                    for (let field in newData) {
                        this[field] = newData[field];
                        console.log('setData: ', field, ' : ', this[field]);
                    }
                    this.errors.clear();
                }

                /**
                 * Reset the form fields.
                 */
                reset() {
                    for (let field in this.originalData) {
                        if (this.originalData[field] && this.originalData[field].constructor == Object) {
                            for (let field2 in this[field]) {
                                this[field][field2] = this.originalData[field][field2];
                            }
                        } else {
                            this[field] = this.originalData[field];
                        }
                    }
                    this.errors.clear();
                }

                /**
                 * Send a POST request to the given URL.
                 * .
                 * @param {string} url
                 */
                post(url) {
                    return this.submit('post', url);
                }

                /**
                 * Send a PUT request to the given URL.
                 * .
                 * @param {string} url
                 */
                put(url) {
                    return this.submit('put', url);
                }

                /**
                 * Send a PATCH request to the given URL.
                 * .
                 * @param {string} url
                 */
                patch(url) {
                    return this.submit('patch', url);
                }

                /**
                 * Send a DELETE request to the given URL.
                 * .
                 * @param {string} url
                 */
                delete(url) {
                    return this.submit('delete', url);
                }

                /**
                 * Submit the form.
                 *
                 * @param {string} requestType
                 * @param {string} url
                 */
                submit(requestType, url) {
                    return new Promise((resolve, reject) => {
                        axios[requestType](url, this.data())
                            .then(response => {
                                this.onSuccess(response.data);
                                resolve(response.data);
                            })
                            .catch(error => {
                                this.onFail(error.response.data);
                                reject(error.response.data);
                            });
                    });
                }

                /**
                 * Handle a successful form submission.
                 *
                 * @param {object} data
                 */
                onSuccess(data) {
                    alert(data.message); // temporary
                    this.reset();
                }

                /**
                 * Handle a failed form submission.
                 *
                 * @param {object} errors
                 */
                onFail(errors) {
                    this.errors.record(errors);
                }
            }

            return {
                page     : {
                    title      : 'Students',
                    subTitle   : 'List and manage Student',
                    vuexKey    : 'students',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    print      : {
                        title     : 'Students',
                        subTitle  : 'List of Students',
                        footer    : 'Copyright.',
                        time      : true,
                        printType : 'dataTable', // dataTable = DataTable Loop, divId = sectionId.
                        printDivId: 'mainSection',
                        format    : 'pdf',
                        pageSize  : 'A4',
                        layout    : 'Portrait',
                        margin    : '10px 10px 10px 10px',
                        class     : '',
                        headers   : ['Id', 'Student Number', 'Name', 'Phone', 'Status'],
                        fields    : ['id', 'employee_no', 'name', 'phone', 'active'],
                    },
                    headers    : [
                        {
                            title   : 'Id',
                            relation: false, // false or 'string'
                            field   : 'id',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : 'min-width: 50px;',
                        },
                        {
                            title   : 'Photo',
                            relation: false, // false or 'string'
                            field   : '',
                            operator: '',
                            sortType: '', // js, jsText or db
                            click   : '',
                            class   : '',
                            style   : 'width: 80px;',
                        },
                        {
                            title   : 'Student Number',
                            relation: false, // false or 'string'
                            field   : 'employee_no',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Name',
                            relation: false, // false or 'string'
                            field   : 'name',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Phone',
                            relation: false, // false or 'string'
                            field   : 'phone',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Status',
                            relation: false, // false or 'string'
                            field   : 'active',
                            operator: 'like',
                            sortType: 'jsText', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : 'width: 90px;',
                        },
                        {
                            title   : 'Action',
                            relation: false, // false or 'string'
                            field   : '',
                            operator: '',
                            sortType: '', // js, jsText or db
                            click   : '',
                            class   : 'text-center',
                            style   : 'width: 120px;',
                        },
                    ],
                },
                paginate : ['items'],
                dataForm : {},
                modalAdd : {},
                modalEdit: {},
                dbInputs : [],
                dbQuery  : {
                    table     : 'User',
                    tableWith : [
                        'nationality',
                        'country',
                        'emergency_country',
                    ],
                    matchThese: [
                        [
                            'role_id',
                            '=',
                            3
                        ],
                    ],
                    orThose   : [],
                    where     : [],
                    orWhere   : [],
                    search    : {
                        text  : '',
                        fields: [],
                    },
                    select    : {
                        'id'                  : 'id',
                        'name'                : 'name',
                        'email'               : 'email',
                        'date_of_birth'       : 'date_of_birth',
                        'gender'              : 'gender',
                        'religion'            : 'religion',
                        'blood_group'         : 'blood_group',
                        'marital_status'      : 'marital_status',
                        'nationality_id'      : 'nationality_id',
                        'passport_no'         : 'passport_no',
                        'driving_license'     : 'driving_license',
                        'employee_no'         : 'employee_no',
                        'nid'                 : 'nid',
                        'address'             : 'address',
                        'city_id'             : 'city_id',
                        'post_code'           : 'post_code',
                        'country_id'          : 'country_id',
                        'phone'               : 'phone',
                        'emergency_name'      : 'emergency_name',
                        'emergency_address'   : 'emergency_address',
                        'emergency_city_id'   : 'emergency_city_id',
                        'emergency_post_code' : 'emergency_post_code',
                        'emergency_country_id': 'emergency_country_id',
                        'emergency_phone'     : 'emergency_phone',
                        'photo'               : 'photo',
                        'description'         : 'description',
                        'active'              : 'active',
                    },
                    sortBy    : {
                        relation: false, // false or relation name
                        field   : 'id',
                        desc    : true
                    },
                    // orderBy   : 'id',
                    // direction : 'desc',
                    pluck     : {
                        'id'                  : 'id',
                        'name'                : 'name',
                        'email'               : 'email',
                        'date_of_birth'       : 'date_of_birth',
                        'gender'              : 'gender',
                        'religion'            : 'religion',
                        'blood_group'         : 'blood_group',
                        'marital_status'      : 'marital_status',
                        'nationality_id'      : 'nationality_id',
                        'passport_no'         : 'passport_no',
                        'driving_license'     : 'driving_license',
                        'employee_no'         : 'employee_no',
                        'nid'                 : 'nid',
                        'address'             : 'address',
                        'city_id'             : 'city_id',
                        'post_code'           : 'post_code',
                        'country_id'          : 'country_id',
                        'phone'               : 'phone',
                        'emergency_name'      : 'emergency_name',
                        'emergency_address'   : 'emergency_address',
                        'emergency_city_id'   : 'emergency_city_id',
                        'emergency_post_code' : 'emergency_post_code',
                        'emergency_country_id': 'emergency_country_id',
                        'emergency_phone'     : 'emergency_phone',
                        'photo'               : 'photo',
                        'description'         : 'description',
                        'active'              : 'active',
                    }
                },
                dbDestroy: {
                    table         : 'User',
                    role          : {
                        active : false,
                        message: 'You do not have permission to perform this action.',
                        roles  : [
                            'ALL'
                        ],
                    },
                    actionType    : 'delete_student',
                    storeInDeletes: true,
                    validations   : {
                        'id': 'required|min:1|max:15', // '*.id' : 'required|min:1|max:15',
                    }
                },
                options  : {},
                option   : {
                    modalAdd : {},
                    modalEdit: {}
                },
                optionSet: {
                    active: [
                        {
                            id  : 1,
                            name: 'Active',
                        },
                        {
                            id  : 0,
                            name: 'Inactive',
                        }
                    ],
                },
            }
        },
        validations: {},
        created() {
            // this.setLayout('layout-dashboard');
            // this.setPushOptions(this.optionSet, null);
            // this.getFormInputs(this.FormInputsAPI, null, this.dbInputs, null, this.optionSet, null);
            this.onLoadPageData(this.ItemGetUrl, this.dbQuery, this.page.vuexKey, 'loading', false, this.modalEdit.formKey);
            console.log('created: ', this.page.title, ': ', this.$route.params);
        },
        mounted() {
        },
        computed   : {
            dataTable() {
                let data = this.$store.getters.dataTable(this.page.vuexKey);
                if (data && data['data'] && data['data'].length > 0) {
                    data['data'].forEach((d, i) => {
                        data['data'][i]['TableViewData'] = {
                            'id'         : d['id'],
                            'photo'      : d['photo'],
                            'employee_no': d['employee_no'],
                            'name'       : d['name'],
                            'address'    : d['address'],
                            'phone'      : d['phone'],
                            'active'     : d['active'] == 1 ? 'Active' : 'Inactive',
                        }
                    });
                }
                console.log('computed: dataTable: ', this.page.vuexKey, data);
                return data;
            },
            emptyArray() {
                return this.dataTable['data'].length == 0
            }
        },
        watch      : {
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
        methods    : {
            viewModal(data) {
                console.log('viewModal: ', data);
                this.$router.push({
                    name  : 'dashboard.student.id',
                    params: {
                        id      : data['id'],
                        data    : data,
                        viewType: 'view',
                    }
                })
            },
            removeModal(data) {
                console.log('removeModal: ', data, this.modalDelete.data, this.modalDelete.tableView);
                this.$modal.show(ModalDelete, {
                    params: {
                        modalDelete  : this.modalDelete,
                        vuexKey      : this.page.vuexKey,
                        ItemRemoveUrl: this.ItemRemoveUrl, // TODO: Remove this.
                        dbQuery      : this.dbQuery,
                        dbDestroy    : this.dbDestroy,
                    }
                }, {
                    adaptive    : this.modalDelete.options.adaptive,
                    clickToClose: this.modalDelete.options.clickToClose,
                    name        : this.modalDelete.options.name,
                    class       : this.modalDelete.options.class,
                    style       : this.modalDelete.options.style,
                    draggable   : false,
                    scrollable  : this.modalDelete.options.scrollable,
                    transition  : this.modalDelete.options.transition,
                    height      : this.modalDelete.options.height,
                }, {
                    'before-open' : (event) => {
                        console.log('beforeOpen: ', event);
                        this.modalDelete.data = null;
                        this.modalDelete.tableView = null;
                        //this.modalDelete.isSubmitting       = false;
                        //this.modalDelete.statusDiv.class    = 'alert-json-error';
                        this.modalDelete.statusDiv.messages = [];
                        this.modalDelete.data = data;
                        this.modalDelete.tableView = this.generateModalView(this.modalDelete.data);
                        this.modalDelete.header.text = 'Delete ' + this.page.title;
                    },
                    'opened'      : (event) => {
                        console.log('opened: ', event);
                    },
                    'before-close': (event) => {
                        console.log('beforeClose: ', event);
                    },
                    'closed'      : (event) => {
                        console.log('closed: ', event);
                    },
                })
            },
            addModal() {
                console.log('addModal: ');
                this.$router.push({
                    name  : 'dashboard.student.id',
                    params: {
                        id      : 0,
                        data    : null,
                        viewType: 'add',
                    }
                })
            },
            editModal(data) {
                console.log('editModal: ', data);
                this.$router.push({
                    name  : 'dashboard.student.id',
                    params: {
                        id      : data['id'],
                        data    : data,
                        viewType: 'edit',
                    }
                })
            },
            // generateModalView
            generateModalView(modalData) {
                console.log('generateModalView: ', modalData);
                let tableTRData = [
                    [
                        {
                            data : 'Id',
                            class: '',
                            style: 'width: 200px;',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.id,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Student Number',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.employee_no,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Name',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.name,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Status',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : '<span class="badge ' + (modalData.active == 0 ? 'badge-warning' : 'badge-success') + '"> ' + (modalData.active == 0 ? 'Inactive' : 'Active') + '</span>',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                ];
                let tableTRView = '';
                for (let i in tableTRData) {
                    if (tableTRData.hasOwnProperty(i)) {
                        tableTRView += `<tr>`;
                        for (let key in tableTRData[i]) {
                            if (tableTRData[i].hasOwnProperty(key)) {
                                tableTRView += `
                                    <td class = "` + tableTRData[i][key].class + `" style = "` + tableTRData[i][key].style + `" scope="` + tableTRData[i][key].scope + `" colspan="` + tableTRData[i][key].span + `">` + tableTRData[i][key].data + `</td>
                                    `;
                            }
                        }
                        tableTRView += `</tr>`;
                    }
                }
                return `<table class="table table-bordered table-striped">
                            <tbody>
                                ` + tableTRView + `
                            </tbody>
                        </table>`;
            }
        }
    }
</script>
