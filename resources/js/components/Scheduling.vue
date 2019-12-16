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
                                <input @input = "searchPageItem($event, page.searchType, page.searchText, page.headers)" class = "form-control" id = "searchPageItem" name = "searchPageItem"
                                        :placeholder = "page.searchTitle" type = "text" v-model = "page.searchText"> <i @click.prevent = "clearSearch()"
                                    class = "far fa-times-circle search-cancel-button" v-if = "page.searchText && page.searchText.length > 0 && page.searching === false"></i> <i
                                    class = "fas fa-spinner fa-pulse search-loading-icon" v-if = "page.searching"></i>
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
                        Showing <span v-if = "dataTable['data'] && dataTable['data'].length > 0"><b>{{$refs.paginator.pageItemsCount}}</b></span> <span v-else><b>0</b></span> results
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
                                            {{item.title}} <i class = "fas"
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
                                            {{item['TableViewData']['schedule_no']}}
                                        </td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['day']}}</td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['time_from']}}
                                        </td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['time_to']}}</td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['duration']}}
                                        </td>
                                        <td @click.prevent = "viewModal(item)">
                                            {{item['TableViewData']['break_time_from']}}
                                        </td>
                                        <td @click.prevent = "viewModal(item)">
                                            {{item['TableViewData']['break_time_to']}}
                                        </td>
                                        <td @click.prevent = "viewModal(item)">
                                            {{item['TableViewData']['duration_break']}}
                                        </td>
                                        <td @click.prevent = "viewModal(item)">
                                            <span :class = "[item.active == 0 ? 'badge-warning' : 'badge-success']" class = "badge">{{item['TableViewData']['active']}}</span>
                                        </td>
                                        <td class = "text-center">
                                            <div class = "dropdown">
                                                <button class = "btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle = "dropdown" style = "border: 1px solid #4A4A4A5E !important;"
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
                                                    <i class = "fas fa-info-circle"></i> <span><b>EMPTY</b> - Table has no data to show.</span>
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
                                        <multiselect :allow-empty = "false" :close-on-select = "true" :options = "perPageList" :preselectFirst = "true" :searchable = "false" :show-labels = "false"
                                                class = "dropdown multiselect-in-pagination" id = "perPage" name = "perPage" placeholder = "Select Items Per Page"
                                                style = "display: inline-block; width: 90px;" v-model = "perPage"></multiselect>
                                        <span> per page</span>
                                    </div>
                                    <div class = "col">
                                        <paginate-links :limit = "2" :show-step-links = "true" class = "pagination custom-pagination" for = "items" :async = "true"
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
                    title      : 'Scheduling',
                    subTitle   : 'List and manage Scheduling',
                    vuexKey    : 'scheduling',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    print      : {
                        title     : 'Scheduling',
                        subTitle  : 'List of Scheduling',
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
                            title   : 'Schedule No',
                            relation: false, // false or 'string'
                            field   : 'schedule_no',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Day',
                            relation: 'day', // false or 'string'
                            field   : 'day_id',
                            operator: 'like',
                            sortType: 'jsText', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Time From',
                            relation: false, // false or 'string'
                            field   : 'time_from',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Time To',
                            relation: false, // false or 'string'
                            field   : 'time_to',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Duration',
                            relation: false, // false or 'string'
                            field   : 'duration',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Break From',
                            relation: false, // false or 'string'
                            field   : 'break_time_from',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Break To',
                            relation: false, // false or 'string'
                            field   : 'break_time_to',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Break Duration',
                            relation: false, // false or 'string'
                            field   : 'duration_break',
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
                    id             : 0,
                    schedule_no    : null,
                    day_id         : null,
                    time_from      : null,
                    time_to        : null,
                    duration       : null,
                    break_time_from: null,
                    break_time_to  : null,
                    duration_break : null,
                    description    : null,
                    active         : null,
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
                        text      : 'Add New Schedule',
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
                        id             : 0,
                        schedule_no    : null,
                        day_id         : null,
                        time_from      : this.getCurrentDate('HH:mm'),
                        time_to        : this.getCurrentDate('HH:mm'),
                        duration       : null,
                        break_time_from: this.getCurrentDate('HH:mm'),
                        break_time_to  : this.getCurrentDate('HH:mm'),
                        duration_break : null,
                        description    : null,
                        entry_type_id  : 1,
                        api_ver        : '1.0',
                        app_ver        : '1.0.0',
                        app_build_ver  : 1,
                    }),
                    validations : {
                        schedule_no    : {
                            required,
                        },
                        day_id         : {},
                        time_from      : {},
                        time_to        : {},
                        duration       : {},
                        break_time_from: {},
                        break_time_to  : {},
                        duration_break : {},
                        description    : {}
                    },
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalAdd',
                    inputs      : [
                        {
                            label          : {
                                show : true,
                                text : 'Schedule Number',
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
                            placeHolder    : 'Enter Schedule Number',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'schedule_no',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Schedule Number', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Schedule Number is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Day',
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
                                option_id     : 'day_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Day',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'day_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Day', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Day is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Time From',
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
                                type          : "timePicker", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
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
                                    step  : '00:30',
                                    start : '00:00',
                                    end   : '23:59',
                                    // minTime: '',
                                    // maxTime: '',
                                    //
                                    // selectableRange: '18:30:00 - 20:30:00',
                                    format: 'hh:mm A',
                                },
                                valueFormat   : 'HH:mm',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Time From',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'time_from',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Time From', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Time From is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Time To',
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
                                type          : "timePicker", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
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
                                    step  : '00:30',
                                    start : '00:00',
                                    end   : '23:59',
                                    // minTime: '',
                                    // maxTime: '',
                                    //
                                    // selectableRange: '18:30:00 - 20:30:00',
                                    format: 'hh:mm A',
                                },
                                valueFormat   : 'HH:mm',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Time To',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'time_to',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Time To', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Time To is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Duration',
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
                            placeHolder    : 'Enter Duration',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'duration',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Duration', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Duration is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Break Time From',
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
                                type          : "timePicker", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
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
                                    step  : '00:30',
                                    start : '00:00',
                                    end   : '23:59',
                                    // minTime: '',
                                    // maxTime: '',
                                    //
                                    // selectableRange: '18:30:00 - 20:30:00',
                                    format: 'hh:mm A',
                                },
                                valueFormat   : 'HH:mm',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Break Time From',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'break_time_from',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Break Time From', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Break Time From is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Break Time To',
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
                                type          : "timePicker", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
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
                                    step  : '00:30',
                                    start : '00:00',
                                    end   : '23:59',
                                    // minTime: '',
                                    // maxTime: '',
                                    //
                                    // selectableRange: '18:30:00 - 20:30:00',
                                    format: 'hh:mm A',
                                },
                                valueFormat   : 'HH:mm',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Break Time To',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'break_time_to',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Break Time To', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Break Time To is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Break Duration',
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
                            placeHolder    : 'Enter Break Duration',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'duration_break',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Break Duration', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Break Duration is Required'
                                    },
                                    minValue: {
                                        value  : 0,
                                        message: 'Min value can not be less than 1'
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
                        {
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
                    ],
                    dbInsert    : {
                        table             : 'Scheduling',
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
                        actionType        : 'add_schedule',
                        validations       : {
                            'id'             : 'required|min:1|max:14',
                            'schedule_no'    : 'required|min:1|max:32',
                            'day_id'         : 'max:32',
                            'time_from'      : 'max:32',
                            'time_to'        : 'max:32',
                            'duration'       : 'max:16',
                            'break_time_from': 'max:32',
                            'break_time_to'  : 'max:32',
                            'duration_break' : 'max:16',
                            'description'    : 'max:512',
                            'api_ver'        : 'max:8',
                            'app_ver'        : 'max:8',
                            'app_build_ver'  : 'max:8',
                            'u_agent'        : 'max:255',
                            'ipAddress'      : 'max:128',
                        },
                        unique            : {
                            'id': '|unique:scheduling,id,',
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
                        text      : 'Edit Schedule',
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
                        id             : 0,
                        schedule_no    : null,
                        day_id         : null,
                        time_from      : null,
                        time_to        : null,
                        duration       : null,
                        break_time_from: null,
                        break_time_to  : null,
                        duration_break : null,
                        description    : null,
                        active         : null,
                        api_ver        : '1.0',
                        app_ver        : '1.0.0',
                        app_build_ver  : 1,
                    }),
                    validations : {
                        schedule_no    : {
                            required,
                        },
                        day_id         : {},
                        time_from      : {},
                        time_to        : {},
                        duration       : {},
                        break_time_from: {},
                        break_time_to  : {},
                        duration_break : {},
                        description    : {},
                        active         : {
                            required,
                        },
                    },
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputs      : [
                        {
                            label          : {
                                show : true,
                                text : 'Schedule Number',
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
                            placeHolder    : 'Enter Schedule Number',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'schedule_no',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Schedule Number', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Schedule Number is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Day',
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
                                option_id     : 'day_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Day',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'day_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Day', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Day is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Time From',
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
                                type          : "timePicker", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
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
                                    step  : '00:30',
                                    start : '00:00',
                                    end   : '23:59',
                                    // minTime: '',
                                    // maxTime: '',
                                    //
                                    // selectableRange: '18:30:00 - 20:30:00',
                                    format: 'hh:mm A',
                                },
                                valueFormat   : 'HH:mm',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Time From',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'time_from',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Time From', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Time From is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Time To',
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
                                type          : "timePicker", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
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
                                    step  : '00:30',
                                    start : '00:00',
                                    end   : '23:59',
                                    // minTime: '',
                                    // maxTime: '',
                                    //
                                    // selectableRange: '18:30:00 - 20:30:00',
                                    format: 'hh:mm A',
                                },
                                valueFormat   : 'HH:mm',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Time To',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'time_to',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Time To', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Time To is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Duration',
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
                            placeHolder    : 'Enter Duration',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'duration',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Duration', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Duration is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Break Time From',
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
                                type          : "timePicker", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
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
                                    step  : '00:30',
                                    start : '00:00',
                                    end   : '23:59',
                                    // minTime: '',
                                    // maxTime: '',
                                    //
                                    // selectableRange: '18:30:00 - 20:30:00',
                                    format: 'hh:mm A',
                                },
                                valueFormat   : 'HH:mm',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Break Time From',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'break_time_from',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Break Time From', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Break Time From is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Break Time To',
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
                                type          : "timePicker", // timeSelect, timePicker + year/month/date/dates/datetime/ week/datetimerange/daterange/ monthrange
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
                                    step  : '00:30',
                                    start : '00:00',
                                    end   : '23:59',
                                    // minTime: '',
                                    // maxTime: '',
                                    //
                                    // selectableRange: '18:30:00 - 20:30:00',
                                    format: 'hh:mm A',
                                },
                                valueFormat   : 'HH:mm',
                                change        : '',
                                onClick       : '',
                            },
                            placeHolder    : 'Select Break Time To',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'break_time_to',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Break Time To', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Break Time To is Required'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Break Duration',
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
                            placeHolder    : 'Enter Break Duration',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'duration_break',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Break Duration', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Break Duration is Required'
                                    },
                                    minValue: {
                                        value  : 0,
                                        message: 'Min value can not be less than 1'
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
                        {
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
                        {
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
                    ],
                    dbInsert    : {
                        table             : 'Scheduling',
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
                        actionType        : 'edit_schedule',
                        storeInEdits      : true,
                        validations       : {
                            'id'             : 'required|min:1|max:14',
                            'schedule_no'    : 'required|min:1|max:32',
                            'day_id'         : 'max:32',
                            'time_from'      : 'max:32',
                            'time_to'        : 'max:32',
                            'duration'       : 'max:16',
                            'break_time_from': 'max:32',
                            'break_time_to'  : 'max:32',
                            'duration_break' : 'max:16',
                            'description'    : 'max:512',
                            'active'         : 'required|min:1|max:2',
                            'api_ver'        : 'max:8',
                            'app_ver'        : 'max:8',
                            'app_build_ver'  : 'max:8',
                            'u_agent'        : 'max:255',
                            'ipAddress'      : 'max:128',
                        },
                        unique            : {
                            'id': '|unique:scheduling,id,',
                        },
                    },
                },
                dbInputs : [
                    {
                        key       : 'day_id',
                        table     : 'SchedulingDays',
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
                        orderBy   : 'id',
                        direction : 'asc',
                        pluck     : {
                            'id'    : 'id',
                            'name'  : 'name',
                            'active': 'active',
                        }
                    },
                ],
                dbQuery  : {
                    table     : 'Scheduling',
                    tableWith : [
                        'day',
                        'entryby',
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
                        'id'             : 'id',
                        'schedule_no'    : 'schedule_no',
                        'day_id'         : 'day_id',
                        'time_from'      : 'time_from',
                        'time_to'        : 'time_to',
                        'duration'       : 'duration',
                        'break_time_from': 'break_time_from',
                        'break_time_to'  : 'break_time_to',
                        'duration_break' : 'duration_break',
                        'description'    : 'description',
                        'active'         : 'active',
                    },
                    sortBy    : {
                        relation: false, // false or relation name
                        field   : 'id',
                        desc    : true
                    },
                    // orderBy   : 'id',
                    // direction : 'desc',
                    pluck     : {
                        'id'             : 'id',
                        'schedule_no'    : 'schedule_no',
                        'day_id'         : 'day_id',
                        'time_from'      : 'time_from',
                        'time_to'        : 'time_to',
                        'duration'       : 'duration',
                        'break_time_from': 'break_time_from',
                        'break_time_to'  : 'break_time_to',
                        'duration_break' : 'duration_break',
                        'description'    : 'description',
                        'active'         : 'active',
                    }
                },
                dbDestroy: {
                    table         : 'Scheduling',
                    role          : {
                        active : false,
                        message: 'You do not have permission to perform this action.',
                        roles  : [
                            'ALL'
                        ],
                    },
                    actionType    : 'delete_scheduling',
                    storeInDeletes: true,
                    validations   : {
                        'id': 'required|min:1|max:15', // '*.id' : 'required|min:1|max:15',
                    }
                },
                options  : {
                    day_id: []
                },
                option   : {
                    modalAdd : {
                        day_id: {}
                    },
                    modalEdit: {
                        day_id: {},
                        active: {},
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
                            'id'             : d['id'],
                            'schedule_no'    : d['schedule_no'],
                            'day'            : d['day'] ? d['day']['name'] : '',
                            'time_from'      : d['time_from'] ? (this.timeFormat(d['time_from'], 'hh:mm A')) : '',
                            'time_to'        : d['time_to'] ? (this.timeFormat(d['time_to'], 'hh:mm A')) : '',
                            'duration'       : d['duration'],
                            'break_time_from': d['break_time_from'] ? (this.timeFormat(d['break_time_from'], 'hh:mm A')) : '',
                            'break_time_to'  : d['break_time_to'] ? (this.timeFormat(d['break_time_to'], 'hh:mm A')) : '',
                            'duration_break' : d['duration_break'],
                            'active'         : d['active'] == 1 ? 'Active' : 'Inactive',
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
                        modalView: this.modalView, print: this.page.print,
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
                            data : 'Schedule Number',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.schedule_no,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Day',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.day ? modalData.day.name : '',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Time From',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.timeFormat(modalData.time_from, 'hh:mm A'),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Time To',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.timeFormat(modalData.time_to, 'hh:mm A'),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Duration',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.duration,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Break Time From',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.timeFormat(modalData.break_time_from, 'hh:mm A'),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Break Time To',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : this.timeFormat(modalData.break_time_to, 'hh:mm A'),
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Break Duration',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.duration_break,
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
