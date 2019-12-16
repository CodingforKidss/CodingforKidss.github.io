<template>
    <div>
        <div class = "limiter">
            <!--===============================================================================================-->
            <link rel = "stylesheet" type = "text/css" href = "css/login.css">
            <link rel = "stylesheet" type = "text/css" href = "css/login-util.css">

            <div class = "container-login100">
                <div class = "wrap-login100">
                    <form class = "login100-form validate-form"
                            @submit.prevent = "onModalFormSubmit2(page.registerApi, modalEdit.form.data(), modalEdit.dbInsert, dbQuery, page.vuexKey, modalEdit.formKey)">
                        <span class = "login100-form-title p-b-43">
                            Welcome to Coding for Kids
                            <br>
						    Register to Create New Account
					    </span>

                        <div class = "wrap-input100"
                                :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.name.formControlName] && $v.modalEdit.form[modalEdit.inputs.name.formControlName].$error ? 'form-group--error' : '', '']">
                            <input class = "input100"
                                    :class = "[modalEdit.form[modalEdit.inputs.name.formControlName] && modalEdit.form[modalEdit.inputs.name.formControlName].length > 0 ? 'has-val' : '', '']"
                                    :id = "modalEdit.inputs.name.formControlName"
                                    :name = "modalEdit.inputs.name.formControlName"
                                    placeholder = ""
                                    :type = "modalEdit.inputs.name.type"
                                    v-model = "modalEdit.form[modalEdit.inputs.name.formControlName]"
                                    v-model.trim = "$v.modalEdit.form[modalEdit.inputs.name.formControlName].$model">
                            <span class = "focus-input100"></span>
                            <span class = "label-input100">Name</span>
                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.name.formControlName]['required'] === false">
                                Name is Required
                            </div>
                        </div>

                        <div class = "wrap-input100"
                                :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.username.formControlName] && $v.modalEdit.form[modalEdit.inputs.username.formControlName].$error ? 'form-group--error' : '', '']">
                            <input class = "input100"
                                    :class = "[modalEdit.form[modalEdit.inputs.username.formControlName] && modalEdit.form[modalEdit.inputs.username.formControlName].length > 0 ? 'has-val' : '', '']"
                                    :id = "modalEdit.inputs.username.formControlName"
                                    :name = "modalEdit.inputs.username.formControlName"
                                    placeholder = ""
                                    :type = "modalEdit.inputs.username.type"
                                    v-model = "modalEdit.form[modalEdit.inputs.username.formControlName]"
                                    v-model.trim = "$v.modalEdit.form[modalEdit.inputs.username.formControlName].$model">
                            <span class = "focus-input100"></span>
                            <span class = "label-input100">Username</span>
                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.username.formControlName]['required'] === false">
                                Username is Required
                            </div>
                        </div>

                        <div class = "wrap-input100"
                                :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.email.formControlName] && $v.modalEdit.form[modalEdit.inputs.email.formControlName].$error ? 'form-group--error' : '', '']">
                            <input class = "input100"
                                    :class = "[modalEdit.form[modalEdit.inputs.email.formControlName] && modalEdit.form[modalEdit.inputs.email.formControlName].length > 0 ? 'has-val' : '', '']"
                                    :id = "modalEdit.inputs.email.formControlName"
                                    :name = "modalEdit.inputs.email.formControlName"
                                    placeholder = ""
                                    :type = "modalEdit.inputs.email.type"
                                    v-model = "modalEdit.form[modalEdit.inputs.email.formControlName]"
                                    v-model.trim = "$v.modalEdit.form[modalEdit.inputs.email.formControlName].$model">
                            <span class = "focus-input100"></span>
                            <span class = "label-input100">Email</span>
                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.email.formControlName]['required'] === false">
                                Email is Required
                            </div>
                        </div>

                        <div class = "wrap-input100"
                                :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.password.formControlName] && $v.modalEdit.form[modalEdit.inputs.password.formControlName].$error ? 'form-group--error' : '', '']">
                            <input class = "input100"
                                    :class = "[modalEdit.form[modalEdit.inputs.password.formControlName] && modalEdit.form[modalEdit.inputs.password.formControlName].length > 0 ? 'has-val' : '', '']"
                                    :id = "modalEdit.inputs.password.formControlName"
                                    :name = "modalEdit.inputs.password.formControlName"
                                    placeholder = ""
                                    :type = "modalEdit.inputs.password.type"
                                    v-model = "modalEdit.form[modalEdit.inputs.password.formControlName]"
                                    v-model.trim = "$v.modalEdit.form[modalEdit.inputs.password.formControlName].$model">
                            <span class = "focus-input100"></span>
                            <span class = "label-input100">Password</span>
                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.password.formControlName]['required'] === false">
                                Password is Required
                            </div>
                        </div>

                        <div class = "wrap-input100"
                                :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.confirm_password.formControlName] && $v.modalEdit.form[modalEdit.inputs.confirm_password.formControlName].$error ? 'form-group--error' : '', '']">
                            <input class = "input100"
                                    :class = "[modalEdit.form[modalEdit.inputs.confirm_password.formControlName] && modalEdit.form[modalEdit.inputs.confirm_password.formControlName].length > 0 ? 'has-val' : '', '']"
                                    :id = "modalEdit.inputs.confirm_password.formControlName"
                                    :name = "modalEdit.inputs.confirm_password.formControlName"
                                    placeholder = ""
                                    :type = "modalEdit.inputs.confirm_password.type"
                                    v-model = "modalEdit.form[modalEdit.inputs.confirm_password.formControlName]"
                                    v-model.trim = "$v.modalEdit.form[modalEdit.inputs.confirm_password.formControlName].$model">
                            <span class = "focus-input100"></span>
                            <span class = "label-input100">Cofirm Password</span>
                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.confirm_password.formControlName]['required'] === false">
                                Cofirm Password is Required
                            </div>
                        </div>

                        <div class = "wrap-input100"
                                :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.address.formControlName] && $v.modalEdit.form[modalEdit.inputs.address.formControlName].$error ? 'form-group--error' : '', '']">
                            <input class = "input100"
                                    :class = "[modalEdit.form[modalEdit.inputs.address.formControlName] && modalEdit.form[modalEdit.inputs.address.formControlName].length > 0 ? 'has-val' : '', '']"
                                    :id = "modalEdit.inputs.address.formControlName"
                                    :name = "modalEdit.inputs.address.formControlName"
                                    placeholder = ""
                                    :type = "modalEdit.inputs.address.type"
                                    v-model = "modalEdit.form[modalEdit.inputs.address.formControlName]"
                                    v-model.trim = "$v.modalEdit.form[modalEdit.inputs.address.formControlName].$model">
                            <span class = "focus-input100"></span>
                            <span class = "label-input100">Address</span>
                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.address.formControlName]['required'] === false">
                                Address is Required
                            </div>
                        </div>

                        <div class = "wrap-input100"
                                :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.phone.formControlName] && $v.modalEdit.form[modalEdit.inputs.phone.formControlName].$error ? 'form-group--error' : '', '']">
                            <input class = "input100"
                                    :class = "[modalEdit.form[modalEdit.inputs.phone.formControlName] && modalEdit.form[modalEdit.inputs.phone.formControlName].length > 0 ? 'has-val' : '', '']"
                                    :id = "modalEdit.inputs.phone.formControlName"
                                    :name = "modalEdit.inputs.phone.formControlName"
                                    placeholder = ""
                                    :type = "modalEdit.inputs.phone.type"
                                    v-model = "modalEdit.form[modalEdit.inputs.phone.formControlName]"
                                    v-model.trim = "$v.modalEdit.form[modalEdit.inputs.phone.formControlName].$model">
                            <span class = "focus-input100"></span>
                            <span class = "label-input100">Phone</span>
                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.phone.formControlName]['required'] === false">
                                Phone is Required
                            </div>
                        </div>

                        <div class = "wrap-input100"
                                :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.role_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.role_id.formControlName].$error ? 'form-group--error' : '', '']">
                            <multiselect :allow-empty = "true"
                                    class = "form-control multiselect-in-modal multiselect-width-fix"
                                    :close-on-select = "true"
                                    deselect-label = "Can'not remove this value"
                                    :hide-selected = "false"
                                    :id = "modalEdit.inputs.role_id.formControlName"
                                    :name = "modalEdit.inputs.role_id.formControlName"
                                    :options = "options[modalEdit.inputs.role_id.multiSelect.option_id]"
                                    placeholder = ""
                                    :preselectFirst = "false"
                                    :searchable = "true"
                                    :show-labels = "false"
                                    label = "name"
                                    track-by = "id"
                                    @input = "onMultiselectInput2($event, modalEdit.inputs.role_id.formControlName, modalEdit.formKey)"
                                    v-model = "option.modalEdit[modalEdit.inputs.role_id.multiSelect.option_id]"></multiselect>
                            <span class = "focus-input100"></span>
                            <span class = "label-input100">Role Id</span>
                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.role_id.formControlName]['required'] === false">
                                Role Id is Required
                            </div>
                        </div>

                        <div class = "flex-sb-m w-full p-t-3 p-b-32">
                            <!--<div class = "contact100-form-checkbox">
                                <input class = "input-checkbox100" id = "ckb1" type = "checkbox" name = "remember-me">
                                <label class = "label-checkbox100" for = "ckb1"> Remember me </label>
                            </div>-->

                            <div>
                                <router-link :to = "{ name: 'password.forgot' }" class = "txt1">
                                    Forgot your password?
                                </router-link>
                            </div>
                        </div>

                        <div class = "statusDiv" v-if = "modalEdit.statusDiv.show">
                            <div :class = "[modalEdit.statusDiv.class]" v-for = "statusMsgs in modalEdit.statusDiv.messages">
                                <p v-html = "statusMsgs"></p>
                            </div>
                        </div>
                        <div class = "container-login100-form-btn">
                            <button class = "login100-form-btn"
                                    @click.prevent = "onModalFormSubmit2(page.registerApi, modalEdit.form.data(), modalEdit.dbInsert, dbQuery, page.vuexKey, modalEdit.formKey)">
                                Register&nbsp;&nbsp;<i :class = "[modalEdit.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-sign-in-alt']" aria-hidden = "true"></i>
                            </button>
                        </div>

                        <div class = "text-center p-t-46 p-b-20">
						<span class = "txt2">
                            <router-link :to = "{ name: 'login' }" class = "txt1">
                                Already Have Accout? Login Here
                            </router-link>
						</span>
                        </div>
                    </form>
                    <div class = "login100-more" style = "background-image: url('img/login-background.jpg');"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const {required, email, minLength, maxLength, sameAs} = require('vuelidate/lib/validators');
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';

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
                    title      : 'Register',
                    subTitle   : 'Enter your details below to create new account',
                    vuexKey    : null,
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    registerApi: '/api/v1/register',
                },
                dataForm : {},
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
                        text      : 'Register',
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
                        name            : null,
                        username        : null,
                        email           : null,
                        password        : null,
                        confirm_password: null,
                        address         : null,
                        phone           : null,
                        role_id         : null,
                        active          : 1,
                        api_ver         : '1.0',
                        app_ver         : '1.0.0',
                        app_build_ver   : 1,
                    }),
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputs      : {
                        'name'            : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'name',
                        },
                        'username'        : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'username',
                        },
                        'email'           : {
                            inputType      : 'text',
                            type           : 'email',
                            formControlName: 'email',
                        },
                        'password'        : {
                            inputType      : 'text',
                            type           : 'password',
                            formControlName: 'password',
                        },
                        'confirm_password': {
                            inputType      : 'text',
                            type           : 'password',
                            formControlName: 'confirm_password',
                        },
                        'address'         : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'address',
                        },
                        'phone'           : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'phone',
                        },
                        'role_id'         : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'role_id',
                            multiSelect    : {
                                option_id: 'role_id',
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
                        actionType        : 'register',
                        sentAsFormData    : false,
                        storeInEdits      : false,
                        validations       : {
                            'name'            : 'required|min:100|max:255',
                            'username'        : 'required|min:4|max:24|unique:users,username',
                            'email'           : 'required|min:1|max:255|unique:users,email',
                            'password'        : 'required|min:4|max:24',
                            'confirm_password': 'required|min:4|max:24|same:password',
                            'address'         : 'required|min:1|max:255',
                            'phone'           : 'required|min:1|max:64|unique:users,phone',
                            'role_id'         : 'required|min:1|max:4',
                            'photo'           : '',
                            'api_ver'         : 'max:8',
                            'app_ver'         : 'max:8',
                            'app_build_ver'   : 'max:8',
                            'u_agent'         : 'max:255',
                            'ipAddress'       : 'max:128',
                        },
                        unique            : {},
                    },
                },
                dbInputs : [
                    {
                        key       : 'role_id',
                        table     : 'UserRoles',
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
                        direction : 'desc',
                        pluck     : {
                            'id'    : 'id',
                            'name'  : 'name',
                            'active': 'active',
                        }
                    },
                ],
                dbQuery  : {},
                dbDestroy: {},
                options  : {
                    role_id: [],
                },
                option   : {
                    modalAdd : {
                        role_id: {},
                    },
                    modalEdit: {
                        role_id: {},
                        active : {},
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
                },//Option Sub
            }
        },
        validations: {
            modalEdit: {
                form: {
                    name            : {
                        required,
                    },
                    username        : {
                        required,
                        minLength: minLength(4),
                        maxLength: maxLength(24),
                    },
                    email           : {
                        required,
                    },
                    password        : {
                        required,
                        minLength: minLength(4),
                        maxLength: maxLength(24),
                    },
                    confirm_password: {
                        required,
                        minLength     : minLength(4),
                        maxLength     : maxLength(24),
                        sameAsPassword: sameAs('password')
                    },
                    address         : {
                        required,
                    },
                    phone           : {
                        required
                    },
                    role_id         : {
                        required
                    },
                    photo           : {}
                }
            }
        },
        created() {
            // this.setLayout('layout-login');
            this.getFormInputs(this.FormInputsAPI, null, this.dbInputs, null, this.optionSet, null);
            console.log('created: ', this.page.title, ': ', this.$route.params);
        },
        mounted() {
        },
        computed   : {},
        watch      : {},
        methods    : {}
    }
</script>
