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
                    <div :class = "user && user['role'] && user['role']['name'] && (user['role']['name'] === 'Admin' || user['role']['name'] === 'HR') ? 'col-8' : 'col-8'">
                        <div class = "card">
                            <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                <div class = "card-title-2">Change Password</div>
                                <form :class = "modalEdit.formClass" :style = "modalEdit.formStyle"
                                        @submit.prevent = "onModalFormSubmit2(passwordChangeUrl, modalEdit.form.data(), modalEdit.dbInsert, null, null, modalEdit.formKey)">
                                    <div class = "row justify-content-center">
                                        <div class = "col">
                                            <template v-for = "(item, index) of modalEdit.inputs">
                                                <div :class = "item.rowClass" :style = "item.rowStyle">
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
                                                                    :placeholder = "item.placeHolder" :readonly = "item.readonly" :required = "item.required" :style = "item.inputStyle"
                                                                    :type = "item.type" v-if = "item.inputType === 'text' && item.validation.active === false"
                                                                    v-model = "modalEdit.form[item.formControlName]">
                                                                <multiselect :allow-empty = "item.multiSelect.allowEmpty" :class = "item.multiSelect.inputClass"
                                                                        :close-on-select = "item.multiSelect.closeOnSelect" :deselect-label = "item.multiSelect.deselectLabel"
                                                                        :disabled = "item.disabled" :hide-selected = "item.multiSelect.hideSelected" :id = "item.formControlName"
                                                                        :label = "item.multiSelect.label" :name = "item.formControlName" :options = "options[item.multiSelect.option_id]"
                                                                        :placeholder = "item.placeHolder" :preselectFirst = "item.multiSelect.preselectFirst" :readonly = "item.readonly"
                                                                        :required = "item.required" :searchable = "item.multiSelect.searchable" :show-labels = "item.multiSelect.showLabels"
                                                                        :style = "item.multiSelect.inputStyle" :track-by = "item.multiSelect.id"
                                                                        @input = "onMultiselectInput2($event, item.formControlName, modalEdit.formKey)" v-if = "item.inputType === 'select'"
                                                                        v-model = "option.modalEdit[item.multiSelect.option_id]"></multiselect>
                                                                <div :class = "item.dateTime.inputClass" :style = "item.dateTime.inputStyle" v-if = "item.inputType === 'dateTime'">
                                                                    <el-date-picker :class = "item.dateTime.inputDateClass" :style = "item.dateTime.inputDateStyle" :id = "item.formControlName"
                                                                            :name = "item.formControlName" :placeholder = "item.placeHolder" :disabled = "item.disabled" :readonly = "item.readonly"
                                                                            :required = "item.required" :type = "item.dateTime.type" :align = "item.dateTime.align"
                                                                            :clearable = "item.dateTime.clearable" :editable = "item.dateTime.editable"
                                                                            :range-separator = "item.dateTime.rangeSeparator" :format = "item.dateTime.displayFormat"
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
                                                </div> <!-- FORM ROW -->
                                            </template>
                                            <div class = "statusDiv" v-if = "modalEdit.statusDiv.show">
                                                <div :class = "[modalEdit.statusDiv.class]" v-for = "statusMsgs in modalEdit.statusDiv.messages">
                                                    <p v-html = "statusMsgs"></p>
                                                </div>
                                            </div>
                                            <div style = "text-align: center;">
                                                <button class = "btn btn-warning button-single" type = "submit">
                                                    Update Password <i :class = "[modalEdit.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-save']" aria-hidden = "true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                page             : {
                    title      : 'Settings',
                    subTitle   : 'Manage Various Settings',
                    vuexKey    : 'settings',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    headers    : [],
                },
                paginate         : ['items'],
                passwordChangeUrl: '/api/v1/auth/password-change',
                dataForm         : {
                    id                       : 0,
                    /*current_password    : null,
                    new_password        : null,
                    confirm_new_password: null,*/
                    currency_name            : null,
                    currency_text            : null,
                    currency_symbol          : null,
                    currency_conversation_usd: null,
                    work_days                : null,
                    working_days_per_month   : null,
                    working_hours_per_day    : null,
                    break_min_per_shift      : null,
                    overtime_count_after     : null,
                    overtime_max_hours       : null,
                    overtime_rate_workday    : null,
                    overtime_rate_weekend    : null,
                    overtime_rate_holiday    : null,
                    description              : null,
                    active                   : null,
                },
                modalEdit        : {
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
                        text      : 'Edit Password',
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
                        id                  : 0,
                        current_password    : null,
                        new_password        : null,
                        confirm_new_password: null,
                        /*start_date           : new Date(),
                        start_date2          : [
                            new Date(),
                            new Date()
                        ],*/
                    }),
                    formClass   : 'form-modal paper-form',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputs      : [
                        /*{
                            label           : {
                                show  : true,
                                text  : 'Article',
                                class : '',
                                style : '',
                            },
                            icon            : {
                                show  : true,
                                text  : '<i class = "far fa-newspaper"></i>',
                                class : '',
                                style : '',
                            },
                            inputType       : 'dateTime',
                            rowClass        : 'form-row',
                            rowStyle        : '',
                            colClass        : 'col',
                            colStyle        : '',
                            formClass       : 'form-group',
                            inputClass      : 'form-control',
                            inputStyle      : '',
                            type            : 'dateTime',
                            dateTime        : {
                                type                : "text", // inline, text
                                inputClass          : 'form-control no-padding',
                                inputStyle          : '',
                                inputDateClass      : 'datepicker-custom',
                                inputDateStyle      : '',
                                inputDateInputClass : '',
                                inputDatePopupClass : '',
                                clearable           : true,
                                showButtons         : false,
                                rangeSeparator      : '~',
                                disableDate         : {
                                    active : true,
                                    range  : [
                                        0,
                                        6
                                    ]
                                },
                                format              : 'DD/MM/YYYY HH:mm:ss',
                                onConfirm           : '',
                                onClear             : '',
                                onCancel            : '',
                            },
                            placeHolder     : 'Select Article Date',
                            required        : true,
                            readonly        : false,
                            disabled        : false,
                            value           : null,
                            formControlName : 'start_date',
                            validation      : {
                                active     : false,
                                show       : false,
                                label      : 'Article Name', // Validation Error Label
                                class      : 'error',
                                style      : '',
                                validators : {
                                    required  : {
                                        message : 'Field is Required'
                                    },
                                    minLength : {
                                        value   : 1,
                                        message : 'Min length can not be less than 1'
                                    },
                                },
                            },
                        },*/
                        {
                            label          : {
                                show : true,
                                text : 'Current Password',
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
                            type           : 'password',
                            placeHolder    : 'Current Password',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'current_password',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Current Password', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required : {
                                        message: 'Current Password is Required'
                                    },
                                    minLength: {
                                        value  : 4,
                                        message: 'Password must be atleast 4 char long'
                                    },
                                    maxLength: {
                                        value  : 24,
                                        message: 'Password can not be more than 24 char long'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'New Password',
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
                            type           : 'password',
                            placeHolder    : 'New Password',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'new_password',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'New Password', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required      : {
                                        message: 'New Password is Required'
                                    },
                                    minLength     : {
                                        value  : 4,
                                        message: 'Password must be atleast 4 char long'
                                    },
                                    maxLength     : {
                                        value  : 24,
                                        message: 'Password can not be more than 24 char long'
                                    },
                                    sameAsPassword: {
                                        message: 'The current password and new password can not be same.'
                                    },
                                },
                            },
                        },
                        {
                            label          : {
                                show : true,
                                text : 'Confirm New Password',
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
                            type           : 'password',
                            placeHolder    : 'Confirm New Password',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'confirm_new_password',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Confirm New Password', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required      : {
                                        message: 'Confirm New Password is Required'
                                    },
                                    minLength     : {
                                        value  : 4,
                                        message: 'Password must be atleast 4 char long'
                                    },
                                    maxLength     : {
                                        value  : 24,
                                        message: 'Password can not be more than 24 char long'
                                    },
                                    sameAsPassword: {
                                        message: 'The new password and confirm new password must match.'
                                    },
                                },
                            },
                        },
                    ],
                    dbInsert    : {
                        table             : 'User',
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
                                'User',
                                'Parent',
                            ],
                        },
                        actionType        : 'edit_settings',
                        sentAsFormData    : false,
                        storeInEdits      : true,
                        validations       : {
                            'id'                  : 'required|min:1|max:14',
                            'current_password'    : 'required|min:4|max:24',
                            'new_password'        : 'required|min:4|max:24',
                            'confirm_new_password': 'required|min:4|max:24|same:new_password',
                            'api_ver'             : 'max:8',
                            'app_ver'             : 'max:8',
                            'app_build_ver'       : 'max:8',
                            'u_agent'             : 'max:255',
                            'ipAddress'           : 'max:128',
                        },
                        unique            : {
                            'id': '|unique:users,id,',
                        },
                    },
                },
                modalEdit2       : {
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
                        text      : 'Edit System Settings',
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
                        id                       : 0,
                        currency_name            : null,
                        currency_text            : null,
                        currency_symbol          : null,
                        currency_conversation_usd: null,
                        work_days                : null,
                        working_days_per_month   : null,
                        working_hours_per_day    : null,
                        break_min_per_shift      : null,
                        overtime_count_after     : null,
                        overtime_max_hours       : null,
                        overtime_rate_workday    : null,
                        overtime_rate_weekend    : null,
                        overtime_rate_holiday    : null,
                        description              : null,
                        photo                    : null,
                        branch_id                : null,
                        active                   : null,
                        entryby_id               : null,
                        entry_type_id            : 1,
                        api_ver                  : '1.0',
                        app_ver                  : '1.0.0',
                        app_build_ver            : 1,
                    }),
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalEdit2',
                    inputs      : {
                        'currency_name'            : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'currency_name',
                        },
                        'currency_text'            : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'currency_text',
                        },
                        'currency_symbol'          : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'currency_symbol',
                        },
                        'currency_conversation_usd': {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'currency_conversation_usd',
                        },
                        'work_days'                : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'work_days',
                            multiSelect    : {
                                option_id: 'work_days',
                            },
                        },
                        'working_days_per_month'   : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'working_days_per_month',
                        },
                        'working_hours_per_day'    : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'working_hours_per_day',
                        },
                        'break_min_per_shift'      : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'break_min_per_shift',
                        },
                        'overtime_count_after'     : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'overtime_count_after',
                        },
                        'overtime_max_hours'       : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'overtime_max_hours',
                        },
                        'overtime_rate_workday'    : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'overtime_rate_workday',
                        },
                        'overtime_rate_weekend'    : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'overtime_rate_weekend',
                        },
                        'overtime_rate_holiday'    : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'overtime_rate_holiday',
                        },
                    },
                    dbInsert    : {
                        table             : 'Settings',
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
                        actionType        : 'edit_settings',
                        sentAsFormData    : false,
                        fileUploads       : {
                            active: false,
                            strict: true,
                            files : {
                                photo: {
                                    saveAsString: true,
                                    active      : false,
                                    files       : [],
                                    imageSrc    : null,
                                    storeType   : 'update', // create, update
                                    table       : 'User',
                                    field       : 'photo',
                                    storePath   : 'uploads/settings/',
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
                            'id'                       : 'required|min:1|max:14',
                            'currency_name'            : 'required|min:1|max:64',
                            'currency_text'            : 'required|min:1|max:64',
                            'currency_symbol'          : 'required|min:1|max:8',
                            'currency_conversation_usd': 'required|numeric|min:1|max:16',
                            'work_days'                : 'required|min:1',
                            'working_days_per_month'   : 'required|numeric|min:0|max:31',
                            'working_hours_per_day'    : 'required|numeric|min:0|max:24',
                            'break_min_per_shift'      : 'required|numeric|min:0|max:1440',
                            'overtime_count_after'     : 'required|numeric|min:0|max:1440',
                            'overtime_max_hours'       : 'required|numeric|min:0|max:24',
                            'overtime_rate_workday'    : 'required|numeric|max:10000',
                            'overtime_rate_weekend'    : 'required|numeric|max:10000',
                            'overtime_rate_holiday'    : 'required|numeric|max:10000',
                            'description'              : 'max:512',
                            'active'                   : 'max:2',
                            'branch_id'                : 'max:14',
                            'api_ver'                  : 'max:8',
                            'app_ver'                  : 'max:8',
                            'app_build_ver'            : 'max:8',
                            'u_agent'                  : 'max:255',
                            'ipAddress'                : 'max:128',
                        },
                        unique            : {
                            'id': '|unique:settings,id,',
                        },
                    },
                },
                dbInputs         : [
                    {
                        key       : 'work_days',
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
                dbQuery          : {
                    settings: {
                        table     : 'Settings',
                        tableWith : [],
                        matchThese: [
                            [
                                'active',
                                '=',
                                1
                            ],
                            [
                                'id',
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
                            'id'                       : 'id',
                            'currency_name'            : 'currency_name',
                            'currency_text'            : 'currency_text',
                            'currency_symbol'          : 'currency_symbol',
                            'currency_conversation_usd': 'currency_conversation_usd',
                            'work_days'                : 'work_days',
                            'working_days_per_month'   : 'working_days_per_month',
                            'working_hours_per_day'    : 'working_hours_per_day',
                            'break_min_per_shift'      : 'break_min_per_shift',
                            'overtime_count_after'     : 'overtime_count_after',
                            'overtime_max_hours'       : 'overtime_max_hours',
                            'overtime_rate_workday'    : 'overtime_rate_workday',
                            'overtime_rate_weekend'    : 'overtime_rate_weekend',
                            'overtime_rate_holiday'    : 'overtime_rate_holiday',
                            'active'                   : 'active',
                        },
                        sortBy    : {
                            relation: false, // false or relation name
                            field   : 'id',
                            desc    : true
                        },
                        // orderBy   : 'id',
                        // direction : 'desc',
                        pluck     : {
                            'id'                       : 'id',
                            'currency_name'            : 'currency_name',
                            'currency_text'            : 'currency_text',
                            'currency_symbol'          : 'currency_symbol',
                            'currency_conversation_usd': 'currency_conversation_usd',
                            'work_days'                : 'work_days',
                            'working_days_per_month'   : 'working_days_per_month',
                            'working_hours_per_day'    : 'working_hours_per_day',
                            'break_min_per_shift'      : 'break_min_per_shift',
                            'overtime_count_after'     : 'overtime_count_after',
                            'overtime_max_hours'       : 'overtime_max_hours',
                            'overtime_rate_workday'    : 'overtime_rate_workday',
                            'overtime_rate_weekend'    : 'overtime_rate_weekend',
                            'overtime_rate_holiday'    : 'overtime_rate_holiday',
                            'active'                   : 'active',
                        }
                    },
                },
                dbDestroy        : {},
                options          : {
                    work_days: [],
                }, //Option Selected
                option           : {
                    modalAdd  : {
                        work_days: [], // for multiselect, need to set as an array.
                    },
                    modalEdit : {
                        work_days: [], // for multiselect, need to set as an array.
                    },
                    modalEdit2: {
                        work_days: [], // for multiselect, need to set as an array.
                    }
                }, //Option Sub
                optionSub        : {
                    modalAdd : {},
                    modalEdit: {}
                }, //Setting
                optionSet        : {}, //Pushing custom option to option array
                optionPush       : {}, //Reseting Option, OptionSub to blank value after form submit
            }
        },

        validations: {
            modalEdit : {
                form: {
                    current_password    : {
                        required,
                        minLength: minLength(4),
                        maxLength: maxLength(24),
                    },
                    new_password        : {
                        required,
                        minLength     : minLength(4),
                        maxLength     : maxLength(24),
                        sameAsPassword: not(sameAs('current_password'))
                    },
                    confirm_new_password: {
                        required,
                        minLength     : minLength(4),
                        maxLength     : maxLength(24),
                        sameAsPassword: sameAs('new_password')
                    },
                }
            },
            modalEdit2: {
                form: {
                    currency_name            : {
                        required,
                    },
                    currency_text            : {
                        required,
                    },
                    currency_symbol          : {
                        required,
                    },
                    currency_conversation_usd: {
                        required,
                        decimal,
                        maxValue: maxValue(100000000),
                    },
                    work_days                : {
                        required,
                    },
                    working_days_per_month   : {
                        required,
                        decimal,
                        // minValue : minValue(0),
                        maxValue: maxValue(31),
                    },
                    working_hours_per_day    : {
                        required,
                        decimal,
                        // minValue : minValue(0),
                        maxValue: maxValue(24),
                    },
                    break_min_per_shift      : {
                        required,
                        decimal,
                        // minValue : minValue(0),
                        maxValue: maxValue(1440),
                    },
                    overtime_count_after     : {
                        required,
                        decimal,
                        // minValue : minValue(0),
                        maxValue: maxValue(1440),
                    },
                    overtime_max_hours       : {
                        required,
                        decimal,
                        // minValue : minValue(0),
                        maxValue: maxValue(24),
                    },
                    overtime_rate_workday    : {
                        required,
                        decimal,
                        // minValue : minValue(0),
                        maxValue: maxValue(10000),
                    },
                    overtime_rate_weekend    : {
                        required,
                        decimal,
                        // minValue : minValue(0),
                        maxValue: maxValue(10000),
                    },
                    overtime_rate_holiday    : {
                        required,
                        decimal,
                        // minValue : minValue(0),
                        maxValue: maxValue(10000),
                    },
                }
            }
        },
        created() {
            // this.setLayout('layout-dashboard');
            // this.setPushOptions(this.optionSet, null);
            // this.getFormInputs(this.FormInputsAPI, null, this.dbInputs, null, this.optionSet, null);
            // this.onLoadPageData(this.ItemGetUrl, this.dbQuery.settings, this.page.vuexKey, 'loading', true, this.modalEdit2.formKey);
            console.log('created: ', this.page.title, ': ', this.$route.params);
        },
        mounted() {
        },
        computed   : {
            user() {
                let data = this.$store.getters.user;
                console.log('computed: user: ', data);
                return data;
            }
        },
        watch      : {},
        methods    : {}
    }
</script>
