<template>
    <div>
        <div class = "cascading-modal">
            <div class = "modal-content">
                <div :class = "modalDelete.header.colorClass" class = "modal-header">
                    <h4 class = "title">
                        <span v-html = "modalDelete.header.icon"></span>
                        {{modalDelete.header.text}}
                    </h4>
                    <button @click.prevent = "$modal.hide(modalDelete.options.name, modalDelete.header.closeData)" class = "close" type = "button">
                        <i class = "fas fa-times"></i>
                    </button>
                </div>
                <div :class = "modalDelete.body.class" :style = "modalDelete.body.style" v-html = "modalDelete.tableView">
                    <table :class = "modalDelete.body.table.class" :style = "modalDelete.body.table.style">
                        <thead :class = "modalDelete.body.table.thead.class" :style = "modalDelete.body.table.thead.style">
                        <tr :class = "modalDelete.body.table.thead.tr.class" :style = "modalDelete.body.table.thead.tr.style">
                            <th :class = "modalDelete.body.table.thead.tr.class" :scope = "modalDelete.body.table.thead.tr.th.scope" :style = "modalDelete.body.table.thead.tr.style">
                                #
                            </th>
                            <th :class = "modalDelete.body.table.thead.tr.class" :scope = "modalDelete.body.table.thead.tr.th.scope" :style = "modalDelete.body.table.thead.tr.style">
                                First
                            </th>
                        </tr>
                        </thead>
                        <tbody :class = "modalDelete.body.table.tbody.class" :style = "modalDelete.body.table.tbody.style">
                        <tr :class = "modalDelete.body.table.tbody.tr.class" :style = "modalDelete.body.table.tbody.tr.style">
                            <th :class = "modalDelete.body.table.tbody.tr.th.class" :scope = "modalDelete.body.table.tbody.tr.th.scope" :style = "modalDelete.body.table.tbody.tr.th.style">
                                1
                            </th>
                            <td :class = "modalDelete.body.table.tbody.tr.td.class"
                                    :colspan = "modalDelete.body.table.tbody.tr.td.colspan"
                                    :scope = "modalDelete.body.table.tbody.tr.td.scope"
                                    :style = "modalDelete.body.table.tbody.tr.td.style">
                                Mark
                            </td>
                            <td :class = "modalDelete.body.table.tbody.tr.td.class"
                                    :colspan = "modalDelete.body.table.tbody.tr.td.colspan"
                                    :scope = "modalDelete.body.table.tbody.tr.td.scope"
                                    :style = "modalDelete.body.table.tbody.tr.td.style">
                                Mark
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class = "m-footer">
                    <div class = "statusDiv" v-if = "modalDelete.statusDiv.show">
                        <div :class = "[modalDelete.statusDiv.class]" v-for = "statusMsgs in modalDelete.statusDiv.messages">
                            <p v-html = "statusMsgs"></p>
                        </div>
                    </div>
                    <div style = "text-align: center;">
                        <button @click.prevent = "onRemovePageItem(ItemRemoveUrl, dbDestroy, dbQuery, modalDelete.data.id, vuexKey)" class = "btn btn-danger" type = "button">
                            Delete
                            <i :class = "[modalDelete.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-trash']" aria-hidden = "true"></i>
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
        props : ['params'],

        data() {
            return {
                modalDelete  : null,
                vuexKey      : null,
                ItemRemoveUrl: null,
                dbQuery      : null,
                dbDestroy    : null,
            }
        },
        created() {
            console.log('created: ', this.params);
            this.modalDelete = this.params.modalDelete;
            this.vuexKey = this.params.vuexKey;
            this.ItemRemoveUrl = this.params.ItemRemoveUrl;
            this.dbQuery = this.params.dbQuery;
            this.dbDestroy = this.params.dbDestroy;
            // console.log('created: ', validations);
        },
        computed: {},
        watch   : {},
        methods : {}
    }
</script>
