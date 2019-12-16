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
                                       class = "form-control" id = "searchPageItem"
                                       name = "searchPageItem" :placeholder = "page.searchTitle" type = "text"
                                       v-model = "page.searchText">
                                <i @click.prevent = "clearSearch()" class = "far fa-times-circle search-cancel-button"
                                   v-if = "page.searchText && page.searchText.length > 0 && page.searching === false"></i>
                                <i class = "fas fa-spinner fa-pulse search-loading-icon" v-if = "page.searching"></i>
                            </div>
                        </div>
                        <div class = "col-md-8">
                            <div class = "btn-group pull-right" data-toggle = "buttons">
                                <button @click.prevent = "printDiv(page.print, page.print.printType, dataTable['data'])"
                                        class = "btn btn-outline-info group-btn-1 btn-12" type = "button">
                                    <i class = "fas fa-print"></i>&nbsp;Print
                                </button>
                                <button @click.prevent = "addModal()"
                                        class = "btn btn-outline-danger group-btn-2 btn-12" data-toggle = "modal"
                                        type = "button">
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
                            <paginate :list = "dataTable['data']" :per = "perPage" name = "items" ref = "paginator"
                                      tag = "div">
                                <table class = "table table-striped table-hover">
                                    <thead>
                                    <template v-for = "(item, index) of page.headers">
                                        <th :class = "item.class" :style = "item.style"
                                            v-if = "item.title && item.title.length > 0"
                                            @click.prevent = "sortTableData(item, dbQuery, page.vuexKey)">
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
                                    <tr :key = "index" class = "" v-for = "(item, index) in paginated('items')"
                                        v-if = "dataTable && dataTable['data'] && dataTable['data'].length > 0">
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['id']}}</td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['user']}}
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['date_from']}}
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['date_to']}}
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['total_amount']}}
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['amount']}}
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['due']}}
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['date']}}
                                        <td @click.prevent = "viewModal(item)">
                                            {{item['TableViewData']['payment_method']}}
                                        <td @click.prevent = "viewModal(item)">
                                            {{item['TableViewData']['payment_status']}}
                                        <td @click.prevent = "viewModal(item)">
                                            <span :class = "[item.active == 0 ? 'badge-warning' : 'badge-success']"
                                                  class = "badge">{{item['TableViewData']['active']}}</span>
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
                                                    <button @click.prevent = "viewModal(item)"
                                                            class = "dropdown-item dropdown-info" type = "button">
                                                        View &nbsp;<i class = "far fa-eye"></i>
                                                    </button>
                                                    <button @click.prevent = "editModal(item)"
                                                            class = "dropdown-item dropdown-yellow" type = "button">
                                                        Edit &nbsp;<i class = "fas fa-edit"></i>
                                                    </button>
                                                    <button @click.prevent = "removeModal(item)"
                                                            class = "dropdown-item dropdown-red" type = "button">
                                                        Delete &nbsp;<i class = "far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if = "dataTable && dataTable['data'] && dataTable['data'].length === 0">
                                        <td :colspan = "page.headers.length">
                                            <div style = "text-align: center;">
                                                <div class = "alert alert-info alert-with-icon"
                                                     v-if = "!page.loading">
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
                                        <multiselect :allow-empty = "false" :close-on-select = "true"
                                                     :options = "perPageList" :preselectFirst = "true"
                                                     :searchable = "false" :show-labels = "false"
                                                     class = "dropdown multiselect-in-pagination" id = "perPage"
                                                     name = "perPage" placeholder = "Select Items Per Page"
                                                     style = "display: inline-block; width: 90px;"
                                                     v-model = "perPage"></multiselect>
                                        <span> per page</span>
                                    </div>
                                    <div class = "col">
                                        <paginate-links :limit = "2" :show-step-links = "true"
                                                        class = "pagination custom-pagination"
                                                        for = "items" :async = "true"
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
    import ModalEdit from './modals/ModalEdit.vue'
    import ModalAdd from './modals/ModalAdd.vue'
    import ModalView from './modals/ModalView.vue'
    import ModalDelete from './modals/ModalDelete.vue'

    export default {
        mixins     : [FormMixin],
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
                    title      : 'Salaries',
                    subTitle   : 'List and manage Salary',
                    vuexKey    : 'salaries',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    print      : {
                        title     : 'Salaries',
                        subTitle  : 'List of Salaries',
                        footer    : 'Copyright.',
                        time      : true,
                        printType : 'dataTable', // dataTable = DataTable Loop, divId = sectionId.
                        printDivId: 'mainSection',
                        format    : 'pdf',
                        pageSize  : 'A4',
                        layout    : 'Portrait',
                        margin    : '10px 10px 10px 10px',
                        class     : '',
                        headers   : ['Id', 'Employee\'s Name', 'Date', 'Type', 'Shift', 'Time In', 'Time Out', 'Work Duration', 'Late', 'Over Time', 'Attendance', 'Status'],
                        fields    : ['id', 'user', 'date', 'workday_type', 'shift', 'time_in', 'time_out', 'work_duration', 'late', 'overtime', 'attendance_status', 'active'],
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
                            title   : 'Emp Name',
                            relation: 'user', // false or 'string'
                            field   : 'name',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Date From',
                            relation: false, // false or 'string'
                            field   : 'date_from',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Date To',
                            relation: false, // false or 'string'
                            field   : 'date_to',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Total',
                            relation: false, // false or 'string'
                            field   : 'total_amount',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Paid',
                            relation: false, // false or 'string'
                            field   : 'amount',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Due',
                            relation: false, // false or 'string'
                            field   : 'due',
                            operator: '', // skip it for not searching using db or js. use jsText for searching and sorting.
                            sortType: 'jsText', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Payment Date',
                            relation: false, // false or 'string'
                            field   : 'date',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Payment Method',
                            relation: 'payment_method', // false or 'string'
                            field   : 'name',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Payment Status',
                            relation: 'payment_status', // false or 'string'
                            field   : 'name',
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
                dataForm : {
                    id               : 0,
                    user_id          : null,
                    total_amount     : null,
                    amount           : null,
                    date_from        : null,
                    date_to          : null,
                    date             : null,
                    payment_method_id: null,
                    payment_status_id: null,
                    reference_no     : null,
                    description      : null,
                    active           : null,
                },
                modalAdd : {
                    options     : {
                        name        : 'ModalAdd',
                        class       : 'modal-custom',
                        style       : '',
                        height      : 'auto',
                        transition  : 'pop-out',
                        scrollable  : true,
                        adaptive    : false,
                        clickToClose: true,
                        beforeOpen  : {},
                        opened      : {},
                        beforeClose : {},
                        closed      : {},
                    },
                    header      : {
                        text      : 'Add New Salary',
                        subHeader : 'subHeader',
                        icon      : '<i class="far fa-plus-square"></i>',
                        colorClass: 'modal-header-blue',
                        closeData : 'modal-header-blue',
                    },
                    statusDiv   : {
                        show    : true,
                        class   : 'alert-json-error',
                        style   : '',
                        messages: [],
                    },
                    isSubmitting: false,
                    form        : new Form({
                        id               : 0,
                        user_id          : null,
                        total_amount     : null,
                        amount           : null,
                        date_from        : this.getCurrentDate('YYYY-MM-DD'),
                        date_to          : this.getCurrentDate('YYYY-MM-DD'),
                        date             : this.getCurrentDate('YYYY-MM-DD'),
                        payment_method_id: null,
                        payment_status_id: null,
                        reference_no     : null,
                        description      : null,
                        photo            : null,
                        api_ver          : '1.0',
                        app_ver          : '1.0.0',
                        app_build_ver    : 1,
                    }),
                    validations : {
                        user_id          : {
                            required,
                        },
                        total_amount     : {
                            required,
                            decimal,
                            minValue: minValue(0),
                            maxValue: maxValue(1000000000),
                        },
                        amount           : {
                            required,
                            decimal,
                            minValue: minValue(0),
                            maxValue: maxValue(1000000000),
                        },
                        date_from        : {
                            required,
                        },
                        date_to          : {
                            required,
                        },
                        date             : {
                            required
                        },
                        payment_method_id: {
                            required,
                        },
                        payment_status_id: {
                            required
                        },
                        reference_no     : {},
                        description      : {},
                        photo            : {}
                    },
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalAdd',
                    inputs      : {
                        user_id          : {
                            label          : {
                                show : true,
                                text : 'Employee',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'select',
                            multiSelect    : {
                                inputClass    : 'form-control multiselect-in-modal',
                                inputStyle    : '',
                                allowEmpty    : true,
                                searchable    : true,
                                closeOnSelect : true,
                                showLabels    : false,
                                deselectLabel : 'Can\'not remove this value',
                                hideSelected  : false,
                                preselectFirst: false,
                                option_id     : 'user_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Employee',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'user_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Employee', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Employee is Required'
                                    },
                                },
                            },
                        },
                        total_amount     : {
                            label          : {
                                show : true,
                                text : 'Total Salary',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "nc-icon nc-settings"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'text',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'text',
                            placeHolder    : 'Enter Employee Total Salary',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'total_amount',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Total Salary', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Total Salary is Required'
                                    },
                                    minValue: {
                                        value  : 0,
                                        message: 'Min value can not be less than 0'
                                    },
                                    maxValue: {
                                        value  : 1000000000,
                                        message: 'Maximum value can not be more than 1000000000'
                                    },
                                    decimal : {
                                        message: 'Input must be in Number format.'
                                    },
                                },
                            },
                        },
                        amount           : {
                            label          : {
                                show : true,
                                text : 'Amount Paid',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "nc-icon nc-settings"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'text',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'text',
                            placeHolder    : 'Enter Salary Amount Paid',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'amount',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Amount Paid', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Amount Paid is Required'
                                    },
                                    minValue: {
                                        value  : 0,
                                        message: 'Min value can not be less than 0'
                                    },
                                    maxValue: {
                                        value  : 1000000000,
                                        message: 'Maximum value can not be more than 1000000000'
                                    },
                                    decimal : {
                                        message: 'Input must be in Number format.'
                                    },
                                },
                            },
                        },
                        date_from        : {
                            label          : {
                                show : true,
                                text : 'Salary Date From',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'dateTime',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'dateTime',
                            dateTime       : {
                                type          : "date", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
                                size          : "", // large/small/mini
                                inputClass    : 'form-control no-padding',
                                inputStyle    : '',
                                inputDateClass: 'datepicker-custom',
                                inputDateStyle: '',
                                editable      : true,
                                clearable     : true,
                                isRange       : false,
                                arrowControl  : false,
                                align         : 'center', // left/center/right
                                rangeSeparator: '-',
                                pickerOptions : {
                                    /*disabledDate(time) {
                                        return time.getTime() > Date.now();
                                    },
                                    shortcuts: [{
                                        text: 'Today',
                                        onClick(picker) {
                                            picker.$emit('pick', new Date());
                                        }
                                    }, {
                                        text: 'Yesterday',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                                            picker.$emit('pick', date);
                                        }
                                    }, {
                                        text: 'A week ago',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                                            picker.$emit('pick', date);
                                        }
                                    }]*/
                                },
                                displayFormat : 'dd/MM/yyyy',
                                valueFormat   : 'yyyy-MM-dd',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Salary Date From',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date_from',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Salary Date From', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Salary Date From is Required'
                                    },
                                },
                            },
                        },
                        date_to          : {
                            label          : {
                                show : true,
                                text : 'Salary Date To',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'dateTime',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'dateTime',
                            dateTime       : {
                                type          : "date", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
                                size          : "", // large/small/mini
                                inputClass    : 'form-control no-padding',
                                inputStyle    : '',
                                inputDateClass: 'datepicker-custom',
                                inputDateStyle: '',
                                editable      : true,
                                clearable     : true,
                                isRange       : false,
                                arrowControl  : false,
                                align         : 'center', // left/center/right
                                rangeSeparator: '-',
                                pickerOptions : {
                                    /*disabledDate(time) {
                                        return time.getTime() > Date.now();
                                    },
                                    shortcuts: [{
                                        text: 'Today',
                                        onClick(picker) {
                                            picker.$emit('pick', new Date());
                                        }
                                    }, {
                                        text: 'Yesterday',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                                            picker.$emit('pick', date);
                                        }
                                    }, {
                                        text: 'A week ago',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                                            picker.$emit('pick', date);
                                        }
                                    }]*/
                                },
                                displayFormat : 'dd/MM/yyyy',
                                valueFormat   : 'yyyy-MM-dd',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Salary Date To',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date_to',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Salary Date To', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Salary Date To is Required'
                                    },
                                },
                            },
                        },
                        date             : {
                            label          : {
                                show : true,
                                text : 'Salary Payment Date',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'dateTime',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'dateTime',
                            dateTime       : {
                                type          : "date", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
                                size          : "", // large/small/mini
                                inputClass    : 'form-control no-padding',
                                inputStyle    : '',
                                inputDateClass: 'datepicker-custom',
                                inputDateStyle: '',
                                editable      : true,
                                clearable     : true,
                                isRange       : false,
                                arrowControl  : false,
                                align         : 'center', // left/center/right
                                rangeSeparator: '-',
                                pickerOptions : {
                                    /*disabledDate(time) {
                                        return time.getTime() > Date.now();
                                    },
                                    shortcuts: [{
                                        text: 'Today',
                                        onClick(picker) {
                                            picker.$emit('pick', new Date());
                                        }
                                    }, {
                                        text: 'Yesterday',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                                            picker.$emit('pick', date);
                                        }
                                    }, {
                                        text: 'A week ago',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                                            picker.$emit('pick', date);
                                        }
                                    }]*/
                                },
                                displayFormat : 'dd/MM/yyyy',
                                valueFormat   : 'yyyy-MM-dd',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Salary Payment Date',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Salary Payment Date', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Salary Payment Date is Required'
                                    },
                                },
                            },
                        },
                        payment_method_id: {
                            label          : {
                                show : true,
                                text : 'Payment Method',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'select',
                            multiSelect    : {
                                inputClass    : 'form-control multiselect-in-modal',
                                inputStyle    : '',
                                allowEmpty    : true,
                                searchable    : true,
                                closeOnSelect : true,
                                showLabels    : false,
                                deselectLabel : 'Can\'not remove this value',
                                hideSelected  : false,
                                preselectFirst: false,
                                option_id     : 'payment_method_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Payment Method',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'payment_method_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Payment Method', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Payment Method is Required'
                                    },
                                },
                            },
                        },
                        payment_status_id: {
                            label          : {
                                show : true,
                                text : 'Payment Status',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'select',
                            multiSelect    : {
                                inputClass    : 'form-control multiselect-in-modal',
                                inputStyle    : '',
                                allowEmpty    : true,
                                searchable    : true,
                                closeOnSelect : true,
                                showLabels    : false,
                                deselectLabel : 'Can\'not remove this value',
                                hideSelected  : false,
                                preselectFirst: false,
                                option_id     : 'payment_status_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Payment Status',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'payment_status_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Payment Status', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Payment Status is Required'
                                    },
                                },
                            },
                        },
                        reference_no     : {
                            label          : {
                                show : true,
                                text : 'Reference Number',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-clock"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'text',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col-12',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'text',
                            placeHolder    : 'Reference Number',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'reference_no',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Reference Number', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Reference Number is Required'
                                    },
                                },
                            },
                        },
                        description      : {
                            label          : {
                                show : true,
                                text : 'Description',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-clock"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'text',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col-12',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'text',
                            placeHolder    : 'Description',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'description',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Description', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Description is Required'
                                    },
                                },
                            },
                        },
                        photo            : {
                            label          : {
                                show : true,
                                text : 'Payment Photo <i class = "fas fa-camera"></i> ',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : false,
                                text : '<i class = "fas fa-camera"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'image',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col-12',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'file',
                            multiple       : true,
                            image          : {
                                inputClass     : 'picture-div',
                                inputStyle     : '',
                                inputImageClass: 'picture-img-src',
                                inputImageStyle: '',
                                inputLabelClass: 'picture-div-progress',
                                imageServer    : '/uploads/salaries/',
                                imageSrc       : null,
                                onChange       : [
                                    'modalAdd',
                                    'inputs',
                                    'photo',
                                    'image',
                                    'imageSrc'
                                ],
                                clearButton    : {
                                    show : true,
                                    class: 'floating-clear',
                                    style: '',
                                    props: [
                                        'modalAdd',
                                        'form',
                                        'photo',
                                    ],
                                }
                            },
                            placeHolder    : 'Upload Photo',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'photo',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Photo', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Photo is Required'
                                    },
                                },
                            },
                        },
                    },
                    dbInsert    : {
                        table             : 'Salaries',
                        createMany        : false,
                        createManyField   : 'listItems',
                        createManyTable   : 'CustomerPaymentInwardItems',
                        createManyTableId : 'customer_payment_inward_id',
                        createManyRelation: 'items',
                        role              : {
                            active : false,
                            message: 'You do not have permission to perform this action.',
                            roles  : [
                                'ALL'
                            ],
                        },
                        actionType        : 'add_salary',
                        sentAsFormData    : true,
                        fileUploads       : {
                            active: true,
                            strict: true,
                            files : {
                                photo: {
                                    saveAsString: true,
                                    active      : true,
                                    files       : [],
                                    imageSrc    : null,
                                    storeType   : 'update', // create, update
                                    table       : 'Salaries',
                                    field       : 'photo',
                                    storePath   : 'uploads/salaries/',
                                    width       : 800,
                                    height      : 800,
                                    size        : 200,
                                    maxWidth    : 1600,
                                    maxHeight   : 1600,
                                    maxSize     : 200,
                                    quality     : 70,
                                    sizeLimit   : 5, // js validation
                                    validations : {
                                        'file': 'required|mimes:webp,bmp,gif,png,jpg,jpeg,txt,pdf,doc,docx|max:5120',
                                    }
                                }
                            }
                        },
                        validations       : {
                            'id'               : 'required|min:1|max:14',
                            'user_id'          : 'required|min:1|max:14',
                            'total_amount'     : 'required|min:1|max:16',
                            'amount'           : 'required|min:1|max:16',
                            'date_from'        : 'required|min:1|max:32',
                            'date_to'          : 'required|min:1|max:32',
                            'date'             : 'required|min:1|max:32',
                            'payment_method_id': 'required|min:1|max:14',
                            'payment_status_id': 'required|min:1|max:14',
                            'reference_no'     : 'max:128',
                            'description'      : 'max:512',
                            'photo'            : '',
                            'api_ver'          : 'max:8',
                            'app_ver'          : 'max:8',
                            'app_build_ver'    : 'max:8',
                            'u_agent'          : 'max:255',
                            'ipAddress'        : 'max:128',
                        },
                        unique            : {
                            'id': '|unique:salaries,id,',
                        },
                    },
                },
                modalEdit: {
                    options     : {
                        name        : 'ModalEdit',
                        class       : 'modal-custom',
                        style       : '',
                        height      : 'auto',
                        transition  : 'pop-out',
                        scrollable  : true,
                        adaptive    : false,
                        clickToClose: true,
                        beforeOpen  : {},
                        opened      : {},
                        beforeClose : {},
                        closed      : {},
                    },
                    header      : {
                        text      : 'Edit Salary',
                        subHeader : 'subHeader',
                        icon      : '<i class = "far fa-edit"></i>',
                        colorClass: 'modal-header-warning',
                        closeData : 'modal-header-warning',
                    },
                    statusDiv   : {
                        show    : true,
                        class   : 'alert-json-error',
                        style   : '',
                        messages: [],
                    },
                    isSubmitting: false,
                    form        : new Form({
                        id               : 0,
                        user_id          : null,
                        total_amount     : null,
                        amount           : null,
                        date_from        : this.getCurrentDate('YYYY-MM-DD'),
                        date_to          : this.getCurrentDate('YYYY-MM-DD'),
                        date             : this.getCurrentDate('YYYY-MM-DD'),
                        payment_method_id: null,
                        payment_status_id: null,
                        reference_no     : null,
                        description      : null,
                        active           : null,
                        photo            : null,
                        api_ver          : '1.0',
                        app_ver          : '1.0.0',
                        app_build_ver    : 1,
                    }),
                    validations : {
                        user_id          : {
                            required,
                        },
                        total_amount     : {
                            required,
                            decimal,
                            minValue: minValue(0),
                            maxValue: maxValue(1000000000),
                        },
                        amount           : {
                            required,
                            decimal,
                            minValue: minValue(0),
                            maxValue: maxValue(1000000000),
                        },
                        date_from        : {
                            required,
                        },
                        date_to          : {
                            required,
                        },
                        date             : {
                            required
                        },
                        payment_method_id: {
                            required,
                        },
                        payment_status_id: {
                            required
                        },
                        reference_no     : {},
                        description      : {},
                        photo            : {},
                        active           : {
                            required,
                        },
                    },
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalEdit2',
                    inputs      : {
                        user_id          : {
                            label          : {
                                show : true,
                                text : 'Employee',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'select',
                            multiSelect    : {
                                inputClass    : 'form-control multiselect-in-modal',
                                inputStyle    : '',
                                allowEmpty    : true,
                                searchable    : true,
                                closeOnSelect : true,
                                showLabels    : false,
                                deselectLabel : 'Can\'not remove this value',
                                hideSelected  : false,
                                preselectFirst: false,
                                option_id     : 'user_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Employee',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'user_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Employee', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Employee is Required'
                                    },
                                },
                            },
                        },
                        total_amount     : {
                            label          : {
                                show : true,
                                text : 'Total Salary',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "nc-icon nc-settings"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'text',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'text',
                            placeHolder    : 'Enter Employee Total Salary',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'total_amount',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Total Salary', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Total Salary is Required'
                                    },
                                    minValue: {
                                        value  : 0,
                                        message: 'Min value can not be less than 0'
                                    },
                                    maxValue: {
                                        value  : 1000000000,
                                        message: 'Maximum value can not be more than 1000000000'
                                    },
                                    decimal : {
                                        message: 'Input must be in Number format.'
                                    },
                                },
                            },
                        },
                        amount           : {
                            label          : {
                                show : true,
                                text : 'Amount Paid',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "nc-icon nc-settings"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'text',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'text',
                            placeHolder    : 'Enter Salary Amount Paid',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'amount',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Amount Paid', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Amount Paid is Required'
                                    },
                                    minValue: {
                                        value  : 0,
                                        message: 'Min value can not be less than 0'
                                    },
                                    maxValue: {
                                        value  : 1000000000,
                                        message: 'Maximum value can not be more than 1000000000'
                                    },
                                    decimal : {
                                        message: 'Input must be in Number format.'
                                    },
                                },
                            },
                        },
                        date_from        : {
                            label          : {
                                show : true,
                                text : 'Salary Date From',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'dateTime',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'dateTime',
                            dateTime       : {
                                type          : "date", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
                                size          : "", // large/small/mini
                                inputClass    : 'form-control no-padding',
                                inputStyle    : '',
                                inputDateClass: 'datepicker-custom',
                                inputDateStyle: '',
                                editable      : true,
                                clearable     : true,
                                isRange       : false,
                                arrowControl  : false,
                                align         : 'center', // left/center/right
                                rangeSeparator: '-',
                                pickerOptions : {
                                    /*disabledDate(time) {
                                        return time.getTime() > Date.now();
                                    },
                                    shortcuts: [{
                                        text: 'Today',
                                        onClick(picker) {
                                            picker.$emit('pick', new Date());
                                        }
                                    }, {
                                        text: 'Yesterday',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                                            picker.$emit('pick', date);
                                        }
                                    }, {
                                        text: 'A week ago',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                                            picker.$emit('pick', date);
                                        }
                                    }]*/
                                },
                                displayFormat : 'dd/MM/yyyy',
                                valueFormat   : 'yyyy-MM-dd',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Salary Date From',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date_from',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Salary Date From', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Salary Date From is Required'
                                    },
                                },
                            },
                        },
                        date_to          : {
                            label          : {
                                show : true,
                                text : 'Salary Date To',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'dateTime',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'dateTime',
                            dateTime       : {
                                type          : "date", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
                                size          : "", // large/small/mini
                                inputClass    : 'form-control no-padding',
                                inputStyle    : '',
                                inputDateClass: 'datepicker-custom',
                                inputDateStyle: '',
                                editable      : true,
                                clearable     : true,
                                isRange       : false,
                                arrowControl  : false,
                                align         : 'center', // left/center/right
                                rangeSeparator: '-',
                                pickerOptions : {
                                    /*disabledDate(time) {
                                        return time.getTime() > Date.now();
                                    },
                                    shortcuts: [{
                                        text: 'Today',
                                        onClick(picker) {
                                            picker.$emit('pick', new Date());
                                        }
                                    }, {
                                        text: 'Yesterday',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                                            picker.$emit('pick', date);
                                        }
                                    }, {
                                        text: 'A week ago',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                                            picker.$emit('pick', date);
                                        }
                                    }]*/
                                },
                                displayFormat : 'dd/MM/yyyy',
                                valueFormat   : 'yyyy-MM-dd',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Salary Date To',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date_to',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Salary Date To', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Salary Date To is Required'
                                    },
                                },
                            },
                        },
                        date             : {
                            label          : {
                                show : true,
                                text : 'Salary Payment Date',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'dateTime',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'dateTime',
                            dateTime       : {
                                type          : "date", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
                                size          : "", // large/small/mini
                                inputClass    : 'form-control no-padding',
                                inputStyle    : '',
                                inputDateClass: 'datepicker-custom',
                                inputDateStyle: '',
                                editable      : true,
                                clearable     : true,
                                isRange       : false,
                                arrowControl  : false,
                                align         : 'center', // left/center/right
                                rangeSeparator: '-',
                                pickerOptions : {
                                    /*disabledDate(time) {
                                        return time.getTime() > Date.now();
                                    },
                                    shortcuts: [{
                                        text: 'Today',
                                        onClick(picker) {
                                            picker.$emit('pick', new Date());
                                        }
                                    }, {
                                        text: 'Yesterday',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                                            picker.$emit('pick', date);
                                        }
                                    }, {
                                        text: 'A week ago',
                                        onClick(picker) {
                                            const date = new Date();
                                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                                            picker.$emit('pick', date);
                                        }
                                    }]*/
                                },
                                displayFormat : 'dd/MM/yyyy',
                                valueFormat   : 'yyyy-MM-dd',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Salary Payment Date',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Salary Payment Date', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Salary Payment Date is Required'
                                    },
                                },
                            },
                        },
                        payment_method_id: {
                            label          : {
                                show : true,
                                text : 'Payment Method',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'select',
                            multiSelect    : {
                                inputClass    : 'form-control multiselect-in-modal',
                                inputStyle    : '',
                                allowEmpty    : true,
                                searchable    : true,
                                closeOnSelect : true,
                                showLabels    : false,
                                deselectLabel : 'Can\'not remove this value',
                                hideSelected  : false,
                                preselectFirst: false,
                                option_id     : 'payment_method_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Payment Method',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'payment_method_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Payment Method', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Payment Method is Required'
                                    },
                                },
                            },
                        },
                        payment_status_id: {
                            label          : {
                                show : true,
                                text : 'Payment Status',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'select',
                            multiSelect    : {
                                inputClass    : 'form-control multiselect-in-modal',
                                inputStyle    : '',
                                allowEmpty    : true,
                                searchable    : true,
                                closeOnSelect : true,
                                showLabels    : false,
                                deselectLabel : 'Can\'not remove this value',
                                hideSelected  : false,
                                preselectFirst: false,
                                option_id     : 'payment_status_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Payment Status',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'payment_status_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Payment Status', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Payment Status is Required'
                                    },
                                },
                            },
                        },
                        reference_no     : {
                            label          : {
                                show : true,
                                text : 'Reference Number',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-clock"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'text',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col-12',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'text',
                            placeHolder    : 'Reference Number',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'reference_no',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Reference Number', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Reference Number is Required'
                                    },
                                },
                            },
                        },
                        description      : {
                            label          : {
                                show : true,
                                text : 'Description',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-clock"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'text',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col-12',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'text',
                            placeHolder    : 'Description',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'description',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Description', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Description is Required'
                                    },
                                },
                            },
                        },
                        photo            : {
                            label          : {
                                show : true,
                                text : 'Payment Photo <i class = "fas fa-camera"></i> ',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : false,
                                text : '<i class = "fas fa-camera"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'image',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col-12',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'file',
                            multiple       : true,
                            image          : {
                                inputClass     : 'picture-div',
                                inputStyle     : '',
                                inputImageClass: 'picture-img-src',
                                inputImageStyle: '',
                                inputLabelClass: 'picture-div-progress',
                                imageServer    : '/uploads/salaries/',
                                imageSrc       : null,
                                onChange       : [
                                    'modalEdit',
                                    'inputs',
                                    'photo',
                                    'image',
                                    'imageSrc'
                                ],
                                clearButton    : {
                                    show : true,
                                    class: 'floating-clear',
                                    style: '',
                                    props: [
                                        'modalAdd',
                                        'form',
                                        'photo',
                                    ],
                                }
                            },
                            placeHolder    : 'Upload Photo',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'photo',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Photo', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Photo is Required'
                                    },
                                },
                            },
                        },
                        active           : {
                            label          : {
                                show : true,
                                text : 'Status',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "far fa-newspaper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col',
                            colStyle       : '',
                            formClass      : 'form-group',
                            inputClass     : 'form-control',
                            inputStyle     : '',
                            type           : 'select',
                            multiSelect    : {
                                inputClass    : 'form-control multiselect-in-modal',
                                inputStyle    : '',
                                allowEmpty    : true,
                                searchable    : true,
                                closeOnSelect : true,
                                showLabels    : false,
                                deselectLabel : 'Can\'not remove this value',
                                hideSelected  : false,
                                preselectFirst: false,
                                option_id     : 'active',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Status',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'active',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Status',
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Status is Required'
                                    },
                                },
                            },
                        },
                    },
                    dbInsert    : {
                        table             : 'Salaries',
                        createMany        : false,
                        createManyField   : 'listItems',
                        createManyTable   : 'CustomerPaymentInwardItems',
                        createManyTableId : 'customer_payment_inward_id',
                        createManyRelation: 'items',
                        role              : {
                            active : false,
                            message: 'You do not have permission to perform this action.',
                            roles  : [
                                'ALL'
                            ],
                        },
                        actionType        : 'edit_salary',
                        sentAsFormData    : true,
                        fileUploads       : {
                            active: true,
                            strict: true,
                            files : {
                                photo: {
                                    saveAsString: true,
                                    active      : true,
                                    files       : [],
                                    imageSrc    : null,
                                    storeType   : 'update', // create, update
                                    table       : 'Salaries',
                                    field       : 'photo',
                                    storePath   : 'uploads/salaries/',
                                    width       : 800,
                                    height      : 800,
                                    size        : 200,
                                    maxWidth    : 1600,
                                    maxHeight   : 1600,
                                    maxSize     : 200,
                                    quality     : 70,
                                    sizeLimit   : 5, // js validation
                                    validations : {
                                        'file': 'required|mimes:webp,bmp,gif,png,jpg,jpeg,txt,pdf,doc,docx|max:5120',
                                    }
                                }
                            }
                        },
                        storeInEdits      : true,
                        validations       : {
                            'id'               : 'required|min:1|max:14',
                            'user_id'          : 'required|min:1|max:14',
                            'total_amount'     : 'required|min:1|max:16',
                            'amount'           : 'required|min:1|max:16',
                            'date_from'        : 'required|min:1|max:32',
                            'date_to'          : 'required|min:1|max:32',
                            'date'             : 'required|min:1|max:32',
                            'payment_method_id': 'required|min:1|max:14',
                            'payment_status_id': 'required|min:1|max:14',
                            'reference_no'     : 'max:128',
                            'description'      : 'max:512',
                            'active'           : 'required|min:1|max:2',
                            'api_ver'          : 'max:8',
                            'app_ver'          : 'max:8',
                            'app_build_ver'    : 'max:8',
                            'u_agent'          : 'max:255',
                            'ipAddress'        : 'max:128',
                        },
                        unique            : {
                            'id': '|unique:salaries,id,',
                        },
                    },
                },
                dbInputs : [
                    {
                        key       : 'user_id',
                        table     : 'User',
                        tableWith : [],
                        matchThese: [
                            [
                                'active',
                                '=',
                                1
                            ],
                            [
                                'role_id',
                                '=',
                                3
                            ],
                        ],
                        orThose   : [],
                        select    : {
                            'id'    : 'id',
                            'name'  : 'name',
                            'active': 'active',
                        },
                        orderBy   : 'name',
                        direction : 'asc',
                        pluck     : {
                            'id'    : 'id',
                            'name'  : 'name',
                            'active': 'active',
                        }
                    },
                    {
                        key       : 'payment_method_id',
                        table     : 'PaymentMethod',
                        tableWith : [],
                        matchThese: [
                            [
                                'active',
                                '=',
                                1
                            ],
                        ],
                        orThose   : [],
                        select    : {
                            'id'    : 'id',
                            'name'  : 'name',
                            'active': 'active',
                        },
                        orderBy   : 'name',
                        direction : 'asc',
                        pluck     : {
                            'id'    : 'id',
                            'name'  : 'name',
                            'active': 'active',
                        }
                    },
                    {
                        key       : 'payment_status_id',
                        table     : 'PaymentStatus',
                        tableWith : [],
                        matchThese: [
                            [
                                'active',
                                '=',
                                1
                            ],
                        ],
                        orThose   : [],
                        select    : {
                            'id'    : 'id',
                            'name'  : 'name',
                            'active': 'active',
                        },
                        orderBy   : 'name',
                        direction : 'asc',
                        pluck     : {
                            'id'    : 'id',
                            'name'  : 'name',
                            'active': 'active',
                        }
                    },
                ], //Options Array
                dbQuery  : {
                    table     : 'Salaries',
                    tableWith : [
                        'user',
                        'payment_method',
                        'payment_status',
                    ],
                    matchThese: [
                        [
                            'active',
                            '=',
                            1
                        ],
                    ],
                    orThose   : [
                        [
                            'active',
                            '=',
                            0
                        ],
                    ],
                    where     : [],
                    orWhere   : [],
                    search    : {
                        text  : '',
                        fields: [],
                    },
                    select    : {
                        'id'               : 'id',
                        'user_id'          : 'user_id',
                        'total_amount'     : 'total_amount',
                        'amount'           : 'amount',
                        'date_from'        : 'date_from',
                        'date_to'          : 'date_to',
                        'date'             : 'date',
                        'payment_method_id': 'payment_method_id',
                        'payment_status_id': 'payment_status_id',
                        'reference_no'     : 'reference_no',
                        'description'      : 'description',
                        'photo'            : 'photo',
                        'active'           : 'active',
                    },
                    sortBy    : {
                        relation: false, // false or relation name
                        field   : 'id',
                        desc    : true
                    },
                    // orderBy   : 'id',
                    // direction : 'desc',
                    pluck     : {
                        'id'               : 'id',
                        'user_id'          : 'user_id',
                        'total_amount'     : 'total_amount',
                        'amount'           : 'amount',
                        'date_from'        : 'date_from',
                        'date_to'          : 'date_to',
                        'date'             : 'date',
                        'payment_method_id': 'payment_method_id',
                        'payment_status_id': 'payment_status_id',
                        'reference_no'     : 'reference_no',
                        'description'      : 'description',
                        'photo'            : 'photo',
                        'active'           : 'active',
                    }
                },
                dbDestroy: {
                    table         : 'Salaries',
                    role          : {
                        active : false,
                        message: 'You do not have permission to perform this action.',
                        roles  : [
                            'ALL'
                        ],
                    },
                    actionType    : 'delete_salary',
                    storeInDeletes: true,
                    validations   : {
                        'id': 'required|min:1|max:15', // '*.id' : 'required|min:1|max:15',
                    }
                },
                options  : {
                    user_id          : [],
                    payment_method_id: [],
                    payment_status_id: [],
                },
                option   : {
                    modalAdd : {
                        user_id          : {},
                        payment_method_id: {},
                        payment_status_id: {},
                    },
                    modalEdit: {
                        user_id          : {},
                        payment_method_id: {},
                        payment_status_id: {},
                        active           : {},
                    }
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
            this.setPushOptions(this.optionSet, null);
            this.getFormInputs(this.FormInputsAPI, null, this.dbInputs, null, this.optionSet, null);
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
                            'id'            : d['id'],
                            'user'          : d['user'] ? d['user']['name'] : '',  // use relation name a key for relations
                            'date_from'     : d['date_from'] ? (this.dateFormat(d['date_from'], 'Do MMM, YYYY')) : '',
                            'date_to'       : d['date_to'] ? (this.dateFormat(d['date_to'], 'Do MMM, YYYY')) : '',
                            'total_amount'  : d['total_amount'] ? (this.twoDecimalPlace(d['total_amount'])) : '',
                            'amount'        : d['amount'] ? (this.twoDecimalPlace(d['amount'])) : '',
                            'due'           : d['total_amount'] ? (this.twoDecimalPlace(d['total_amount'] - d['amount'])) : '',
                            'date'          : d['date'] ? (this.dateFormat(d['date'], 'Do MMM, YYYY')) : '',
                            'payment_method': d['payment_method'] ? d['payment_method']['name'] : '',
                            'payment_status': d['payment_status'] ? d['payment_status']['name'] : '',
                            'active'        : d['active'] == 1 ? 'Active' : 'Inactive',
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
                console.log('viewModal: ', data, this.modalView.data, this.modalView.tableView);
                this.$modal.show(ModalView, {
                    params: {
                        modalView: this.modalView, print    : this.page.print,
                    }
                }, {
                    adaptive    : this.modalView.options.adaptive,
                    clickToClose: this.modalView.options.clickToClose,
                    name        : this.modalView.options.name,
                    class       : this.modalView.options.class,
                    style       : this.modalView.options.style,
                    draggable   : false,
                    scrollable  : this.modalView.options.scrollable,
                    transition  : this.modalView.options.transition,
                    height      : this.modalView.options.height,
                }, {
                    'before-open' : (event) => {
                        console.log('beforeOpen: ', event);
                        this.modalView.data        = null;
                        this.modalView.tableView   = null;
                        this.modalView.data        = data;
                        this.modalView.tableView   = this.generateModalView(this.modalView.data);
                        this.modalView.header.text = this.page.title + ' Details';
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
                        this.modalDelete.data      = null;
                        this.modalDelete.tableView = null;
                        //this.modalDelete.isSubmitting       = false;
                        //this.modalDelete.statusDiv.class    = 'alert-json-error';
                        this.modalDelete.statusDiv.messages = [];
                        this.modalDelete.data               = data;
                        this.modalDelete.tableView          = this.generateModalView(this.modalDelete.data);
                        this.modalDelete.header.text        = 'Delete ' + this.page.title;
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
                this.$modal.show(ModalAdd, {
                    params: {
                        modalAdd  : this.modalAdd,
                        options   : this.options,
                        option    : this.option,
                        optionSet : this.optionSet,
                        ItemAddUrl: this.ItemAddUrl,
                        vuexKey   : this.page.vuexKey,
                        dbQuery   : this.dbQuery,
                    }
                }, {
                    adaptive    : this.modalAdd.options.adaptive,
                    clickToClose: this.modalAdd.options.clickToClose,
                    name        : this.modalAdd.options.name,
                    class       : this.modalAdd.options.class,
                    style       : this.modalAdd.options.style,
                    draggable   : false,
                    scrollable  : this.modalAdd.options.scrollable,
                    transition  : this.modalAdd.options.transition,
                    height      : this.modalAdd.options.height,
                }, {
                    'before-open' : (event) => {
                        console.log('beforeOpen: ', event);
                        //this.modalAdd.isSubmitting       = false;
                        //this.modalAdd.statusDiv.class    = 'alert-json-error';
                        this.modalAdd.statusDiv.messages = [];
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
            editModal(data) {
                console.log('editModal: ', data);
                this.$modal.show(ModalEdit, {
                    params: {
                        modalEdit : this.modalEdit,
                        options   : this.options,
                        option    : this.option,
                        optionSet : this.optionSet,
                        ItemAddUrl: this.ItemAddUrl,
                        vuexKey   : this.page.vuexKey,
                        dbQuery   : this.dbQuery,
                    }
                }, {
                    adaptive    : this.modalEdit.options.adaptive,
                    clickToClose: this.modalEdit.options.clickToClose,
                    name        : this.modalEdit.options.name,
                    class       : this.modalEdit.options.class,
                    style       : this.modalEdit.options.style,
                    draggable   : false,
                    scrollable  : this.modalEdit.options.scrollable,
                    transition  : this.modalEdit.options.transition,
                    height      : this.modalEdit.options.height,
                }, {
                    'before-open' : (event) => {
                        console.log('beforeOpen: ', event);
                        //this.modalEdit.isSubmitting       = false;
                        //this.modalEdit.statusDiv.class    = 'alert-json-error';
                        this.pageItemSelected(data, this.modalEdit.formKey);
                        this.modalEdit.statusDiv.messages = [];
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
                            data : 'Employee\'s Name',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.user ? modalData.user.name : '',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Date From',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.dateFormat(modalData.date_from, 'Do MMM, YYYY'),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Date To',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.dateFormat(modalData.date_to, 'Do MMM, YYYY'),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Total Salary',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.twoDecimalPlace(modalData.total_amount),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Paid Amount',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.twoDecimalPlace(modalData.amount),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Due Amount',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.twoDecimalPlace(modalData.total_amount - modalData.amount),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Payment Date',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.dateFormat(modalData.date, 'Do MMM, YYYY'),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Payment Method',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.payment_method ? modalData.payment_method.name : '',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Payment Status',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.payment_status ? modalData.payment_status.name : '',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Reference Number',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.reference_no ? modalData.reference_no : '-',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Description',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.description ? modalData.description : '-',
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
