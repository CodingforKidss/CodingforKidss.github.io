<template>
    <div>
        <div class = "limiter">

            <!--===============================================================================================-->
            <link rel = "stylesheet" type = "text/css" href = "css/login.css">
            <link rel = "stylesheet" type = "text/css" href = "css/login-util.css">

            <div class = "container-login100">
                <div class = "wrap-login100">
                    <form class = "login100-form validate-form"
                            @submit.prevent = "onModalFormSubmit2(page.loginApi, modalEdit.form.data(), modalEdit.dbInsert, dbQuery, page.vuexKey, modalEdit.formKey)">
                        <span class = "login100-form-title p-b-43">
                            Welcome to Coding for Kids
                            <br>
						    Login to continue
					    </span>
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
                                    @click.prevent = "onModalFormSubmit2(page.loginApi, modalEdit.form.data(), modalEdit.dbInsert, dbQuery, page.vuexKey, modalEdit.formKey)">
                                Login&nbsp;&nbsp;<i :class = "[modalEdit.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-sign-in-alt']" aria-hidden = "true"></i>
                            </button>
                        </div>

                        <div class = "text-center p-t-46 p-b-20">
						<span class = "txt2">
                            <router-link :to = "{ name: 'register' }" class = "txt1">
                                or Register a new Account
                            </router-link>
						</span>
                        </div>

                        <!--<div class = "login100-form-social flex-c-m">
                            <a href = "#" class = "login100-form-social-item flex-c-m bg1 m-r-5">
                                <i class = "fa fa-facebook-f" aria-hidden = "true"></i>
                            </a>

                            <a href = "#" class = "login100-form-social-item flex-c-m bg2 m-r-5">
                                <i class = "fa fa-twitter" aria-hidden = "true"></i>
                            </a>
                        </div>-->
                    </form>
                    <div class = "login100-more" style = "background-image: url('img/login-background.jpg');"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    const {required, email, minLength, maxLength} = require('vuelidate/lib/validators');
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';

    export default {
        mixins     : [FormMixin],
        data() {

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
                    // this.errors = new Errors();
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
            }

            return {
                page      : {
                    title      : 'Login',
                    subTitle   : 'Enter your details to Login',
                    vuexKey    : null,
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    loginApi   : '/api/v1/login',
                },
                dataForm  : {
                    username: null,
                    password: null,
                },
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
                        text      : 'Login',
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
                        username     : null,
                        password     : null,
                        api_ver      : '1.0',
                        app_ver      : '1.0.0',
                        app_build_ver: 1,
                    }),
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputs      : {
                        'username': {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'username',
                        },
                        'password': {
                            inputType      : 'text',
                            type           : 'password',
                            formControlName: 'password',
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
                        fileUploads       : {},
                        storeInEdits      : false,
                        validations       : {
                            'username'     : 'required|min:4|max:24',
                            'password'     : 'required|min:4|max:24',
                            'api_ver'      : 'max:8',
                            'app_ver'      : 'max:8',
                            'app_build_ver': 'max:8',
                            'u_agent'      : 'max:255',
                            'ipAddress'    : 'max:128',
                        },
                        unique            : {},
                    },
                },
                dbInputs  : [], //Options Array
                dbQuery   : {
                    table     : 'User',
                    tableWith : [
                        'entryby',
                        'role',
                        'fcm_tokens',
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
                        'id'             : 'id',
                        'name'           : 'name',
                        'username'       : 'username',
                        'email'          : 'email',
                        'address'        : 'address',
                        'city_id'        : 'city_id',
                        'post_code'      : 'post_code',
                        'country_id'     : 'country_id',
                        'phone'          : 'phone',
                        'role_id'        : 'role_id',
                        'employee_no'    : 'employee_no',
                        'date_of_birth'  : 'date_of_birth',
                        'gender'         : 'gender',
                        'religion'       : 'religion',
                        'blood_group'    : 'blood_group',
                        'marital_status' : 'marital_status',
                        'nationality_id' : 'nationality_id',
                        'passport_no'    : 'passport_no',
                        'driving_license': 'driving_license',
                        'nid'            : 'nid',
                        'description'    : 'description',
                        'photo'          : 'photo',
                        'active'         : 'active',
                    },
                    /*sortBy    : {
                        relation: false, // false or relation name
                        field   : 'id',
                        desc    : true
                    },*/
                    orderBy   : 'id',
                    direction : 'desc',
                    pluck     : {
                        'id'             : 'id',
                        'name'           : 'name',
                        'username'       : 'username',
                        'email'          : 'email',
                        'address'        : 'address',
                        'city_id'        : 'city_id',
                        'post_code'      : 'post_code',
                        'country_id'     : 'country_id',
                        'phone'          : 'phone',
                        'role_id'        : 'role_id',
                        'employee_no'    : 'employee_no',
                        'date_of_birth'  : 'date_of_birth',
                        'gender'         : 'gender',
                        'religion'       : 'religion',
                        'blood_group'    : 'blood_group',
                        'marital_status' : 'marital_status',
                        'nationality_id' : 'nationality_id',
                        'passport_no'    : 'passport_no',
                        'driving_license': 'driving_license',
                        'nid'            : 'nid',
                        'description'    : 'description',
                        'photo'          : 'photo',
                        'active'         : 'active',
                    }
                },
                dbDestroy : {},
                options   : {}, //Option Selected
                option    : {
                    modalAdd : {},
                    modalEdit: {}
                }, //Option Sub
                optionSub : {
                    modalAdd : {},
                    modalEdit: {}
                }, //Setting
                optionSet : {}, //Pushing custom option to option array
                optionPush: {}, //Reseting Option, OptionSub to blank value after form submit
            }
        },
        validations: {
            modalEdit: {
                form: {
                    username: {
                        required,
                        minLength: minLength(4),
                        maxLength: maxLength(24),
                    },
                    password: {
                        required,
                        minLength: minLength(4),
                        maxLength: maxLength(24),
                    },
                }
            }
        },
        created() {
            console.log('created: ', this.page.title, ': ', this.$route.params);
        },
        mounted() {
            if (this.$route.params && this.$route.params['message'] && this.$route.params['message'].length > 0) {
                this.$notify(this.$route.params);
            }
        },
        computed   : {},
        watch      : {},
        methods    : {}
    }
</script>
