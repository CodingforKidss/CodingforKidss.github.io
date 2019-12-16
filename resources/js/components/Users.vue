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
                                            <img :src = "'/uploads/avatar/' + item['TableViewData']['photo']" onerror = "src='/img/avatar.png'">
                                        </td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['name']}}</td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['username']}}
                                        </td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['email']}}</td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['phone']}}</td>
                                        <td @click.prevent = "viewModal(item)">{{item['TableViewData']['role']}}</td>
                                        <td @click.prevent = "viewModal(item)">
                                            <span :class = "[item.active == 0 ? 'badge-warning' : 'badge-success']" class = "badge">{{item['TableViewData']['active']}}
                                            </span>
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
    const {required, email, minLength, maxLength, minValue, maxValue, numeric, decimal, sameAs} = require('vuelidate/lib/validators');
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';
    import ModalEdit from './modals/ModalEdit.vue';
    import ModalAdd from './modals/ModalAdd.vue';
    import ModalView from './modals/ModalView.vue';
    import ModalDelete from './modals/ModalDelete.vue';

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
                    title      : 'Users',
                    subTitle   : 'List and manage User',
                    vuexKey    : 'users',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    print      : {
                        title     : 'Users',
                        subTitle  : 'List of Users',
                        footer    : 'Copyright.',
                        time      : true,
                        printType : 'dataTable', // dataTable = DataTable Loop, divId = sectionId.
                        printDivId: 'mainSection',
                        format    : 'pdf',
                        pageSize  : 'A4',
                        layout    : 'Portrait',
                        margin    : '10px 10px 10px 10px',
                        class     : '',
                        headers   : ['Id', 'FullName', 'User Name', 'Email', 'Phone', 'Department', 'Role', 'Status'],
                        fields    : ['id', 'name', 'username', 'email', 'phone', 'department', 'role', 'active'],
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
                            title   : 'Image',
                            relation: false, // false or 'string'
                            field   : '',
                            operator: '',
                            sortType: '', // js, jsText or db
                            click   : '',
                            class   : '',
                            style   : 'width: 80px;',
                        },
                        {
                            title   : 'FullName',
                            relation: false, // false or 'string'
                            field   : 'name',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'User Name',
                            relation: false, // false or 'string'
                            field   : 'username',
                            operator: 'like',
                            sortType: 'js', // js, jsText or db
                            click   : '',
                            class   : 'th-sort',
                            style   : '',
                        },
                        {
                            title   : 'Email',
                            relation: false, // false or 'string'
                            field   : 'email',
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
                            title   : 'Role',
                            relation: 'role', // false or 'string'
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
                    id      : 0,
                    name    : null,
                    username: null,
                    // password: null,
                    email   : null,
                    address : null,
                    phone   : null,
                    role_id : null,
                    photo   : null,
                    active  : null,
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
                        text      : 'Add New User',
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
                        id              : 0,
                        name            : null,
                        username        : null,
                        email           : null,
                        password        : null,
                        confirm_password: null,
                        address         : null,
                        phone           : null,
                        role_id         : null,
                        photo           : null,
                        api_ver         : '1.0',
                        app_ver         : '1.0.0',
                        app_build_ver   : 1,
                    }),
                    validations : {
                        name            : {
                            required,
                        },
                        username        : {
                            required,
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
                        photo           : {},
                    },
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalAdd',
                    inputs      : {
                        'role_id'         : {
                            label          : {
                                show : true,
                                text : 'Role',
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
                                option_id     : 'role_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Role',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'role_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Role', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Role is Required'
                                    },
                                },
                            },
                        },
                        'name'            : {
                            label          : {
                                show : true,
                                text : 'Full Name',
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
                            placeHolder    : 'Enter Full Name',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'name',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Full Name', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Full Name is Required'
                                    },
                                },
                            },
                        },
                        'username'        : {
                            label          : {
                                show : true,
                                text : 'Username',
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
                            placeHolder    : 'Username',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'username',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Username', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Username is Required'
                                    },
                                },
                            },
                        },
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
                        'password'        : {
                            label          : {
                                show : true,
                                text : 'Password',
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
                            placeHolder    : 'Enter Password',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'password',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Password', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required : {
                                        message: 'Password is Required'
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
                                text : 'Confirm Password',
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
                            placeHolder    : 'Enter Confirm Password',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'confirm_password',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Confirm Password', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required      : {
                                        message: 'Confirm Password is Required'
                                    },
                                    minLength     : {
                                        value  : 4,
                                        message: 'Confirm Password must be atleast 4 char long'
                                    },
                                    maxLength     : {
                                        value  : 24,
                                        message: 'Confirm Password can not be more than 24 char long'
                                    },
                                    sameAsPassword: {
                                        message: 'The Confirm Password and Password must match.'
                                    },
                                },
                            },
                        },
                        'address'         : {
                            label          : {
                                show : true,
                                text : 'Address',
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
                            placeHolder    : 'Enter Address',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'address',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Address', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Address is Required'
                                    },
                                },
                            },
                        },
                        'phone'           : {
                            label          : {
                                show : true,
                                text : 'Phone',
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
                            placeHolder    : 'Enter Phone',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'phone',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Phone', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Phone is Required'
                                    },
                                },
                            },
                        },
                        'photo'           : {
                            label          : {
                                show : true,
                                text : 'User Photo <i class = "fas fa-camera"></i> ',
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
                                imageServer    : '/uploads/avatar/',
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
                        actionType        : 'add_user',
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
                                    table       : 'User',
                                    field       : 'photo',
                                    storePath   : 'uploads/avatar/',
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
                            'id'              : 'required|min:1|max:14',
                            'name'            : 'required|min:1|max:255',
                            'username'        : 'required|min:1|max:24',
                            'email'           : 'required|min:1|max:255',
                            'password'        : 'required|min:4|max:24',
                            'confirm_password': 'required|min:4|max:24',
                            'address'         : 'required|min:1|max:255',
                            'phone'           : 'required|min:1|max:64',
                            'role_id'         : 'required|min:1|max:4',
                            'photo'           : '',
                            'api_ver'         : 'max:8',
                            'app_ver'         : 'max:8',
                            'app_build_ver'   : 'max:8',
                            'u_agent'         : 'max:255',
                            'ipAddress'       : 'max:128',
                        },
                        unique            : {
                            'id'      : '|unique:users,id,',
                            'username': '|unique:users,username,',
                            'email'   : '|unique:users,email,',
                            'phone'   : '|unique:users,phone,',
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
                        text      : 'Edit User',
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
                        id              : 0,
                        name            : null,
                        username        : null,
                        email           : null,
                        password        : null,
                        confirm_password: null,
                        address         : null,
                        phone           : null,
                        role_id         : null,
                        photo           : null,
                        active          : null,
                        api_ver         : '1.0',
                        app_ver         : '1.0.0',
                        app_build_ver   : 1,
                    }),
                    validations : {
                        name            : {
                            required,
                        },
                        username        : {
                            required,
                        },
                        email           : {
                            required,
                        },
                        password        : {
                            minLength: minLength(4),
                            maxLength: maxLength(24),
                        },
                        confirm_password: {
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
                        photo           : {},
                        active          : {
                            required,
                        },
                    },
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputs      : {
                        'role_id'         : {
                            label          : {
                                show : true,
                                text : 'Role',
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
                                option_id     : 'role_id',
                                label         : 'name',
                                trackBy       : 'id',
                                onInput       : {}
                            },
                            placeHolder    : 'Select Role',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'role_id',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Role', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Role is Required'
                                    },
                                },
                            },
                        },
                        'name'            : {
                            label          : {
                                show : true,
                                text : 'Full Name',
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
                            placeHolder    : 'Enter Full Name',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'name',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Full Name', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Full Name is Required'
                                    },
                                },
                            },
                        },
                        'username'        : {
                            label          : {
                                show : true,
                                text : 'Username',
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
                            placeHolder    : 'Username',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'username',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Username', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Username is Required'
                                    },
                                },
                            },
                        },
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
                        'password'        : {
                            label          : {
                                show : true,
                                text : 'Password',
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
                            placeHolder    : 'Enter Password',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'password',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Password', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required : {
                                        message: 'Password is Required'
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
                                text : 'Confirm Password',
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
                            placeHolder    : 'Enter Confirm Password',
                            required       : false,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'confirm_password',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Confirm Password', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required      : {
                                        message: 'Confirm Password is Required'
                                    },
                                    minLength     : {
                                        value  : 4,
                                        message: 'Confirm Password must be atleast 4 char long'
                                    },
                                    maxLength     : {
                                        value  : 24,
                                        message: 'Confirm Password can not be more than 24 char long'
                                    },
                                    sameAsPassword: {
                                        message: 'The Confirm Password and Password must match.'
                                    },
                                },
                            },
                        },
                        'address'         : {
                            label          : {
                                show : true,
                                text : 'Address',
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
                            placeHolder    : 'Enter Address',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'address',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Address', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Address is Required'
                                    },
                                },
                            },
                        },
                        'phone'           : {
                            label          : {
                                show : true,
                                text : 'Phone',
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
                            placeHolder    : 'Enter Phone',
                            required       : true,
                            readonly       : false,
                            disabled       : false,
                            value          : null,
                            formControlName: 'phone',
                            validation     : {
                                active    : true,
                                show      : true,
                                label     : 'Phone', // Validation Error Label
                                class     : 'error',
                                style     : '',
                                validators: {
                                    required: {
                                        message: 'Phone is Required'
                                    },
                                },
                            },
                        },
                        'status'          : {
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
                        'photo'           : {
                            label          : {
                                show : true,
                                text : 'User Photo <i class = "fas fa-camera"></i> ',
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
                                imageServer    : '/uploads/avatar/',
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
                                        'modalEdit',
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
                        actionType        : 'edit_user',
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
                                    table       : 'User',
                                    field       : 'photo',
                                    storePath   : 'uploads/avatar/',
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
                            'id'              : 'required|min:1|max:14',
                            'name'            : 'required|min:1|max:255',
                            'username'        : 'required|min:1|max:64',
                            'email'           : 'required|min:1|max:255',
                            'password'        : 'max:24',
                            'confirm_password': 'max:24',
                            'address'         : 'required|min:1|max:255',
                            'phone'           : 'required|min:1|max:64',
                            'role_id'         : 'required|min:1|max:4',
                            'photo'           : '',
                            'active'          : 'required|min:1|max:2',
                            'api_ver'         : 'max:8',
                            'app_ver'         : 'max:8',
                            'app_build_ver'   : 'max:8',
                            'u_agent'         : 'max:255',
                            'ipAddress'       : 'max:128',
                        },
                        unique            : {
                            'id'      : '|unique:users,id,',
                            'username': '|unique:users,username,',
                            'email'   : '|unique:users,email,',
                            'phone'   : '|unique:users,phone,',
                        },
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
                dbQuery  : {
                    table     : 'User',
                    tableWith : [
                        'role'
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
                        'id'           : 'id',
                        'name'         : 'name',
                        'username'     : 'username',
                        'email'        : 'email',
                        'address'      : 'address',
                        'city_id'      : 'city_id',
                        'post_code'    : 'post_code',
                        'country_id'   : 'country_id',
                        'phone'        : 'phone',
                        'role_id'      : 'role_id',
                        'photo'        : 'photo',
                        'active'       : 'active',
                    },
                    sortBy    : {
                        relation: false, // false or relation name
                        field   : 'id',
                        desc    : true
                    },
                    // orderBy   : 'id',
                    // direction : 'desc',
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
                        'role_id'      : 'role_id',
                        'photo'        : 'photo',
                        'active'       : 'active',
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
                    actionType    : 'delete_user',
                    storeInDeletes: true,
                    validations   : {
                        'id': 'required|min:1|max:15', // '*.id' : 'required|min:1|max:15',
                    }
                },
                options  : {
                    role_id      : [],
                },
                option   : {
                    modalAdd : {
                        role_id      : {},
                    },
                    modalEdit: {
                        role_id      : {},
                        active       : {},
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
                            'id'        : d['id'],
                            'photo'     : d['photo'],
                            'name'      : d['name'],
                            'username'  : d['username'],
                            'email'     : d['email'],
                            'address'   : d['address'],
                            'phone'     : d['phone'],
                            'role'      : d['role'] ? d['role']['name'] : '', // use relation name a key for relations
                            'active'    : d['active'] == 1 ? 'Active' : 'Inactive',
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
                this.modalEdit.form.reset();
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
                            style: 'width: 170px;',
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
                            data : 'Full Name',
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
                            data : 'Photo',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : `<img style="height: 120px; width: 120px; object-fit: contain;" src = "/uploads/avatar/` + modalData.photo + `" onerror = "src='/img/avatar.png'">`,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Username',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.username,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Email',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.email,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Address',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.address,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Phone',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.phone,
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        }
                    ],
                    [
                        {
                            data : 'Role',
                            class: '',
                            style: '',
                            scope: '',
                            span : '',
                        },
                        {
                            data : modalData.role ? modalData.role.name : '-',
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
