<template>
    <div>
        <div class = "row" id = "mainSection">
            <div class = "col-md-12">
                <div class = "card">
                    <div class = "card-header">
                        <h4 class = "card-title">{{page.title}}</h4>
                        <p class = "card-category">{{page.subTitle}}</p>
                    </div>
                </div>
                <div class = "row justify-content-center">
                    <div class = "col-md-12">
                        <div class = "card">
                            <div class = "card-body" style = "padding: 10px 32px 10px 32px;">
                                <div class = "row">
                                    <div class = "col-5">
                                        <div class = "card-title-2">{{month ? dateFormat(month, 'MMMM, YYYY') : 'Please Select Month'}}</div>
                                    </div>
                                    <div class = "col-2" style = "margin-top: 6px">
                                        <div class = "form-group">
                                            <label>Month</label>
                                            <div class = "form-control no-padding">
                                                <el-date-picker class = "datepicker-custom"
                                                        id = "month"
                                                        name = "month"
                                                        placeholder = ""
                                                        type = "month"
                                                        align = "center"
                                                        :clearable = "true"
                                                        :editable = "true"
                                                        format = "MMMM-yyyy"
                                                        value-format = "yyyy-MM"
                                                        v-model = "month"
                                                        @input = "onMonthChange($event)"></el-date-picker>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "col-5" style = "margin-top: 10px">
                                        <div class = "btn-group pull-right" data-toggle = "buttons">
                                            <button @click.prevent = "printDiv(page.print, page.print.printType, dataTable['data'])" class = "btn btn-outline-info btn-12" type = "button">
                                                <i class = "fas fa-print"></i>&nbsp;Print
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class = "calendar-div" v-if = "month">
                                    <div class = "row justify-content-center cd-days-name">
                                        <div class = "col">
                                            <div class = "cd-div">Mon</div>
                                        </div>
                                        <div class = "col">
                                            <div class = "cd-div">Tue</div>
                                        </div>
                                        <div class = "col">
                                            <div class = "cd-div">Wed</div>
                                        </div>
                                        <div class = "col">
                                            <div class = "cd-div">Thu</div>
                                        </div>
                                        <div class = "col">
                                            <div class = "cd-div">Fri</div>
                                        </div>
                                        <div class = "col cd-weekend">
                                            <div class = "cd-div">Sat</div>
                                        </div>
                                        <div class = "col cd-weekend">
                                            <div class = "cd-div">Sun</div>
                                        </div>
                                    </div>
                                    <div class = "row justify-content-center cd-dates" v-for = "week in calendar">
                                        <template v-for = "day in week">
                                            <div class = "col" :class = "{ 'public_holiday' : day['public_holiday'] === 1, 'cd-weekend' : day['weekend'] === 1}" @click.prevent = "editModal(day)">
                                                <div class = "cd-div-date">{{day['dateText']}}</div>
                                                <div class = "cd-div-date-desc">{{day['description']}}</div>
                                            </div>
                                        </template>
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
    const {required, email, minLength, maxLength, minValue, maxValue, numeric, decimal, sameAs, not} = require('vuelidate/lib/validators');
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';
    import ModalEdit from './modals/ModalEdit.vue';
    import moment from 'moment';

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
                page      : {
                    title      : 'Work Calendar',
                    subTitle   : 'Manage Public Holidays',
                    vuexKey    : 'work_calendar',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    print      : {
                        title     : 'Work Calendar',
                        subTitle  : 'List of Work Calendar',
                        footer    : 'Copyright.',
                        time      : true,
                        printType : 'divId', // dataTable = DataTable Loop, divId = sectionId, image = asItis.
                        printDivId: 'mainSection',
                        format    : 'pdf',
                        pageSize  : 'A4',
                        layout    : 'Portrait',
                        margin    : '10px 10px 10px 10px',
                        class     : '',
                        headers   : [],
                        fields    : [],
                    },
                    headers    : [],
                },
                paginate  : ['items'],
                dataForm  : {
                    id            : 0,
                    date          : null,
                    public_holiday: null,
                    description   : null,
                    // active        : null,
                },
                month     : null,
                monthRange: null,
                calendar  : [
                    [
                        {
                            id            : 0,
                            day           : 'Mon',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Tue',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Wed',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Thu',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Fri',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sat',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sun',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                    ],
                    [
                        {
                            id            : 0,
                            day           : 'Mon',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Tue',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Wed',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Thu',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Fri',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sat',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sun',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                    ],
                    [
                        {
                            id            : 0,
                            day           : 'Mon',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Tue',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Wed',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Thu',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Fri',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sat',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sun',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                    ],
                    [
                        {
                            id            : 0,
                            day           : 'Mon',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Tue',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Wed',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Thu',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Fri',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sat',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sun',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                    ],
                    [
                        {
                            id            : 0,
                            day           : 'Mon',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Tue',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Wed',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Thu',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Fri',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sat',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                        {
                            id            : 0,
                            day           : 'Sun',
                            dateText      : null,
                            date          : null,
                            view          : true,
                            public_holiday: false,
                            weekend       : false,
                            description   : null,
                            active        : false,
                        },
                    ],
                ],
                modalEdit : {
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
                        text      : 'Edit Day',
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
                        id            : 0,
                        date          : null,
                        public_holiday: null,
                        description   : null,
                        // active        : null,
                        api_ver       : '1.0',
                        app_ver       : '1.0.0',
                        app_build_ver : 1,
                    }),
                    validations : {
                        id            : {
                            required,
                        },
                        date          : {
                            required,
                        },
                        public_holiday: {},
                        description   : {},
                    },
                    formClass   : 'form-modal paper-form',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputs      : {
                        date          : {
                            label          : {
                                show : true,
                                text : 'Date',
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
                            placeHolder    : 'Select Date',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Date', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Date is Required'
                                    },
                                },
                            },
                        },
                        public_holiday: {
                            label          : {
                                show : true,
                                text : 'Public Holiday',
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
                                option_id     : 'public_holiday',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Public Holiday Status',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'public_holiday',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Public Holiday',
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Public Holiday is Required'
                                    },
                                },
                            },
                        },
                        description   : {
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
                            inputType      : 'textArea',
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
                            maxlength      : 500,
                            rows           : 2,
                            cols           : 1,
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
                    },
                    dbInsert    : {
                        table             : 'WorkCalendar',
                        createMany        : false,
                        createManyField   : 'listItems',
                        createManyTable   : 'CustomerPaymentInwardItems',
                        createManyTableId : 'customer_payment_inward_id',
                        createManyRelation: 'items',
                        role              : {
                            active : true,
                            message: 'You do not have permission to perform this action.',
                            roles  : [
                                'Admin',
                                'HR',
                            ],
                        },
                        actionType        : 'edit_work_calendar',
                        sentAsFormData    : false,
                        storeInEdits      : true,
                        validations       : {
                            'id'            : 'required|min:1|max:14',
                            'date'          : 'required|min:1|max:24',
                            'public_holiday': 'required',
                            'description'   : 'max:512',
                            'api_ver'       : 'max:8',
                            'app_ver'       : 'max:8',
                            'app_build_ver' : 'max:8',
                            'u_agent'       : 'max:255',
                            'ipAddress'     : 'max:128',
                        },
                        unique            : {
                            'id': '|unique:work_calendar,id,',
                        },
                    },
                },
                dbInputs  : [],
                dbQuery   : {
                    work_calendar: {
                        table     : 'WorkCalendar',
                        tableWith : [],
                        matchThese: [
                            [
                                'active',
                                '=',
                                1
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
                            'id'            : 'id',
                            'date'          : 'date',
                            'public_holiday': 'public_holiday',
                            'description'   : 'description',
                            'active'        : 'active',
                        },
                        sortBy    : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        pluck     : {
                            'id'            : 'id',
                            'date'          : 'date',
                            'public_holiday': 'public_holiday',
                            'description'   : 'description',
                            'active'        : 'active',
                        }
                    },
                },
                dbDestroy : {},
                options   : {},
                option    : {
                    modalAdd : {},
                    modalEdit: {
                        public_holiday: {}
                    },
                }, //Option Sub
                optionSub : {
                    modalAdd : {},
                    modalEdit: {}
                }, //Setting
                optionSet : {
                    public_holiday: [
                        {
                            id  : 1,
                            name: 'Yes',
                        },
                        {
                            id  : 0,
                            name: 'No',
                        }
                    ],
                }, //Pushing custom option to option array
                optionPush: {}, //Reseting Option, OptionSub to blank value after form submit
            }
        },
        validations: {},
        created() {
            // this.setLayout('layout-dashboard');
            this.setPushOptions(this.optionSet, null);
            // this.getFormInputs(this.FormInputsAPI, null, this.dbInputs, null, this.optionSet, null);
            this.onLoadPageData(this.ItemGetUrl, this.dbQuery.work_calendar, this.page.vuexKey, 'loading', false, null);
            console.log('created: ', this.page.title, ': ', this.$route.params);
        },
        mounted() {
        },
        computed   : {
            dataTable() {
                let data = this.$store.getters.dataTable(this.page.vuexKey);
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
            editModal(data) {
                console.log('editModal: ', data);
                if (data && data.date) {

                    this.$modal.show(ModalEdit, {
                        params: {
                            modalEdit : this.modalEdit,
                            options   : this.options,
                            option    : this.option,
                            optionSet : this.optionSet,
                            ItemAddUrl: this.ItemAddUrl,
                            vuexKey   : this.page.vuexKey,
                            dbQuery   : this.dbQuery.work_calendar,
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
                            this.generateCalendar();
                        },
                    })
                }
            },
            generateCalendar() {
                let l = 0;
                this.calendar.forEach((week, index) => {
                    week.forEach((week, i) => {
                        if (this.monthRange[l] && this.monthRange[l].format('ddd') === this.calendar[index][i]['day']) {
                            // console.log('week.forEach: ', index, i, l, this.monthRange[l].format('ddd'));
                            const date = this.monthRange[l].format('YYYY-MM-DD');
                            let workCalendar = this.dataTable['data'].find(x => x.date === date);
                            this.calendar[index][i]['id'] = workCalendar && workCalendar['id'] ? workCalendar['id'] : 0;
                            this.calendar[index][i]['dateText'] = this.monthRange[l].format('D');
                            this.calendar[index][i]['date'] = date;
                            this.calendar[index][i]['view'] = true;
                            this.calendar[index][i]['public_holiday'] = workCalendar && workCalendar['public_holiday'] === 1 ? workCalendar['public_holiday'] : 0;
                            this.calendar[index][i]['weekend'] = this.monthRange[l].format('ddd') === 'Sat' || this.monthRange[l].format('ddd') === 'Sun' ? 1 : 0;
                            this.calendar[index][i]['description'] = workCalendar && workCalendar['description'] ? workCalendar['description'] : null;
                            this.calendar[index][i]['active'] = true;
                            l++;
                        } else {
                            this.calendar[index][i]['id'] = 0;
                            this.calendar[index][i]['dateText'] = null;
                            this.calendar[index][i]['date'] = null;
                            this.calendar[index][i]['view'] = false;
                            this.calendar[index][i]['public_holiday'] = 0;
                            this.calendar[index][i]['weekend'] = 0;
                            this.calendar[index][i]['description'] = null;
                            this.calendar[index][i]['active'] = true;
                        }
                    });
                });
            },
            onMonthChange(value) {
                console.log('onMonthChange: ', value);
                this.monthRange = Array.from({length: moment(value).daysInMonth()}, (x, i) => moment(value).startOf('month').add(i, 'days'));
                this.generateCalendar();
                // console.log([...this.monthRange].map(date => date.format('YYYY-MM-DD')));
            },
        }
    }
</script>
