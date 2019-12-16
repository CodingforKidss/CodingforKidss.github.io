<template>
    <div>
        <div class = "cascading-modal">
            <div class = "modal-content">
                <div :class = "modalAdd.header.colorClass" class = "modal-header">
                    <h4 class = "title">
                        <span v-html = "modalAdd.header.icon"></span>
                        {{modalAdd.header.text}}
                    </h4>
                    <button @click.prevent = "$modal.hide(modalAdd.options.name, modalAdd.header.closeData)" class = "close" type = "button">
                        <i class = "fas fa-times"></i>
                    </button>
                </div>
                <form :class = "modalAdd.formClass"
                        :style = "modalAdd.formStyle"
                        @submit.prevent = "onModalFormSubmit(ItemAddUrl, modalAdd.form.data(), modalAdd.dbInsert, dbQuery, vuexKey, true, null)">
                    <div class = "m-body">
                        <template v-for = "(item, key) of modalAdd.inputs">
                            <div ::class = "item.rowClass" :style = "item.rowStyle">
                                <div :class = "item.colClass" :style = "item.colStyle">
                                    <div :class = "[item.validation.show && item.validation.active && $v.modalAdd.form && $v.modalAdd.form[item.formControlName] && $v.modalAdd.form[item.formControlName].$error ? 'form-group--error' : '', item.formClass]">
                                        <label :for = "item.formControlName" :class = "item.label.class" :style = "item.label.style" v-if = "item.label.show" v-html = "item.label.text"></label>
                                        <div class = "input-group">
                                            <div class = "input-group-prepend" v-if = "item.icon.show">
                                                <span class = "input-group-text" v-html = "item.icon.text"></span>
                                            </div>
                                            <input :class = "item.inputClass"
                                                    :disabled = "item.disabled"
                                                    :id = "item.formControlName"
                                                    :name = "item.formControlName"
                                                    :placeholder = "item.placeHolder"
                                                    :readonly = "item.readonly"
                                                    :required = "item.required"
                                                    :style = "item.inputStyle"
                                                    :type = "item.type"
                                                    v-if = "item.inputType === 'text' && item.validation.active === true"
                                                    v-model = "modalAdd.form[item.formControlName]"
                                                    v-model.trim = "$v.modalAdd.form[item.formControlName].$model">
                                            <input :class = "item.inputClass"
                                                    :disabled = "item.disabled"
                                                    :id = "item.formControlName"
                                                    :name = "item.formControlName"
                                                    :placeholder = "item.placeHolder"
                                                    :readonly = "item.readonly"
                                                    :required = "item.required"
                                                    :style = "item.inputStyle"
                                                    :type = "item.type"
                                                    v-if = "item.inputType === 'text' && item.validation.active === false"
                                                    v-model = "modalAdd.form[item.formControlName]">
                                            <textarea :class = "item.inputClass"
                                                    :disabled = "item.disabled"
                                                    :id = "item.formControlName"
                                                    :name = "item.formControlName"
                                                    :placeholder = "item.placeHolder"
                                                    :readonly = "item.readonly"
                                                    :required = "item.required"
                                                    :style = "item.inputStyle"
                                                    :type = "item.type"
                                                    :maxlength = "item.maxlength"
                                                    :rows = "item.rows"
                                                    :cols = "item.cols"
                                                    v-if = "item.inputType === 'textArea'"
                                                    v-model = "modalEdit.form[item.formControlName]">
                                            </textarea>
                                            <multiselect :allow-empty = "item.multiSelect.allowEmpty"
                                                    :class = "item.multiSelect.inputClass"
                                                    :close-on-select = "item.multiSelect.closeOnSelect"
                                                    :deselect-label = "item.multiSelect.deselectLabel"
                                                    :disabled = "item.disabled"
                                                    :hide-selected = "item.multiSelect.hideSelected"
                                                    :id = "item.formControlName"
                                                    :label = "item.multiSelect.label"
                                                    :name = "item.formControlName"
                                                    :options = "options[item.multiSelect.option_id]"
                                                    :placeholder = "item.placeHolder"
                                                    :preselectFirst = "item.multiSelect.preselectFirst"
                                                    :readonly = "item.readonly"
                                                    :required = "item.required"
                                                    :searchable = "item.multiSelect.searchable"
                                                    :show-labels = "item.multiSelect.showLabels"
                                                    :style = "item.multiSelect.inputStyle"
                                                    :track-by = "item.multiSelect.id"
                                                    @input = "onMultiselectInput($event, item.formControlName, modalAdd.formKey)"
                                                    v-if = "item.inputType === 'select'"
                                                    v-model = "option.modalAdd[item.multiSelect.option_id]"></multiselect>
                                            <div :class = "item.dateTime.inputClass" :style = "item.dateTime.inputStyle" v-if = "item.inputType === 'dateTime'">
                                                <el-date-picker :class = "item.dateTime.inputDateClass"
                                                        :style = "item.dateTime.inputDateStyle"
                                                        :id = "item.formControlName"
                                                        :name = "item.formControlName"
                                                        :placeholder = "item.placeHolder"
                                                        :disabled = "item.disabled"
                                                        :readonly = "item.readonly"
                                                        :required = "item.required"
                                                        :type = "item.dateTime.type"
                                                        :align = "item.dateTime.align"
                                                        :clearable = "item.dateTime.clearable"
                                                        :editable = "item.dateTime.editable"
                                                        :range-separator = "item.dateTime.rangeSeparator"
                                                        :format = "item.dateTime.displayFormat"
                                                        :value-format = "item.dateTime.valueFormat"
                                                        :picker-options = "item.dateTime.pickerOptions"
                                                        v-if = "item.dateTime.type === 'date'"
                                                        v-model = "modalAdd.form[item.formControlName]"
                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-date-picker>
                                                <el-time-picker :class = "item.dateTime.inputDateClass"
                                                        :style = "item.dateTime.inputDateStyle"
                                                        :id = "item.formControlName"
                                                        :name = "item.formControlName"
                                                        :placeholder = "item.placeHolder"
                                                        :disabled = "item.disabled"
                                                        :readonly = "item.readonly"
                                                        :required = "item.required"
                                                        :align = "item.dateTime.align"
                                                        :clearable = "item.dateTime.clearable"
                                                        :editable = "item.dateTime.editable"
                                                        :is-range = "item.dateTime.isRange"
                                                        :arrow-control = "item.dateTime.arrowControl"
                                                        :range-separator = "item.dateTime.rangeSeparator"
                                                        :value-format = "item.dateTime.valueFormat"
                                                        :picker-options = "item.dateTime.pickerOptions"
                                                        v-if = "item.dateTime.type === 'timePicker'"
                                                        v-model = "modalAdd.form[item.formControlName]"
                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-time-picker>
                                                <el-time-select :class = "item.dateTime.inputDateClass"
                                                        :style = "item.dateTime.inputDateStyle"
                                                        :id = "item.formControlName"
                                                        :name = "item.formControlName"
                                                        :placeholder = "item.placeHolder"
                                                        :disabled = "item.disabled"
                                                        :readonly = "item.readonly"
                                                        :required = "item.required"
                                                        :align = "item.dateTime.align"
                                                        :clearable = "item.dateTime.clearable"
                                                        :editable = "item.dateTime.editable"
                                                        :is-range = "item.dateTime.isRange"
                                                        :arrow-control = "item.dateTime.arrowControl"
                                                        :range-separator = "item.dateTime.rangeSeparator"
                                                        :value-format = "item.dateTime.valueFormat"
                                                        :picker-options = "item.dateTime.pickerOptions"
                                                        v-if = "item.dateTime.type === 'timeSelect'"
                                                        v-model = "modalAdd.form[item.formControlName]"
                                                        @input = "onDateInput($event, item.formControlName, item.dateTime.valueFormat)"></el-time-select>
                                            </div>
                                            <div :class = "item.image.inputClass" :style = "item.image.inputStyle" v-if = "item.inputType === 'image'">
                                                <div>
                                                    <div :class = "item.image.inputLabelClass"
                                                            :style = "[modalAdd.uploadPercentage && modalAdd.uploadPercentage >= 0 ? {'display': 'block'} : {'display': 'none'}]">
                                                        Uploading:
                                                        <b>{{ modalAdd.uploadPercentage && modalAdd.uploadPercentage >= 0 ? modalAdd.uploadPercentage + '%' : modalAdd.uploadPercentage }}</b>
                                                    </div>
                                                    <img :src = "item.image.imageSrc" :class = "item.image.inputImageClass" :style = "item.image.inputImageStyle" alt = "">
                                                    <i class = "fas fa-times"
                                                            :class = "item.image.clearButton.class"
                                                            data-toggle = "tooltip"
                                                            title = "Remove Photo"
                                                            @click.prevent = "clearPhoto($event, item.image.onChange, item.image.clearButton.props)"
                                                            v-if = "item.image.imageSrc && item.image.imageSrc.length > 0"></i>
                                                </div>
                                                <input :class = "item.inputClass"
                                                        :disabled = "item.disabled"
                                                        :id = "item.formControlName"
                                                        :placeholder = "item.placeHolder"
                                                        :readonly = "item.readonly"
                                                        :required = "item.required"
                                                        :multiple = "item.multiple"
                                                        :style = "item.inputStyle"
                                                        :type = "item.type"
                                                        @change = "onImageFileChange($event, item.image.onChange)"
                                                        v-if = "item.inputType === 'image'">
                                            </div>
                                        </div>
                                        <template v-if = "item.validation.active && item.validation.show && $v.modalAdd.form && $v.modalAdd.form[item.formControlName]">
                                            <div v-for = "(vItem, vKey) of item.validation.validators">
                                                <div :class = "item.validation.class" v-if = "$v.modalAdd.form[item.formControlName][vKey] === false">
                                                    {{vItem.message}}
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div> <!-- FORM COL -->
                            </div> <!-- FORM ROW -->
                        </template> <!-- INPUT LOOP -->
                    </div>
                    <div class = "m-footer">
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
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    const {required, email, minLength, maxLength, minValue, maxValue, numeric, decimal} = require('vuelidate/lib/validators');
    import FormMixin from '../../FormMixin';
    import MyConstant from '../../variables';

    export default {
        props   : ['params'],
        mixins  : [FormMixin],
        data() {
            return {
                modalAdd  : null,
                options   : null,
                option    : null,
                optionSet : null,
                vuexKey   : null,
                ItemAddUrl: null,
                dbQuery   : null,
            }
        },
        /*validations: {
            modalAdd: {
                form: {
                    employee_id: {
                        required,
                    },
                    date: {},
                    schedule_id: {
                        required,
                    },
                    time_in: {},
                    time_out: {},
                    attendance_method_id: {},
                    remark: {required,},
                    description: {},
                },
            },
        },*/
        validations() {
            if (this.modalAdd && this.modalAdd.validations) {
                return {
                    modalAdd: {
                        form: this.modalAdd.validations
                    }
                }
            } else {
                return {
                    modalAdd: {
                        form: {}
                    }
                }
            }
        },
        created() {
            console.log('created: ', this.params);
            this.$v.modalAdd.$touch();
            this.$v.modalAdd.$reset();
            this.modalAdd = this.params.modalAdd;
            this.options = this.params.options;
            this.option = this.params.option;
            this.optionSet = this.params.optionSet;
            this.vuexKey = this.params.vuexKey;
            this.ItemAddUrl = this.params.ItemAddUrl;
            this.dbQuery = this.params.dbQuery;
            // console.log('created: ', validations);
        },
        computed: {},
        watch   : {},
        methods : {}
    }
</script>
