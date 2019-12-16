<script src = "../../variables.js"></script>
<template>
    <div>
        <div class = "cascading-modal">
            <div class = "modal-content" id = "modalView">
                <div :class = "modalView.header.colorClass" class = "modal-header">
                    <h4 class = "title">
                        <span v-html = "modalView.header.icon"></span>
                        {{modalView.header.text}}
                    </h4>
                    <button @click.prevent = "$modal.hide(modalView.options.name, modalView.header.closeData)" class = "close" type = "button">
                        <i class = "fas fa-times"></i>
                    </button>
                </div>
                <div :class = "modalView.body.class" :style = "modalView.body.style" v-html = "modalView.tableView">
                    <table :class = "modalView.body.table.class" :style = "modalView.body.table.style">
                        <thead :class = "modalView.body.table.thead.class" :style = "modalView.body.table.thead.style">
                        <tr :class = "modalView.body.table.thead.tr.class" :style = "modalView.body.table.thead.tr.style">
                            <th :class = "modalView.body.table.thead.tr.class" :scope = "modalView.body.table.thead.tr.th.scope" :style = "modalView.body.table.thead.tr.style">
                                #
                            </th>
                            <th :class = "modalView.body.table.thead.tr.class" :scope = "modalView.body.table.thead.tr.th.scope" :style = "modalView.body.table.thead.tr.style">
                                First
                            </th>
                        </tr>
                        </thead>
                        <tbody :class = "modalView.body.table.tbody.class" :style = "modalView.body.table.tbody.style">
                        <tr :class = "modalView.body.table.tbody.tr.class" :style = "modalView.body.table.tbody.tr.style">
                            <th :class = "modalView.body.table.tbody.tr.th.class" :scope = "modalView.body.table.tbody.tr.th.scope" :style = "modalView.body.table.tbody.tr.th.style">
                                1
                            </th>
                            <td :class = "modalView.body.table.tbody.tr.td.class"
                                    :colspan = "modalView.body.table.tbody.tr.td.colspan"
                                    :scope = "modalView.body.table.tbody.tr.td.scope"
                                    :style = "modalView.body.table.tbody.tr.td.style">
                                Mark
                            </td>
                            <td :class = "modalView.body.table.tbody.tr.td.class"
                                    :colspan = "modalView.body.table.tbody.tr.td.colspan"
                                    :scope = "modalView.body.table.tbody.tr.td.scope"
                                    :style = "modalView.body.table.tbody.tr.td.style">
                                Mark
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class = "m-footer">
                    <div class = "statusDiv" v-if = "modalView.statusDiv.show">
                        <div :class = "[modalView.statusDiv.class]" v-for = "statusMsgs in modalView.statusDiv.messages">
                            <p v-html = "statusMsgs"></p>
                        </div>
                    </div>
                    <div style = "text-align: center;">
                        <button class = "btn btn-info" type = "button" @click.prevent = "printDiv(params.print, printType, modalView.tableView)">
                            Print <i class = "fas fa-print"></i>
                        </button>
                        <button @click.prevent = "$modal.hide(modalView.options.name)" class = "btn btn-dark" type = "button">
                            Close
                            <i class = "far fa-times-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import FormMixin from '../../FormMixin';
    import MyConstant from '../../variables';

    export default {
        mixins: [FormMixin],

        props   : ['params'],
        data() {
            return {
                printType: 'divId', // modalView
                modalView: null,
                print    : null,
            }
        },
        created() {
            console.log('created: ', this.params);
            this.modalView = this.params.modalView;
            this.print = this.params.print;
            this.print.printDivId = 'modalView';
            // this.page.print.title      = this.modalView.header.text;
            // this.page.print.subTitle   = '';
            // console.log('created: ', validations);
        },
        computed: {},
        watch   : {},
        methods : {}
    }
</script>
