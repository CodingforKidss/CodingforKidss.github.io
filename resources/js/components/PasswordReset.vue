<style scoped>
    .navbar, .wrapper {
        font-family : 'Muli', 'Montserrat', 'Helvetica Neue', Arial, sans-serif;;
    }
</style>
<template>
    <div class = "layout-login">
        <nav class = "navbar navbar-transparent navbar-absolute" style = "padding-top: 15px; border-bottom: none;">
            <div class = "container">
                <div class = "navbar-header">
                    <button class = "navbar-toggle" data-target = "#navigation-example-2" data-toggle = "collapse" type = "button">
                        <span class = "sr-only">Toggle navigation</span> <span class = "icon-bar"></span> <span class = "icon-bar"></span> <span class = "icon-bar"></span>
                    </button>
                    <div>
                        <img style = "width: 150px; height: 80px; object-fit: contain;" onerror = "src='/img/avatar.png'" src = "/img/logo.png">
                    </div>
                    <div>
                        <a class = "navbar-brand" style = "margin: 0px 0px;padding: 15px 40px; color: white;font-weight: bold;">Coding for Kids</a>
                    </div>
                </div>
                <div class = "collapse navbar-collapse">
                    <ul class = "nav navbar-nav navbar-right">
                        <li>
                            <router-link :to = "{ name: 'register' }" class = "">Register</router-link>
                        </li>
                        <li>
                            <router-link :to = "{ name: 'login' }" class = "">Login</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class = "wrapper wrapper-full-page">
            <div class = "full-page login-page">
                <!-- change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
                <div class = "content">
                    <div class = "container">
                        <div class = "row">
                            <div class = "col-md-5 col-sm-6" style = "margin: 0 auto;">
                                <div class = "card" data-background = "color" data-color = "blue">
                                    <div class = "card-header">
                                        <h3 class = "card-title">{{page.title}}</h3>
                                        <p class = "card-category">{{page.subTitle}}</p>
                                    </div>
                                    <div class = "card-content">
                                        <form :class = "modalEdit.formClass" :style = "modalEdit.formStyle"
                                                @submit.prevent = "onModalFormSubmit2(passwordResetApi, modalEdit.form.data(), modalEdit.dbInsert, dbQuery, page.vuexKey, modalEdit.formKey)">
                                            <div>
                                                <div class = "row justify-content-center">
                                                    <div class = "col-11">
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
                                                                                    v-model = "modalEdit.form[item.formControlName]" v-model.trim = "$v.modalEdit.form[item.formControlName].$model">
                                                                            <input :class = "item.inputClass" :disabled = "item.disabled" :id = "item.formControlName" :name = "item.formControlName"
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
                                                                                <el-date-picker :class = "item.dateTime.inputDateClass" :style = "item.dateTime.inputDateStyle"
                                                                                        :id = "item.formControlName" :name = "item.formControlName" :placeholder = "item.placeHolder"
                                                                                        :disabled = "item.disabled" :readonly = "item.readonly" :required = "item.required" :type = "item.dateTime.type"
                                                                                        :align = "item.dateTime.align" :clearable = "item.dateTime.clearable" :editable = "item.dateTime.editable"
                                                                                        :range-separator = "item.dateTime.rangeSeparator" :format = "item.dateTime.displayFormat"
                                                                                        :value-format = "item.dateTime.valueFormat" :picker-options = "item.dateTime.pickerOptions"
                                                                                        v-if = "item.dateTime.type === 'date'" v-model = "modalEdit.form[item.formControlName]"
                                                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-date-picker>
                                                                                <el-time-picker :class = "item.dateTime.inputDateClass" :style = "item.dateTime.inputDateStyle"
                                                                                        :id = "item.formControlName" :name = "item.formControlName" :placeholder = "item.placeHolder"
                                                                                        :disabled = "item.disabled" :readonly = "item.readonly" :required = "item.required"
                                                                                        :align = "item.dateTime.align" :clearable = "item.dateTime.clearable" :editable = "item.dateTime.editable"
                                                                                        :is-range = "item.dateTime.isRange" :arrow-control = "item.dateTime.arrowControl"
                                                                                        :range-separator = "item.dateTime.rangeSeparator" :value-format = "item.dateTime.valueFormat"
                                                                                        :picker-options = "item.dateTime.pickerOptions" v-if = "item.dateTime.type === 'timePicker'"
                                                                                        v-model = "modalEdit.form[item.formControlName]"
                                                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-time-picker>
                                                                                <el-time-select :class = "item.dateTime.inputDateClass" :style = "item.dateTime.inputDateStyle"
                                                                                        :id = "item.formControlName" :name = "item.formControlName" :placeholder = "item.placeHolder"
                                                                                        :disabled = "item.disabled" :readonly = "item.readonly" :required = "item.required"
                                                                                        :align = "item.dateTime.align" :clearable = "item.dateTime.clearable" :editable = "item.dateTime.editable"
                                                                                        :is-range = "item.dateTime.isRange" :arrow-control = "item.dateTime.arrowControl"
                                                                                        :range-separator = "item.dateTime.rangeSeparator" :value-format = "item.dateTime.valueFormat"
                                                                                        :picker-options = "item.dateTime.pickerOptions" v-if = "item.dateTime.type === 'timeSelect'"
                                                                                        v-model = "modalEdit.form[item.formControlName]"
                                                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-time-select>
                                                                            </div>
                                                                        </div>
                                                                        <template
                                                                                v-if = "item.validation.active && item.validation.show && $v.modalEdit.form && $v.modalEdit.form[item.formControlName]">
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
                                                            <button class = "btn btn-secondary button-single" type = "submit">
                                                                Reset Password <i :class = "[modalEdit.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-save']" aria-hidden = "true"></i>
                                                            </button>
                                                            <div class = "forgot danger-a">
                                                                <router-link :to = "{ name: 'password.forgot' }" class = "">
                                                                    Did Not Receive The Recover Code? Request Here!
                                                                </router-link>
                                                            </div>
                                                            <br>
                                                            <div>OR</div>
                                                            <div class = "forgot green-a">
                                                                <router-link :to = "{ name: 'login' }" class = "">
                                                                    Already Have an Account? Login Here!
                                                                </router-link>
                                                            </div>
                                                            <br>
                                                        </div>
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
                <footer class = "footer footer-transparent">
                    <div class = "container">
                        <div class = "copyright text-center" style = "float: none;">&copy; 2019, made with <i class = "fa fa-heart heart"></i> for <a href = "https://www..com">People's Talent</a>
                        </div>
                    </div>
                </footer>
                <div class = "full-page-background" style = "background-image: url(../img/background.jpg) "></div>
            </div>
        </div>
    </div>
</template>
<script>
    const {required, email, minLength, maxLength, sameAs} = require('vuelidate/lib/validators');
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';

    export default {
        // name: `Home`,
        // components: {
        //     Layout,
        // },
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
                page            : {
                    title      : 'Reset Password',
                    subTitle   : 'Enter Details Below to Reset your Password',
                    vuexKey    : null,
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                },
                passwordResetApi: '/api/v1/password-reset',
                dataForm        : {
                    email               : null,
                    code                : null,
                    new_password        : null,
                    confirm_new_password: null,
                },
                modalEdit       : {
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
                        text      : 'Reset Password',
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
                        email               : null,
                        code                : null,
                        new_password        : null,
                        confirm_new_password: null,
                        api_ver             : '1.0',
                        app_ver             : '1.0.0',
                        app_build_ver       : 1,
                    }),
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputs      : {
                        'email'           : {
                            label          : {
                                show : true,
                                text : 'Email',
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
                            type           : 'email',
                            placeHolder    : 'Enter Email',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'email',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Email', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Email is Required'
                                    },
                                },
                            },
                        },
                        'code'            : {
                            label          : {
                                show : true,
                                text : 'Reset Code',
                                class: '',
                                style: 'font-weight: 700; color: #252422;',
                            },
                            icon           : {
                                show : true,
                                text : '<i class = "nc-icon nc-single-02"></i>',
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
                            placeHolder    : 'Reset Code',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'code',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Reset Code', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required : {
                                        message: 'Reset Code is Required'
                                    },
                                    minLength: {
                                        value  : 6,
                                        message: 'Reset Code must be 6 char long'
                                    },
                                    maxLength: {
                                        value  : 6,
                                        message: 'Reset Code must be 6 char long'
                                    },
                                },
                            },
                        },
                        'new_password'    : {
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
                                    required : {
                                        message: 'New Password is Required'
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
                        'confirm_password': {
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
                    },
                    dbInsert    : {
                        table             : 'User',
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
                        actionType        : 'login',
                        sentAsFormData    : false,
                        storeInEdits      : false,
                        validations       : {
                            'email'               : 'required|min:1|max:255',
                            'code'                : 'required|min:6|max:6',
                            'new_password'        : 'required|min:4|max:24',
                            'confirm_new_password': 'required|min:4|max:24|same:new_password',
                            'api_ver'             : 'max:8',
                            'app_ver'             : 'max:8',
                            'app_build_ver'       : 'max:8',
                            'u_agent'             : 'max:255',
                            'ipAddress'           : 'max:128',
                        },
                        unique            : {},
                    },
                },
                dbInputs        : [], //Options Array
                dbQuery         : {
                    table     : 'User',
                    tableWith : [
                        'entryby',
                        'role',
                        'fcm_tokens',
                        'department',
                    ],
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
                        'id'           : 'id',
                        'name'         : 'name',
                        'username'     : 'username',
                        'email'        : 'email',
                        'address'      : 'address',
                        'city_id'      : 'city_id',
                        'post_code'    : 'post_code',
                        'country_id'   : 'country_id',
                        'phone'        : 'phone',
                        'department_id': 'department_id',
                        'role_id'      : 'role_id',
                        'photo'        : 'photo',
                        'active'       : 'active',
                    },
                    /*sortBy    : {
                        relation: false, // false or relation name
                        field   : 'id',
                        desc    : true
                    },*/
                    orderBy   : 'id',
                    direction : 'desc',
                    pluck     : {
                        'id'           : 'id',
                        'name'         : 'name',
                        'username'     : 'username',
                        'email'        : 'email',
                        'address'      : 'address',
                        'city_id'      : 'city_id',
                        'post_code'    : 'post_code',
                        'country_id'   : 'country_id',
                        'phone'        : 'phone',
                        'department_id': 'department_id',
                        'role_id'      : 'role_id',
                        'photo'        : 'photo',
                        'active'       : 'active',
                    }
                },
                dbDestroy       : {},
                options         : {}, //Option Selected
                option          : {
                    modalAdd : {},
                    modalEdit: {}
                }, //Option Sub
                optionSub       : {
                    modalAdd : {},
                    modalEdit: {}
                }, //Setting
                optionSet       : {}, //Pushing custom option to option array
                optionPush      : {}, //Reseting Option, OptionSub to blank value after form submit
            }
        },
        validations: {
            modalEdit: {
                form: {
                    email               : {
                        required,
                    },
                    code                : {
                        required,
                        minLength: minLength(6),
                        maxLength: maxLength(6),
                    },
                    new_password        : {
                        required,
                        minLength: minLength(4),
                        maxLength: maxLength(24),
                    },
                    confirm_new_password: {
                        required,
                        minLength     : minLength(4),
                        maxLength     : maxLength(24),
                        sameAsPassword: sameAs('new_password')
                    },
                }
            }
        },
        created() {
            // this.setLayout('layout-login');
            console.log('created: ', this.page.title, ': ', this.$route.params);
        }
    }
</script>
