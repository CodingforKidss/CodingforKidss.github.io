<template>
    <div>
        <div class = "row" id = "mainSection">
            <div class = "col-md-12">
                <div class = "card">
                    <div class = "row ml-1 mr-1">
                        <div class = "col-md-8">
                            <div class = "card-header">
                                <h4 class = "card-title" v-if = "page.viewType && page.viewType === 'add'">Add Employee</h4>
                                <h4 class = "card-title"
                                        v-if = "page.viewType && page.viewType === 'edit' && page.user && page.user['role'] && page.user['role']['name'] && page.user['role']['name'] !== 'Employee'">
                                    Edit Employee</h4>
                                <h4 class = "card-title"
                                        v-if = "page.viewType && page.viewType === 'edit' && page.user && page.user['role'] && page.user['role']['name'] && page.user['role']['name'] === 'Employee'">
                                    Edit Profile</h4>
                                <h4 class = "card-title"
                                        v-if = "page.viewType && page.viewType === 'view' && page.user && page.user['role'] && page.user['role']['name'] && page.user['role']['name'] !== 'Employee'">
                                    Employee Details</h4>
                                <h4 class = "card-title"
                                        v-if = "page.viewType && page.viewType === 'view' && page.user && page.user['role'] && page.user['role']['name'] && page.user['role']['name'] === 'Employee'">
                                    My Profile</h4>
                                <p class = "card-category" v-if = "page.viewType && page.viewType === 'add'">Add New Employee</p>
                                <p class = "card-category"
                                        v-if = "page.viewType && page.viewType === 'edit' && page.user && page.user['role'] && page.user['role']['name'] && page.user['role']['name'] !== 'Employee'">
                                    Edit Employee Information</p>
                                <p class = "card-category"
                                        v-if = "page.viewType && page.viewType === 'edit' && page.user && page.user['role'] && page.user['role']['name'] && page.user['role']['name'] === 'Employee'">
                                    Edit Profile Information</p>
                                <p class = "card-category"
                                        v-if = "page.viewType && page.viewType === 'view' && page.user && page.user['role'] && page.user['role']['name'] && page.user['role']['name'] !== 'Employee'">
                                    View Details of an Employee</p>
                                <p class = "card-category"
                                        v-if = "page.viewType && page.viewType === 'view' && page.user && page.user['role'] && page.user['role']['name'] && page.user['role']['name'] === 'Employee'">
                                    View My Profile Details</p><br>
                            </div>
                        </div>
                        <div class = "col-md-4" style = "margin-top: 36px;">
                            <div class = "btn-group pull-right" data-toggle = "buttons">
                                <button @click.prevent = "printDiv(page.print, page.print.printType, dataTable['data'])" class = "btn btn-outline-info group-btn-1 btn-12" type = "button">
                                    <i class = "fas fa-print"></i>&nbsp;Print
                                </button>
                                <button v-if = "page.viewType === 'add'"
                                        @click.prevent = "onModalFormSubmit(ItemAddUrl, modalAdd.form.data(), modalAdd.dbInsert, dbQuery, page.vuexKey)"
                                        class = "btn btn-outline-primary group-btn-2 btn-12"
                                        data-toggle = "modal"
                                        type = "button">
                                    <i class = "fas fa-edit"></i>&nbsp;Submit
                                </button>
                                <button v-if = "page.viewType === 'edit'"
                                        @click.prevent = "switchViewType()"
                                        class = "btn btn-outline-warning group-btn-2 btn-12"
                                        data-toggle = "modal"
                                        type = "button">
                                    <i class = "fas fa-eye"></i>&nbsp;View
                                </button>
                                <button v-if = "page.viewType === 'view'"
                                        @click.prevent = "switchViewType()"
                                        class = "btn btn-outline-success group-btn-2 btn-12"
                                        data-toggle = "modal"
                                        type = "button">
                                    <i class = "fas fa-edit"></i>&nbsp;Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <template v-if = "page.viewType === 'view' && dataTable['data'] && dataTable['data'][0]">
                    <div class = "row justify-content-center card-modal-view">
                        <div class = "col-4">
                            <div class = "card">
                                <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                    <div class = "table-responsive">
                                        <div class = "card-title-2">Basic Details</div>
                                        <div class = "row">
                                            <div class = "col-12">
                                                <div class = "picture-div-2" style = "height: 240px; background-size: 70px;">
                                                    <div style = "width: 100%; height: 100%;" v-if = "dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['photo']">
                                                        <img :src = "'/uploads/avatar/' + dataTable['data'][0]['photo']" class = "picture-img-src" alt = "">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class = "row">
                                            <div class = "col">
                                                <div class = "cmv-label">Employee Name</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['name'] ? dataTable['data'][0]['name'] : '-'}}</div>
                                            </div>
                                        </div>
                                        <div class = "row">
                                            <div class = "col">
                                                <div class = "cmv-label">Email</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['email'] ? dataTable['data'][0]['email'] : -''}}</div>
                                            </div>
                                        </div>
                                        <div class = "row">
                                            <div class = "col">
                                                <div class = "cmv-label">Phone</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['phone'] ? dataTable['data'][0]['phone'] : '-'}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "col-8">
                            <div class = "card">
                                <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                    <div class = "table-responsive">
                                        <div class = "card-title-2">Personal Details</div>
                                        <div class = "row">
                                            <div class = "col">
                                                <div class = "cmv-label">Address</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['address'] ? dataTable['data'][0]['address'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col-4">
                                                <div class = "cmv-label">City</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['city_id'] ? dataTable['data'][0]['city_id'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Country</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['country'] && dataTable['data'][0]['country']['name'] ? dataTable['data'][0]['country']['name'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Post Code</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['post_code'] ? dataTable['data'][0]['post_code'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col-4">
                                                <div class = "cmv-label">Nationality</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['nationality'] && dataTable['data'][0]['nationality']['name'] ? dataTable['data'][0]['nationality']['name'] : '-'}}</div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Date of Birth</div>
                                                <div class = "cmv-text">{{dataTable['data'][0]['date_of_birth'] | dateFormatDMYD}}</div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Blood Group</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['blood_group'] ? dataTable['data'][0]['blood_group'] : '-'}}</div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col-4">
                                                <div class = "cmv-label">Gender</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['gender'] ? dataTable['data'][0]['gender'] : '-'}}</div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Religion</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['religion'] ? dataTable['data'][0]['religion'] : '-'}}</div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Marital Status</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['marital_status'] ? dataTable['data'][0]['marital_status'] : '-'}}</div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "row justify-content-center card-modal-view">
                        <div class = "col-4">
                            <div class = "card">
                                <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                    <div class = "table-responsive">
                                        <div class = "card-title-2">Document Information</div>
                                        <div class = "row">
                                            <div class = "col">
                                                <div class = "cmv-label">Passport No</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['passport_no'] ? dataTable['data'][0]['passport_no'] : '-'}}</div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col">
                                                <div class = "cmv-label">Driving License</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['driving_license'] ? dataTable['data'][0]['driving_license'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col">
                                                <div class = "cmv-label">NID/IC</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['nid'] ? dataTable['data'][0]['nid'] : '-'}}</div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "col-8">
                            <div class = "card">
                                <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                    <div class = "table-responsive">
                                        <div class = "card-title-2">Emergency Contact Details</div>
                                        <div class = "row">
                                            <div class = "col-8">
                                                <div class = "cmv-label">Name</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['emergency_name'] ? dataTable['data'][0]['emergency_name'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Phone Number</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['emergency_phone'] ? dataTable['data'][0]['emergency_phone'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col">
                                                <div class = "cmv-label">Address</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['emergency_address'] ? dataTable['data'][0]['emergency_address'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col-4">
                                                <div class = "cmv-label">City</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['emergency_city_id'] ? dataTable['data'][0]['emergency_city_id'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Post Code</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['emergency_post_code'] ? dataTable['data'][0]['emergency_post_code'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-4">
                                                <div class = "cmv-label">Country</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['emergency_country'] ? dataTable['data'][0]['emergency_country']['name'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "row justify-content-center card-modal-view">
                        <div class = "col-12">
                            <div class = "card">
                                <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                    <div class = "table-responsive">
                                        <div class = "card-title-2">Job Details</div>
                                        <div class = "row">
                                            <div class = "col-3">
                                                <div class = "cmv-label">Department</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['department'] ? dataTable['data'][0]['department']['name'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-3">
                                                <div class = "cmv-label">Designation</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['designation'] ? dataTable['data'][0]['designation']['name'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-3">
                                                <div class = "cmv-label">Joining Date</div>
                                                <div class = "cmv-text">{{dataTable['data'][0]['joining_date'] | dateFormatDMYD}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-3">
                                                <div class = "cmv-label">Resign Date</div>
                                                <div class = "cmv-text">{{dataTable['data'][0]['resign_date'] | dateFormatDMYD}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div>
                                        <div class = "row">
                                            <div class = "col-3">
                                                <div class = "cmv-label">Salary</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['pay_rate'] ? dataTable['data'][0]['pay_rate'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-3">
                                                <div class = "cmv-label">Pay Rate</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['pay_rate_unit_type'] ? ('/' + dataTable['data'][0]['pay_rate_unit_type']['name']) : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-3">
                                                <div class = "cmv-label">Shift</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['shift'] ? dataTable['data'][0]['shift']['name'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-3">
                                                <div class = "cmv-label">Work Days</div>
                                                <div class = "cmv-text" v-if = "dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['work_days']">
                                                    <div v-for = "data in dataTable['data'][0]['work_days']">{{data['name']}}</div>
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col-3">
                                                <div class = "cmv-label">Employement Type</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['employement_type'] ? dataTable['data'][0]['employement_type'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                            <div class = "col-3">
                                                <div class = "cmv-label">Employee Number</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['employee_no'] ? dataTable['data'][0]['employee_no'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                        <div class = "row">
                                            <div class = "col-12">
                                                <div class = "cmv-label">About Me</div>
                                                <div class = "cmv-text">{{dataTable && dataTable['data'] && dataTable['data'][0] && dataTable['data'][0]['description'] ? dataTable['data'][0]['description'] : '-'}}
                                                </div>
                                            </div> <!-- FORM COL -->
                                        </div> <!-- FORM ROW -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if = "page.viewType === 'add'">
                    <form class = "form-modal paper-form" @submit.prevent = "onModalFormSubmit(ItemAddUrl, modalAdd.form.data(), modalAdd.dbInsert, dbQuery, page.vuexKey)">
                        <div class = "row justify-content-center">
                            <div class = "col-4">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Basic Details</div>
                                            <div class = "form-row">
                                                <div class = "col-12">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form['photo'] && $v.modalAdd.form['photo'].$error ? 'form-group--error' : '', 'form-group']">
                                                        <div class = "picture-div-2" style = "height: 240px; background-size: 70px;">
                                                            <div style = "width: 100%; height: 100%;">
                                                                <div class = "picture-div-progress"
                                                                        :style = "[modalAdd.uploadPercentage && modalAdd.uploadPercentage > 0 ? {'display': 'block'} : {'display': 'none'}]">
                                                                    Uploading:
                                                                    <b>{{ modalAdd.uploadPercentage && modalAdd.uploadPercentage >= 0 ? modalAdd.uploadPercentage + '%' : modalAdd.uploadPercentage }}</b>
                                                                </div>
                                                                <img :src = "modalAdd.inputs.photo.image.imageSrc" class = "picture-img-src" alt = "">
                                                                <i class = "fas fa-times"
                                                                        :class = "modalAdd.inputs.photo.image.clearButton.class"
                                                                        data-toggle = "tooltip"
                                                                        title = "Remove Photo"
                                                                        @click.prevent = "clearPhoto($event, modalAdd.inputs.photo.image.onChange, modalAdd.inputs.photo.image.clearButton.props)"
                                                                        v-if = "modalAdd.inputs.photo.image.imageSrc && modalAdd.inputs.photo.image.imageSrc.length > 0"></i>
                                                            </div>
                                                            <input class = "form-control"
                                                                    id = "photo"
                                                                    :type = "modalAdd.inputs.photo.type"
                                                                    @change = "onImageFileChange($event, modalAdd.inputs.photo.image.onChange)">
                                                        </div>
                                                        <div class = "error" v-if = "$v.modalAdd.form['photo']['required'] === false">
                                                            Photo is Required
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- FORM ROW --><br>
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.name.formControlName] && $v.modalAdd.form[modalAdd.inputs.name.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.name.formControlName">Employee Name</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.name.formControlName"
                                                                :name = "modalAdd.inputs.name.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.name.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.name.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.name.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.name.formControlName]['required'] === false">
                                                            Employee Name is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.email.formControlName] && $v.modalAdd.form[modalAdd.inputs.email.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.email.formControlName">Email</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.email.formControlName"
                                                                :name = "modalAdd.inputs.email.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.email.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.email.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.email.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.email.formControlName]['required'] === false">
                                                            Email is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.phone.formControlName] && $v.modalAdd.form[modalAdd.inputs.phone.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.phone.formControlName">Phone</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.phone.formControlName"
                                                                :name = "modalAdd.inputs.phone.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.phone.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.phone.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.phone.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.phone.formControlName]['required'] === false">
                                                            Phone Number is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-8">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Personal Details</div>
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.address.formControlName] && $v.modalAdd.form[modalAdd.inputs.address.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.address.formControlName">Address</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.address.formControlName"
                                                                :name = "modalAdd.inputs.address.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.address.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.address.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.address.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.address.formControlName]['required'] === false">
                                                            Address is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.city_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.city_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.city_id.formControlName">City</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.city_id.formControlName"
                                                                :name = "modalAdd.inputs.city_id.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.city_id.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.city_id.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.city_id.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.city_id.formControlName]['required'] === false">
                                                            City is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.country_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.country_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.country_id.formControlName">Country</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.country_id.formControlName"
                                                                :name = "modalAdd.inputs.country_id.formControlName"
                                                                :options = "options[modalAdd.inputs.country_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.country_id.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.country_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.country_id.formControlName]['required'] === false">
                                                            Country is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.post_code.formControlName] && $v.modalAdd.form[modalAdd.inputs.post_code.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.post_code.formControlName">Post Code</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.post_code.formControlName"
                                                                :name = "modalAdd.inputs.post_code.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.post_code.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.post_code.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.post_code.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.post_code.formControlName]['required'] === false">
                                                            Post Code is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.nationality_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.nationality_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.nationality_id.formControlName">Nationality</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.nationality_id.formControlName"
                                                                :name = "modalAdd.inputs.nationality_id.formControlName"
                                                                :options = "options[modalAdd.inputs.nationality_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.nationality_id.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.nationality_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.nationality_id.formControlName]['required'] === false">
                                                            Nationality is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.date_of_birth.formControlName] && $v.modalAdd.form[modalAdd.inputs.date_of_birth.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.date_of_birth.formControlName">Date of Birth</label>

                                                        <div class = "form-control no-padding">
                                                            <el-date-picker class = "datepicker-custom"
                                                                    :id = "modalAdd.inputs.date_of_birth.formControlName"
                                                                    :name = "modalAdd.inputs.date_of_birth.formControlName"
                                                                    placeholder = ""
                                                                    type = "date"
                                                                    align = "center"
                                                                    :clearable = "true"
                                                                    :editable = "true"
                                                                    :format = "modalAdd.inputs.date_of_birth.dateTime.displayFormat"
                                                                    :value-format = "modalAdd.inputs.date_of_birth.dateTime.valueFormat"
                                                                    v-model = "modalAdd.form[modalAdd.inputs.date_of_birth.formControlName]"
                                                                    @input = "onDateInput($event, modalAdd.inputs.date_of_birth.formControlName, modalAdd.inputs.date_of_birth.dateTime.valueFormat)"></el-date-picker>
                                                            <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.date_of_birth.formControlName]['required'] === false">
                                                                Date of Birth is Required
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.blood_group.formControlName] && $v.modalAdd.form[modalAdd.inputs.blood_group.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.blood_group.formControlName">Blood Group</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.blood_group.formControlName"
                                                                :name = "modalAdd.inputs.blood_group.formControlName"
                                                                :options = "options[modalAdd.inputs.blood_group.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.blood_group.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.blood_group.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.blood_group.formControlName]['required'] === false">
                                                            Blood Group is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.gender.formControlName] && $v.modalAdd.form[modalAdd.inputs.gender.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.gender.formControlName">Gender</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.gender.formControlName"
                                                                :name = "modalAdd.inputs.gender.formControlName"
                                                                :options = "options[modalAdd.inputs.gender.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.gender.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.gender.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.gender.formControlName]['required'] === false">
                                                            Gender is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.religion.formControlName] && $v.modalAdd.form[modalAdd.inputs.religion.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.religion.formControlName">Religion</label>

                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.religion.formControlName"
                                                                :name = "modalAdd.inputs.religion.formControlName"
                                                                :options = "options[modalAdd.inputs.religion.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.religion.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.religion.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.religion.formControlName]['required'] === false">
                                                            Religion is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.marital_status.formControlName] && $v.modalAdd.form[modalAdd.inputs.marital_status.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.marital_status.formControlName">Marital Status</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.marital_status.formControlName"
                                                                :name = "modalAdd.inputs.marital_status.formControlName"
                                                                :options = "options[modalAdd.inputs.marital_status.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.marital_status.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.marital_status.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.marital_status.formControlName]['required'] === false">
                                                            Marital Status is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row justify-content-center">
                            <div class = "col-4">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Document Information</div>
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.passport_no.formControlName] && $v.modalAdd.form[modalAdd.inputs.passport_no.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.passport_no.formControlName">Passport No</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.passport_no.formControlName"
                                                                :name = "modalAdd.inputs.passport_no.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.passport_no.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.passport_no.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.passport_no.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.passport_no.formControlName]['required'] === false">
                                                            Passport No is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.driving_license.formControlName] && $v.modalAdd.form[modalAdd.inputs.driving_license.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.driving_license.formControlName">Driving License (Optional)</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.driving_license.formControlName"
                                                                :name = "modalAdd.inputs.driving_license.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.driving_license.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.driving_license.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.driving_license.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.driving_license.formControlName]['required'] === false">
                                                            Driving License is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.nid.formControlName] && $v.modalAdd.form[modalAdd.inputs.nid.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.nid.formControlName">NID/IC</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.nid.formControlName"
                                                                :name = "modalAdd.inputs.nid.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.nid.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.nid.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.nid.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.nid.formControlName]['required'] === false">
                                                            NID/IC is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-8">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Emergency Contact Details</div>
                                            <div class = "form-row">
                                                <div class = "col-8">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.emergency_name.formControlName] && $v.modalAdd.form[modalAdd.inputs.emergency_name.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.emergency_name.formControlName">Name</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.emergency_name.formControlName"
                                                                :name = "modalAdd.inputs.emergency_name.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.emergency_name.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.emergency_name.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.emergency_name.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.emergency_name.formControlName]['required'] === false">
                                                            Name is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.emergency_phone.formControlName] && $v.modalAdd.form[modalAdd.inputs.emergency_phone.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.emergency_phone.formControlName">Phone Number</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.emergency_phone.formControlName"
                                                                :name = "modalAdd.inputs.emergency_phone.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.emergency_phone.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.emergency_phone.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.emergency_phone.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.emergency_phone.formControlName]['required'] === false">
                                                            Phone Number is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.emergency_address.formControlName] && $v.modalAdd.form[modalAdd.inputs.emergency_address.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.emergency_address.formControlName">Address</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.emergency_address.formControlName"
                                                                :name = "modalAdd.inputs.emergency_address.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.emergency_address.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.emergency_address.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.emergency_address.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.emergency_address.formControlName]['required'] === false">
                                                            Address is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.emergency_city_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.emergency_city_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.emergency_city_id.formControlName">City</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.emergency_city_id.formControlName"
                                                                :name = "modalAdd.inputs.emergency_city_id.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.emergency_city_id.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.emergency_city_id.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.emergency_city_id.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.emergency_city_id.formControlName]['required'] === false">
                                                            City is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.emergency_post_code.formControlName] && $v.modalAdd.form[modalAdd.inputs.emergency_post_code.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.emergency_post_code.formControlName">Post Code</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.emergency_post_code.formControlName"
                                                                :name = "modalAdd.inputs.emergency_post_code.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.emergency_post_code.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.emergency_post_code.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.emergency_post_code.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.emergency_post_code.formControlName]['required'] === false">
                                                            Post Code is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-5">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.emergency_country_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.emergency_country_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.emergency_country_id.formControlName">Country</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.emergency_country_id.formControlName"
                                                                :name = "modalAdd.inputs.emergency_country_id.formControlName"
                                                                :options = "options[modalAdd.inputs.emergency_country_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.emergency_country_id.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.emergency_country_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.emergency_country_id.formControlName]['required'] === false">
                                                            Country is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row justify-content-center">
                            <div class = "col-12">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Job Details</div>
                                            <div class = "form-row">
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.department_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.department_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.department_id.formControlName">Department</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.department_id.formControlName"
                                                                :name = "modalAdd.inputs.department_id.formControlName"
                                                                :options = "options[modalAdd.inputs.department_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.department_id.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.department_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.department_id.formControlName]['required'] === false">
                                                            Department is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.designation_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.designation_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.designation_id.formControlName">Designation</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.designation_id.formControlName"
                                                                :name = "modalAdd.inputs.designation_id.formControlName"
                                                                :options = "options[modalAdd.inputs.designation_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.designation_id.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.designation_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.designation_id.formControlName]['required'] === false">
                                                            Designation is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.joining_date.formControlName] && $v.modalAdd.form[modalAdd.inputs.joining_date.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.joining_date.formControlName">Joining Date</label>

                                                        <div class = "form-control no-padding">
                                                            <el-date-picker class = "datepicker-custom"
                                                                    :id = "modalAdd.inputs.joining_date.formControlName"
                                                                    :name = "modalAdd.inputs.joining_date.formControlName"
                                                                    placeholder = ""
                                                                    type = "date"
                                                                    align = "center"
                                                                    :clearable = "true"
                                                                    :editable = "true"
                                                                    :format = "modalAdd.inputs.joining_date.dateTime.displayFormat"
                                                                    :value-format = "modalAdd.inputs.joining_date.dateTime.valueFormat"
                                                                    v-model = "modalAdd.form[modalAdd.inputs.joining_date.formControlName]"
                                                                    @input = "onDateInput($event, modalAdd.inputs.joining_date.formControlName, modalAdd.inputs.joining_date.dateTime.valueFormat)"></el-date-picker>
                                                            <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.joining_date.formControlName]['required'] === false">
                                                                Joining Date is Required
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.resign_date.formControlName] && $v.modalAdd.form[modalAdd.inputs.resign_date.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.resign_date.formControlName">Resign Date</label>

                                                        <div class = "form-control no-padding">
                                                            <el-date-picker class = "datepicker-custom"
                                                                    :id = "modalAdd.inputs.resign_date.formControlName"
                                                                    :name = "modalAdd.inputs.resign_date.formControlName"
                                                                    placeholder = ""
                                                                    type = "date"
                                                                    align = "center"
                                                                    :clearable = "true"
                                                                    :editable = "true"
                                                                    :format = "modalAdd.inputs.resign_date.dateTime.displayFormat"
                                                                    :value-format = "modalAdd.inputs.resign_date.dateTime.valueFormat"
                                                                    v-model = "modalAdd.form[modalAdd.inputs.resign_date.formControlName]"
                                                                    @input = "onDateInput($event, modalAdd.inputs.resign_date.formControlName, modalAdd.inputs.resign_date.dateTime.valueFormat)"></el-date-picker>
                                                            <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.resign_date.formControlName]['required'] === false">
                                                                Resign Date is Required
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div>
                                            <div class = "form-row">
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName] && $v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.pay_rate.formControlName">Salary</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.pay_rate.formControlName"
                                                                :name = "modalAdd.inputs.pay_rate.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.pay_rate.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.pay_rate.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName]['required'] === false">
                                                            Salary is Required
                                                        </div>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName]['decimal'] === false">
                                                            Must be Number
                                                        </div>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName]['minValue'] === false">
                                                            Minimum Value can not be less than {{$v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName].$params['minValue']['min']}}
                                                        </div>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName]['maxValue'] === false">
                                                            Maximum Value can not be more than {{$v.modalAdd.form[modalAdd.inputs.pay_rate.formControlName].$params['maxValue']['max']}}
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.pay_rate_unit_type_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.pay_rate_unit_type_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.pay_rate_unit_type_id.formControlName">Pay Rate</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.pay_rate_unit_type_id.formControlName"
                                                                :name = "modalAdd.inputs.pay_rate_unit_type_id.formControlName"
                                                                :options = "options[modalAdd.inputs.pay_rate_unit_type_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.pay_rate_unit_type_id.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.pay_rate_unit_type_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.pay_rate_unit_type_id.formControlName]['required'] === false">
                                                            Pay Rate is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.shift_id.formControlName] && $v.modalAdd.form[modalAdd.inputs.shift_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.shift_id.formControlName">Shift</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.shift_id.formControlName"
                                                                :name = "modalAdd.inputs.shift_id.formControlName"
                                                                :options = "options[modalAdd.inputs.shift_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.shift_id.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.shift_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.shift_id.formControlName]['required'] === false">
                                                            Shift is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.work_days.formControlName] && $v.modalAdd.form[modalAdd.inputs.work_days.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.work_days.formControlName">Work Days</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "false"
                                                                :clear-on-select = "false"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.work_days.formControlName"
                                                                :name = "modalAdd.inputs.work_days.formControlName"
                                                                :options = "options[modalAdd.inputs.work_days.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                :multiple = "true"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.work_days.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.work_days.multiSelect.option_id]">
                                                            <template slot = "selection" slot-scope = "{ values, search, isOpen }"><span class = "multiselect__single"
                                                                    v-if = "values.length &amp;&amp; !isOpen">{{ values.length }} day(s) selected</span>
                                                            </template>
                                                        </multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.work_days.formControlName]['required'] === false">
                                                            Work Days is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.employement_type.formControlName] && $v.modalAdd.form[modalAdd.inputs.employement_type.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.employement_type.formControlName">Employment Type</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalAdd.inputs.employement_type.formControlName"
                                                                :name = "modalAdd.inputs.employement_type.formControlName"
                                                                :options = "options[modalAdd.inputs.employement_type.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput($event, modalAdd.inputs.employement_type.formControlName, modalAdd.formKey)"
                                                                v-model = "option.modalAdd[modalAdd.inputs.employement_type.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.employement_type.formControlName]['required'] === false">
                                                            Employment Type is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.employee_no.formControlName] && $v.modalAdd.form[modalAdd.inputs.employee_no.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.employee_no.formControlName">Employee Number</label>
                                                        <input class = "form-control"
                                                                :id = "modalAdd.inputs.employee_no.formControlName"
                                                                :name = "modalAdd.inputs.employee_no.formControlName"
                                                                placeholder = ""
                                                                :type = "modalAdd.inputs.employee_no.type"
                                                                v-model = "modalAdd.form[modalAdd.inputs.employee_no.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.employee_no.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.employee_no.formControlName]['required'] === false">
                                                            Employee Number is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-12">
                                                    <div :class = "[$v.modalAdd.form && $v.modalAdd.form[modalAdd.inputs.description.formControlName] && $v.modalAdd.form[modalAdd.inputs.description.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalAdd.inputs.description.formControlName">About Me</label>
                                                        <textarea class = "form-control"
                                                                :id = "modalAdd.inputs.description.formControlName"
                                                                :name = "modalAdd.inputs.description.formControlName"
                                                                placeholder = ""
                                                                rows = "7"
                                                                v-model = "modalAdd.form[modalAdd.inputs.description.formControlName]"
                                                                v-model.trim = "$v.modalAdd.form[modalAdd.inputs.description.formControlName].$model"></textarea>
                                                        <div class = "error" v-if = "$v.modalAdd.form[modalAdd.inputs.description.formControlName]['required'] === false">
                                                            About Me is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "statusDiv" v-if = "modalAdd.statusDiv.show">
                                                <div :class = "[modalAdd.statusDiv.class]" v-for = "statusMsgs in modalAdd.statusDiv.messages">
                                                    <p v-html = "statusMsgs"></p>
                                                </div>
                                            </div>
                                            <div style = "text-align: center;">
                                                <button class = "btn btn-primary button-single" type = "submit">
                                                    Submit
                                                    <i :class = "[modalAdd.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-save']" aria-hidden = "true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </template>
                <template v-if = "page.viewType === 'edit'">
                    <form class = "form-modal paper-form" @submit.prevent = "onModalFormSubmit2(ItemAddUrl, modalEdit.form.data(), modalEdit.dbInsert, dbQuery, page.vuexKey, modalEdit.formKey)">
                        <div class = "row justify-content-center">
                            <div class = "col-4">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Basic Details</div>
                                            <div class = "form-row">
                                                <div class = "col-12">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form['photo'] && $v.modalEdit.form['photo'].$error ? 'form-group--error' : '', 'form-group']">
                                                        <div class = "picture-div-2" style = "height: 240px; background-size: 70px;">
                                                            <div style = "width: 100%; height: 100%;">
                                                                <div class = "picture-div-progress"
                                                                        :style = "[modalEdit.uploadPercentage && modalEdit.uploadPercentage > 0 ? {'display': 'block'} : {'display': 'none'}]">
                                                                    Uploading:
                                                                    <b>{{ modalEdit.uploadPercentage && modalEdit.uploadPercentage >= 0 ? modalEdit.uploadPercentage + '%' : modalEdit.uploadPercentage }}</b>
                                                                </div>
                                                                <img :src = "modalEdit.inputs.photo.image.imageSrc" class = "picture-img-src" alt = "">
                                                                <i class = "fas fa-times"
                                                                        :class = "modalEdit.inputs.photo.image.clearButton.class"
                                                                        data-toggle = "tooltip"
                                                                        title = "Remove Photo"
                                                                        @click.prevent = "clearPhoto($event, modalEdit.inputs.photo.image.onChange, modalEdit.inputs.photo.image.clearButton.props)"
                                                                        v-if = "modalEdit.inputs.photo.image.imageSrc && modalEdit.inputs.photo.image.imageSrc.length > 0"></i>
                                                            </div>
                                                            <input class = "form-control"
                                                                    :type = "modalEdit.inputs.photo.type"
                                                                    @change = "onImageFileChange($event, modalEdit.inputs.photo.image.onChange)">
                                                        </div>
                                                        <div class = "error" v-if = "$v.modalEdit.form['photo']['required'] === false">
                                                            Photo is Required
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- FORM ROW --><br>
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.name.formControlName] && $v.modalEdit.form[modalEdit.inputs.name.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.name.formControlName">Employee Name</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.name.formControlName"
                                                                :name = "modalEdit.inputs.name.formControlName"
                                                                placeholder = ""
                                                                :readonly = "page.user['role']['name'] === 'Employee'"
                                                                :type = "modalEdit.inputs.name.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.name.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.name.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.name.formControlName]['required'] === false">
                                                            Employee Name is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.email.formControlName] && $v.modalEdit.form[modalEdit.inputs.email.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.email.formControlName">Email</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.email.formControlName"
                                                                :name = "modalEdit.inputs.email.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.email.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.email.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.email.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.email.formControlName]['required'] === false">
                                                            Email is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.phone.formControlName] && $v.modalEdit.form[modalEdit.inputs.phone.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.phone.formControlName">Phone</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.phone.formControlName"
                                                                :name = "modalEdit.inputs.phone.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.phone.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.phone.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.phone.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.phone.formControlName]['required'] === false">
                                                            Phone Number is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-8">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Personal Details</div>
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.address.formControlName] && $v.modalEdit.form[modalEdit.inputs.address.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.address.formControlName">Address</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.address.formControlName"
                                                                :name = "modalEdit.inputs.address.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.address.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.address.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.address.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.address.formControlName]['required'] === false">
                                                            Address is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.city_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.city_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.city_id.formControlName">City</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.city_id.formControlName"
                                                                :name = "modalEdit.inputs.city_id.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.city_id.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.city_id.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.city_id.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.city_id.formControlName]['required'] === false">
                                                            City is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.country_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.country_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.country_id.formControlName">Country</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.country_id.formControlName"
                                                                :name = "modalEdit.inputs.country_id.formControlName"
                                                                :options = "options[modalEdit.inputs.country_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.country_id.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.country_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.country_id.formControlName]['required'] === false">
                                                            Country is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.post_code.formControlName] && $v.modalEdit.form[modalEdit.inputs.post_code.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.post_code.formControlName">Post Code</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.post_code.formControlName"
                                                                :name = "modalEdit.inputs.post_code.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.post_code.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.post_code.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.post_code.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.post_code.formControlName]['required'] === false">
                                                            Post Code is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.nationality_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.nationality_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.nationality_id.formControlName">Nationality</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.nationality_id.formControlName"
                                                                :name = "modalEdit.inputs.nationality_id.formControlName"
                                                                :options = "options[modalEdit.inputs.nationality_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.nationality_id.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.nationality_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.nationality_id.formControlName]['required'] === false">
                                                            Nationality is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.date_of_birth.formControlName] && $v.modalEdit.form[modalEdit.inputs.date_of_birth.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.date_of_birth.formControlName">Date of Birth</label>
                                                        <div class = "form-control no-padding">
                                                            <el-date-picker class = "datepicker-custom"
                                                                    :id = "modalEdit.inputs.date_of_birth.formControlName"
                                                                    :name = "modalEdit.inputs.date_of_birth.formControlName"
                                                                    placeholder = ""
                                                                    :readonly = "page.user['role']['name'] === 'Employee'"
                                                                    type = "date"
                                                                    align = "center"
                                                                    :clearable = "true"
                                                                    :editable = "true"
                                                                    :format = "modalEdit.inputs.date_of_birth.dateTime.displayFormat"
                                                                    :value-format = "modalEdit.inputs.date_of_birth.dateTime.valueFormat"
                                                                    v-model = "modalEdit.form[modalEdit.inputs.date_of_birth.formControlName]"
                                                                    @input = "onDateInput($event, modalEdit.inputs.date_of_birth.formControlName, modalEdit.inputs.date_of_birth.dateTime.valueFormat)"></el-date-picker>
                                                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.date_of_birth.formControlName]['required'] === false">
                                                                Date of Birth is Required
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.blood_group.formControlName] && $v.modalEdit.form[modalEdit.inputs.blood_group.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.blood_group.formControlName">Blood Group</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.blood_group.formControlName"
                                                                :name = "modalEdit.inputs.blood_group.formControlName"
                                                                :options = "options[modalEdit.inputs.blood_group.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.blood_group.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.blood_group.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.blood_group.formControlName]['required'] === false">
                                                            Blood Group is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.gender.formControlName] && $v.modalEdit.form[modalEdit.inputs.gender.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.gender.formControlName">Gender</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.gender.formControlName"
                                                                :name = "modalEdit.inputs.gender.formControlName"
                                                                :options = "options[modalEdit.inputs.gender.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :disabled = "page.user['role']['name'] === 'Employee'"
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.gender.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.gender.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.gender.formControlName]['required'] === false">
                                                            Gender is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.religion.formControlName] && $v.modalEdit.form[modalEdit.inputs.religion.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.religion.formControlName">Religion</label>

                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.religion.formControlName"
                                                                :name = "modalEdit.inputs.religion.formControlName"
                                                                :options = "options[modalEdit.inputs.religion.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.religion.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.religion.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.religion.formControlName]['required'] === false">
                                                            Religion is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.marital_status.formControlName] && $v.modalEdit.form[modalEdit.inputs.marital_status.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.marital_status.formControlName">Marital Status</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.marital_status.formControlName"
                                                                :name = "modalEdit.inputs.marital_status.formControlName"
                                                                :options = "options[modalEdit.inputs.marital_status.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.marital_status.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.marital_status.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.marital_status.formControlName]['required'] === false">
                                                            Marital Status is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row justify-content-center">
                            <div class = "col-4">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Document Information</div>
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.passport_no.formControlName] && $v.modalEdit.form[modalEdit.inputs.passport_no.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.passport_no.formControlName">Passport No</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.passport_no.formControlName"
                                                                :name = "modalEdit.inputs.passport_no.formControlName"
                                                                placeholder = ""
                                                                :readonly = "page.user['role']['name'] === 'Employee'"
                                                                :type = "modalEdit.inputs.passport_no.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.passport_no.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.passport_no.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.passport_no.formControlName]['required'] === false">
                                                            Passport No is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.driving_license.formControlName] && $v.modalEdit.form[modalEdit.inputs.driving_license.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.driving_license.formControlName">Driving License (Optional)</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.driving_license.formControlName"
                                                                :name = "modalEdit.inputs.driving_license.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.driving_license.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.driving_license.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.driving_license.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.driving_license.formControlName]['required'] === false">
                                                            Driving License is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.nid.formControlName] && $v.modalEdit.form[modalEdit.inputs.nid.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.nid.formControlName">NID/IC</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.nid.formControlName"
                                                                :name = "modalEdit.inputs.nid.formControlName"
                                                                placeholder = ""
                                                                :readonly = "page.user['role']['name'] === 'Employee'"
                                                                :type = "modalEdit.inputs.nid.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.nid.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.nid.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.nid.formControlName]['required'] === false">
                                                            NID/IC is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-8">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Emergency Contact Details</div>
                                            <div class = "form-row">
                                                <div class = "col-8">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.emergency_name.formControlName] && $v.modalEdit.form[modalEdit.inputs.emergency_name.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.emergency_name.formControlName">Name</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.emergency_name.formControlName"
                                                                :name = "modalEdit.inputs.emergency_name.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.emergency_name.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.emergency_name.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.emergency_name.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.emergency_name.formControlName]['required'] === false">
                                                            Name is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.emergency_phone.formControlName] && $v.modalEdit.form[modalEdit.inputs.emergency_phone.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.emergency_phone.formControlName">Phone Number</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.emergency_phone.formControlName"
                                                                :name = "modalEdit.inputs.emergency_phone.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.emergency_phone.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.emergency_phone.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.emergency_phone.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.emergency_phone.formControlName]['required'] === false">
                                                            Phone Number is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.emergency_address.formControlName] && $v.modalEdit.form[modalEdit.inputs.emergency_address.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.emergency_address.formControlName">Address</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.emergency_address.formControlName"
                                                                :name = "modalEdit.inputs.emergency_address.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.emergency_address.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.emergency_address.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.emergency_address.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.emergency_address.formControlName]['required'] === false">
                                                            Address is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-4">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.emergency_city_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.emergency_city_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.emergency_city_id.formControlName">City</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.emergency_city_id.formControlName"
                                                                :name = "modalEdit.inputs.emergency_city_id.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.emergency_city_id.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.emergency_city_id.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.emergency_city_id.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.emergency_city_id.formControlName]['required'] === false">
                                                            City is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.emergency_post_code.formControlName] && $v.modalEdit.form[modalEdit.inputs.emergency_post_code.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.emergency_post_code.formControlName">Post Code</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.emergency_post_code.formControlName"
                                                                :name = "modalEdit.inputs.emergency_post_code.formControlName"
                                                                placeholder = ""
                                                                :type = "modalEdit.inputs.emergency_post_code.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.emergency_post_code.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.emergency_post_code.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.emergency_post_code.formControlName]['required'] === false">
                                                            Post Code is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-5">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.emergency_country_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.emergency_country_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.emergency_country_id.formControlName">Country</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.emergency_country_id.formControlName"
                                                                :name = "modalEdit.inputs.emergency_country_id.formControlName"
                                                                :options = "options[modalEdit.inputs.emergency_country_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.emergency_country_id.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.emergency_country_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.emergency_country_id.formControlName]['required'] === false">
                                                            Country is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row justify-content-center">
                            <div class = "col-12">
                                <div class = "card">
                                    <div class = "card-body" style = "padding: 0px 32px 10px 32px;">
                                        <div class = "table-responsive">
                                            <div class = "card-title-2">Job Details</div>
                                            <div class = "form-row">
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.department_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.department_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.department_id.formControlName">Department</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.department_id.formControlName"
                                                                :name = "modalEdit.inputs.department_id.formControlName"
                                                                :options = "options[modalEdit.inputs.department_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :disabled = "page.user['role']['name'] === 'Employee'"
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.department_id.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.department_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.department_id.formControlName]['required'] === false">
                                                            Department is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.designation_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.designation_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.designation_id.formControlName">Designation</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.designation_id.formControlName"
                                                                :name = "modalEdit.inputs.designation_id.formControlName"
                                                                :options = "options[modalEdit.inputs.designation_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :disabled = "page.user['role']['name'] === 'Employee'"
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.designation_id.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.designation_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.designation_id.formControlName]['required'] === false">
                                                            Designation is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.joining_date.formControlName] && $v.modalEdit.form[modalEdit.inputs.joining_date.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.joining_date.formControlName">Joining Date</label>

                                                        <div class = "form-control no-padding">
                                                            <el-date-picker class = "datepicker-custom"
                                                                    :id = "modalEdit.inputs.joining_date.formControlName"
                                                                    :name = "modalEdit.inputs.joining_date.formControlName"
                                                                    placeholder = ""
                                                                    :readonly = "page.user['role']['name'] === 'Employee'"
                                                                    type = "date"
                                                                    align = "center"
                                                                    :clearable = "true"
                                                                    :editable = "true"
                                                                    :format = "modalEdit.inputs.joining_date.dateTime.displayFormat"
                                                                    :value-format = "modalEdit.inputs.joining_date.dateTime.valueFormat"
                                                                    v-model = "modalEdit.form[modalEdit.inputs.joining_date.formControlName]"
                                                                    @input = "onDateInput($event, modalEdit.inputs.joining_date.formControlName, modalEdit.inputs.joining_date.dateTime.valueFormat)"></el-date-picker>
                                                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.joining_date.formControlName]['required'] === false">
                                                                Joining Date is Required
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.resign_date.formControlName] && $v.modalEdit.form[modalEdit.inputs.resign_date.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.resign_date.formControlName">Resign Date</label>

                                                        <div class = "form-control no-padding">
                                                            <el-date-picker class = "datepicker-custom"
                                                                    :id = "modalEdit.inputs.resign_date.formControlName"
                                                                    :name = "modalEdit.inputs.resign_date.formControlName"
                                                                    placeholder = ""
                                                                    :readonly = "page.user['role']['name'] === 'Employee'"
                                                                    type = "date"
                                                                    align = "center"
                                                                    :clearable = "true"
                                                                    :editable = "true"
                                                                    :format = "modalEdit.inputs.resign_date.dateTime.displayFormat"
                                                                    :value-format = "modalEdit.inputs.resign_date.dateTime.valueFormat"
                                                                    v-model = "modalEdit.form[modalEdit.inputs.resign_date.formControlName]"
                                                                    @input = "onDateInput($event, modalEdit.inputs.resign_date.formControlName, modalEdit.inputs.resign_date.dateTime.valueFormat)"></el-date-picker>
                                                            <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.resign_date.formControlName]['required'] === false">
                                                                Resign Date is Required
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div>
                                            <div class = "form-row">
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName] && $v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.pay_rate.formControlName">Salary</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.pay_rate.formControlName"
                                                                :name = "modalEdit.inputs.pay_rate.formControlName"
                                                                placeholder = ""
                                                                :readonly = "page.user['role']['name'] === 'Employee'"
                                                                :type = "modalEdit.inputs.pay_rate.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.pay_rate.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName]['required'] === false">
                                                            Salary is Required
                                                        </div>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName]['decimal'] === false">
                                                            Must be Number
                                                        </div>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName]['minValue'] === false">
                                                            Minimum Value can not be less than {{$v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName].$params['minValue']['min']}}
                                                        </div>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName]['maxValue'] === false">
                                                            Maximum Value can not be more than {{$v.modalEdit.form[modalEdit.inputs.pay_rate.formControlName].$params['maxValue']['max']}}
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.pay_rate_unit_type_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.pay_rate_unit_type_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.pay_rate_unit_type_id.formControlName">Pay Rate</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.pay_rate_unit_type_id.formControlName"
                                                                :name = "modalEdit.inputs.pay_rate_unit_type_id.formControlName"
                                                                :options = "options[modalEdit.inputs.pay_rate_unit_type_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :disabled = "page.user['role']['name'] === 'Employee'"
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.pay_rate_unit_type_id.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.pay_rate_unit_type_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.pay_rate_unit_type_id.formControlName]['required'] === false">
                                                            Pay Rate is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.shift_id.formControlName] && $v.modalEdit.form[modalEdit.inputs.shift_id.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.shift_id.formControlName">Shift</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.shift_id.formControlName"
                                                                :name = "modalEdit.inputs.shift_id.formControlName"
                                                                :options = "options[modalEdit.inputs.shift_id.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :disabled = "page.user['role']['name'] === 'Employee'"
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.shift_id.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.shift_id.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.shift_id.formControlName]['required'] === false">
                                                            Shift is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.work_days.formControlName] && $v.modalEdit.form[modalEdit.inputs.work_days.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.work_days.formControlName">Work Days</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "false"
                                                                :clear-on-select = "false"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.work_days.formControlName"
                                                                :name = "modalEdit.inputs.work_days.formControlName"
                                                                :options = "options[modalEdit.inputs.work_days.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :disabled = "page.user['role']['name'] === 'Employee'"
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                :multiple = "true"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.work_days.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.work_days.multiSelect.option_id]">
                                                            <template slot = "selection" slot-scope = "{ values, search, isOpen }"><span class = "multiselect__single"
                                                                    v-if = "values.length &amp;&amp; !isOpen">{{ values.length }} day(s) selected</span>
                                                            </template>
                                                        </multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.work_days.formControlName]['required'] === false">
                                                            Work Days is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.employement_type.formControlName] && $v.modalEdit.form[modalEdit.inputs.employement_type.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.employement_type.formControlName">Employment Type</label>
                                                        <multiselect :allow-empty = "true"
                                                                class = "form-control multiselect-in-modal multiselect-width-fix"
                                                                :close-on-select = "true"
                                                                deselect-label = "Can'not remove this value"
                                                                :hide-selected = "false"
                                                                :id = "modalEdit.inputs.employement_type.formControlName"
                                                                :name = "modalEdit.inputs.employement_type.formControlName"
                                                                :options = "options[modalEdit.inputs.employement_type.multiSelect.option_id]"
                                                                placeholder = ""
                                                                :disabled = "page.user['role']['name'] === 'Employee'"
                                                                :preselectFirst = "false"
                                                                :searchable = "true"
                                                                :show-labels = "false"
                                                                label = "name"
                                                                track-by = "id"
                                                                @input = "onMultiselectInput2($event, modalEdit.inputs.employement_type.formControlName, modalEdit.formKey)"
                                                                v-model = "option.modalEdit[modalEdit.inputs.employement_type.multiSelect.option_id]"></multiselect>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.employement_type.formControlName]['required'] === false">
                                                            Employment Type is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                                <div class = "col-3">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.employee_no.formControlName] && $v.modalEdit.form[modalEdit.inputs.employee_no.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.employee_no.formControlName">Employee Number</label>
                                                        <input class = "form-control"
                                                                :id = "modalEdit.inputs.employee_no.formControlName"
                                                                :name = "modalEdit.inputs.employee_no.formControlName"
                                                                placeholder = ""
                                                                :readonly = "page.user['role']['name'] === 'Employee'"
                                                                :type = "modalEdit.inputs.employee_no.type"
                                                                v-model = "modalEdit.form[modalEdit.inputs.employee_no.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.employee_no.formControlName].$model">
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.employee_no.formControlName]['required'] === false">
                                                            Employee Number is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "form-row">
                                                <div class = "col-12">
                                                    <div :class = "[$v.modalEdit.form && $v.modalEdit.form[modalEdit.inputs.description.formControlName] && $v.modalEdit.form[modalEdit.inputs.description.formControlName].$error ? 'form-group--error' : '', 'form-group']">
                                                        <label :for = "modalEdit.inputs.description.formControlName">About Me</label>
                                                        <textarea class = "form-control"
                                                                :id = "modalEdit.inputs.description.formControlName"
                                                                :name = "modalEdit.inputs.description.formControlName"
                                                                placeholder = ""
                                                                rows = "7"
                                                                v-model = "modalEdit.form[modalEdit.inputs.description.formControlName]"
                                                                v-model.trim = "$v.modalEdit.form[modalEdit.inputs.description.formControlName].$model"></textarea>
                                                        <div class = "error" v-if = "$v.modalEdit.form[modalEdit.inputs.description.formControlName]['required'] === false">
                                                            About Me is Required
                                                        </div>
                                                    </div>
                                                </div> <!-- FORM COL -->
                                            </div> <!-- FORM ROW -->
                                            <div class = "statusDiv" v-if = "modalEdit.statusDiv.show">
                                                <div :class = "[modalEdit.statusDiv.class]" v-for = "statusMsgs in modalEdit.statusDiv.messages">
                                                    <p v-html = "statusMsgs"></p>
                                                </div>
                                            </div>
                                            <div style = "text-align: center;">
                                                <button class = "btn btn-warning button-single" type = "submit">
                                                    Update
                                                    <i :class = "[modalEdit.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-save']" aria-hidden = "true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
    const {required, email, minLength, maxLength, minValue, maxValue, numeric, decimal} = require('vuelidate/lib/validators');
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';

    export default {
        mixins: [FormMixin],
        props : ['id'],

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
                    title      : 'Employee Details',
                    subTitle   : 'View Details of an Employee',
                    vuexKey    : 'profile',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    print      : {
                        title     : 'Attendance',
                        subTitle  : 'List of Attendance',
                        footer    : 'Copyright.',
                        time      : true,
                        printType : 'divId', // dataTable = DataTable Loop, divId = sectionId.
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
                    //
                    viewType   : 'view',
                    user_id    : null,
                    user       : null,
                },
                paginate : ['items'],
                dataForm : {
                    id                   : 0,
                    name                 : null,
                    email                : null,
                    date_of_birth        : null,
                    gender               : null,
                    religion             : null,
                    blood_group          : null,
                    marital_status       : null,
                    driving_license      : null,
                    passport_no          : null,
                    nid                  : null,
                    nationality_id       : null,
                    address              : null,
                    city_id              : null,
                    post_code            : null,
                    country_id           : null,
                    phone                : null,
                    role_id              : null,
                    emergency_name       : null,
                    emergency_address    : null,
                    emergency_city_id    : null,
                    emergency_post_code  : null,
                    emergency_country_id : null,
                    emergency_phone      : null,
                    department_id        : null,
                    designation_id       : null,
                    joining_date         : null,
                    resign_date          : null,
                    pay_rate             : null,
                    pay_rate_unit_type_id: null,
                    shift_id             : null,
                    work_days            : null,
                    employement_type     : null,
                    employee_no          : null,
                    description          : null,
                    photo                : null,
                    branch_id            : null,
                    entryby_id           : null,
                    entry_type_id        : null,
                    active               : null,
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
                        text      : 'Add New Employee',
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
                        id                   : 0,
                        name                 : null,
                        email                : null,
                        phone                : null,
                        role_id              : 3,
                        date_of_birth        : null,
                        gender               : null,
                        blood_group          : null,
                        religion             : null,
                        marital_status       : null,
                        driving_license      : null,
                        passport_no          : null,
                        nid                  : null,
                        nationality_id       : null,
                        address              : null,
                        city_id              : null,
                        post_code            : null,
                        country_id           : null,
                        emergency_name       : null,
                        emergency_address    : null,
                        emergency_city_id    : null,
                        emergency_post_code  : null,
                        emergency_country_id : null,
                        emergency_phone      : null,
                        department_id        : null,
                        designation_id       : null,
                        joining_date         : null,
                        resign_date          : null,
                        pay_rate             : null,
                        pay_rate_unit_type_id: null,
                        shift_id             : null,
                        work_days            : null,
                        employement_type     : null,
                        employee_no          : null,
                        description          : null,
                        photo                : null,
                        branch_id            : null,
                        entryby_id           : null,
                        entry_type_id        : 1,
                        api_ver              : '1.0',
                        app_ver              : '1.0.0',
                        app_build_ver        : 1,
                    }),
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalAdd',
                    inputs      : {
                        'name'                 : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'name',
                        },
                        'email'                : {
                            inputType      : 'text',
                            type           : 'email',
                            formControlName: 'email',
                        },
                        'phone'                : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'phone',
                        },
                        'address'              : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'address',
                        },
                        'city_id'              : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'city_id',
                        },
                        'post_code'            : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'post_code',
                        },
                        'country_id'           : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'country_id',
                            multiSelect    : {
                                option_id: 'country_id',
                            },
                        },
                        'nationality_id'       : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'nationality_id',
                            multiSelect    : {
                                option_id: 'nationality_id',
                            },
                        },
                        'date_of_birth'        : {
                            inputType      : 'dateTime',
                            type           : 'dateTime',
                            dateTime       : {
                                displayFormat: 'dd/MM/yyyy',
                                valueFormat  : 'yyyy-MM-dd',
                            },
                            formControlName: 'date_of_birth',
                        },
                        'blood_group'          : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'blood_group',
                            multiSelect    : {
                                option_id: 'blood_group',
                            },
                        },
                        'gender'               : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'gender',
                            multiSelect    : {
                                option_id: 'gender',
                            },
                        },
                        'religion'             : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'religion',
                            multiSelect    : {
                                option_id: 'religion',
                            },
                        },
                        'marital_status'       : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'marital_status',
                            multiSelect    : {
                                option_id: 'marital_status',
                            },
                        },
                        'passport_no'          : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'passport_no',
                        },
                        'driving_license'      : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'driving_license',
                        },
                        'nid'                  : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'nid',
                        },
                        'emergency_name'       : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'emergency_name',
                        },
                        'emergency_phone'      : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'emergency_phone',
                        },
                        'emergency_address'    : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'emergency_address',
                        },
                        'emergency_city_id'    : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'emergency_city_id',
                            multiSelect    : {
                                option_id: 'emergency_city_id',
                            },
                        },
                        'emergency_post_code'  : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'emergency_post_code',
                        },
                        'emergency_country_id' : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'emergency_country_id',
                            multiSelect    : {
                                option_id: 'emergency_country_id',
                            },
                        },
                        'department_id'        : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'department_id',
                            multiSelect    : {
                                option_id: 'department_id',
                            },
                        },
                        'designation_id'       : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'designation_id',
                            multiSelect    : {
                                option_id: 'designation_id',
                            },
                        },
                        'joining_date'         : {
                            inputType      : 'dateTime',
                            type           : 'dateTime',
                            dateTime       : {
                                displayFormat: 'dd/MM/yyyy',
                                valueFormat  : 'yyyy-MM-dd',
                            },
                            formControlName: 'joining_date',
                        },
                        'pay_rate'             : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'pay_rate',
                        },
                        'pay_rate_unit_type_id': {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'pay_rate_unit_type_id',
                            multiSelect    : {
                                option_id: 'pay_rate_unit_type_id',
                            },
                        },
                        'resign_date'          : {
                            inputType      : 'dateTime',
                            type           : 'dateTime',
                            dateTime       : {
                                displayFormat: 'dd/MM/yyyy',
                                valueFormat  : 'yyyy-MM-dd',
                            },
                            formControlName: 'resign_date',
                        },
                        'shift_id'             : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'shift_id',
                            multiSelect    : {
                                option_id: 'shift_id',
                            },
                        },
                        'work_days'            : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'work_days',
                            multiSelect    : {
                                option_id: 'work_days',
                            },
                        },
                        'employement_type'     : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'employement_type',
                            multiSelect    : {
                                option_id: 'employement_type',
                            },
                        },
                        'employee_no'          : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'employee_no',
                        },
                        'description'          : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'description',
                        },
                        'active'               : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'active',
                            multiSelect    : {
                                option_id: 'active',
                            },
                        },
                        'photo'                : {
                            inputType      : 'image',
                            type           : 'file',
                            formControlName: 'photo',
                            image          : {
                                imageServer: '/uploads/avatar/',
                                imageSrc   : null,
                                onChange   : [
                                    'modalAdd',
                                    'inputs',
                                    'photo',
                                    'image',
                                    'imageSrc'
                                ],
                                clearButton: {
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
                        actionType        : 'add_employee',
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
                            'id'                   : 'required|min:1|max:14',
                            'name'                 : 'required|min:1|max:255',
                            'email'                : 'required|min:1|max:255',
                            'date_of_birth'        : 'max:32',
                            'gender'               : 'max:16',
                            'religion'             : 'max:32',
                            'blood_group'          : 'max:4',
                            'marital_status'       : 'max:16',
                            'driving_license'      : 'max:64',
                            'passport_no'          : 'max:64',
                            'nid'                  : 'max:64',
                            'nationality_id'       : 'max:14',
                            'address'              : 'max:255',
                            'city_id'              : 'max:255',
                            'post_code'            : 'max:16',
                            'country_id'           : 'max:14',
                            'phone'                : 'required|min:1|max:32',
                            'role_id'              : 'required|min:1|max:14',
                            'emergency_name'       : 'max:255',
                            'emergency_address'    : 'max:255',
                            'emergency_city_id'    : 'max:14',
                            'emergency_post_code'  : 'max:16',
                            'emergency_country_id' : 'max:14',
                            'emergency_phone'      : 'max:32',
                            'department_id'        : 'max:14',
                            'designation_id'       : 'max:14',
                            'joining_date'         : 'max:32',
                            'resign_date'          : 'max:32',
                            'pay_rate'             : 'required|numeric|min:0|max:10000000000',
                            'pay_rate_unit_type_id': 'required|max:16',
                            'shift_id'             : 'max:16',
                            'work_days'            : '',
                            'employement_type'     : 'max:16',
                            'employee_no'          : 'required|min:1|max:32',
                            'description'          : 'max:512',
                            'photo'                : '',
                            'branch_id'            : 'max:14',
                            'api_ver'              : 'max:8',
                            'app_ver'              : 'max:8',
                            'app_build_ver'        : 'max:8',
                            'u_agent'              : 'max:255',
                            'ipAddress'            : 'max:128',
                        },
                        unique            : {
                            'id'         : '|unique:employees,id,',
                            'employee_no': '|unique:employees,employee_no,',
                            'email'      : '|unique:employees,email,',
                            'phone'      : '|unique:employees,phone,',
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
                        text      : 'Edit Employee',
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
                        id                   : 0,
                        name                 : null,
                        email                : null,
                        phone                : null,
                        role_id              : 3,
                        date_of_birth        : null,
                        gender               : null,
                        blood_group          : null,
                        religion             : null,
                        marital_status       : null,
                        driving_license      : null,
                        passport_no          : null,
                        nid                  : null,
                        nationality_id       : null,
                        address              : null,
                        city_id              : null,
                        post_code            : null,
                        country_id           : null,
                        emergency_name       : null,
                        emergency_address    : null,
                        emergency_city_id    : null,
                        emergency_post_code  : null,
                        emergency_country_id : null,
                        emergency_phone      : null,
                        department_id        : null,
                        designation_id       : null,
                        joining_date         : null,
                        resign_date          : null,
                        pay_rate             : null,
                        pay_rate_unit_type_id: null,
                        shift_id             : null,
                        work_days            : null,
                        employee_no          : null,
                        employement_type     : null,
                        description          : null,
                        photo                : null,
                        branch_id            : null,
                        active               : null,
                        entryby_id           : null,
                        entry_type_id        : 1,
                        api_ver              : '1.0',
                        app_ver              : '1.0.0',
                        app_build_ver        : 1,
                    }),
                    formClass   : 'form-modal',
                    formStyle   : '',
                    formKey     : 'modalEdit',
                    inputs      : {
                        'name'                 : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'name',
                        },
                        'email'                : {
                            inputType      : 'text',
                            type           : 'email',
                            formControlName: 'email',
                        },
                        'phone'                : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'phone',
                        },
                        'address'              : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'address',
                        },
                        'city_id'              : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'city_id',
                        },
                        'post_code'            : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'post_code',
                        },
                        'country_id'           : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'country_id',
                            multiSelect    : {
                                option_id: 'country_id',
                            },
                        },
                        'nationality_id'       : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'nationality_id',
                            multiSelect    : {
                                option_id: 'nationality_id',
                            },
                        },
                        'date_of_birth'        : {
                            inputType      : 'dateTime',
                            type           : 'dateTime',
                            dateTime       : {
                                displayFormat: 'dd/MM/yyyy',
                                valueFormat  : 'yyyy-MM-dd',
                            },
                            formControlName: 'date_of_birth',
                        },
                        'blood_group'          : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'blood_group',
                            multiSelect    : {
                                option_id: 'blood_group',
                            },
                        },
                        'gender'               : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'gender',
                            multiSelect    : {
                                option_id: 'gender',
                            },
                        },
                        'religion'             : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'religion',
                            multiSelect    : {
                                option_id: 'religion',
                            },
                        },
                        'marital_status'       : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'marital_status',
                            multiSelect    : {
                                option_id: 'marital_status',
                            },
                        },
                        'passport_no'          : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'passport_no',
                        },
                        'driving_license'      : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'driving_license',
                        },
                        'nid'                  : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'nid',
                        },
                        'emergency_name'       : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'emergency_name',
                        },
                        'emergency_phone'      : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'emergency_phone',
                        },
                        'emergency_address'    : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'emergency_address',
                        },
                        'emergency_city_id'    : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'emergency_city_id',
                            multiSelect    : {
                                option_id: 'emergency_city_id',
                            },
                        },
                        'emergency_post_code'  : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'emergency_post_code',
                        },
                        'emergency_country_id' : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'emergency_country_id',
                            multiSelect    : {
                                option_id: 'emergency_country_id',
                            },
                        },
                        'department_id'        : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'department_id',
                            multiSelect    : {
                                option_id: 'department_id',
                            },
                        },
                        'designation_id'       : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'designation_id',
                            multiSelect    : {
                                option_id: 'designation_id',
                            },
                        },
                        'joining_date'         : {
                            inputType      : 'dateTime',
                            type           : 'dateTime',
                            dateTime       : {
                                displayFormat: 'dd/MM/yyyy',
                                valueFormat  : 'yyyy-MM-dd',
                            },
                            formControlName: 'joining_date',
                        },
                        'pay_rate'             : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'pay_rate',
                        },
                        'pay_rate_unit_type_id': {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'pay_rate_unit_type_id',
                            multiSelect    : {
                                option_id: 'pay_rate_unit_type_id',
                            },
                        },
                        'resign_date'          : {
                            inputType      : 'dateTime',
                            type           : 'dateTime',
                            dateTime       : {
                                displayFormat: 'dd/MM/yyyy',
                                valueFormat  : 'yyyy-MM-dd',
                            },
                            formControlName: 'resign_date',
                        },
                        'shift_id'             : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'shift_id',
                            multiSelect    : {
                                option_id: 'shift_id',
                            },
                        },
                        'work_days'            : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'work_days',
                            multiSelect    : {
                                option_id: 'work_days',
                            },
                        },
                        'employement_type'     : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'employement_type',
                            multiSelect    : {
                                option_id: 'employement_type',
                            },
                        },
                        'employee_no'          : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'employee_no',
                        },
                        'description'          : {
                            inputType      : 'text',
                            type           : 'text',
                            formControlName: 'description',
                        },
                        'active'               : {
                            inputType      : 'select',
                            type           : 'select',
                            formControlName: 'active',
                            multiSelect    : {
                                option_id: 'active',
                            },
                        },
                        'photo'                : {
                            inputType      : 'image',
                            type           : 'file',
                            formControlName: 'photo',
                            image          : {
                                imageServer: '/uploads/avatar/',
                                imageSrc   : null,
                                onChange   : [
                                    'modalEdit',
                                    'inputs',
                                    'photo',
                                    'image',
                                    'imageSrc'
                                ],
                                clearButton: {
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
                        actionType        : 'edit_employee',
                        sentAsFormData    : true,
                        fileUploads       : {
                            active: true,
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
                            'id'                   : 'required|min:1|max:14',
                            'name'                 : 'required|min:1|max:255',
                            'email'                : 'required|min:1|max:255',
                            'date_of_birth'        : 'max:32',
                            'gender'               : 'max:16',
                            'religion'             : 'max:32',
                            'blood_group'          : 'max:4',
                            'marital_status'       : 'max:16',
                            'driving_license'      : 'max:64',
                            'passport_no'          : 'max:64',
                            'nid'                  : 'max:64',
                            'nationality_id'       : 'max:14',
                            'address'              : 'max:255',
                            'city_id'              : 'max:255',
                            'post_code'            : 'max:16',
                            'country_id'           : 'max:14',
                            'phone'                : 'required|min:1|max:32',
                            // 'role_id'              : 'required|min:1|max:14',
                            'emergency_name'       : 'max:255',
                            'emergency_address'    : 'max:255',
                            'emergency_city_id'    : 'max:14',
                            'emergency_post_code'  : 'max:16',
                            'emergency_country_id' : 'max:14',
                            'emergency_phone'      : 'max:32',
                            'department_id'        : 'max:14',
                            'designation_id'       : 'max:14',
                            'joining_date'         : 'max:32',
                            'resign_date'          : 'max:32',
                            'pay_rate'             : 'max:16',
                            'pay_rate_unit_type_id': 'max:16',
                            'shift_id'             : 'max:16',
                            'work_days'            : '',
                            'employement_type'     : 'max:16',
                            'employee_no'          : 'required|min:1|max:32',
                            'description'          : 'max:512',
                            'active'               : 'max:2',
                            'photo'                : '',
                            'branch_id'            : 'max:14',
                            'api_ver'              : 'max:8',
                            'app_ver'              : 'max:8',
                            'app_build_ver'        : 'max:8',
                            'u_agent'              : 'max:255',
                            'ipAddress'            : 'max:128',
                        },
                        unique            : {
                            'id'         : '|unique:employees,id,',
                            'employee_no': '|unique:employees,employee_no,',
                        },
                    },
                },
                dbInputs : [
                    {
                        key       : 'country_id',
                        table     : 'Country',
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
                        key       : 'emergency_country_id',
                        table     : 'Country',
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
                        key       : 'nationality_id',
                        table     : 'Country',
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
                        key       : 'pay_rate_unit_type_id',
                        table     : 'TimeUnits',
                        tableWith : [],
                        matchThese: [
                            /* [
                                 'active',
                                 '=',
                                 1
                             ],*/
                        ],
                        orThose   : [],
                        where     : [],
                        orWhere   : [
                            {
                                type      : 'static', // static, request, /auth, relation
                                columnName: 'name',
                                operator  : '=',
                                value     : 'Month',
                            },
                            {
                                type      : 'static', // static, request, /auth, relation
                                columnName: 'name',
                                operator  : '=',
                                value     : 'Hour',
                            },
                        ],
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
                            'id'        : 'id',
                            'name'      : 'name',
                            'short_name': 'short_name',
                            'active'    : 'active',
                        },
                        orderBy   : 'id',
                        direction : 'asc',
                        pluck     : {
                            'id'        : 'id',
                            'name'      : 'name',
                            'short_name': 'short_name',
                            'active'    : 'active',
                        }
                    },
                ],
                dbQuery  : {
                    table     : 'User',
                    tableWith : [
                        'role',
                        'shift',
                        'department',
                        'designation',
                        'nationality',
                        'country',
                        'emergency_country',
                        'pay_rate_unit_type',
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
                        'id'                   : 'id',
                        'employee_no'          : 'employee_no',
                        'name'                 : 'name',
                        'email'                : 'email',
                        'date_of_birth'        : 'date_of_birth',
                        'gender'               : 'gender',
                        'religion'             : 'religion',
                        'blood_group'          : 'blood_group',
                        'marital_status'       : 'marital_status',
                        'nationality_id'       : 'nationality_id',
                        'passport_no'          : 'passport_no',
                        'driving_license'      : 'driving_license',
                        'nid'                  : 'nid',
                        'address'              : 'address',
                        'city_id'              : 'city_id',
                        'post_code'            : 'post_code',
                        'country_id'           : 'country_id',
                        'phone'                : 'phone',
                        'role_id'              : 'role_id',
                        'emergency_name'       : 'emergency_name',
                        'emergency_address'    : 'emergency_address',
                        'emergency_city_id'    : 'emergency_city_id',
                        'emergency_post_code'  : 'emergency_post_code',
                        'emergency_country_id' : 'emergency_country_id',
                        'emergency_phone'      : 'emergency_phone',
                        'photo'                : 'photo',
                        'department_id'        : 'department_id',
                        'designation_id'       : 'designation_id',
                        'joining_date'         : 'joining_date',
                        'resign_date'          : 'resign_date',
                        'pay_rate'             : 'pay_rate',
                        'pay_rate_unit_type_id': 'pay_rate_unit_type_id',
                        'shift_id'             : 'shift_id',
                        'work_days'            : 'work_days',
                        'employement_type'     : 'employement_type',
                        'description'          : 'description',
                        'active'               : 'active',
                    },
                    sortBy    : {
                        relation: false, // false or relation name
                        field   : 'id',
                        desc    : true
                    },
                    // orderBy   : 'id',
                    // direction : 'desc',
                    pluck     : {
                        'id'                   : 'id',
                        'employee_no'          : 'employee_no',
                        'name'                 : 'name',
                        'email'                : 'email',
                        'date_of_birth'        : 'date_of_birth',
                        'gender'               : 'gender',
                        'religion'             : 'religion',
                        'blood_group'          : 'blood_group',
                        'marital_status'       : 'marital_status',
                        'nationality_id'       : 'nationality_id',
                        'passport_no'          : 'passport_no',
                        'driving_license'      : 'driving_license',
                        'nid'                  : 'nid',
                        'address'              : 'address',
                        'city_id'              : 'city_id',
                        'post_code'            : 'post_code',
                        'country_id'           : 'country_id',
                        'phone'                : 'phone',
                        'role_id'              : 'role_id',
                        'emergency_name'       : 'emergency_name',
                        'emergency_address'    : 'emergency_address',
                        'emergency_city_id'    : 'emergency_city_id',
                        'emergency_post_code'  : 'emergency_post_code',
                        'emergency_country_id' : 'emergency_country_id',
                        'emergency_phone'      : 'emergency_phone',
                        'photo'                : 'photo',
                        'department_id'        : 'department_id',
                        'designation_id'       : 'designation_id',
                        'joining_date'         : 'joining_date',
                        'resign_date'          : 'resign_date',
                        'pay_rate'             : 'pay_rate',
                        'pay_rate_unit_type_id': 'pay_rate_unit_type_id',
                        'shift_id'             : 'shift_id',
                        'work_days'            : 'work_days',
                        'description'          : 'description',
                        'active'               : 'active',
                    }
                },
                options  : {
                    country_id           : [],
                    emergency_country_id : [],
                    emergency_city_id    : [],
                    nationality_id       : [],
                    department_id        : [],
                    designation_id       : [],
                    pay_rate_unit_type_id: [],
                    shift_id             : [],
                    work_days            : [],
                    employement_type     : [],
                },
                option   : {
                    modalAdd : {
                        country_id           : {},
                        emergency_country_id : {},
                        emergency_city_id    : {},
                        nationality_id       : {},
                        department_id        : {},
                        designation_id       : {},
                        pay_rate_unit_type_id: {},
                        employement_type     : {},
                        gender               : {},
                        blood_group          : {},
                        religion             : {},
                        marital_status       : {},
                        shift_id             : {},
                        work_days            : [], // for multiselect, need to set as an array.
                        employement_type     : {},
                    },
                    modalEdit: {
                        country_id           : {},
                        emergency_country_id : {},
                        emergency_city_id    : {},
                        nationality_id       : {},
                        department_id        : {},
                        designation_id       : {},
                        pay_rate_unit_type_id: {},
                        employement_type     : {},
                        gender               : {},
                        blood_group          : {},
                        religion             : {},
                        marital_status       : {},
                        shift_id             : {},
                        work_days            : [],
                        employement_type     : {},
                        active               : {},
                    }
                },
                optionSet: {
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
                    blood_group     : [
                        {
                            id  : 'A+',
                            name: 'A+',
                        },
                        {
                            id  : 'A-',
                            name: 'A-',
                        },
                        {
                            id  : 'B+',
                            name: 'B+',
                        },
                        {
                            id  : 'B-',
                            name: 'B-',
                        },
                        {
                            id  : 'O+',
                            name: 'O+',
                        },
                        {
                            id  : 'O-',
                            name: 'O-',
                        },
                        {
                            id  : 'AB+',
                            name: 'AB+',
                        },
                        {
                            id  : 'AB-',
                            name: 'AB-',
                        }
                    ],
                    gender          : [
                        {
                            id  : 'Male',
                            name: 'Male',
                        },
                        {
                            id  : 'Female',
                            name: 'Female',
                        },
                        {
                            id  : 'Other',
                            name: 'Other',
                        },
                    ],
                    religion        : [
                        {
                            id  : 'Islam',
                            name: 'Islam',
                        },
                        {
                            id  : 'Hinduism',
                            name: 'Hinduism',
                        },
                        {
                            id  : 'Christianity',
                            name: 'Christianity',
                        },
                        {
                            id  : 'Buddhism',
                            name: 'Buddhism',
                        },
                        {
                            id  : 'Other',
                            name: 'Other',
                        },
                    ],
                    marital_status  : [
                        {
                            id  : 'Single',
                            name: 'Single',
                        },
                        {
                            id  : 'Married',
                            name: 'Married',
                        },
                        {
                            id  : 'Divorced',
                            name: 'Divorced',
                        },
                        {
                            id  : 'Widowed',
                            name: 'Widowed',
                        },
                        {
                            id  : 'Separated',
                            name: 'Separated',
                        },
                        {
                            id  : 'Other',
                            name: 'Other',
                        },
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
            }
        },
        validations: {
            modalAdd : {
                form: {
                    name                 : {
                        required,
                    },
                    email                : {
                        required,
                    },
                    phone                : {},
                    address              : {
                        required,
                    },
                    city_id              : {
                        required,
                    },
                    post_code            : {
                        required,
                    },
                    country_id           : {
                        required,
                    },
                    nationality_id       : {
                        required,
                    },
                    date_of_birth        : {
                        required,
                    },
                    blood_group          : {
                        required,
                    },
                    gender               : {
                        required,
                    },
                    religion             : {
                        required,
                    },
                    marital_status       : {
                        required,
                    },
                    passport_no          : {
                        required,
                    },
                    driving_license      : {},
                    nid                  : {},
                    emergency_name       : {},
                    emergency_address    : {},
                    emergency_city_id    : {},
                    emergency_post_code  : {},
                    emergency_country_id : {},
                    emergency_phone      : {},
                    department_id        : {
                        required,
                    },
                    designation_id       : {
                        required,
                    },
                    joining_date         : {
                        required,
                    },
                    resign_date          : {},
                    pay_rate             : {
                        required,
                        decimal,
                        minValue: minValue(0),
                        maxValue: maxValue(10000000000),
                    },
                    pay_rate_unit_type_id: {
                        required
                    },
                    shift_id             : {
                        required,
                    },
                    work_days            : {
                        required,
                    },
                    employement_type     : {
                        required
                    },
                    employee_no          : {
                        required
                    },
                    description          : {},
                    photo                : {},
                }
            },
            modalEdit: {
                form: {
                    name                 : {
                        required,
                    },
                    email                : {
                        required,
                    },
                    phone                : {},
                    address              : {
                        required,
                    },
                    city_id              : {
                        required,
                    },
                    post_code            : {
                        required,
                    },
                    country_id           : {
                        required,
                    },
                    nationality_id       : {
                        required,
                    },
                    date_of_birth        : {
                        required,
                    },
                    blood_group          : {
                        required,
                    },
                    gender               : {
                        required,
                    },
                    religion             : {
                        required,
                    },
                    marital_status       : {
                        required,
                    },
                    passport_no          : {
                        required,
                    },
                    driving_license      : {},
                    nid                  : {},
                    emergency_name       : {},
                    emergency_address    : {},
                    emergency_city_id    : {},
                    emergency_post_code  : {},
                    emergency_country_id : {},
                    emergency_phone      : {},
                    department_id        : {
                        required,
                    },
                    designation_id       : {
                        required,
                    },
                    joining_date         : {
                        required,
                    },
                    resign_date          : {},
                    pay_rate             : {
                        required,
                        decimal,
                        minValue: minValue(0),
                        maxValue: maxValue(10000000000),
                    },
                    pay_rate_unit_type_id: {
                        required
                    },
                    shift_id             : {
                        required,
                    },
                    work_days            : {
                        required,
                    },
                    employement_type     : {
                        required
                    },
                    employee_no          : {
                        required
                    },
                    description          : {},
                    photo                : {},
                    active               : {
                        required,
                    },
                }
            }
        },
        created() {
            // this.setLayout('layout-dashboard');
            this.setPushOptions(this.optionSet, null);
            this.getFormInputs(this.FormInputsAPI, null, this.dbInputs, this.$route.params['data'] ? this.$route.params['data'] : null, this.optionSet, null);

            this.page.user = this.$store.getters.user;

            if (this.page.user['id'] && this.page.user['role'] && this.page.user['role']['name']) {
                if (this.$route.params && this.$route.params['viewType']) {
                    this.page.viewType = this.$route.params['viewType'];
                } else {
                    this.page.viewType = 'view';
                }
                switch (this.page.user['role']['name']) {
                    case 'Admin':
                    case 'HR':
                        this.page.user_id = this.$route.params.id;
                        break;
                    case 'Employee':
                        this.page.user_id = this.page.user['id'];
                        break;
                    default:
                        this.page.user_id = 0;
                        break;
                }
                if (this.page.user_id && Number(this.page.user_id > 0)) {
                    this.dbQuery.matchThese = [
                        [
                            'active',
                            '=',
                            1
                        ],
                        [
                            'id',
                            '=',
                            this.page.user_id
                        ],
                    ];
                    if (this.page.viewType === 'edit') {
                        this.pageItemSelected(this.$route.params.data, this.modalEdit.formKey);
                    } else {
                        this.onLoadPageData(this.ItemGetUrl, this.dbQuery, this.page.vuexKey, 'loading', false, this.modalEdit.formKey);
                    }
                }
            } else {
                // NO PERMISSON
            }

            console.log('created: ', this.page.title, ': ', this.$route.params, this.page.viewType);
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
            switchViewType() {
                console.log('switchViewType: ', this.page.viewType);
                if (this.page.viewType === 'edit') {
                    this.page.viewType = 'view';
                } else if (this.page.viewType === 'view') {
                    this.page.viewType = 'edit';
                    this.dbQuery.matchThese = [
                        [
                            'active',
                            '=',
                            1
                        ],
                        [
                            'id',
                            '=',
                            this.page.user_id
                        ],
                    ];
                    this.pageItemSelected(this.dataTable['data'][0], this.modalEdit.formKey);
                }
                console.log('switchViewType: ', this.page.viewType);
            }
        }
    }
</script>
