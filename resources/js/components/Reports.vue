<template>
    <div>
        <div class = "row" id = "mainSection">
            <div class = "col-md-12 card">
                <div class = "">
                    <div class = "card-header">
                        <h4 class = "card-title">{{page.title}}</h4>
                        <p class = "card-category">{{page.subTitle}}</p>

                    </div>
                    <form :class = "modalEdit.formClass" :style = "modalEdit.formStyle"
                            @submit.prevent = "onModalFormSubmit2(page.ItemGetUrl, modalEdit.form.data(), null, dbQuery, page.vuexKey, modalEdit.formKey)">
                        <div>
                            <div class = "row justify-content-center">
                                <div class = "col-md-12">
                                    <template v-for = "(row, index) of modalEdit.inputs">
                                        <div :class = "row.rowClass" :style = "row.rowStyle">
                                            <template v-for = "(item, index) of row['column']">
                                                <div :class = "item.colClass" :style = "item.colStyle">
                                                    <div :class = "[item.validation.show && item.validation.active && $v.modalEdit.form && $v.modalEdit.form[item.formControlName] && $v.modalEdit.form[item.formControlName].$error ? 'form-group--error' : '', item.formClass]">
                                                        <label :class = "item.label.class" :for = "item.formControlName" :style = "item.label.style" v-html = "item.label.text"
                                                                v-if = "item.label.show"></label>
                                                        <div class = "input-group">
                                                            <div class = "input-group-prepend" v-if = "item.icon.show">
                                                                <span class = "input-group-text" v-html = "item.icon.text"></span>
                                                            </div>
                                                            <input :class = "item.inputClass" :disabled = "item.disabled" :id = "item.formControlName" :name = "item.formControlName"
                                                                    :placeholder = "item.placeHolder" :readonly = "item.readonly" :required = "item.required" :style = "item.inputStyle"
                                                                    :type = "item.type" v-if = "item.inputType === 'text' && item.validation.active === true"
                                                                    v-model = "modalEdit.form[item.formControlName]" v-model.trim = "$v.modalEdit.form[item.formControlName].$model"> <input
                                                                :class = "item.inputClass" :disabled = "item.disabled" :id = "item.formControlName" :name = "item.formControlName"
                                                                :placeholder = "item.placeHolder" :readonly = "item.readonly" :required = "item.required" :style = "item.inputStyle" :type = "item.type"
                                                                v-if = "item.inputType === 'text' && item.validation.active === false" v-model = "modalEdit.form[item.formControlName]">
                                                            <multiselect :allow-empty = "item.multiSelect.allowEmpty" :class = "item.multiSelect.inputClass"
                                                                    :close-on-select = "item.multiSelect.closeOnSelect" :deselect-label = "item.multiSelect.deselectLabel" :disabled = "item.disabled"
                                                                    :hide-selected = "item.multiSelect.hideSelected" :id = "item.formControlName" :label = "item.multiSelect.label"
                                                                    :name = "item.formControlName" :options = "options[item.multiSelect.option_id]" :placeholder = "item.placeHolder"
                                                                    :preselectFirst = "item.multiSelect.preselectFirst" :readonly = "item.readonly" :required = "item.required"
                                                                    :searchable = "item.multiSelect.searchable" :show-labels = "item.multiSelect.showLabels" :style = "item.multiSelect.inputStyle"
                                                                    :track-by = "item.multiSelect.id"
                                                                    @input = "onMultiselectInput3($event, item.formControlName, modalEdit.formKey, item.multiSelect.onInput)"
                                                                    v-if = "item.inputType === 'select'" v-model = "option.modalEdit[item.multiSelect.option_id]"></multiselect>
                                                            <div :class = "item.dateTime.inputClass" :style = "item.dateTime.inputStyle" v-if = "item.inputType === 'dateTime'">
                                                                <el-date-picker :class = "item.dateTime.inputDateClass" :style = "item.dateTime.inputDateStyle" :id = "item.formControlName"
                                                                        :name = "item.formControlName" :placeholder = "item.placeHolder" :disabled = "item.disabled" :readonly = "item.readonly"
                                                                        :required = "item.required" :type = "item.dateTime.type" :align = "item.dateTime.align" :clearable = "item.dateTime.clearable"
                                                                        :editable = "item.dateTime.editable" :range-separator = "item.dateTime.rangeSeparator" :format = "item.dateTime.displayFormat"
                                                                        :value-format = "item.dateTime.valueFormat" :picker-options = "item.dateTime.pickerOptions"
                                                                        v-if = "item.dateTime.type === 'date'" v-model = "modalEdit.form[item.formControlName]"
                                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-date-picker>
                                                                <el-time-picker :class = "item.dateTime.inputDateClass" :style = "item.dateTime.inputDateStyle" :id = "item.formControlName"
                                                                        :name = "item.formControlName" :placeholder = "item.placeHolder" :disabled = "item.disabled" :readonly = "item.readonly"
                                                                        :required = "item.required" :align = "item.dateTime.align" :clearable = "item.dateTime.clearable"
                                                                        :editable = "item.dateTime.editable" :is-range = "item.dateTime.isRange" :arrow-control = "item.dateTime.arrowControl"
                                                                        :range-separator = "item.dateTime.rangeSeparator" :value-format = "item.dateTime.valueFormat"
                                                                        :picker-options = "item.dateTime.pickerOptions" v-if = "item.dateTime.type === 'timePicker'"
                                                                        v-model = "modalEdit.form[item.formControlName]"
                                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-time-picker>
                                                                <el-time-select :class = "item.dateTime.inputDateClass" :style = "item.dateTime.inputDateStyle" :id = "item.formControlName"
                                                                        :name = "item.formControlName" :placeholder = "item.placeHolder" :disabled = "item.disabled" :readonly = "item.readonly"
                                                                        :required = "item.required" :align = "item.dateTime.align" :clearable = "item.dateTime.clearable"
                                                                        :editable = "item.dateTime.editable" :is-range = "item.dateTime.isRange" :arrow-control = "item.dateTime.arrowControl"
                                                                        :range-separator = "item.dateTime.rangeSeparator" :value-format = "item.dateTime.valueFormat"
                                                                        :picker-options = "item.dateTime.pickerOptions" v-if = "item.dateTime.type === 'timeSelect'"
                                                                        v-model = "modalEdit.form[item.formControlName]"
                                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-time-select>
                                                            </div>
                                                        </div>
                                                        <template v-if = "item.validation.active && item.validation.show && $v.modalEdit.form && $v.modalEdit.form[item.formControlName]">
                                                            <div v-for = "(vItem, vKey) of item.validation.validators">
                                                                <div :class = "item.validation.class" v-if = "$v.modalEdit.form[item.formControlName][vKey] === false">
                                                                    {{vItem.message}}
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </template>
                                        </div> <!-- FORM ROW -->
                                    </template>
                                    <div class = "statusDiv" v-if = "modalEdit.statusDiv.show">
                                        <div :class = "[modalEdit.statusDiv.class]" v-for = "statusMsgs in modalEdit.statusDiv.messages">
                                            <p v-html = "statusMsgs"></p>
                                        </div>
                                    </div>
                                    <div style = "text-align: center;">
                                        <button class = "btn btn-danger button-single" type = "submit">
                                            Generate Report <i :class = "[modalEdit.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-save']" aria-hidden = "true"></i>
                                        </button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class = "row" v-if = "report.viewing === true && dataTable['data']">
            <div class = "col-md-12">
                <div class = "card">
                    <div class = "card-header">
                        <h4 class = "card-title" v-html = "report.title"></h4>
                        <div class = "card-category" v-html = "report.subTitle" v-if = "report.subTitle && report.subTitle.length > 0"></div>
                        <div class = "card-category" v-html = "report.dateText" v-if = "report.dateText && report.dateText.length > 0"></div>
                    </div>
                    <br>
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
                                <button @click.prevent = "printDiv(page.print, page.print.printType, dataTable['data'])" class = "btn btn-outline-info btn-12" type = "button">
                                    <i class = "fas fa-print"></i>&nbsp;Print
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
                                        <th :class = "item.class" :style = "item.style" v-if = "item && item.title && item.title.length > 0"
                                                @click.prevent = "sortTableData(item, dbQuery, page.vuexKey)">
                                            {{item.title}} <i class = "fas"
                                                :class = "[dbQuery.sortBy.desc === true ? 'fa-sort-alpha-up-alt' : '', dbQuery.sortBy.desc === false ? 'fa-sort-alpha-down' : '']"
                                                v-if = "item.field && item.field.length > 0 && dbQuery.sortBy.relation === item.relation && dbQuery.sortBy.field === item.field"></i>
                                        </th>
                                    </template>
                                    </thead>
                                    <tbody>
                                    <template v-for = "(item, index) in paginated('items')" v-if = "dataTable && dataTable['data'] && dataTable['data'].length > 0">
                                        <!--<tr v-if = "item['report_header'] && item['report_header']['text'] && getSerialData(index, item, paginated('items'), {rel: 'user', field : 'id'})">
                                            <td colspan = "100%" v-html = "item['report_header']['text']"></td>
                                        </tr>-->
                                        <tr :key = "index" v-if="">
                                            <td @click.prevent = "viewModal(item['modalViewData'])" v-for = "(value, i) in item['TableViewData']" v-html = "value"></td>
                                        </tr>
                                    </template>
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
    import ModalView from './modals/ModalView.vue';

    export default {
        mixins  : [FormMixin],
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
                page          : {
                    title      : 'Reports',
                    subTitle   : 'View various Reports',
                    vuexKey    : 'report',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    ItemGetUrl : '/api/v1/auth/report-generator',
                    print      : {},
                    headers    : []
                },
                report        : {
                    title   : 'Report',
                    subTitle: '',
                    dateText: '',
                    viewing : false,
                },
                paginate      : ['items'],
                /*dataForm   : {
                    report_id           : null,
                    attendance_status_id: null,
                    shift_id            : null,
                    active              : null,
                },*/
                modalEdit     : {
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
                        text      : 'Report Generate',
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
                        report_id           : null,
                        date_from           : null,
                        date_to             : null,
                        user_id             : null,
                        shift_id            : null,
                        attendance_status_id: null,
                        attendance_method_id: null,
                        department_id       : null,
                        designation_id      : null,
                        employement_type    : null,
                        active              : null,
                    }),
                    formClass   : 'form-modal paper-form',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputList   : {
                        report_id           : {
                            label          : {
                                show : true,
                                text : 'Report Type',
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
                            colClass       : 'col-3',
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
                                option_id     : 'report_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : 'switch_input'
                            },
                            placeHolder    : 'Select Report Type',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'report_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Report Type',
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Report Type is Required'
                                    },
                                },
                            },
                        },
                        date_from           : {
                            label          : {
                                show : true,
                                text : 'Date From (Optional)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class="far fa-calendar-alt"></i>',
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
                            placeHolder    : 'Select Date From',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date_from',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Date From', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Date From is Required'
                                    },
                                },
                            },
                        },
                        date_to             : {
                            label          : {
                                show : true,
                                text : 'Date To (Optional)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class="far fa-calendar-alt"></i>',
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
                            placeHolder    : 'Select Date To',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'date_to',
                            validation     : {
                                active    : false,
                                show      : false,
                                label     : 'Date To', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Date To is Required'
                                    },
                                },
                            },
                        },
                        user_id             : {
                            label          : {
                                show : true,
                                text : 'Employee (for Individual Report)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "fas fa-user-tie"></i>',
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
                        shift_id            : {
                            label          : {
                                show : true,
                                text : 'Shift (Optional)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class="fab fa-shirtsinbulk"></i>',
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
                                option_id     : 'shift_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Shift',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'shift_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Shift', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Shift is Required'
                                    },
                                },
                            },
                        },
                        attendance_status_id: {
                            label          : {
                                show : true,
                                text : 'Attendance Status (Optional)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class="fas fa-hand-paper"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col-3',
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
                                option_id     : 'attendance_status_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Attendance Status',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'attendance_status_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Attendance Status', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Attendance Status is Required'
                                    },
                                },
                            },
                        },
                        attendance_method_id: {
                            label          : {
                                show : true,
                                text : 'Attendance Method (Optional)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class="fas fa-cash-register"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
                            rowClass       : 'form-row',
                            rowStyle       : '',
                            colClass       : 'col-3',
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
                                option_id     : 'attendance_method_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Attendance Method',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'attendance_method_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Attendance Status', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Attendance Method is Required'
                                    },
                                },
                            },
                        },
                        department_id       : {
                            label          : {
                                show : true,
                                text : 'Department (Optional)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class="fas fa-building"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
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
                                option_id     : 'department_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : ''
                            },
                            placeHolder    : 'Select Department',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'department_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Department',
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Department is Required'
                                    },
                                },
                            },
                        },
                        designation_id      : {
                            label          : {
                                show : true,
                                text : 'Designation (Optional)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class="fas fa-briefcase"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
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
                                option_id     : 'designation_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : ''
                            },
                            placeHolder    : 'Select Designation',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'designation_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Designation',
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Designation is Required'
                                    },
                                },
                            },
                        },
                        employement_type    : {
                            label          : {
                                show : true,
                                text : 'Employement Type (Optional)',
                                class: '',
                                style: '',
                            },
                            icon           : {
                                show : true,
                                text : '<i class="fas fa-user"></i>',
                                class: '',
                                style: '',
                            },
                            inputType      : 'select',
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
                                option_id     : 'employement_type',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : ''
                            },
                            placeHolder    : 'Select Employement Type',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'employement_type',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Employement Type',
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Employement Type is Required'
                                    },
                                },
                            },
                        },
                        active              : {
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
                    inputs      : [],
                },
                dbQueryList   : [
                    // Modal WITH relationship is auto called. Wierd.
                    // Modal WITH matchThese or WhereHas.
                    // Select Array index based on report_id: report_id - 1
                    // 0=>1: Attendance:
                    {
                        table         : 'Attendance',
                        tableWith     : {
                            'user': {
                                matchThese: {},
                                orThose   : {},
                                select    : [
                                    'id',
                                    'employee_no',
                                    'name',
                                    'email',
                                    'role_id',
                                    'department_id',
                                    'designation_id',
                                    'pay_rate',
                                    'pay_rate_unit_type_id',
                                    'shift_id',
                                    'work_days',
                                    'employement_type',
                                    'photo',
                                ],// '*'
                                groupBy   : 'id',
                                addSelect : [
                                    // 'SUM(pay_rate) as pay_rate_total',
                                ],
                            },
                        },
                        matchThese    : {
                            'user_id'             : {
                                type      : 'request', // static, request, /auth, relation
                                columnName: 'user_id',
                                operator  : '=',
                                value     : 'user_id',
                            },
                            'shift_id'            : {
                                type      : 'request',
                                columnName: 'shift_id',
                                operator  : '=',
                                value     : 'shift_id',
                            },
                            'attendance_status_id': {
                                type      : 'request',
                                columnName: 'attendance_status_id',
                                operator  : '=',
                                value     : 'attendance_status_id',
                            },
                            'attendance_method_id': {
                                type      : 'request',
                                columnName: 'attendance_method_id',
                                operator  : '=',
                                value     : 'attendance_method_id',
                            },
                        },
                        orThose       : {},
                        search        : {
                            text  : '',
                            fields: [],
                        },
                        whereHas      : {
                            'user': {
                                relation  : 'user',
                                selectRaw : null, // 'SUM(std_time) as std_time_total' || NULL
                                matchThese: {
                                    'department_id'   : {
                                        type      : 'request', // static, request, /auth, relation
                                        columnName: 'department_id',
                                        operator  : '=',
                                        value     : 'department_id',
                                    },
                                    'designation_id'  : {
                                        type      : 'request', // static, request, /auth, relation
                                        columnName: 'designation_id',
                                        operator  : '=',
                                        value     : 'designation_id',
                                    },
                                    'employement_type': {
                                        type      : 'request',
                                        columnName: 'employement_type',
                                        operator  : '=',
                                        value     : 'employement_type',
                                    }
                                },
                                orThose   : null,
                            },
                        },
                        withCount     : [
                            'user',
                        ],
                        withCountWhere: {},
                        addSelect     : [
                            'SUM(time_in) as time_in_total',
                        ],
                        select        : [
                            'id',
                            'user_id',
                            'date',
                            'shift_id',
                            'time_in',
                            'time_out',
                            'attendance_method_id',
                            'attendance_status_id',
                            'remark',
                            'description',
                            'photo',
                            'branch_id',
                            'entryby_id',
                            'active',
                            'status',
                        ], // '*'
                        sortBy        : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        pluck         : [],
                        groupBy       : 'id',
                    },
                    // 1=>2: : Overtime:
                    {
                        table         : 'Attendance',
                        tableWith     : {
                            'user': {
                                matchThese: {},
                                orThose   : {},
                                select    : [
                                    'id',
                                    'employee_no',
                                    'name',
                                    'email',
                                    'role_id',
                                    'department_id',
                                    'designation_id',
                                    'pay_rate',
                                    'pay_rate_unit_type_id',
                                    'shift_id',
                                    'work_days',
                                    'employement_type',
                                    'photo',
                                ],// '*'
                                groupBy   : 'id',
                                addSelect : [
                                    // 'SUM(pay_rate) as pay_rate_total',
                                ],
                            },
                        },
                        matchThese    : {
                            'user_id' : {
                                type      : 'request', // static, request, /auth, relation
                                columnName: 'user_id',
                                operator  : '=',
                                value     : 'user_id',
                            },
                            'shift_id': {
                                type      : 'request',
                                columnName: 'shift_id',
                                operator  : '=',
                                value     : 'shift_id',
                            },
                        },
                        orThose       : {},
                        search        : {
                            text  : '',
                            fields: [],
                        },
                        whereHas      : {
                            'user': {
                                relation  : 'user',
                                selectRaw : null, // 'SUM(std_time) as std_time_total' || NULL
                                matchThese: {
                                    'department_id'   : {
                                        type      : 'request', // static, request, /auth, relation
                                        columnName: 'department_id',
                                        operator  : '=',
                                        value     : 'department_id',
                                    },
                                    'designation_id'  : {
                                        type      : 'request', // static, request, /auth, relation
                                        columnName: 'designation_id',
                                        operator  : '=',
                                        value     : 'designation_id',
                                    },
                                    'employement_type': {
                                        type      : 'request',
                                        columnName: 'employement_type',
                                        operator  : '=',
                                        value     : 'employement_type',
                                    }
                                },
                                orThose   : null,
                            },
                        },
                        withCount     : [
                            'user',
                        ],
                        withCountWhere: {},
                        addSelect     : [
                            'SUM(time_in) as time_in_total',
                        ],
                        select        : [
                            'id',
                            'user_id',
                            'date',
                            'shift_id',
                            'time_in',
                            'time_out',
                            'attendance_method_id',
                            'attendance_status_id',
                            'remark',
                            'description',
                            'photo',
                            'branch_id',
                            'entryby_id',
                            'active',
                            'status',
                        ], // '*'
                        sortBy        : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        pluck         : [],
                        groupBy       : 'id',
                    },
                    // 2=>3: LATE:
                    {
                        table         : 'Attendance',
                        tableWith     : {
                            'user': {
                                matchThese: {},
                                orThose   : {},
                                select    : [
                                    'id',
                                    'employee_no',
                                    'name',
                                    'email',
                                    'role_id',
                                    'department_id',
                                    'designation_id',
                                    'pay_rate',
                                    'pay_rate_unit_type_id',
                                    'shift_id',
                                    'work_days',
                                    'employement_type',
                                    'photo',
                                ],// '*'
                                groupBy   : 'id',
                                addSelect : [
                                    // 'SUM(pay_rate) as pay_rate_total',
                                ],
                            },
                        },
                        matchThese    : {
                            'user_id' : {
                                type      : 'request', // static, request, /auth, relation
                                columnName: 'user_id',
                                operator  : '=',
                                value     : 'user_id',
                            },
                            'shift_id': {
                                type      : 'request',
                                columnName: 'shift_id',
                                operator  : '=',
                                value     : 'shift_id',
                            },
                        },
                        orThose       : {},
                        search        : {
                            text  : '',
                            fields: [],
                        },
                        whereHas      : {
                            'user': {
                                relation  : 'user',
                                selectRaw : null, // 'SUM(std_time) as std_time_total' || NULL
                                matchThese: {
                                    'department_id'   : {
                                        type      : 'request', // static, request, /auth, relation
                                        columnName: 'department_id',
                                        operator  : '=',
                                        value     : 'department_id',
                                    },
                                    'designation_id'  : {
                                        type      : 'request', // static, request, /auth, relation
                                        columnName: 'designation_id',
                                        operator  : '=',
                                        value     : 'designation_id',
                                    },
                                    'employement_type': {
                                        type      : 'request',
                                        columnName: 'employement_type',
                                        operator  : '=',
                                        value     : 'employement_type',
                                    }
                                },
                                orThose   : null,
                            },
                        },
                        withCount     : [
                            'user',
                        ],
                        withCountWhere: {},
                        addSelect     : [
                            'SUM(time_in) as time_in_total',
                        ],
                        select        : [
                            'id',
                            'user_id',
                            'date',
                            'shift_id',
                            'time_in',
                            'time_out',
                            'attendance_method_id',
                            'attendance_status_id',
                            'remark',
                            'description',
                            'photo',
                            'branch_id',
                            'entryby_id',
                            'active',
                            'status',
                        ], // '*'
                        sortBy        : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        pluck         : [],
                        groupBy       : 'id',
                    },
                    // 3=>4: Absent:
                    {
                        table         : 'Users',
                        tableWith     : {},
                        matchThese    : {},
                        orThose       : {},
                        search        : {
                            text  : '',
                            fields: [],
                        },
                        whereHas      : {},
                        withCount     : [],
                        withCountWhere: {},
                        addSelect     : [],
                        select        : [
                            'id',
                            'order_no',
                            'order_date',
                            'quantity',
                            'description',
                            'photo',
                            'branch_id',
                            'entryby_id',
                            'active',
                            'status',
                        ], // '*'
                        sortBy        : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        pluck         : [],
                        groupBy       : 'id',
                    },
                    // 4=>5: Leave:
                    {
                        table         : 'Attendance',
                        tableWith     : {
                            'user': {
                                matchThese: {},
                                orThose   : {},
                                select    : [
                                    'id',
                                    'employee_no',
                                    'name',
                                    'email',
                                    'role_id',
                                    'department_id',
                                    'designation_id',
                                    'pay_rate',
                                    'pay_rate_unit_type_id',
                                    'shift_id',
                                    'work_days',
                                    'employement_type',
                                    'photo',
                                ],// '*'
                                groupBy   : 'id',
                                addSelect : [
                                    // 'SUM(pay_rate) as pay_rate_total',
                                ],
                            },
                        },
                        matchThese    : {
                            'user_id'             : {
                                type      : 'request', // static, request, /auth, relation
                                columnName: 'user_id',
                                operator  : '=',
                                value     : 'user_id',
                            },
                            'shift_id'            : {
                                type      : 'request',
                                columnName: 'shift_id',
                                operator  : '=',
                                value     : 'shift_id',
                            },
                            'attendance_status_id': {
                                type      : 'static',
                                columnName: 'attendance_status_id',
                                operator  : '=',
                                value     : 4, // LEAVE
                            },
                        },
                        orThose       : {},
                        search        : {
                            text  : '',
                            fields: [],
                        },
                        whereHas      : {
                            'user': {
                                relation  : 'user',
                                selectRaw : null, // 'SUM(std_time) as std_time_total' || NULL
                                matchThese: {
                                    'department_id'   : {
                                        type      : 'request', // static, request, /auth, relation
                                        columnName: 'department_id',
                                        operator  : '=',
                                        value     : 'department_id',
                                    },
                                    'designation_id'  : {
                                        type      : 'request', // static, request, /auth, relation
                                        columnName: 'designation_id',
                                        operator  : '=',
                                        value     : 'designation_id',
                                    },
                                    'employement_type': {
                                        type      : 'request',
                                        columnName: 'employement_type',
                                        operator  : '=',
                                        value     : 'employement_type',
                                    }
                                },
                                orThose   : null,
                            },
                        },
                        withCount     : [
                            'user',
                        ],
                        withCountWhere: {},
                        addSelect     : [
                            'SUM(time_in) as time_in_total',
                        ],
                        select        : [
                            'id',
                            'user_id',
                            'date',
                            'shift_id',
                            'time_in',
                            'time_out',
                            'attendance_method_id',
                            'attendance_status_id',
                            'remark',
                            'description',
                            'photo',
                            'branch_id',
                            'entryby_id',
                            'active',
                            'status',
                        ], // '*'
                        sortBy        : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        pluck         : [],
                        groupBy       : 'id',
                    },
                    // 5=>6: Overall:
                    {
                        table         : 'Users',
                        tableWith     : {},
                        matchThese    : {},
                        orThose       : {},
                        search        : {
                            text  : '',
                            fields: [],
                        },
                        whereHas      : {},
                        withCount     : [],
                        withCountWhere: {},
                        addSelect     : [],
                        select        : [
                            'id',
                            'order_no',
                            'order_date',
                            'quantity',
                            'description',
                            'photo',
                            'branch_id',
                            'entryby_id',
                            'active',
                            'status',
                        ], // '*'
                        sortBy        : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        pluck         : [],
                        groupBy       : 'id',
                    },
                    // 6=>7: Overall (Consolidate):
                    {
                        table         : 'Users',
                        tableWith     : {},
                        matchThese    : {},
                        orThose       : {},
                        search        : {
                            text  : '',
                            fields: [],
                        },
                        whereHas      : {},
                        withCount     : [],
                        withCountWhere: {},
                        addSelect     : [],
                        select        : [
                            'id',
                            'order_no',
                            'order_date',
                            'quantity',
                            'description',
                            'photo',
                            'branch_id',
                            'entryby_id',
                            'active',
                            'status',
                        ], // '*'
                        sortBy        : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        pluck         : [],
                        groupBy       : 'id',
                    },
                    // OTHER: SAVED:
                    {
                        table         : 'Orders',
                        tableWith     : {},
                        matchThese    : {},
                        orThose       : {},
                        whereHas      : {},
                        withCount     : [],
                        withCountWhere: {},
                        addSelect     : [
                            'SUM(quantity) as quantity_total',
                        ],
                        select        : [
                            'id',
                            'order_no',
                            'order_date',
                            'quantity',
                            'description',
                            'photo',
                            'branch_id',
                            'entryby_id',
                            'active',
                            'status',
                        ], // '*'
                        pluck         : [],
                        groupBy       : 'id',
                    },
                    // OTHER: SAVED:
                    {
                        table         : 'WorkDone',
                        tableWith     : {
                            'worker'   : {
                                matchThese: {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 0,
                                    },
                                },
                                orThose   : {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 1,
                                    },
                                },
                                select    : [
                                    'id',
                                    'worker_no',
                                    'name',
                                    'active',
                                ],// '*'
                                groupBy   : 'id',
                                addSelect : [
                                    'SUM(pay_rate) as pay_rate_total',
                                    'SUM(pay_rate) as pay_rate_total5'
                                ],
                            },
                            'article'  : {
                                matchThese: {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 1,
                                    },
                                },
                                orThose   : {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 0,
                                    },
                                },
                                select    : [
                                    'id',
                                    'name',
                                    'active',
                                ]
                            },
                            'operation': {
                                matchThese: {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 1,
                                    },
                                },
                                orThose   : {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 0,
                                    },
                                },
                                select    : [
                                    'id',
                                    'name',
                                    'active',
                                ]
                            },
                        },
                        /*matchThese     : {
                            'active'     : {
                                type       : 'static', // static, request, /auth, relation
                                columnName : 'active',
                                operator   : '=',
                                value      : 1,
                            },
                            'article_id' : {
                                type       : 'request',
                                columnName : 'article_id',
                                operator   : '=',
                                value      : 'article_id',
                            },
                        },
                        orThose        : {
                            'active' : {
                                type       : 'static', // static, request, /auth, relation
                                columnName : 'active',
                                operator   : '=',
                                value      : 1,
                            },
                        },*/
                        whereHas      : {
                            'operation': {
                                relation  : 'operation',
                                selectRaw : 'SUM(std_time) as std_time_total', // 'SUM(std_time) as std_time_total' || NULL
                                matchThese: {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 1,
                                    },
                                },
                                orThose   : null,
                            },
                        },
                        withCount     : [
                            'article',
                        ],
                        withCountWhere: {
                            'operation': {
                                relation  : 'operation AS operational',
                                selectRaw : 'SUM(std_time) as std_time_total', // 'SUM(std_time) as std_time_total' || NULL
                                matchThese: {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 1,
                                    },
                                },
                                orThose   : {
                                    'active': {
                                        type      : 'static', // static, request, /auth, relation
                                        columnName: 'active',
                                        operator  : '=',
                                        value     : 0,
                                    },
                                },
                            },
                        },
                        addSelect     : [
                            'SUM(quantity) as commision_total',
                            'SUM(quantity) as commision_total5'
                        ],
                        select        : [
                            'id',
                            'work_done_no',
                            'worker_id',
                            'article_id',
                            'operation_id',
                            'work_date',
                            'quantity',
                            'description',
                            'active',
                        ], // '*'
                        pluck         : [
                            'work_done_no',
                            'worker_id',
                        ],
                        groupBy       : 'id',
                    },
                ],
                dbQuery       : {},
                dbInputs      : [
                    {
                        key       : 'report_id',
                        table     : 'ReportTypes',
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
                        key       : 'shift_id',
                        table     : 'Shifts',
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
                        key       : 'attendance_status_id',
                        table     : 'AttendanceStatus',
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
                        key       : 'attendance_method_id',
                        table     : 'AttendanceMethod',
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
                        key       : 'designation_id',
                        table     : 'Designations',
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
                        key       : 'department_id',
                        table     : 'Departments',
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
                options       : {
                    report_id           : [],
                    user_id             : [],
                    shift_id            : [],
                    attendance_status_id: [],
                    attendance_method_id: [],
                    designation_id      : [],
                    department_id       : [],
                    employement_type    : [],
                    active              : [],
                },
                option        : {
                    modalEdit: {
                        report_id           : {},
                        user_id             : {},
                        shift_id            : {},
                        attendance_status_id: {},
                        attendance_method_id: {},
                        designation_id      : {},
                        department_id       : {},
                        employement_type    : {},
                        active              : {},
                    }
                },
                optionSet     : {
                    active          : [
                        {
                            id  : 1,
                            name: 'Active',
                        },
                        {
                            id  : 0,
                            name: 'Inactive',
                        }
                    ],
                    employement_type: [
                        {
                            id  : 'Full Time',
                            name: 'Full Time',
                        },
                        {
                            id  : 'Part Time',
                            name: 'Part Time',
                        },
                    ],
                },
                validations   : null,
                validationList: {
                    first : {
                        report_id           : {
                            required,
                        },
                        date_from           : {},
                        date_to             : {},
                        user_id             : {},
                        shift_id            : {},
                        attendance_status_id: {},
                        attendance_method_id: {},
                        department_id       : {},
                        designation_id      : {},
                        employement_type    : {},
                        active              : {},
                    },
                    second: {
                        report_id           : {
                            required,
                        },
                        date_from           : {},
                        date_to             : {},
                        user_id             : {
                            required,
                        },
                        shift_id            : {},
                        attendance_status_id: {},
                        attendance_method_id: {},
                        department_id       : {},
                        designation_id      : {},
                        employement_type    : {},
                        active              : {},
                    }
                }
            }
        },
        validations() {
            if (this.validations) {
                return {
                    modalEdit: {
                        form: this.validations
                    }
                }
            } else {
                return {
                    modalEdit: {
                        form: {}
                    }
                }
            }
        },
        created() {
            // this.setLayout('layout-dashboard');
            this.inputDefaults();
            this.getFormInputs(this.FormInputsAPI, null, this.dbInputs, null, this.optionSet, null);
            console.log('created: ', this.page.title, ': ', this.$route.params);
        },
        mounted() {
        },
        computed: {
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
        methods : {
            viewModal(data) {
                // console.log('viewModal: ', data, this.modalView.data, this.modalView.tableView);
                this.$modal.show(ModalView, {
                    params: {
                        modalView: this.modalView,
                        print    : this.page.print,
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
                    // width       : this.modalView.options.width,
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
            inputDefaults() {
                this.validations      = this.validationList.first;
                this.modalEdit.inputs = [
                    {
                        rowClass: 'form-row',
                        rowStyle: '',
                        column  : [
                            this.modalEdit.inputList.report_id,
                            // this.modalEdit.inputList.date_from,
                            // this.modalEdit.inputList.date_to,
                            // this.modalEdit.inputList.user_id,
                        ],
                    },
                    /*{
                        rowClass: 'form-row',
                        rowStyle: '',
                        column  : [
                            this.modalEdit.inputList.shift_id,
                            this.modalEdit.inputList.employement_type,
                            this.modalEdit.inputList.designation_id,
                            this.modalEdit.inputList.department_id,
                        ],
                    },
                    {
                        rowClass: 'form-row',
                        rowStyle: '',
                        column  : [
                            this.modalEdit.inputList.attendance_status_id,
                            this.modalEdit.inputList.attendance_method_id,
                        ],
                    },*/
                ];
                this.nullifyFormFields(this.modalEdit.formKey, [
                    'report_id',
                    'date_from',
                    'date_to',
                    'user_id',
                    'shift_id',
                    'employement_type',
                    'designation_id',
                    'department_id',
                    'attendance_status_id',
                    'attendance_method_id',
                    'active',
                ]);
            },
            // generateModalView
            generateModalView(modalViewData) {
                console.log('generateModalView: ', modalViewData);
                let tableTRView = '';
                for (let i in modalViewData) {
                    if (modalViewData.hasOwnProperty(i)) {
                        tableTRView += `<tr>`;
                        for (let key in modalViewData[i]) {
                            if (modalViewData[i].hasOwnProperty(key)) {
                                tableTRView += `
                                    <td class = "` + modalViewData[i][key].class + `" style = "` + modalViewData[i][key].style + `" scope="` + modalViewData[i][key].scope + `" colspan="` + modalViewData[i][key].span + `">` + modalViewData[i][key].data + `</td>
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
