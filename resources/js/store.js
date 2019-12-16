import Vue from 'vue'
import Vuex from 'vuex';

Vue.use(Vuex)

export const store = new Vuex.Store({
    state    : {
        user     : null,
        token    : null,
        layout   : null,
        dataTable: {
            dashboard : {
                data : [],
                data2: [],
            },
            report    : {
                data : [],
                data2: [],
            },
            courses   : {
                data : [],
                data2: [],
            },
            profile   : {
                data : [],
                data2: [],
            },
            category  : {
                data : [],
                data2: [],
            },
            enrolments: {
                data : [],
                data2: [],
            },
            parents   : {
                data : [],
                data2: [],
            },
            students  : {
                data : [],
                data2: [],
            },
            users     : {
                data : [],
                data2: [],
            },
        }
    },
    actions  : {
        ADD_USER        : function ({commit}, payload) {
            commit("UPDATE_USER", payload);
        },
        ADD_TOKEN       : function ({commit}, payload) {
            commit("UPDATE_TOKEN", payload);
        },
        DELETE_USER     : function ({commit}, payload) {
            commit("REMOVE_USER", payload);
        },
        DELETE_TOKEN    : function ({commit}, payload) {
            commit("REMOVE_TOKEN", payload);
        },
        ADD_DATATABLE   : function ({commit}, payload) {
            commit("ADD_DATATABLE_REPLACE", payload);
        },
        DELETE_DATATABLE: function ({commit}, payload) {
            commit("DELETE_DATATABLE_REPLACE", payload);
        }
    },
    mutations: {
        SET_LAYOUT(state, payload) {
            state.layout = payload;
        },
        UPDATE_USER(state, payload) {
            // console.log('UPDATE_USER: ', payload);
            state.user = payload;
        },
        UPDATE_TOKEN(state, payload) {
            // console.log('UPDATE_TOKEN: ', payload);
            state.token = payload;
        },
        REMOVE_USER(state, payload) {
            console.log('REMOVE_USER: ', payload);
            state.user = null;
        },
        REMOVE_TOKEN(state, payload) {
            console.log('REMOVE_TOKEN: ', payload);
            state.token = null;
        },
        ADD_DATATABLE_REPLACE(state, payload) {
            state.dataTable[payload['key']] = {
                data : payload['data'],
                data2: payload['data2'],
            };
        },
        DELETE_DATATABLE_REPLACE(state, payload) {
            state.dataTable[payload['key']] = {
                data : [],
                data2: [],
            };
        },
        /*ADD_DATATABLE_MUTATION(state, new_dataTable) {
            state.dataTable.push(new_dataTable);
        },
        DELETE_DATATABLE_MUTATION(state, dataTable_id) {
            state.dataTable.splice(dataTable_id, 1);
        }*/
    },
    getters  : {
        layout   : state => {
            return state.layout
        },
        user     : state => {
            return state.user
        },
        token    : state => {
            return state.token
        },
        dataTable: state => vuexKey => {
            return state.dataTable[vuexKey];
        }
    }
})

export default store
