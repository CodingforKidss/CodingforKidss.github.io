var moment = require('moment');

export default {
    data   : function () {
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
        }

        return {
            FormInputsAPI : '/api/v1/db-form-inputs',
            ItemGetUrl    : '/api/v1/auth/db-get',
            ItemAddUrl    : '/api/v1/auth/db-store',
            ItemRemoveUrl : '/api/v1/auth/db-remove',
            ItemRemovesUrl: '/api/v1/auth/db-removes',
            perPageList   : [
                20,
                100,
                200,
                500,
                1000,
            ],
            perPage       : 20,
            modalView     : {
                options  : {
                    name        : 'ModalView',
                    class       : 'modal-custom',
                    style       : '',
                    height      : 'auto',
                    width       : '900px',
                    transition  : 'pop-out',
                    scrollable  : true,
                    adaptive    : false,
                    clickToClose: true,
                    beforeOpen  : {},
                    opened      : {},
                    beforeClose : {},
                    closed      : {},
                },
                header   : {
                    text      : 'View Information',
                    subHeader : 'subHeader',
                    icon      : '<i class = "fas fa-info-circle"></i>',
                    colorClass: 'modal-header-info',
                    closeData : 'closeData',
                },
                statusDiv: {
                    show    : true,
                    class   : 'alert-json-info',
                    style   : '',
                    messages: [],
                },
                data     : null,
                tableView: null,
                body     : {
                    class: 'm-body',
                    style: '',
                    table: {
                        class: 'table table-striped table-bordered',
                        style: '',
                        thead: {
                            class: '',
                            style: '',
                            tr   : {
                                class: '',
                                style: '',
                                th   : {
                                    class: '',
                                    style: '',
                                    scope: 'col',
                                }
                            }
                        },
                        tbody: {
                            class: '',
                            style: '',
                            tr   : {
                                class: '',
                                style: '',
                                th   : {
                                    class: 'bg-warning',
                                    style: '',
                                    scope: 'row',
                                },
                                td   : {
                                    class  : 'bg-warning',
                                    style  : '',
                                    scope  : 'row',
                                    colspan: '2',
                                },
                            }
                        }
                    }
                }
            },
            modalDelete   : {
                options     : {
                    name        : 'ModalDelete',
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
                    text      : 'Delete Information',
                    subHeader : 'subHeader',
                    icon      : '<i class="fas fa-trash"></i>',
                    colorClass: 'modal-header-danger',
                    closeData : 'closeData',
                },
                statusDiv   : {
                    show    : true,
                    class   : 'alert-json-alert',
                    style   : '',
                    messages: [],
                },
                isSubmitting: null,
                data        : null,
                tableView   : null,
                body        : {
                    class: 'm-body',
                    style: '',
                    table: {
                        class: 'table table-striped table-bordered',
                        style: '',
                        thead: {
                            class: '',
                            style: '',
                            tr   : {
                                class: '',
                                style: '',
                                th   : {
                                    class: '',
                                    style: '',
                                    scope: 'col',
                                }
                            }
                        },
                        tbody: {
                            class: '',
                            style: '',
                            tr   : {
                                class: '',
                                style: '',
                                th   : {
                                    class: 'bg-warning',
                                    style: '',
                                    scope: 'row',
                                },
                                td   : {
                                    class  : 'bg-warning',
                                    style  : '',
                                    scope  : 'row',
                                    colspan: '2',
                                },
                            }
                        }
                    }
                }
            },

        }
    },
    filters: {
        dateFormatDoF(value) {
            if (value) {
                return moment(String(value)).format('Do MMM, YYYY');
            } else {
                return '-';
            }
        },
        dateFormatDoFL(value) {
            if (value) {
                return moment(String(value)).format('ddd, Do MMM, YYYY');
            } else {
                return '-';
            }
        },
        dateFormatDMYD(value) {
            if (value) {
                return moment(String(value)).format('Do MMM, YYYY, ddd');
            } else {
                return '-';
            }
        },
        dateFormatDoFHHmmss(value) {
            if (value) {
                return moment(String(value)).format('Do MMM, YYYY. hh:mm A');
            } else {
                return '-';
            }
        },
        dateFormatHHmm(value) {
            if (value) {
                return moment(String(value), 'HH:mm:ss').format('hh:mm A');
            } else {
                return '-';
            }
        },
        dateFormatHHmmss(value) {
            if (value) {
                return moment(String(value), 'HH:mm:ss').format('hh:mm:ss A');
            } else {
                return '-';
            }
        },
        twoDecimalPlaceF(value) {
            if (value) {
                return parseFloat(value).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
                return '-';
            }
        },
        timeFromNow(value) {
            if (value) {
                return moment(date).fromNow();
            } else {
                return '-';
            }
        }
    },
    methods: {
        logout() {
            this.$modal.show('dialog', {
                title  : 'Logout!',
                text   : 'Are You Sure You Want To Logout ?',
                buttons: [
                    {
                        title  : 'Yes',
                        handler: () => {
                            let data = this.user;
                            console.log('handler: user: ', data);
                            this.onModalFormSubmit3('/api/v1/logout', data, 'You Have Been Succesfully Logged Out!');
                            this.$modal.hide('dialog');
                        }
                    },
                    {
                        title  : 'No',
                        default: true,
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    },
                ]
            })
        },
        pagignatorEmptyArray: function (newVal, oldVal) {
            console.log('watch: pagignatorEmptyArray: ');
            if (newVal === false && oldVal === true) {
                setTimeout(() => {
                    if (this.$refs.paginator) {
                        this.$refs.paginator.goToPage(1)
                    }
                }, 100)
            }
        },

        getLateSpan(item) {
            if (item['time_in'] && item['shift'] && item['shift']['time_from']) {
                let start = moment(item['shift']['time_from'], 'HH:mm:ss');
                let end = moment(item['time_in'], 'HH:mm:ss');
                if (item['shift']['time_from'] > item['time_in']) {
                    return '<span class = "badge badge-success">- ' + this.timeDiffer2(end, start, '[h][, ]m[m]') + '</span>';
                } else if (item['shift']['time_from'] < item['time_in']) {
                    return '<span class = "badge badge-danger">' + this.timeDiffer2(start, end, '[h][, ]m[m]') + '</span>';
                } else {
                    return '-';
                }
            } else {
                return '-';
            }
        },

        getWorkDayType(item, work_calendar) {
            // console.log('getWorkDayType: ', item, work_calendar);
            let workday_type = '-';
            if (item['date'] && item['user'] && item['user']['work_days']) {
                if (this.isPublicHoliday(item, work_calendar)) {
                    workday_type = 'Public Holiday';
                } else if (this.isWorkingDay(item)) {
                    workday_type = 'Workday';
                } else {
                    workday_type = 'Non Workday';
                }
            } else {
                workday_type = 'Error!';
            }
            return workday_type;
        },

        getWorkDayTypeSpan(workday_type) {
            switch (workday_type) {
                case 'Workday':
                    return '<span class = "badge badge-success">' + workday_type + '</span>';
                    break;
                case 'Non Workday':
                    return '<span class = "badge badge-warning">' + workday_type + '</span>';
                    break;
                case 'Public Holiday':
                    return '<span class = "badge badge-danger">' + workday_type + '</span>';
                    break;
                default:
                    return '<span class = "badge badge-neutral">' + workday_type + '</span>';
                    break;
            }
        },

        getAttendanceStatus(attendance_status) {
            switch (attendance_status) {
                case 'Present':
                    return '<span class = "badge badge-success">' + attendance_status + '</span>';
                    break;
                case 'Late':
                    return '<span class = "badge badge-success-2">' + attendance_status + '</span>';
                    break;
                case 'Absent':
                    return '<span class = "badge badge-danger">' + attendance_status + '</span>';
                    break;
                case 'Leave':
                    return '<span class = "badge badge-warning">' + attendance_status + '</span>';
                    break;

                case 'Workday':
                    return '<span class = "badge badge-danger">' + 'Absent' + '</span>';
                    break;
                case 'Non Workday':
                    return '<span class = "badge badge-neutral">' + 'N/A' + '</span>';
                    break;
                case 'Public Holiday':
                    return '<span class = "badge badge-neutral">' + 'N/A' + '</span>';
                    break;

                default:
                    return '<span class = "badge badge-neutral">' + attendance_status + '</span>';
                    break;
            }
        },

        getUserPayRate(user) {
            if (user && user['pay_rate_unit_type'] && user['pay_rate_unit_type']['name']) {
                switch (user['pay_rate_unit_type']['name']) {
                    case 'Month':
                        return user['pay_rate'] / 30 / 8;
                        break;
                    case 'Hour':
                        return user['pay_rate'];
                        break;
                    default:
                        return false;
                        break;
                }
            } else {
                return false;
            }
        },

        getOvertime(item, work_calendar, settings) {
            let overtime = '-';
            if (item['time_in'] && item['time_out'] && item['shift'] && item['shift']['time_from'] && item['shift']['time_to']) {
                let time_to = moment(item['shift']['time_to'], 'HH:mm:ss');
                let time_to_new = time_to.add(settings['overtime_count_after'], 'minutes');
                let time_out = moment(item['time_out'], 'HH:mm:ss');
                let time_in = moment(item['time_in'], 'HH:mm:ss');

                if (this.isWorkingDay(item)) {
                    if (this.isPublicHoliday(item, work_calendar)) {
                        overtime = this.timeDiffer2(time_in, time_out, '[h][, ]m[m]');
                    } else {
                        if (time_out > time_to) {
                            if (time_out > time_to_new) {
                                overtime = this.timeDiffer2(time_to_new, time_out, '[h][, ]m[m]');
                            } else {
                                overtime = '-';
                            }
                        } else {
                            overtime = '-' + this.timeDiffer2(time_out, time_to, '[h][, ]m[m]');
                        }
                    }
                } else {
                    overtime = this.timeDiffer2(time_in, time_out, '[h][, ]m[m]');
                }
            }

            return overtime;
        },

        getOvertimeIncome(item, work_calendar, settings) {
            let overtime = '-';
            let user_pay_rate_hour = this.getUserPayRate(item['user']);
            // console.log('getOvertimeIncome: ', user_pay_rate_hour, item['user'], work_calendar, item['date'], settings['overtime_count_after'], settings['overtime_rate_workday'], settings['overtime_rate_weekend'], settings['overtime_rate_holiday']);
            if (user_pay_rate_hour && user_pay_rate_hour > 0 && work_calendar && settings['overtime_rate_workday'] > 0 && settings['overtime_rate_weekend'] > 0 && settings['overtime_rate_holiday'] > 0) {
                if (item['time_in'] && item['time_out'] && item['shift'] && item['shift']['time_from'] && item['shift']['time_to']) {
                    let time_to = moment(item['shift']['time_to'], 'HH:mm:ss');
                    let time_to_new = time_to.add(settings['overtime_count_after'], 'minutes');
                    let time_out = moment(item['time_out'], 'HH:mm:ss');
                    let time_in = moment(item['time_in'], 'HH:mm:ss');

                    if (this.isPublicHoliday(item, work_calendar)) {
                        overtime = (moment.duration(time_out.diff(time_in)).asMinutes() / 60) * (user_pay_rate_hour * settings['overtime_rate_holiday']);
                    } else if (this.isWorkingDay(item)) {
                        if (time_out > time_to && time_out > time_to_new) {
                            overtime = (moment.duration(time_out.diff(time_to_new)).asMinutes() / 60) * (user_pay_rate_hour * settings['overtime_rate_workday']);
                        } else {
                            overtime = 0;
                        }
                    } else {
                        overtime = (moment.duration(time_out.diff(time_in)).asMinutes() / 60) * (user_pay_rate_hour * settings['overtime_rate_weekend']);
                    }
                }
            } else {
                overtime = 'Error!';
            }

            return overtime;
        },

        isPublicHoliday(item, work_calendar) {
            // console.log('isPublicHoliday: ', item, work_calendar);
            if (work_calendar && work_calendar.find(e => e.date === item['date'])) {
                return true;
            }
            return false;
        },

        isWorkingDay(item) {
            let date = moment(item['date'], 'YYYY-MM-DD');
            // console.log('isWorkingDay: ', item, item['user']['work_days'], date.format('dddd'));
            if (item['user'] && item['user']['work_days'] && item['user']['work_days'].find(e => e.name === date.format('dddd'))) {
                return true;
            }
            return false;
        },

        getSerialData(index, item, data, c) {
            console.log('getSerialData: ', index);
            // console.log('getSerialData: ', index, item, data, c);
            // const allEqual = arr => arr.every(v => v === arr[0]);
            // IF all the ids are same, show in the first only.
            // IF id not exists anywhere else, then.
            // IF the next id is same, more than 1, not exists anywhere else, then.
            let show = false;
            if (index === 0) { // If First Item in Full Array.
                show = true;
            } else if (index > 0) { // Second and Onward Array Item:
                const count = data.reduce(function (m, val) {
                    return m + (val[c.rel][c.field] === item[c.rel][c.field]);
                }, 0);
                if (count === 1) { // If current item count is 1:
                    show = true;
                } else if (count > 1) { // If current item count is more than 1:
                    let pos = [];
                    data.forEach((dt, i) => { // Get Positions of Same Name Items.
                        if (item[c.rel][c.field] === data[i][c.rel][c.field]) {
                            pos.push(i);
                        }
                    });
                    let showTemp = false;
                    pos.forEach((n, i) => { // Go Through all the positions of Array.
                        if (n[i + 1] && n[i] + 1 === n[i + 1]) {
                            showTemp = true;
                        } else {
                            showTemp = false;
                        }
                    });
                    console.log('pos.forEach: ', showTemp);
                }

                /*if (data[index - 1] && item[c.rel][c.field] === data[index - 1][c.rel][c.field]) { // If the previous item exists and item name same as current item name.
                    show = false;
                } else if (data[index + 1] && item[c.rel][c.field] === data[index + 1][c.rel][c.field]) { // If the next item exists and item name same as current item name.
                    show = false;
                } else if (data[index - 1] && item[c.rel][c.field] !== data[index - 1][c.rel][c.field]) { // If the previous item exists and item name not same as current item name.
                    const count = data.reduce(function (m, val) {
                        return m + (val[c.rel][c.field] === item[c.rel][c.field]);
                    }, 0);
                    if (count === 1) { // If current item count is 1:
                        show = true;
                    } else if (count > 1) { // If current item count is more than 1:
                        // If all items are same:
                        console.log('getSerialData: ', data.some(e => e[c.rel][c.field] === item[c.rel][c.field]));
                        if (data.some(e => e[c.rel][c.field] === item[c.rel][c.field])) { // exists in items from next array:
                            show = false;
                        } else {
                            show = true;
                        }
                    } else { // Not Reachable Probabily:
                        //TODO:
                        show = false;
                    }
                    /!*for (const [i, d] of data.entries()) {
                        if (item[c.rel][c.field] === d[c.rel][c.field] && data[i + 1] && item[c.rel][c.field] === data[i + 1][c.rel][c.field]) {
                            show = true;
                        } else {
                            show = true;
                        }
                    }*!/
                } else if (data[index - 1]) { // If the next item exists: // Not Reachable Probabily:
                    //TODO:
                    show = false;
                } else { // Not Reachable Probabily:
                    //TODO:
                    show = false;
                }*/
            } else { // Only 1 Item in Array.
                console.log('getSerialData: Only 1 Item in Array.');
                show = true;
            }
            return show;


            /*if (data && data.length === 1) {
                return true;
            } else if (data && data.length > 1) {
                let guilty = false;
                for (const [i, d] of data.entries()) {
                    console.log('getSerialData: ', d, i, d[c.rel][c.field], item[c.rel][c.field]);
                    if (item[c.rel][c.field] === d[c.rel][c.field] && data[i + 1] && item[c.rel][c.field] === data[i + 1][c.rel][c.field]) {

                    } else {
                        guilty = true;
                        if (i === data.length - 1) {
                            return true;
                        }
                    }
                }
            } else {
                return false;
            }*/
        },

        onPageChange(toPage, fromPage) {
            console.log('onPageChange: ', toPage, fromPage);
        },
        printDiv(print, printType, data) {
            console.log('printDiv: ', print, printType, data);
            var mywindow = window.open('', 'PRINT', 'height=600,width=1000');
            let title = '';
            let subTitle = '';

            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('<link rel = "stylesheet" href = "/css/print.css" type = "text/css" />');
            mywindow.document.write('</head><body class = "body">');
            mywindow.document.write('<div class = "document-title">' + document.title + '</div>');
            mywindow.document.write('<div class = "section-title">' + title + '</div>');
            mywindow.document.write('<div class = "section-subtitle">' + subTitle + '</div>');
            if (print.time) {
                mywindow.document.write('<div class = "section-time">' + moment().format('DD-MM-YYYY, hh:mm a') + '</div>');
            }
            mywindow.document.write('<hr>');

            switch (printType) {
                case 'dataTable':
                    mywindow.document.write('<div class = "table-div"><table class = "table table-striped"><thead>');
                    print.headers.forEach((header, i) => {
                        mywindow.document.write('<th class = "table-th">' + header + '</th>');
                    });
                    mywindow.document.write('</thead><tbody class = "table-tbody">');
                    data.forEach((dt, i) => {
                        if (dt['report_header'] && dt['report_header']['text']) {
                            mywindow.document.write('<tr class = "table-tr">');
                            mywindow.document.write('<td colspan = "100%" class="table-td">' + dt['report_header']['text'] + '</td>');
                            mywindow.document.write('</tr>');
                        }
                        mywindow.document.write('<tr class = "table-tr">');
                        print.fields.forEach((f) => {
                            mywindow.document.write('<td class="table-td">' + dt.TableViewData[f] + '</td>');
                        });
                        mywindow.document.write('</tr>');
                    });
                    mywindow.document.write('</tbody></table></div>');

                    mywindow.document.write('</body>');
                    mywindow.document.write('</html>');
                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10*/
                    break;
                case 'modalView':
                    mywindow.document.write(data);

                    mywindow.document.write('</body>');
                    mywindow.document.write('</html>');
                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10*/
                    break;
                case 'divId':
                    if (print.printDivId) {
                        mywindow.document.write(document.getElementById(print.printDivId).innerHTML);

                        mywindow.document.write('</body>');
                        mywindow.document.write('</html>');
                        mywindow.document.close(); // necessary for IE >= 10
                        mywindow.focus(); // necessary for IE >= 10*/
                    }
                    break;
                default:
                    break;
            }


            // mywindow.print();
            // mywindow.close();
        },
        setLayout(layout) {
            console.log('setLayout: ', layout);
            // this.$store.commit('SET_LAYOUT', layout);
        },
        countObjectProp(obj) {
            let count = 0;
            for (let property in obj) {
                if (Object.prototype.hasOwnProperty.call(obj, property)) {
                    count++;
                }
            }
            return count;
        },

        sortTableData(item, dbQuery, vuexKey) {
            console.log('sortTableData 1: ', item, dbQuery, vuexKey, this.dataTable['data']);
            if (item.field && item.field.length > 0) {
                this.dbQuery.sortBy.relation = item.relation;
                this.dbQuery.sortBy.field = item.field;
                this.dbQuery.sortBy.desc === true ? this.dbQuery.sortBy.desc = false : this.dbQuery.sortBy.desc = true;
                if (item.sortType === 'js') {
                    this.dataTable['data'].sort(this.compareValues(item.relation, item.field, this.dbQuery.sortBy.desc === true ? 'desc' : 'asc'));
                } else if (item.sortType === 'jsText') {
                    this.dataTable['data'].sort(this.compareValues2(item.relation === false ? item.field : item.relation, this.dbQuery.sortBy.desc === true ? 'desc' : 'asc'));
                } else if (item.sortType === 'db') {
                    this.onLoadPageData(this.ItemGetUrl, dbQuery, vuexKey, 'loading', false);
                }
            }
            // this.dataTable['data2'] = this.dataTable['data'];
        },
        compareValues(relation, field, order = 'asc') {
            console.log('compareValues: ', relation, field, order);
            if (relation && relation !== false && relation.length > 0) {
                return (a, b) => {
                    if (a[relation] === null || b[relation] === null || !a[relation].hasOwnProperty(field) || !b[relation].hasOwnProperty(field)) {
                        // property doesn't exist on either object
                        return 0;
                    }

                    const varA = (typeof a[relation][field] === 'string') ?
                        a[relation][field].toUpperCase() : a[relation][field];
                    const varB = (typeof b[relation][field] === 'string') ?
                        b[relation][field].toUpperCase() : b[relation][field];

                    let comparison = 0;
                    if (varA > varB) {
                        comparison = 1;
                    } else if (varA < varB) {
                        comparison = -1;
                    }
                    return ((order == 'desc') ? (comparison * -1) : comparison);
                };
            } else if (relation === false) {
                return (a, b) => {
                    if (!a.hasOwnProperty(field) || !b.hasOwnProperty(field)) {
                        // property doesn't exist on either object
                        return 0;
                    }

                    const varA = (typeof a[field] === 'string') ?
                        a[field].toUpperCase() : a[field];
                    const varB = (typeof b[field] === 'string') ?
                        b[field].toUpperCase() : b[field];

                    let comparison = 0;
                    if (varA > varB) {
                        comparison = 1;
                    } else if (varA < varB) {
                        comparison = -1;
                    }
                    return ((order == 'desc') ? (comparison * -1) : comparison);
                };
            } else {
                // return 0;
            }
        },
        compareValues2(field, order = 'asc') {
            console.log('compareValues2: ', field, order);
            return (a, b) => {
                if (!a['TableViewData'].hasOwnProperty(field) || !b['TableViewData'].hasOwnProperty(field)) {
                    // property doesn't exist on either object
                    return 0;
                }

                const varA = (typeof a['TableViewData'][field] === 'string') ?
                    a['TableViewData'][field].toUpperCase() : a['TableViewData'][field];
                const varB = (typeof b['TableViewData'][field] === 'string') ?
                    b['TableViewData'][field].toUpperCase() : b['TableViewData'][field];

                let comparison = 0;
                if (varA > varB) {
                    comparison = 1;
                } else if (varA < varB) {
                    comparison = -1;
                }
                return ((order == 'desc') ? (comparison * -1) : comparison);
            }
        },
        searchPageItem(event, searchType, searchText, headers) {
            // console.log('searchPageItem: ', searchType, searchText, headers);
            let _this = this;
            if (event.target.value && event.target.value.length > 0) {
                if (searchType && searchType === 'js') {
                    this.page.searching = true;
                    let searchWord = event.target.value.toString().toLowerCase().trim();
                    this.dataTable['data'] = this.dataTable['data2'].filter(function (item) {
                        for (let i in headers) {
                            // console.log('searchPageItem: 0: ', i, searchType, headers[i].field, headers[i].relation, item['TableViewData'], item[headers[i].field]);
                            if (headers[i].field && headers[i].field.length > 0 && headers[i].operator && headers[i].operator.length > 0) {
                                let dataWord = '';
                                if (headers[i].relation && headers[i].relation.length > 0 && item[headers[i].relation] && item[headers[i].relation][headers[i].field]) {
                                    dataWord = item[headers[i].relation][headers[i].field].toString().toLowerCase().trim();
                                    // console.log('searchPageItem: 1: ', i, headers[i].field, headers[i].relation, item[headers[i].relation][headers[i].field], dataWord, searchWord);
                                } else if (headers[i].relation === false && item[headers[i].field]) {
                                    dataWord = item[headers[i].field].toString().toLowerCase().trim();
                                    // console.log('searchPageItem: 2: ', i, headers[i].field, headers[i].relation, item[headers[i].field], dataWord, searchWord, item);
                                }
                                if (dataWord.includes(searchWord)) {
                                    return true;
                                }
                            }
                        }
                        /*headers.forEach(function (header, i) {
                            if (header.field && header.field.length > 0) {
                                let dataWord = '';
                                // if (item[key] && typeof item[key] !== 'undefined' && item[key] !== undefined && item[key] !== null) {
                                // if (typeof item[key] == 'object') {
                                if (header.relation && header.relation.length > 0 && item[header.relation] && item[header.relation][header.field]) {
                                    dataWord = item[header.relation][header.field].toString().toLowerCase().trim();
                                    console.log('searchPageItem: 1: ', i, header.field, header.relation, item[header.relation][header.field], dataWord, searchWord);
                                } else if (header.relation === false) {
                                    dataWord = item[header.field].toString().toLowerCase().trim();
                                    console.log('searchPageItem: 2: ', i, header.field, header.relation, item[header.field], dataWord, searchWord);
                                }
                                if (dataWord.includes(searchWord)) {
                                    console.log('searchPageItem: 3: TRUE');
                                    return true;
                                }
                            }
                        })*/
                    });
                    if (this.$refs.paginator && this.dataTable['data'] && this.dataTable['data'].length > 0) {
                        this.$refs.paginator.goToPage2(1);
                    }
                    this.page.searching = false;
                } else if (searchType && searchType === 'jsText') {
                    this.page.searching = true;
                    let searchWord = event.target.value.toString().toLowerCase().trim();
                    this.dataTable['data'] = this.dataTable['data2'].filter(function (item) {
                        for (let i in headers) {
                            // console.log('searchPageItem: 0: ', i, headers[i].field, headers[i].relation, item['TableViewData']);
                            // console.log('searchPageItem: 0: ', i, searchType, headers[i].field, headers[i].relation, item['TableViewData'], searchWord);
                            let dataWord = '';
                            if (headers[i].field && headers[i].field.length > 0 && headers[i].relation && headers[i].relation.length > 0 && item['TableViewData'][headers[i].relation]) {
                                dataWord = item['TableViewData'][headers[i].relation].toString().toLowerCase().trim();
                                // console.log('searchPageItem: 1: ', i, headers[i].field, headers[i].relation, item[headers[i].relation][headers[i].field], dataWord, searchWord);
                            } else if (headers[i].field && headers[i].field.length > 0 && headers[i].relation === false && item['TableViewData'][headers[i].field]) {
                                dataWord = item['TableViewData'][headers[i].field].toString().toLowerCase().trim();
                                // console.log('searchPageItem: 2: ', i, headers[i].field, headers[i].relation, item[headers[i].field], dataWord, searchWord);
                            }
                            if (dataWord.includes(searchWord)) {
                                return true;
                            }
                        }
                    });
                    if (this.$refs.paginator && this.dataTable['data'] && this.dataTable['data'].length > 0) {
                        this.$refs.paginator.goToPage2(1);
                    }
                    this.page.searching = false;
                } else if (searchType && searchType === 'db') {
                    if (this.timeout) clearTimeout(this.timeout);
                    this.timeout = setTimeout(() => {
                        this.dbQuery.search.text = searchText;
                        this.dbQuery.search.fields = headers;
                        console.log('searchType: db: ', this.dbQuery.search);
                        this.onLoadPageData(this.ItemGetUrl, this.dbQuery, this.page.vuexKey, 'searching', false);
                    }, 500);
                }
            } else {
                this.dataTable['data'] = this.dataTable['data2'];
                if (this.$refs.paginator) {
                    this.$refs.paginator.goToPage2(1);
                }
            }
            //console.log('searchPageItem: ', event.target.value, this.dataTable.event.length, this.dataTable['data2']);
        },
        clearSearch() {
            this.page.searchText = '';
            this.dataTable['data'] = this.dataTable['data2'];
            if (this.$refs.paginator && this.dataTable['data'] && this.dataTable['data'].length > 0) {
                this.$refs.paginator.goToPage2(1);
            }
            console.log('clearSearch: ', this.page.searchText, this.dataTable['data'].length, this.dataTable['data2']);
        },

        onFileChange(event, params) {
            let files = event.target.files;
            let sizeLimit = this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['sizeLimit'];
            console.log('onFileChange: ', params, files.length, files);
            if (files && files.length > 0) {
                // this[params[0]][params[1]][params[2]][params[3]][params[4]] = null;
                this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['files'] = [];
                for (let i = 0; i < files.length; i++) {
                    let file = files[i];
                    let size = file.size / 1024 / 1024;
                    console.log('onFileChange: size: ', i, size, sizeLimit, file);
                    if (size > sizeLimit) {
                        this.vueDialogShow('Size limit Exceed!', 'File too large, Maximum Size limit ' + sizeLimit + 'MB');
                    } else {
                        // this[params[0]]['form'][params[2]] = URL.createObjectURL(file); // set in normal form
                        this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['files'][i] = file; // set form file object in dbInsert files object array.
                    }
                }
                console.log('onFileChange: fileURL: ', this[params[0]][params[1]][params[2]].formControlName, ' : ', this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['files']);
            } else {
                this.vueDialogShow('File not found!', 'File not detected, Please choose correct file.');
            }
        },
        onImageFileChange(event, params) {
            let files = event.target.files;
            console.log('onImageFileChange: ', params, files.length, files);
            let sizeLimit = this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['sizeLimit'];
            if (files && files.length > 0) {
                this[params[0]][params[1]][params[2]][params[3]][params[4]] = null;
                this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['files'] = [];
                for (let i = 0; i < files.length; i++) {
                    let imageFile = files[i];
                    let size = imageFile.size / 1024 / 1024;
                    console.log('onImageFileChange: size: ', i, size, sizeLimit, imageFile);
                    if (!imageFile.type.match('image.*')) {
                        this.vueDialogShow('Invalid Image format!', 'Please choose correct image file (jpg, jpeg, png, bmp...).');
                    } else if (size > sizeLimit) {
                        this.vueDialogShow('Size limit Exceed!', 'File too large, Maximum Size limit ' + sizeLimit + 'MB');
                    } else {
                        this[params[0]]['form'][params[2]] = URL.createObjectURL(imageFile); // set in normal form
                        this[params[0]][params[1]][params[2]][params[3]][params[4]] = URL.createObjectURL(imageFile); // set image url in 'modalAdd', 'inputs', 'photo', 'image', 'imageSrc'.
                        this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['active'] = true;
                        this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['files'][i] = imageFile; // set form file object in dbInsert files object array.
                    }
                }
                console.log('onImageFileChange: imageURL: ', this.modalEdit.form, this[params[0]]['form'][params[2]], this[params[0]][params[1]][params[2]].formControlName, ' : ', this[params[0]].dbInsert.fileUploads.files[this[params[0]][params[1]][params[2]].formControlName]['files']);
            } else {
                this.vueDialogShow('File not found!', 'File not detected, Please choose correct file.');
            }
        },
        clearPhoto(event, imageParams, clearButtonParams) {
            console.log('clearPhoto: ', event, imageParams, clearButtonParams);
            this[imageParams[0]][imageParams[1]][imageParams[2]][imageParams[3]][imageParams[4]] = null; // clear imageSrc
            this[clearButtonParams[0]][clearButtonParams[1]][clearButtonParams[2]] = null; // clear normal form
            this[imageParams[0]].dbInsert.fileUploads.files[this[imageParams[0]][imageParams[1]][imageParams[2]].formControlName]['files'] = null; // clear form data object
            console.log('clearPhoto: ', this[imageParams[0]][imageParams[1]][imageParams[2]][imageParams[3]][imageParams[4]], this[clearButtonParams[0]][clearButtonParams[1]][clearButtonParams[2]], this[imageParams[0]].dbInsert.fileUploads.files[this[imageParams[0]][imageParams[1]][imageParams[2]].formControlName]['files']);
        },

        timeDiffer(from, to, format = '[h][, ]mm[m, ]ss[s]') {
            console.log('timeDiffer: ', from, to, format);
            if (from && to) {
                let ms = moment(to, 'HH:mm:ss').diff(moment(from, 'HH:mm:ss'));
                let d = moment.duration(ms);
                return Math.floor(d.asHours()) + moment.utc(ms).format(format);
            } else {
                return '-';
            }
        },
        timeDiffer2(from, to = moment(), format = ':mm:ss') {
            // console.log('timeDiffer2: ', from, to, format);
            if (format && from && to) {
                let ms = moment(to, 'HH:mm:ss').diff(moment(from, 'HH:mm:ss'));
                let d = moment.duration(ms);
                return Math.floor(d.asHours()) + moment.utc(ms).format(format);
                // return d.format("hh:mm:ss");
            } else {
                return '-';
            }
        },
        timeDiffer3(from, to, addMin, format = ':mm:ss') {
            // console.log('timeDiffer3: ', from, to, addMin, format);
            if (format && from) {
                let momentFrom = moment(from, 'HH:mm:ss');
                let momentTo = moment(to, 'HH:mm:ss');
                let momentFromNew = momentFrom;
                if (momentTo > momentFrom) {
                    momentFromNew = momentFrom.add(addMin, 'minutes');
                    if (momentTo > momentFromNew) {
                        const difference = momentTo.diff(momentFromNew);
                        const differenceFormatted = Math.floor(moment.duration(difference).asHours()) + moment.utc(difference).format(format);
                        return differenceFormatted;
                    } else {
                        return '-';
                    }
                } else {
                    const difference = momentTo.diff(momentFrom);
                    const differenceFormatted = Math.floor(moment.duration(difference).asHours()) + moment.utc(difference).format(format);
                    return differenceFormatted;
                }
            } else {
                return '-';
            }
        },
        getCurrentDate(format) {
            if (format) {
                console.log('getCurrentDate: ', format, moment().format(format));
                return moment().format(format);
            } else {
                return '-';
            }
        },
        dateFormat(date, format) {
            if (date && format) {
                return moment(date).format(format);
            } else {
                return '-';
            }
        },
        timeFormat(time, format) {
            if (time && format) {
                return moment(time, 'HH:mm:ss').format(format);
            } else {
                return '-';
            }
        },
        twoDecimalPlace(value) {
            if (value) {
                return parseFloat(value).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
                '-';
            }
        },
        onDateInput(value, id, format) {
            console.log('dateInput: ', value, id, format);
            /*if (id && this.modalAdd.form[id]) {
                let setData = {};
                setData[id] = moment(this.modalAdd.form[id]).format(format);
                this.modalAdd.form.setData(setData);
            }*/
        },
        onDateInput2(value, id, format) {
            console.log('dateInput: ', value, id, format);
            if (id && this.modalEdit.form[id]) {
                let setData = {};
                setData[id] = moment(this.modalEdit.form[id]).format(format);
                this.modalEdit.form.setData(setData);
            }
        },
        disabledDate(time, data) {
            console.log('disabledDate: ', time, data);
            if (data && data.active === true) {
                var day = time.getDay();
                return day === 0 || day === 6;
            }
        },

        onMultiselectInput(value, id, formKey) {
            console.log('multiselectInput: ', id, value, formKey);
            let setData = {};
            if (value && (typeof value.id === 'number' || typeof value.id === 'string')) {
                setData[id] = value.id;
            } else if (value && value.length > 0) {
                setData[id] = value;
            } else if (id) {
                setData[id] = null;
            }
            if (this[formKey] && this[formKey].form) {
                this[formKey].form.setData(setData);
            }
        },
        onMultiselectInput2(value, id, formKey) {
            console.log('onMultiselectInput2: ', value, id, formKey);
            let setData = {};
            if (value && (typeof value.id === 'number' || typeof value.id === 'string')) {
                setData[id] = value.id;
            } else if (value && value.length > 0) {
                setData[id] = value;
            } else if (id) {
                setData[id] = null;
            }
            if (this[formKey] && this[formKey].form) {
                this[formKey].form.setData(setData);
            }
        },
        onMultiselectInput3(value, id, formKey, onInput) {
            console.log('onMultiselectInput3: ', value, id, formKey, onInput);
            let setData = {};
            if (value && (typeof value.id === 'number' || typeof value.id === 'string')) {
                setData[id] = value.id;
            } else if (value && value.length > 0) {
                setData[id] = value;
            } else if (id) {
                setData[id] = null;
            }
            if (this[formKey].form) {
                this[formKey].form.setData(setData);
            }
            if (onInput && onInput == 'switch_input' && value && value.id) {
                this.dbQuery = this.dbQueryList[this[formKey].form.report_id - 1];
                switch (value.id) {
                    case 1: // Attendance:
                        this.validations = this.validationList.first;
                        this[formKey].inputs = [
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this[formKey].inputList.report_id,
                                    this[formKey].inputList.date_from,
                                    this[formKey].inputList.date_to,
                                    this[formKey].inputList.user_id,
                                ],
                            },
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this.modalEdit.inputList.shift_id,
                                    this.modalEdit.inputList.employement_type,
                                    this.modalEdit.inputList.designation_id,
                                    this.modalEdit.inputList.department_id,
                                ],
                            },
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this.modalEdit.inputList.attendance_status_id,
                                    this.modalEdit.inputList.attendance_method_id,
                                ],
                            },
                        ];
                        this.nullifyFormFields(formKey, [
                            /*'report_id',
                            'date_from',
                            'date_to',
                            'user_id',
                            'shift_id',
                            'designation_id',
                            'department_id',
                            'employement_type',
                             'attendance_status_id',
                            'attendance_method_id',*/
                            'active',
                        ]);
                        break;
                    case 2: // Overtime:
                        this.validations = this.validationList.first;
                        this[formKey].inputs = [
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this[formKey].inputList.report_id,
                                    this[formKey].inputList.date_from,
                                    this[formKey].inputList.date_to,
                                    this[formKey].inputList.user_id,
                                ],
                            },
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this.modalEdit.inputList.shift_id,
                                    this.modalEdit.inputList.employement_type,
                                    this.modalEdit.inputList.designation_id,
                                    this.modalEdit.inputList.department_id,
                                ],
                            },
                        ];
                        this.nullifyFormFields(formKey, [
                            /*'report_id',
                             'date_from',
                             'date_to',
                             'user_id',
                             'shift_id',
                             'designation_id',
                             'department_id',
                             'employement_type',*/
                            'attendance_status_id',
                            'attendance_method_id',
                            'active',
                        ]);
                        break;
                    case 3: // LATE:
                        this.validations = this.validationList.first;
                        this[formKey].inputs = [
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this[formKey].inputList.report_id,
                                    this[formKey].inputList.date_from,
                                    this[formKey].inputList.date_to,
                                    this[formKey].inputList.user_id,
                                ],
                            },
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this.modalEdit.inputList.shift_id,
                                    this.modalEdit.inputList.employement_type,
                                    this.modalEdit.inputList.designation_id,
                                    this.modalEdit.inputList.department_id,
                                ],
                            },
                        ];
                        this.nullifyFormFields(formKey, [
                            /*'report_id',
                            'date_from',
                            'date_to',
                            'user_id',
                            'shift_id',
                            'designation_id',
                            'department_id',
                            'employement_type',*/
                            'attendance_status_id',
                            'attendance_method_id',
                            'active',
                        ]);
                        break;
                    case 4: // Absent:
                        this.validations = this.validationList.first;
                        this[formKey].inputs = [
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this[formKey].inputList.report_id,
                                    this[formKey].inputList.date_from,
                                    this[formKey].inputList.date_to,
                                    this[formKey].inputList.user_id,
                                ],
                            },
                        ];
                        this.nullifyFormFields(formKey, [
                            /*'report_id',
                            'date_from',
                            'date_to',
                            'user_id',*/
                            'shift_id',
                            'designation_id',
                            'department_id',
                            'employement_type',
                            'attendance_status_id',
                            'attendance_method_id',
                            'active',
                        ]);
                        break;
                    case 5: // Leave:
                        this.validations = this.validationList.first;
                        this[formKey].inputs = [
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this[formKey].inputList.report_id,
                                    this[formKey].inputList.date_from,
                                    this[formKey].inputList.date_to,
                                    this[formKey].inputList.user_id,
                                ],
                            },
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this.modalEdit.inputList.shift_id,
                                    this.modalEdit.inputList.employement_type,
                                    this.modalEdit.inputList.designation_id,
                                    this.modalEdit.inputList.department_id,
                                ],
                            },
                        ];
                        this.nullifyFormFields(formKey, [
                            /*'report_id',
                            'date_from',
                            'date_to',
                            'user_id',
                            'shift_id',
                            'designation_id',
                            'department_id',
                            'employement_type',*/
                            'attendance_status_id',
                            'attendance_method_id',
                            'active',
                        ]);
                        break;
                    case 6: // Overall:
                    case 7: // Overall (Consolidate):
                        this.validations = this.validationList.first;
                        this[formKey].inputs = [
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this[formKey].inputList.report_id,
                                    this[formKey].inputList.date_from,
                                    this[formKey].inputList.date_to,
                                    this[formKey].inputList.user_id,
                                ],
                            },
                        ];
                        this.nullifyFormFields(formKey, [
                            /*'report_id',
                            'date_from',
                            'date_to',
                            'user_id',*/
                            'shift_id',
                            'designation_id',
                            'department_id',
                            'employement_type',
                            'attendance_status_id',
                            'attendance_method_id',
                            'active',
                        ]);
                        break;
                    default:
                        // this.inputDefaults();
                        this[formKey].inputs = [
                            {
                                rowClass: 'form-row',
                                rowStyle: '',
                                column  : [
                                    this[formKey].inputList.report_id,
                                    this[formKey].inputList.date_from,
                                    this[formKey].inputList.date_to,
                                    // this[formKey].inputList.active,
                                ],
                            },
                        ];
                        this.nullifyFormFields(formKey, [
                            'report_id',
                            'date_from',
                            'date_to',
                            'user_id',
                            'shift_id',
                            'employement_type',
                            'designation_id',
                            'department_id',
                            'attendance_status_id',
                            'attendance_method_id',
                            'active',
                        ]);
                        break;
                }
            }
        },

        nullifyFormFields(formKey, formFields) {
            console.log('nullifyFormFields: ', formKey, formFields);
            let setData = {};
            formFields.forEach((val) => {
                setData[val] = null;
                this.option[formKey][val] = {};
            });
            if (this[formKey].form) {
                this[formKey].form.setData(setData);
            }
        },

        inputCBListModal(vueModalListCBAll, id) {
            console.log('inputCBListModal: ', vueModalListCBAll, this.options[id]);
            if (vueModalListCBAll) {
                for (let i = 0; i < this.options[id].length; i++) {
                    this.options[id][i]['selected'] = false;
                }
            } else {
                for (let i = 0; i < this.options[id].length; i++) {
                    this.options[id][i]['selected'] = true;
                }
            }
        },

        getVueValidationErrors(modalForm) {
            let errors = [];
            let errorDisplay = [];
            if (modalForm.$invalid === true) {
                for (let prop in modalForm.$params) {
                    if (modalForm.hasOwnProperty(prop)) {
                        if (modalForm[prop].$invalid === true) {
                            for (let field in modalForm[prop].$params) {
                                if (modalForm[prop].hasOwnProperty(field)) {
                                    if (modalForm[prop][field] === false) {
                                        errors.push({prop: modalForm[prop][field]});
                                        errorDisplay.push(modalForm[prop][field]);
                                    }
                                }
                            }
                        }
                    }
                }
                console.log('getVueValidationErrors: ERRORS: ', errors, modalForm.$invalid, modalForm.$params);
            } else {
                console.log('getVueValidationErrors: NO ERRORS: ', errors, modalForm.$invalid, modalForm.$params);
            }
        },
        setPushOptions(optionSet, optionPush) {
            if (optionSet && optionSet) {
                for (let property in optionSet) {
                    this.options[property] = optionSet[property];
                }
            }
            if (optionPush && optionPush) {
                let i = 0;
                for (let property in optionPush) {
                    this.options[property].push(optionPush[property][i]);
                    i++;
                }
            }
        },
        getFormInputs(url, data, dbQueryForInputs, routeParams, optionSet, optionPush) {
            try {
                console.log('getFormInputs: ', url, data, dbQueryForInputs, routeParams, optionSet, optionPush);
                axios({
                    method      : 'POST',
                    url         : url,
                    data        : {
                        data            : data ? data : [],
                        dbQueryForInputs: dbQueryForInputs ? dbQueryForInputs : [],
                    },
                    responseType: 'json'
                }).then(response => {
                    console.log('getFormInputs: ', response.data ? response.data : response);
                    if (response.data && response.data.status === 200) {
                        this.options = response.data.data;
                        if (optionSet && optionSet) {
                            for (let property in optionSet) {
                                this.options[property] = optionSet[property];
                            }
                        }
                        if (optionPush && optionPush) {
                            let i = 0;
                            for (let property in optionPush) {
                                this.options[property].push(optionPush[property][i]);
                                i++;
                            }
                        }
                        if (routeParams && routeParams) {
                            this.setPageFormDataOptionsWithParams(routeParams);
                        }
                        console.log('getFormInputs: options: ', this.options, this.option);
                    } else {
                        this.vueDialogShow('Error!', 'Data Not Found!');
                    }
                }).catch(error => {
                    //console.log('error: ', error);
                    let errors = [];
                    let errorDisplay = '';
                    //errors.push("Failed to perform operation");
                    if (error.response) {
                        console.log('error.response: ', error.response);
                        errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                    } else if (error.request) {
                        console.log('error.request: ', error.request);
                        errors.push(error.request);
                    } else {
                        console.log('error.else: ', error.message ? error.message : error);
                        errors.push(error.message ? error.message : 'error.message not found');
                    }
                    if (error.response && error.response.data && error.response.data.message) {
                        if (typeof error.response.data.message == 'string') {
                            errors.push(error.response.data.message);
                        } else if (typeof error.response.data.message == 'object') {
                            for (let prop in error.response.data.message) {
                                if (error.response.data.message.hasOwnProperty(prop)) {
                                    errors.push(error.response.data.message[prop]);
                                }
                            }
                        }
                    }
                    errors.forEach((val) => {
                        errorDisplay += val + '<br>';
                    });
                    this.vueDialogShow('Error!', errorDisplay);
                });
            } catch (err) {
                console.log('err: ', url, err);
                this.vueDialogShow('Error!', err.message ? err.message : err);
            }
        },
        onLoadPageData(url, dbQuery, vuexKey, loadType, setPageData, formKey) {
            try {
                if (this.page[loadType] === false) {
                    this.page[loadType] = true;
                    console.log('onLoadPageData: ', url, dbQuery, vuexKey, loadType, this.page[loadType], setPageData, formKey);
                    axios({
                        method      : 'POST',
                        url         : url,
                        data        : {
                            dbQuery: dbQuery ? dbQuery : [],
                        },
                        responseType: 'json',
                        headers     : {
                            'Authorization': 'Bearer ' + localStorage.getItem('token'),
                        },
                    }).then(response => {
                        console.log('response/data: ', url, response.data ? response.data : response);
                        if (response.data && response.data.status === 200) {
                            if (vuexKey && vuexKey.length > 0) {
                                if (loadType && loadType === 'searching') {
                                    let vuexPayload = {
                                        key  : vuexKey,
                                        data : response.data.data,
                                        data2: this.dataTable['data2'],
                                    }
                                    this.$store.dispatch('ADD_DATATABLE', vuexPayload);
                                } else {
                                    let vuexPayload = {
                                        key  : vuexKey,
                                        data : response.data.data,
                                        data2: response.data.data,
                                    }
                                    this.$store.dispatch('ADD_DATATABLE', vuexPayload);
                                    // _this.$store.commit('ADD_DATATABLE', vuexPayload);
                                }
                            }
                            if (setPageData) {
                                this.pageItemSelected(response.data.data[0], formKey);
                            }
                        } else {
                            this.vueDialogShow('Error!', 'Data Loading Failed!');
                        }
                        this.page[loadType] = false;
                        if (this.$refs.paginator) {
                            this.$refs.paginator.goToPage2(1);
                        }
                    }).catch(error => {
                        //console.log('ACC: error: ', error);
                        this.page[loadType] = false;
                        if (this.$refs.paginator) {
                            this.$refs.paginator.goToPage2(1);
                        }
                        let errors = [];
                        let errorDisplay = '';
                        //errors.push("Failed to perform operation");
                        if (error.response) {
                            console.log('error.response: onLoadPageData: ', error.response);
                            if (error.response.status && error.response.status === 401) {
                                let notifyData = {
                                    'group': 'edited',
                                    'type' : 'warn',
                                    'title': 'Session Expired!',
                                    'text' : 'Your Session has Expired, Please Login Again.'
                                };
                                this.$notify(notifyData);
                                this.onModalFormSubmit3('/api/v1/logout', [], 'Your Session has Expired, Please Login Again.');
                            } else {
                                errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                            }

                        } else if (error.request) {
                            console.log('error.request: onLoadPageData: ', error.request);
                            errors.push(error.request);
                        } else {
                            console.log('error.else: onLoadPageData: ', error.message ? error.message : error);
                            errors.push(error.message ? error.message : 'error.message not found');
                        }
                        if (error.response && error.response.data && error.response.data.message) {
                            if (typeof error.response.data.message == 'string') {
                                errors.push(error.response.data.message);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errors.push(error.response.data.message[prop]);
                                    }
                                }
                            }
                        }
                        errors.forEach((val) => {
                            errorDisplay += val + '<br>';
                        });
                        this.vueDialogShow('Error!', errorDisplay);
                    });
                }
            } catch (err) {
                console.log('catch-err: onLoadPageData: ', err);
                this.page[loadType] = false;
                if (this.$refs.paginator) {
                    this.$refs.paginator.goToPage2(1);
                }
                this.vueDialogShow('Error!', err.message ? err.message : err);
            }
        },
        onModalFormSubmit(url, data, dbInsert, dbQuery, vuexKey, resetForm = true, focusId = null) {
            let _this = this;
            let postData = null;
            let formData = new FormData();
            let formConfig = null;
            try {
                _this.$v.modalAdd.$touch();
                _this.$v.modalAdd.$reset();
                _this.modalAdd.isSubmitting = true;
                _this.modalAdd.statusDiv.class = 'alert-json-error';
                _this.modalAdd.statusDiv.messages = [];
                //this.getVueValidationErrors(this.$v.modalAdd.form);
                /*for (let field in dbInsert.unique) {
                    dbInsert.validations[field] = dbInsert.validations[field] + dbInsert.unique[field] + data.id;
                }*/
                console.log('onModalFormSubmit: ', url, data, dbInsert, dbQuery, vuexKey, resetForm, focusId);
                if (_this.$v.modalAdd.$invalid) {
                    setTimeout(function () {
                        _this.$v.modalAdd.$touch();
                        _this.modalAdd.isSubmitting = false;
                        _this.modalAdd.statusDiv.messages.push('Form is Invalid! Please Check Inputs!');
                        console.log('Form is Invalid! Please Check Inputs!', _this.$v.modalAdd.form);
                    }, 700);
                } else {
                    if (dbInsert && dbInsert.sentAsFormData === true) {
                        if (dbInsert && dbInsert.fileUploads && dbInsert.fileUploads.files) {
                            for (let field in dbInsert.fileUploads.files) {
                                if (dbInsert.fileUploads.files.hasOwnProperty(field) && dbInsert.fileUploads.files[field] && dbInsert.fileUploads.files[field]['active'] === true) {
                                    for (let i in dbInsert.fileUploads.files[field].files) {
                                        formData.append(field + '[]', dbInsert.fileUploads.files[field].files[i]);
                                        data[field] = null;
                                    }
                                    console.log('onModalFormSubmit: formData: ', field, formData.getAll(field + '[]'));
                                }
                            }
                            formData.append('data', JSON.stringify(data));
                            formData.append('dbInsert', JSON.stringify(dbInsert));
                            formData.append('dbQuery', JSON.stringify(dbQuery));
                        }
                        postData = formData;
                        _this.modalAdd.uploadPercentage = null;
                        formConfig = {
                            headers: {
                                'content-type': 'multipart/form-data',
                            }
                        }
                        console.log('onModalFormSubmit: ', JSON.parse(formData.getAll('data')), JSON.parse(formData.getAll('dbInsert')), JSON.parse(formData.getAll('dbQuery')));
                    } else {
                        postData = {
                            data    : data ? data : [],
                            dbInsert: dbInsert ? dbInsert : [],
                            dbQuery : dbQuery ? dbQuery : [],
                        }
                    }
                    axios({
                        method          : 'POST',
                        url             : url,
                        data            : postData,
                        config          : formConfig,
                        responseType    : 'json',
                        headers         : {
                            'Authorization': 'Bearer ' + localStorage.getItem('token'),
                        },
                        onUploadProgress: function (progressEvent) {
                            _this.modalAdd.uploadPercentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total));
                            console.log('percentCompleted: ', _this.modalAdd.uploadPercentage, progressEvent);
                            if (_this.modalAdd.uploadPercentage >= 100) {
                                _this.modalAdd.uploadPercentage = 'Done';
                            }
                        }
                    }).then(response => {
                        _this.modalAdd.isSubmitting = false;
                        console.log('response/data: ', url, response.data ? response.data : response);
                        if (response.data && response.data.status === 200) {
                            //this.listDisplay.unshift(response.data.data);
                            //this.listDisplay[0] = response.data.data;
                            if (vuexKey && vuexKey.length > 0) {
                                let vuexPayload = {
                                    key  : vuexKey,
                                    data : response.data.data['dataAll'],
                                    data2: response.data.data['dataAll'],
                                }
                                _this.$store.dispatch('ADD_DATATABLE', vuexPayload);
                                // _this.$store.commit('ADD_DATATABLE', vuexPayload);
                            }
                            console.log('paginator: ', response.data.data['dataAll'].length);
                            if (response.data.data['dataAll'] && response.data.data['dataAll'].length === 1 && this.$refs.paginator) {
                                this.$refs.paginator.goToPage2(1);
                            }
                            if (focusId && focusId.length > 0) {
                                _this.setInputFocus(focusId);
                            }
                            if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved') {
                                if (resetForm) {
                                    _this.modalAdd.form.reset();
                                    _this.resetOption();
                                    _this.$v.modalAdd.$reset();
                                    _this.resetInputPhotos('modalAdd');
                                    /*if (this.modalAdd.form.listItems) {
                                        this.modalAdd.form.listItems = [];
                                    }*/
                                }
                                _this.modalAdd.statusDiv.class = 'alert-json-success';
                                _this.modalAdd.statusDiv.messages.push(response.data.data['notify']['text']);
                                _this.$notify(response.data.data['notify']);
                            } else {
                                _this.modalAdd.statusDiv.messages.push(response.data.data['notify']['text']);
                            }
                        } else {
                            _this.modalAdd.statusDiv.messages.push('Error, Data Not Found!');
                        }
                    }).catch(error => {
                        setTimeout(function () {
                            _this.modalAdd.isSubmitting = false;
                            //console.log('ACC: error: ', error);
                            //errors.push("Failed to perform operation");
                            if (error.response && error.response.data && error.response.data.message) {
                                console.log('catch-error: response: ', error);
                                if (typeof error.response.data.message == 'string') {
                                    _this.modalAdd.statusDiv.messages.push(error.response.data.message);
                                } else if (typeof error.response.data.message == 'object') {
                                    for (let prop in error.response.data.message) {
                                        if (error.response.data.message.hasOwnProperty(prop)) {
                                            _this.modalAdd.statusDiv.messages.push(error.response.data.message[prop]);
                                        }
                                    }
                                }
                            }
                            if (error.response) {
                                console.log('error.response: ', error.response);
                                _this.modalAdd.statusDiv.messages.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                                _this.modalAdd.statusDiv.messages.push(error.response.data && error.response.data.exception ? error.response.data.exception : 'exception not found');
                            } else if (error.request) {
                                console.log('error.request: ', error.request);
                                _this.modalAdd.statusDiv.messages.push(error.request);
                            } else {
                                console.log('error.else: ', error.message ? error.message : error);
                                _this.modalAdd.statusDiv.messages.push(error.message ? error.message : 'error.message not found');
                            }
                        }, 700);
                    });
                }
            } catch (err) {
                console.log('catch-err: ', err);
                setTimeout(function () {
                    _this.modalAdd.isSubmitting = false;
                    _this.modalAdd.statusDiv.class = 'alert-json-error';
                    _this.modalAdd.statusDiv.messages = [];
                    _this.modalAdd.statusDiv.messages.push(err.message ? err.message : err);
                }, 700);
            }
        },
        onModalFormSubmit2(url, data, dbInsert, dbQuery, vuexKey, formKey = '') {
            console.log('onModalFormSubmit2: ', url, data, dbInsert, dbQuery, vuexKey, formKey);
            let _this = this;
            let postData = null;
            let formData = new FormData();
            let formConfig = null;
            try {
                _this.$v[formKey].$touch();
                _this.$v[formKey].$reset();
                _this[formKey].isSubmitting = true;
                _this[formKey].statusDiv.class = 'alert-json-error';
                _this[formKey].statusDiv.messages = [];
                //_this.getVueValidationErrors(_this.$v[formKey].form);
                /*if (dbInsert && dbInsert.unique) {
                    for (let field in dbInsert.unique) {
                        if (dbInsert.unique.hasOwnProperty(field)) {
                            dbInsert.validations[field] = dbInsert.validations[field] + dbInsert.unique[field] + data.id;
                        }
                    }
                }*/
                if (_this.$v[formKey].$invalid) {
                    setTimeout(function () {
                        _this.$v[formKey].$touch();
                        _this[formKey].isSubmitting = false;
                        _this[formKey].statusDiv.messages.push('Form is Invalid! Please Check Inputs!');
                        console.log('Form is Invalid! Please Check Inputs!', _this.$v[formKey].form);
                    }, 700);
                } else {
                    if (dbInsert && dbInsert.sentAsFormData === true) {
                        if (dbInsert && dbInsert.fileUploads && dbInsert.fileUploads.files) {
                            for (let field in dbInsert.fileUploads.files) {
                                if (dbInsert.fileUploads.files.hasOwnProperty(field) && dbInsert.fileUploads.files[field] && dbInsert.fileUploads.files[field]['active'] === true) {
                                    for (let i in dbInsert.fileUploads.files[field].files) {
                                        formData.append(field + '[]', dbInsert.fileUploads.files[field].files[i]);
                                        data[field] = null;
                                    }
                                    console.log('onModalFormSubmit2: formData: ', field, formData.getAll(field + '[]'));
                                }
                            }
                            formData.append('data', JSON.stringify(data));
                            formData.append('dbInsert', JSON.stringify(dbInsert));
                            formData.append('dbQuery', JSON.stringify(dbQuery));
                        }
                        postData = formData;
                        _this[formKey].uploadPercentage = null;
                        formConfig = {
                            headers: {
                                'content-type': 'multipart/form-data',
                            }
                        }
                        console.log('onModalFormSubmit2: ', JSON.parse(formData.getAll('data')), JSON.parse(formData.getAll('dbInsert')), JSON.parse(formData.getAll('dbQuery')));
                    } else {
                        postData = {
                            data    : data ? data : [],
                            dbInsert: dbInsert ? dbInsert : [],
                            dbQuery : dbQuery ? dbQuery : [],
                        }
                    }
                    axios({
                        method          : 'POST',
                        url             : url,
                        data            : postData,
                        config          : formConfig,
                        responseType    : 'json',
                        headers         : {
                            'Authorization': 'Bearer ' + localStorage.getItem('token'),
                        },
                        onUploadProgress: function (progressEvent) {
                            _this[formKey].uploadPercentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total));
                            console.log('percentCompleted: ', _this[formKey].uploadPercentage, progressEvent);
                            if (_this[formKey].uploadPercentage >= 100) {
                                _this[formKey].uploadPercentage = 'Done';
                            }
                        }
                    }).then(response => {
                        _this[formKey].isSubmitting = false;
                        console.log('response/data: ', url, response.data ? response.data : response);
                        if (response.data && response.data.status === 200) {
                            if (vuexKey && vuexKey.length > 0) {
                                let vuexPayload = {
                                    key  : vuexKey,
                                    data : response.data.data['dataAll'],
                                    data2: response.data.data['dataAll'],
                                }
                                _this.$store.dispatch('ADD_DATATABLE', vuexPayload);
                                // _this.$store.commit('ADD_DATATABLE', vuexPayload);
                            }
                            if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'edited' && response.data.data['notify']['title'] == 'Data Edited!') {
                                _this.$v[formKey].$reset();
                                _this.resetInputPhotos2('modalEdit', response.data.data['dataAll']);
                                _this[formKey].statusDiv.class = 'alert-json-success';
                                _this[formKey].statusDiv.messages.push(response.data.data['notify']['text']);
                                _this.$notify(response.data.data['notify']);
                            } else if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'edited' && response.data.data['notify']['title'] == 'Data Untouched!') {
                                _this.$v[formKey].$reset();
                                // _this.resetInputPhotos2('modalEdit', response.data.data['dataAll']);
                                _this[formKey].statusDiv.class = 'alert-json-success-no-change';
                                _this[formKey].statusDiv.messages.push(response.data.data['notify']['text']);
                            } else if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved' && response.data.data['notify']['title'] == 'Registration') {
                                _this.$v[formKey].$reset();
                                _this[formKey].statusDiv.class = 'alert-json-success';
                                _this[formKey].statusDiv.messages.push(response.data.data['notify']['text']);
                                _this.$notify(response.data.data['notify']);
                            } else if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved' && response.data.data['notify']['title'] == 'Login' && response.data.data['data'] && response.data.data['data']['token']) {
                                console.log('response/data: token: ', response.data.data['data']['token']);
                                _this.$v[formKey].$reset();
                                _this[formKey].statusDiv.class = 'alert-json-success';
                                _this[formKey].statusDiv.messages.push(response.data.data['notify']['text']);
                                _this.$notify(response.data.data['notify']);
                                // Redirect after login:
                                localStorage.setItem('user', JSON.stringify(response.data.data['data']));
                                localStorage.setItem('token', response.data.data['data']['token']);
                                _this.$store.dispatch('ADD_USER', response.data.data['data']);
                                _this.$store.dispatch('ADD_TOKEN', response.data.data['data']['token']);
                                _this.$router.push({
                                    name  : 'dashboard',
                                    params: []
                                });
                            } else if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved' && (response.data.data['notify']['title'] == 'Report Generated' || response.data.data['notify']['title'] == 'Report Not Generated')) {
                                _this[formKey].statusDiv.class = response.data.data['notify']['statusDivClass'];
                                _this[formKey].statusDiv.messages.push(response.data.data['notify']['text']);
                                _this.report = response.data.data['report'];
                                _this.page.headers = response.data.data['report']['headers'];
                                _this.page.print = response.data.data['report']['print'];
                                _this.$notify(response.data.data['notify']);
                            } else {
                                _this[formKey].statusDiv.class = 'alert-json-error';
                                _this[formKey].statusDiv.messages.push(response.data.data['notify']['text']);
                            }
                        } else {
                            _this[formKey].statusDiv.messages.push('Error, Data Not Found!');
                        }
                    }).catch(error => {
                        setTimeout(function () {
                            _this[formKey].isSubmitting = false;
                            //console.log('ACC: error: ', error);
                            //errors.push("Failed to perform operation");
                            if (error.response && error.response.data && error.response.data.message) {
                                console.log('catch-error: response: ', error.response);
                                if (typeof error.response.data.message == 'string') {
                                    _this[formKey].statusDiv.messages.push(error.response.data.message);
                                } else if (typeof error.response.data.message == 'object') {
                                    for (let prop in error.response.data.message) {
                                        if (error.response.data.message.hasOwnProperty(prop)) {
                                            _this[formKey].statusDiv.messages.push(error.response.data.message[prop]);
                                        }
                                    }
                                }
                            }
                            if (error.response) {
                                console.log('error.response: ', error.response);
                                _this[formKey].statusDiv.messages.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                                _this[formKey].statusDiv.messages.push(error.response.data && error.response.data.exception ? error.response.data.exception : 'exception not found');
                            } else if (error.request) {
                                console.log('error.request: ', error.request);
                                _this[formKey].statusDiv.messages.push(error.request);
                            } else {
                                console.log('error.else: ', error.message ? error.message : error);
                                _this[formKey].statusDiv.messages.push(error.message ? error.message : 'error.message not found');
                            }
                        }, 700);
                    });
                }
            } catch (err) {
                console.log('catch-err: ', err);
                setTimeout(function () {
                    _this[formKey].isSubmitting = false;
                    _this[formKey].statusDiv.class = 'alert-json-error';
                    _this[formKey].statusDiv.messages = [];
                    _this[formKey].statusDiv.messages.push(err.message ? err.message : err);
                }, 700);
            }
        },
        onModalFormSubmit3(url, data, message) {
            let _this = this;
            try {
                axios({
                    method      : 'POST',
                    url         : url,
                    data        : data ? data : [],
                    responseType: 'json',
                    headers     : {
                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    },
                }).then(response => {
                    console.log('response/data: ', url, response.data ? response.data : response);
                    if (response.data && response.data.status === 200) {
                        console.log('response/data: ', response.data.data);
                        if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved') {
                            localStorage.removeItem('user');
                            localStorage.removeItem('token');
                            _this.$store.dispatch('DELETE_USER', null);
                            _this.$store.dispatch('DELETE_TOKEN', null);
                            console.log('localStorage: ', localStorage.getItem('user'), localStorage.getItem('token'));
                            response.data.data['notify']['message'] = message;
                            _this.$router.push({
                                name  : 'login',
                                params: response.data.data['notify']
                            });
                        } else {
                            let notifyData = {
                                'group': 'edited',
                                'type' : 'warn',
                                'title': 'Request Failed!',
                                'text' : response.data.data['notify']
                            };
                            _this.$notify(notifyData);
                        }
                    } else {
                        let notifyData = {
                            'group': 'edited',
                            'type' : 'warn',
                            'title': 'Request Failed!',
                            'text' : response.data.data['notify']
                        };
                        _this.$notify(notifyData);
                    }
                }).catch(error => {
                    setTimeout(function () {
                        //console.log('ACC: error: ', error);
                        //errors.push("Failed to perform operation");
                        let errorMessage = [];
                        if (error.response && error.response.data && error.response.data.message) {
                            console.log('catch-error: response: ', error.response);
                            if (typeof error.response.data.message == 'string') {
                                let notifyData = {
                                    'group': 'edited',
                                    'type' : 'warn',
                                    'title': 'Request Failed!',
                                    'text' : error.response.data.message
                                };
                                _this.$notify(notifyData);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errorMessage.push(error.response.data.message[prop]);
                                    }
                                }
                                let notifyData = {
                                    'group': 'edited',
                                    'type' : 'warn',
                                    'title': 'Request Failed!',
                                    'text' : errorMessage
                                };
                                _this.$notify(notifyData);
                            }
                        }
                        if (error.response) {
                            console.log('error.response: ', error.response);
                            let notifyData = {
                                'group': 'edited',
                                'type' : 'warn',
                                'title': 'Request Failed!',
                                'text' : error.response.statusText ? error.response.statusText : 'statusText not found'
                            };
                            _this.$notify(notifyData);
                            // _this.modalEdit.statusDiv.messages.push(error.response.data && error.response.data.exception ? error.response.data.exception : 'exception not found');

                        } else if (error.request) {
                            console.log('error.request: ', error.request);
                            let notifyData = {
                                'group': 'edited',
                                'type' : 'warn',
                                'title': 'Request Failed!',
                                'text' : error.request
                            };
                            _this.$notify(notifyData);
                        } else {
                            console.log('error.else: ', error.message ? error.message : error);
                            let notifyData = {
                                'group': 'edited',
                                'type' : 'warn',
                                'title': 'Request Failed!',
                                'text' : error.message ? error.message : 'error.message not found'
                            };
                            _this.$notify(notifyData);
                        }
                    }, 700);
                });
            } catch (err) {
                console.log('catch-err: ', err);
                setTimeout(function () {
                    let notifyData = {
                        'group': 'edited',
                        'type' : 'warn',
                        'title': 'Request Failed!',
                        'text' : err.message ? err.message : err
                    };
                    _this.$notify(notifyData);
                }, 700);
            }
        },
        onRemovePageItem(url, dbDestroy, dbQuery, itemId, vuexKey) {
            console.log('onRemovePageItem: ', url, dbDestroy, dbQuery, itemId, vuexKey);
            this.$modal.show('dialog', {
                title  : 'Warning!',
                text   : 'Are you sure you want to delete item id: <b>' + itemId + '</b> ?',
                buttons: [
                    {
                        title  : 'Yes',
                        handler: () => {
                            this.$modal.hide('dialog');
                            let _this = this;
                            try {
                                _this.modalDelete.isSubmitting = true;
                                _this.modalDelete.statusDiv.class = 'alert-json-error';
                                _this.modalDelete.statusDiv.messages = [];
                                axios({
                                    method      : 'patch',
                                    url         : url,
                                    data        : {
                                        data     : {id: itemId},
                                        dbQuery  : dbQuery ? dbQuery : [],
                                        dbDestroy: dbDestroy ? dbDestroy : [],
                                    },
                                    responseType: 'json',
                                    headers     : {
                                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                                    },
                                }).then(response => {
                                    _this.modalDelete.isSubmitting = false;
                                    console.log('response/data: ', url, response.data ? response.data : response);
                                    if (response.data && response.data.status === 200) {
                                        if (vuexKey && vuexKey.length > 0) {
                                            let vuexPayload = {
                                                key  : vuexKey,
                                                data : response.data.data['dataAll'],
                                                data2: response.data.data['dataAll'],
                                            }
                                            this.$store.dispatch('ADD_DATATABLE', vuexPayload);
                                            // _this.$store.commit('ADD_DATATABLE', vuexPayload);
                                        }
                                        if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'deleted') {
                                            _this.modalDelete.statusDiv.class = 'alert-json-success';
                                            _this.modalDelete.statusDiv.messages.push(response.data.data['notify']['text']);
                                            this.$notify(response.data.data['notify']);
                                        } else {
                                            _this.modalDelete.statusDiv.messages.push(response.data.data['notify']['text']);
                                        }
                                    } else {
                                        _this.modalDelete.statusDiv.messages.push('Error, Data Not Found!');
                                    }
                                }).catch(error => {
                                    setTimeout(function () {
                                        _this.modalDelete.isSubmitting = false;
                                        //console.log('ACC: error: ', error);
                                        //errors.push("Failed to perform operation");
                                        if (error.response) {
                                            console.log('error.response: ', error.response);
                                            _this.modalDelete.statusDiv.messages.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                                            _this.modalDelete.statusDiv.messages.push(error.response.data && error.response.data.exception ? error.response.data.exception : 'exception not found');
                                        } else if (error.request) {
                                            console.log('error.request: ', error.request);
                                            _this.modalDelete.statusDiv.messages.push(error.request);
                                        } else {
                                            console.log('error.else: ', error.message ? error.message : error);
                                            _this.modalDelete.statusDiv.messages.push(error.message ? error.message : 'error.message not found');
                                        }
                                        if (error.response && error.response.data && error.response.data.message) {
                                            if (typeof error.response.data.message == 'string') {
                                                _this.modalDelete.statusDiv.messages.push(error.response.data.message);
                                            } else if (typeof error.response.data.message == 'object') {
                                                for (let prop in error.response.data.message) {
                                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                                        _this.modalDelete.statusDiv.messages.push(error.response.data.message[prop]);
                                                    }
                                                }
                                            }
                                        }
                                    }, 700);
                                });
                            } catch (err) {
                                console.log('catch-err: ', err);
                                setTimeout(function () {
                                    _this.modalDelete.isSubmitting = false;
                                    _this.modalDelete.statusDiv.class = 'alert-json-error';
                                    _this.modalDelete.statusDiv.messages = [];
                                    _this.modalDelete.statusDiv.messages.push(err.message ? err.message : err);
                                }, 700);
                            }
                        }
                    },
                    {
                        title  : 'No',
                        default: true,
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    },
                ]
            })
        }, //
        onRemovePageItem2(url, dbDestroy, dbQuery, index, itemId, action = false) {
            if (action) {
                try {
                    console.log('onRemovePageItem2: ', url, dbDestroy, dbQuery, itemId, index, this.listDisplay[index]);
                    axios({
                        method      : 'patch',
                        url         : url,
                        data        : {
                            data     : {id: itemId},
                            dbQuery  : dbQuery ? dbQuery : [],
                            dbDestroy: dbDestroy ? dbDestroy : [],
                        },
                        responseType: 'json',
                        headers     : {
                            'Authorization': 'Bearer ' + localStorage.getItem('token'),
                        },
                    }).then(response => {
                        console.log('response/data: ', url, response.data ? response.data : response);
                        if (response.data && response.data.status === 200) {
                            //this.listDisplay.splice(index, 1);
                            this.listDisplay = response.data.data['data'];
                            this.listDisplay2 = response.data.data['data'];
                            this.listForm.reset();
                            this.$v.$reset();
                            this.resetDatepickers();
                            this.resetOption();
                            /*if (this.pageForm.listItems) {
                                this.pageForm.listItems = [];
                            }*/
                            this.$notify(response.data.data['notify']);
                        } else {
                            this.vueDialogShow('Error!', 'Data Not Found!');
                        }
                    }).catch(error => {
                        //console.log('ACC: error: ', error);
                        let errors = [];
                        let errorDisplay = '';
                        //errors.push("Failed to perform operation");
                        if (error.response) {
                            console.log('error.response: ', error.response);
                            errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                        } else if (error.request) {
                            console.log('error.request: ', error.request);
                            errors.push(error.request);
                        } else {
                            console.log('error.else: ', error.message ? error.message : error);
                            errors.push(error.message ? error.message : 'error.message not found');
                        }
                        if (error.response && error.response.data && error.response.data.message) {
                            if (typeof error.response.data.message == 'string') {
                                errors.push(error.response.data.message);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errors.push(error.response.data.message[prop]);
                                    }
                                }
                            }
                        }
                        errors.forEach((val) => {
                            errorDisplay += val + '<br>';
                        });
                        this.vueDialogShow('Error!', errorDisplay);
                    });
                } catch (err) {
                    console.log('catch-err: ', err);
                    this.vueDialogShow('Error!', err.message ? err.message : err);
                }
            } else {
                this.$modal.show('dialog', {
                    title  : 'Warning!',
                    text   : 'Are you sure you want to delete item id: <b><u>' + itemId + '</u></b> ?',
                    buttons: [
                        {
                            title  : 'Yes',
                            handler: () => {
                                this.onRemovePageItem2(url, dbDestroy, dbQuery, index, itemId, true);
                                this.$modal.hide('dialog');
                            }
                        },
                        {
                            title  : 'No',
                            default: true,
                            handler: () => {
                                this.$modal.hide('dialog')
                            }
                        },
                    ]
                })
            }
        },

        onNewListItemFormSubmit(url, data, dbInsert, dbQuery) {
            try {
                this.isSubmitting = true;
                for (let field in dbInsert.unique) {
                    dbInsert.validations[field] = dbInsert.validations[field] + dbInsert.unique[field] + data.id;
                }
                console.log('onNewListItemFormSubmit: ', url, data, dbInsert, dbQuery);
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.isSubmitting = false;
                    this.vueDialogShow('Error!', 'Form is Invalid! Please Check Inputs!');
                } else {
                    axios({
                        method      : 'POST',
                        url         : url,
                        data        : {
                            data    : data ? data : [],
                            dbInsert: dbInsert ? dbInsert : [],
                            dbQuery : dbQuery ? dbQuery : [],
                        },
                        responseType: 'json'
                    }).then(response => {
                        this.isSubmitting = false;
                        console.log('response/data: ', url, response.data ? response.data : response);
                        if (response.data && response.data.status === 200) {
                            //this.listDisplay.unshift(response.data.data);
                            //this.listDisplay[0] = response.data.data;
                            this.listDisplay = response.data.data['data'];
                            this.listDisplay2 = response.data.data['data'];
                            if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved') {
                                this.listForm.reset();
                                this.$v.$reset();
                                this.resetDatepickers();
                                if (this.resetOptions) {
                                    this.option = this.resetOptions.option;
                                    this.optionSub = this.resetOptions.optionSub;
                                } else {
                                    this.resetOption();
                                }
                                if (this.pageForm.listItems) {
                                    this.pageForm.listItems = [];
                                }
                            }
                            this.$notify(response.data.data['notify']);
                        } else {
                            this.vueDialogShow('Error!', 'Data Not Found!');
                        }
                    }).catch(error => {
                        this.isSubmitting = false;
                        //console.log('ACC: error: ', error);
                        let errors = [];
                        let errorDisplay = '';
                        //errors.push("Failed to perform operation");
                        if (error.response) {
                            console.log('error.response: ', error.response);
                            errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                        } else if (error.request) {
                            console.log('error.request: ', error.request);
                            errors.push(error.request);
                        } else {
                            console.log('error.else: ', error.message ? error.message : error);
                            errors.push(error.message ? error.message : 'error.message not found');
                        }
                        if (error.response && error.response.data && error.response.data.message) {
                            if (typeof error.response.data.message == 'string') {
                                errors.push(error.response.data.message);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errors.push(error.response.data.message[prop]);
                                    }
                                }
                            }
                        }
                        errors.forEach((val) => {
                            errorDisplay += val + '<br>';
                        });
                        this.vueDialogShow('Error!', errorDisplay);
                    });
                }
            } catch (err) {
                this.isSubmitting = false;
                console.log('catch-err: ', err);
                this.vueDialogShow('Error!', err.message ? err.message : err);
            }
        },
        onRemoveListItem(url, dbDestroy, dbQuery, index, itemId, action = false) {
            if (action) {
                try {
                    console.log('onRemoveListItem: ', url, dbDestroy, dbQuery, itemId, index, this.listDisplay[index]);
                    axios({
                        method      : 'patch',
                        url         : url,
                        data        : {
                            data     : {id: itemId},
                            dbQuery  : dbQuery ? dbQuery : [],
                            dbDestroy: dbDestroy ? dbDestroy : [],
                        },
                        responseType: 'json'
                    }).then(response => {
                        console.log('response/data: ', url, response.data ? response.data : response);
                        if (response.data && response.data.status === 200) {
                            //this.listDisplay.splice(index, 1);
                            this.listDisplay = response.data.data['data'];
                            this.listDisplay2 = response.data.data['data'];
                            this.listForm.reset();
                            this.$v.$reset();
                            this.resetDatepickers();
                            if (this.resetOptions) {
                                this.option = this.resetOptions.option;
                                this.optionSub = this.resetOptions.optionSub;
                            } else {
                                this.resetOption();
                            }
                            if (this.pageForm.listItems) {
                                this.pageForm.listItems = [];
                            }
                            this.$notify(response.data.data['notify']);
                        } else {
                            this.vueDialogShow('Error!', 'Data Not Found!');
                        }
                    }).catch(error => {
                        //console.log('ACC: error: ', error);
                        let errors = [];
                        let errorDisplay = '';
                        //errors.push("Failed to perform operation");
                        if (error.response) {
                            console.log('error.response: ', error.response);
                            errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                        } else if (error.request) {
                            console.log('error.request: ', error.request);
                            errors.push(error.request);
                        } else {
                            console.log('error.else: ', error.message ? error.message : error);
                            errors.push(error.message ? error.message : 'error.message not found');
                        }
                        if (error.response && error.response.data && error.response.data.message) {
                            if (typeof error.response.data.message == 'string') {
                                errors.push(error.response.data.message);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errors.push(error.response.data.message[prop]);
                                    }
                                }
                            }
                        }
                        errors.forEach((val) => {
                            errorDisplay += val + '<br>';
                        });
                        this.vueDialogShow('Error!', errorDisplay);
                    });
                } catch (err) {
                    console.log('catch-err: ', err);
                    this.vueDialogShow('Error!', err.message ? err.message : err);
                }
            } else {
                this.$modal.show('dialog', {
                    title  : 'Warning!',
                    text   : 'Are you sure you want to delete item id: <b><u>' + itemId + '</u></b> ?',
                    buttons: [
                        {
                            title  : 'Yes',
                            handler: () => {
                                this.onRemoveListItem(url, dbDestroy, dbQuery, index, itemId, true);
                                this.$modal.hide('dialog');
                            }
                        },
                        {
                            title  : 'No',
                            default: true,
                            handler: () => {
                                this.$modal.hide('dialog')
                            }
                        },
                    ]
                })
            }
        },
        onRemoveListItems(url, dbDestroy, dbQuery, listDisplay) {
            console.log('onRemoveListItems: ', url, dbDestroy, dbQuery, listDisplay);
            if (this.listDisplay.some(e => e.selected === true)) {
                this.$modal.show('dialog', {
                    title  : 'Warning!',
                    text   : 'Are you sure you want to delete the selected item(s)?',
                    buttons: [
                        {
                            title  : 'Yes',
                            handler: () => {
                                this.$modal.hide('dialog');
                                try {
                                    axios({
                                        method      : 'patch',
                                        url         : url,
                                        data        : {
                                            data     : listDisplay ? listDisplay : [],
                                            dbQuery  : dbQuery ? dbQuery : [],
                                            dbDestroy: dbDestroy ? dbDestroy : [],
                                        },
                                        responseType: 'json'
                                    }).then(response => {
                                        console.log('response/data: ', url, response.data ? response.data : response);
                                        if (response.data && response.data.status === 200) {
                                            this.listDisplay = response.data.data['data'];
                                            this.listDisplay2 = response.data.data['data'];
                                            this.vueListItemsCheckboxAll = null;
                                            this.$notify(response.data.data['notify']);
                                        } else {
                                            this.vueDialogShow('Error!', 'Data Not Found!');
                                        }
                                    }).catch(error => {
                                        //console.log('ACC: error: ', error);
                                        let errors = [];
                                        let errorDisplay = '';
                                        //errors.push("Failed to perform operation");
                                        if (error.response) {
                                            console.log('error.response: ', error.response);
                                            errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                                        } else if (error.request) {
                                            console.log('error.request: ', error.request);
                                            errors.push(error.request);
                                        } else {
                                            console.log('error.else: ', error.message ? error.message : error);
                                            errors.push(error.message ? error.message : 'error.message not found');
                                        }
                                        if (error.response && error.response.data && error.response.data.message) {
                                            if (typeof error.response.data.message == 'string') {
                                                errors.push(error.response.data.message);
                                            } else if (typeof error.response.data.message == 'object') {
                                                for (let prop in error.response.data.message) {
                                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                                        errors.push(error.response.data.message[prop]);
                                                    }
                                                }
                                            }
                                        }
                                        errors.forEach((val) => {
                                            errorDisplay += val + '<br>';
                                        });
                                        this.vueDialogShow('Error!', errorDisplay);
                                    });
                                } catch (err) {
                                    console.log('catch-err: ', err);
                                    this.vueDialogShow('Error!', err.message ? err.message : err);
                                }
                            }
                        },
                        {
                            title  : 'No',
                            default: true,
                            handler: () => {
                                this.$modal.hide('dialog')
                            }
                        },
                    ]
                })
            } else {
                this.vueDialogShow('Alert!', 'Please select item before deleting!');
            }
        },

        moveTo() {
            let to = this.moveToDown
                ? this.$refs.description.offsetTop - 60
                : 0

            window.scroll({
                top     : to,
                left    : 0,
                behavior: 'smooth'
            })

            this.moveToDown = !this.moveToDown
        },

        pageItemSelected(data, formKey) {
            if (this.option && this.options) {
                for (let property in this.option[formKey]) {
                    if (property && property.length > 0 && this.countObjectProp(this.options[property]) > 0) {
                        //console.log('pageItemSelected SELECT: ', property, data[property], this.option[formKey],this.options[property]);
                        if (typeof data[property] === 'object') {
                            this.option[formKey][property] = data[property];
                        } else {
                            this.option[formKey][property] = this.options[property].find(x => x.id === data[property]);
                        }
                    }
                }
            }
            for (let field in this.dataForm) {
                if (this[formKey].form.hasOwnProperty(field)) {
                    console.log('pageItemSelected: ', formKey, field, ' : ', data[field]);
                    if (this[formKey].inputs[field] && (this[formKey].inputs[field]['type'] === 'file' && this[formKey].inputs[field]['inputType'] === 'image') && data[field] && data[field].length > 0) {
                        // this[formKey].form[field]                        = new File([""], this[formKey].inputs[field]['image']['imageServer'] + data[field], {type : 'image/jpeg'});
                        this[formKey].form[field] = data[field];
                        this[formKey].inputs[field]['image']['imageSrc'] = this[formKey].inputs[field]['image']['imageServer'] + data[field];
                    } else {
                        this[formKey].form[field] = data[field];
                    }
                    /*if (this[formKey].inputs[field] && (this[formKey].inputs[field]['type'] === 'text' || this[formKey].inputs[field]['type'] === 'email' || this[formKey].inputs[field]['type'] === 'select' || this[formKey].inputs[field]['type'] === 'number' || this[formKey].inputs[field]['type'] === 'dateTime')) {
                        this[formKey].form[field] = data[field];
                    } else if (this[formKey].inputs[field] && (this[formKey].inputs[field]['type'] === 'file' && this[formKey].inputs[field]['inputType'] === 'image')) {
                    }*/
                }
            }
            console.log('pageItemSelected: ', formKey, this[formKey].form);
        },

        ICLListFormId   : (function (data) {
            this.listForm.id = null;
            console.log('ICLListFormId: ', data.target, this.listForm);
        }),
        /*setPageFormDataWithParams(routeParams) {
            if (routeParams && this.countObjectProp(routeParams) > 0) {
                this.pageForm.setData(routeParams);
                console.log('setPageFormDataWithParams: ', routeParams, this.countObjectProp(routeParams), this.pageForm);
            }
        },*/
        setPageFormDataOptionsWithParams(routeParams) {
            if (routeParams && this.countObjectProp(routeParams) > 0) {
                if (this.option && this.options) {
                    for (let property in this.option.modalEdit) {
                        if (property && property.length > 0 && this.countObjectProp(this.options[property]) > 0) {
                            console.log('setPageFormDataOptionsWithParams: ', property, property.length, typeof routeParams[property], this.options[property]);
                            if (typeof routeParams[property] === 'object') {
                                this.option.modalEdit[property] = routeParams[property];
                            } else {
                                this.option.modalEdit[property] = this.options[property].find(x => x.id === routeParams[property]);
                            }
                        }
                    }
                }
                console.log('setPageFormDataOptionsWithParams: ', routeParams, this.countObjectProp(routeParams), this.option.modalEdit);
            }
        },
        newPageForm() {
            /*if (this.vuePageForm.hasData()) {
                this.promptForPageFormReset('Warning!', 'Are you sure you want to reset the form?');
            } else {
                this.vuePageForm.reset();
                this.$v.$reset();
                this.resetOption();
                this.resetDatepickers();
                if (this.pageForm.listItems) {
                    this.pageForm.listItems = [];
                }
            }
            console.log('newPageFormItem: ', this.vuePageForm);*/
        },
        inputCBListAllListener2(vueListItemsCheckboxAll) {
            console.log('inputCBListAllListener: ', vueListItemsCheckboxAll, this.listDisplay);
            if (vueListItemsCheckboxAll) {
                for (let i = 0; i < this.listDisplay.length; i++) {
                    this.listDisplay[i]['selected'] = false;
                }
            } else {
                for (let i = 0; i < this.listDisplay.length; i++) {
                    this.listDisplay[i]['selected'] = true;
                }
            }
        },
        ICLVueListFormId: (function (data) {
            this.vueListForm.id = null;
            console.log('ICLVueListFormId: ', data.target, this.vueListForm);
        }),
        multiselectInputMixin(value, id) {
            console.log('multiselectInputForm: ', value, id);
            switch (id) {
                case 'doc_date_range':
                    let date = new Date(),
                        y    = date.getFullYear(),
                        m    = date.getMonth();
                    switch (value.name) {
                        case 'Today':
                            this.datepickers.doc_date_from = new Date().toISOString().substr(0, 10);
                            this.datepickers.doc_date_to = new Date().toISOString().substr(0, 10);
                            break;
                        case 'Current Week':
                            let firstDayofWeek = new Date(date.setDate(date.getDate() - date.getDay())).toUTCString();
                            let lastDayofWeek = new Date(date.setDate(date.getDate() - date.getDay() + 6)).toUTCString();
                            this.datepickers.doc_date_from = firstDayofWeek;
                            this.datepickers.doc_date_to = lastDayofWeek;
                            break;
                        case 'Current Month':
                            let firstDayofMonth = new Date(y, m, 1);
                            let lastDayofMonth = new Date(y, m + 1, 0);
                            this.datepickers.doc_date_from = firstDayofMonth;
                            this.datepickers.doc_date_to = lastDayofMonth;
                            break;
                        case 'Last Month':
                            let firstDayofLastMonth = new Date(y, m - 1, 1);
                            let lastDayofLastMonth = new Date(y, m, 0);
                            this.datepickers.doc_date_from = firstDayofLastMonth;
                            this.datepickers.doc_date_to = lastDayofLastMonth;
                            break;
                        case 'Last 3 Months':
                            let firstDayofLast3Month = new Date(y, m - 3, 1);
                            let lastDayofLast3Month = new Date(y, m, 0);
                            this.datepickers.doc_date_from = firstDayofLast3Month;
                            this.datepickers.doc_date_to = lastDayofLast3Month;
                            break;
                        case 'Last 6 Months':
                            let firstDayofLast6Month = new Date(y, m - 6, 1);
                            let lastDayofLast6Month = new Date(y, m, 0);
                            this.datepickers.doc_date_from = firstDayofLast6Month;
                            this.datepickers.doc_date_to = lastDayofLast6Month;
                            break;
                        case 'Last 12 Months':
                            let firstDayofLast12Month = new Date(y, m - 12, 1);
                            let lastDayofLast12Month = new Date(y, m, 0);
                            this.datepickers.doc_date_from = firstDayofLast12Month;
                            this.datepickers.doc_date_to = lastDayofLast12Month;
                            break;
                        case 'Custom':
                            break;
                    }
                    break;
                    s
            }
        },
        resetOption() {
            if (this.option) {
                //console.log('resetOption: ', this.option ? this.option : '', this.option ? this.option.length : '');
                for (let field in this.option.modalAdd) {
                    this.option.modalAdd[field] = {};
                }
            }
            if (this.optionSub) {
                //console.log('resetOptionSub: ', this.optionSub ? this.optionSub : '', this.optionSub ? this.optionSub.length
                // : '');
                for (let field in this.optionSub) {
                    this.optionSub.modalAdd[field] = {};
                }
            }
        },
        resetInputPhotos(param) {
            if (this[param] && this[param]['inputs']) {
                for (let field in this[param]['inputs']) {
                    if (this[param]['inputs'].hasOwnProperty(field)) {
                        if (this[param]['inputs'][field]['inputType'] == 'image' && this[param]['inputs'][field]['image'] && this[param]['inputs'][field]['image']['onChange'] && this[param]['inputs'][field]['image']['clearButton'] && this[param]['inputs'][field]['image']['clearButton']['props']) {
                            this[param]['uploadPercentage'] = null;
                            this[param]['inputs'][field]['image']['imageSrc'] = null;
                            this[param].dbInsert.fileUploads.files[this[param]['inputs'][field].formControlName]['files'] = []; // clear form data object         = null;
                            // this[clearButtonParams[0]][clearButtonParams[1]][clearButtonParams[2]] = null;
                        }
                    }
                }
            }
        },
        resetInputPhotos2(param, data) {
            if (this[param] && this[param]['inputs']) {
                for (let field in this[param]['inputs']) {
                    if (this[param]['inputs'].hasOwnProperty(field)) {
                        if (this[param]['inputs'][field]['inputType'] == 'image' && this[param]['inputs'][field]['image'] && this[param]['inputs'][field]['image']['onChange'] && this[param]['inputs'][field]['image']['clearButton'] && this[param]['inputs'][field]['image']['clearButton']['props']) {
                            this[param]['uploadPercentage'] = null;
                            this[param].form[field] = data[field];
                            this[param].dbInsert.fileUploads.files[this[param]['inputs'][field].formControlName]['files'] = [];
                        }
                    }
                }
            }
            /*for (let field in this.dataForm) {
                if (this.modalEdit.form.hasOwnProperty(field)) {
                    console.log('modalEdit.form: ', field, ' : ', data[field]);
                    if (this.modalEdit.inputs[field] && (this.modalEdit.inputs[field]['type'] === 'file' && this.modalEdit.inputs[field]['inputType'] === 'image') && data[field] && data[field].length > 0) {
                        this.modalEdit.form[field] = data[field];
                    }
                }
            }*/
        },
        inputCBListAllListener() {
            console.log('inputCBListAllListener: ', this.vueListItemsCheckboxAll, this.listDisplay);
            if (this.vueListItemsCheckboxAll) {
                for (let i = 0; i < this.listDisplay.length; i++) {
                    this.listDisplay[i]['selected'] = false;
                }
            } else {
                for (let i = 0; i < this.listDisplay.length; i++) {
                    this.listDisplay[i]['selected'] = true;
                }
            }
        },
        loadFormInputData() {
            try {
                axios.get(this.loadFormInputDataUrl).then(response => {
                    console.log('ACC: options: ', this.loadFormInputDataUrl, this.options, response.data ? response.data : response, response.data && response.data.data ? response.data.data : response);
                    if (response.data && response.data.data) {
                        this.options = response.data.data;
                    } else {
                        this.vueDialogShow('Error!', 'Form Input Data Load Failed!');
                    }
                }).catch(error => {
                    console.error('ACC: options: ', this.loadFormInputDataUrl, error);
                });
            } catch (err) {
                console.log('err: ', err);
            }
        },
        loadFormInputDataWithParams(routeParams) {
            try {
                axios.get(this.loadFormInputDataUrl).then(response => {
                    console.log('ACC: options: ', this.loadFormInputDataUrl, this.options, response.data ? response.data : response, response.data && response.data.data ? response.data.data : response);
                    if (response.data && response.data.data) {
                        this.options = response.data.data;
                        this.setFormPageDataOptionsWithParams(routeParams);
                    } else {
                        this.vueDialogShow('Error!', 'Form Input Data Load Failed!');
                    }
                }).catch(error => {
                    console.error('ACC: options: ', this.loadFormInputDataUrl, error);
                });
            } catch (err) {
                console.log('err: ', err);
            }
        },
        loadListFormInputData() {
            try {
                axios.get(this.loadListFormInputDataUrl).then(response => {
                    console.log('ACC: options: ', this.loadListFormInputDataUrl, this.options, response.data ? response.data : response, response.data && response.data.data ? response.data.data : response);
                    if (response.data && response.data.data) {
                        this.options = response.data.data;
                    } else {
                        this.vueDialogShow('Error!', 'Form Input Data Load Failed!');
                    }
                }).catch(error => {
                    console.error('ACC: options: ', this.loadListFormInputDataUrl, error);
                });
            } catch (err) {
                console.log('err: ', err);
            }
        },
        loadPageFormData(url, loadFormDataQuery) {
            try {
                console.log('ACC: loadPageFormData: ', url, loadFormDataQuery);
                axios({
                    method      : 'POST',
                    url         : url,
                    data        : {
                        loadFormDataQuery: loadFormDataQuery
                    },
                    responseType: 'json'
                }).then(response => {
                    if (response.data && response.data.data) {
                        // this.vuePageForm.setData(response.data.data);
                        if (this.option && this.options) {
                            for (let property in this.option) {
                                if (property && property.length > 0 && this.countObjectProp(this.options[property]) > 0) {
                                    console.log('property: ', property, property.length, this.option[property], this.options[property]);
                                    this.option[property] = this.options[property].find(x => x.id === response.data.data[property]);
                                }
                            }
                        }
                        console.log('created: setFormPageDataOptionsWithParams: ', response.data.data, this.countObjectProp(response.data.data), this.option, this.options);
                    } else {
                        this.vueDialogShow('Error!', 'Data Loading Failed!');
                    }
                    console.log('then: loadPageFormData: ', url, loadFormDataQuery, response.data.data);
                }).catch(error => {
                    this.vueDialogShow('Error!', 'Data Loading Failed!');
                    console.error('catch: loadPageFormData: ', url, loadFormDataQuery, error.response);
                });
            } catch (err) {
                console.log('err: loadPageFormData: ', err);
                this.vueDialogShow('Error!', url, loadFormDataQuery, err.message ? err.message : err);
            }
        },
        loadListData(orderBy, direction) {
            if (orderBy) {
                this.listDisplayQuery.orderBy = orderBy;
            }
            if (direction) {
                this.listDisplayQuery.direction == direction ? this.listDisplayQuery.direction = 'desc' : this.listDisplayQuery.direction = 'asc';
            }
            try {
                axios({
                    method      : 'POST',
                    url         : this.listDisplayUrl,
                    data        : {
                        listDisplayQuery: this.listDisplayQuery
                    },
                    responseType: 'json'
                }).then(response => {
                    if (response.data && response.data.data) {
                        this.listDisplay = response.data.data;
                        this.listDisplay2 = response.data.data;
                    } else {
                        this.vueDialogShow('Error!', 'Data Loading Failed!');
                    }
                    console.log('ACC: loadListData: ', this.listDisplayUrl, this.listDisplay, response.data.data);
                }).catch(error => {
                    this.vueDialogShow('Error!', 'Data Loading Failed!');
                    console.error('ACC: loadListData: ', this.listDisplayUrl, error.response);
                });
            } catch (err) {
                console.log('err: ', err);
                this.vueDialogShow('Error!', this.listDisplayUrl, err.message ? err.message : err);
            }
        },
        loadListDataWithInputs() {
            try {
                axios({
                    method      : 'POST',
                    url         : this.listWithInputsDisplayUrl,
                    data        : {
                        listDisplayQuery: this.listDisplayQuery
                    },
                    responseType: 'json'
                }).then(response => {
                    if (response.data && response.data.data) {
                        this.listDisplay = response.data.data;
                        this.listDisplay2 = response.data.data;
                        this.$notify({
                            'group': 'info',
                            'type' : 'info',
                            'title': 'Data Loaded!',
                            'text' : 'List data loaded with your query.'
                        });
                    } else {
                        this.vueDialogShow('Error!', 'Data Loading Failed!');
                    }
                    console.log('ACC: loadListData: ', this.listWithInputsDisplayUrl, this.countObjectProp(this.listDisplay), this.listDisplay, response.data.data);
                }).catch(error => {
                    this.vueDialogShow('Error!', 'Data Loading Failed!');
                    console.error('ACC: loadListData: ', this.listWithInputsDisplayUrl, error.response);
                });
            } catch (err) {
                console.log('err: ', err);
                this.vueDialogShow('Error!', this.listWithInputsDisplayUrl, err.message ? err.message : err);
            }
        },
        toRoute(url) {
            console.log('toRoute: ', url);
            this.$router.push({
                name  : url,
                params: ''
            });
        },
        listItemSelectedToRoute(item) {
            console.log('listItemSelected: ', item);
            this.$router.push({
                name  : this.listItemSelectedRouteName,
                params: item
            });
        },
        setFormPageDataOptionsWithParams(routeParams) {
            if (routeParams && this.countObjectProp(routeParams) > 0) {
                if (this.option && this.options) {
                    for (let property in this.option) {
                        if (property && property.length > 0 && this.option[property] && this.options[property] && this.countObjectProp(this.options[property]) > 0) {
                            //console.log('created: ', property, property.length, this.option[property], this.options[property]);
                            this.option[property] = this.options[property].find(x => x.id === routeParams[property]);
                        }
                    }
                }
                console.log('created: setFormPageDataOptionsWithParams: ', routeParams, this.countObjectProp(routeParams), this.option, this.options);
            }
        },
        onNewListItemInsertFormSubmit() {
            try {
                this.isSubmitting = true;
                console.log('ACC: onNewListItemInsertFormSubmit: ', this.vueListForm.data());
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.isSubmitting = false;
                    this.vueDialogShow('Error!', 'Form is Invalid! Please Check Inputs!');
                    console.log('ACC: onNewListItemInsertFormSubmit: ', this.vueListForm.data());
                } else {
                    axios({
                        method      : 'POST',
                        url         : this.listItemInsertUrl,
                        data        : {
                            data            : this.vueListForm.data(),
                            listDisplayQuery: this.listDisplayQuery
                        },
                        responseType: 'json'
                    }).then(response => {
                        this.isSubmitting = false;
                        console.log('ACC: response/data: ', this.listItemInsertUrl, response.data ? response.data : response);
                        if (response.data && response.data.data) {
                            //this.listDisplay.unshift(response.data.data);
                            //this.listDisplay[0] = response.data.data;
                            this.listDisplay = response.data.data['data'];
                            this.listDisplay2 = response.data.data['data'];
                            if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved') {
                                this.vueListForm.reset();
                                this.$v.$reset();
                                this.resetOption();
                                this.resetDatepickers();
                            }
                            this.$notify(response.data.data['notify']);
                        } else {
                            this.vueDialogShow('Error!', 'Data Not Found!');
                        }
                    }).catch(error => {
                        this.isSubmitting = false;
                        //console.log('ACC: error: ', error);
                        let errors = [];
                        let errorDisplay = '';
                        //errors.push("Failed to perform operation");
                        if (error.response) {
                            console.log('error.response: ', error.response);
                            errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                        } else if (error.request) {
                            console.log('error.request: ', error.request);
                            errors.push(error.request);
                        } else {
                            console.log('error.else: ', error.message ? error.message : error);
                            errors.push(error.message ? error.message : 'error.message not found');
                        }
                        if (error.response && error.response.data && error.response.data.message) {
                            if (typeof error.response.data.message == 'string') {
                                errors.push(error.response.data.message);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errors.push(error.response.data.message[prop]);
                                    }
                                }
                            }
                        }
                        errors.forEach((val) => {
                            errorDisplay += val + '<br>';
                        });
                        this.vueDialogShow('Error!', errorDisplay);
                    });
                }
            } catch (err) {
                this.isSubmitting = false;
                console.log('err: ', err);
                this.vueDialogShow('Error!', err.message ? err.message : err);
            }
        },
        onNewPageItemAddFormSubmit() {
            try {
                this.isSubmitting = true;
                // console.log('ACC: onNewPageItemAddFormSubmit: ', this.pageItemAddUrl);
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.isSubmitting = false;
                    this.vueDialogShow('Error!', 'Form is Invalid! Please Check Inputs!');
                    // console.log('ACC: onNewPageItemAddFormSubmit: ', this.pageItemAddUrl);
                } else {
                    axios({
                        method      : 'POST',
                        url         : this.pageItemAddUrl,
                        data        : {
                            data            : "",
                            listDisplayQuery: this.listDisplayQuery ? this.listDisplayQuery : []
                        },
                        responseType: 'json'
                    }).then(response => {
                        this.isSubmitting = false;
                        console.log('ACC: response/data: ', response.data ? response.data : response, this.pageItemAddUrl);
                        if (response.data && response.data.data) {
                            if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved') {
                                // this.vuePageForm.reset();
                                this.$v.$reset();
                                this.resetOption();
                                this.resetDatepickers();
                            }
                            this.$notify(response.data.data['notify']);
                        } else {
                            this.vueDialogShow('Error!', 'Data Not Found!');
                        }
                    }).catch(error => {
                        this.isSubmitting = false;
                        //console.log('ACC: error: ', error);
                        let errors = [];
                        let errorDisplay = '';
                        //errors.push("Failed to perform operation");
                        if (error.response) {
                            console.log('error.response: ', error.response);
                            errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                        } else if (error.request) {
                            console.log('error.request: ', error.request);
                            errors.push(error.request);
                        } else {
                            console.log('error.else: ', error.message ? error.message : error);
                            errors.push(error.message ? error.message : 'error.message not found');
                        }
                        if (error.response && error.response.data && error.response.data.message) {
                            if (typeof error.response.data.message == 'string') {
                                errors.push(error.response.data.message);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errors.push(error.response.data.message[prop]);
                                    }
                                }
                            }
                        }
                        errors.forEach((val) => {
                            errorDisplay += val + '<br>';
                        });
                        this.vueDialogShow('Error!', errorDisplay);
                    });
                }
            } catch (err) {
                this.isSubmitting = false;
                console.log('catch-err: ', err);
                this.vueDialogShow('Error!', err.message ? err.message : err);
            }
        },
        onEditPageFormSubmit() {
            try {
                this.isSubmitting = true;
                // console.log('onEditPageFormSubmit: ', this.pageItemEditUrl, this.vuePageForm.data());
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.isSubmitting = false;
                    this.vueDialogShow('Error!', 'Form is Invalid! Please Check Inputs!');
                    // console.log('ACC: onEditPageFormSubmit: ', this.pageItemEditUrl, this.vuePageForm.data());
                } else {
                    axios({
                        method      : 'POST',
                        url         : this.pageItemEditUrl,
                        data        : {
                            data             : "",
                            loadFormDataQuery: this.loadFormDataQuery ? this.loadFormDataQuery : [],
                        },
                        responseType: 'json'
                    }).then(response => {
                        this.isSubmitting = false;
                        console.log('ACC: response/data: ', this.pageItemEditUrl, response.data ? response.data : response);
                        if (response.data && response.data.data) {
                            if (response.data.data['notify'] && response.data.data['notify']['group'] && response.data.data['notify']['group'] == 'saved') {
                                this.$v.$reset();
                            }
                            this.$notify(response.data.data['notify']);
                        } else {
                            this.vueDialogShow('Error!', 'Data Not Found!');
                        }
                    }).catch(error => {
                        this.isSubmitting = false;
                        //console.log('ACC: error: ', error, this.pageItemEditUrl, );
                        let errors = [];
                        let errorDisplay = '';
                        //errors.push("Failed to perform operation");
                        if (error.response) {
                            console.log('error.response: ', error.response);
                            errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                        } else if (error.request) {
                            console.log('error.request: ', error.request);
                            errors.push(error.request);
                        } else {
                            console.log('error.else: ', error.message ? error.message : error);
                            errors.push(error.message ? error.message : 'error.message not found');
                        }
                        if (error.response && error.response.data && error.response.data.message) {
                            if (typeof error.response.data.message == 'string') {
                                errors.push(error.response.data.message);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errors.push(error.response.data.message[prop]);
                                    }
                                }
                            }
                        }
                        errors.forEach((val) => {
                            errorDisplay += val + '<br>';
                        });
                        this.vueDialogShow('Error!', errorDisplay);
                    });
                }
            } catch (err) {
                this.isSubmitting = false;
                console.log('err: ', err);
                this.vueDialogShow('Error!', err.message ? err.message : err);
            }
        },
        removeListItem(index, itemId, action = false) {
            if (action) {
                try {
                    console.log('ACC: removeListItem: ', index, itemId, this.listDisplay[index]);
                    axios({
                        method      : 'patch',
                        url         : this.listItemRemoveUrl,
                        data        : {
                            data            : {id: itemId},
                            listDisplayQuery: this.listDisplayQuery
                        },
                        responseType: 'json'
                    }).then(response => {
                        console.log('ACC: response/data: ', response.data ? response.data : response);
                        if (response.data && response.data.data) {
                            //this.listDisplay.splice(index, 1);
                            this.listDisplay = response.data.data['data'];
                            this.listDisplay2 = response.data.data['data'];
                            this.vueListForm.reset();
                            this.$v.$reset();
                            this.resetOption();
                            this.resetDatepickers();
                            this.$notify(response.data.data['notify']);
                        } else {
                            this.vueDialogShow('Error!', 'Data Not Found!');
                        }
                    }).catch(error => {
                        //console.log('ACC: error: ', error);
                        let errors = [];
                        let errorDisplay = '';
                        //errors.push("Failed to perform operation");
                        if (error.response) {
                            console.log('error.response: ', error.response);
                            errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                        } else if (error.request) {
                            console.log('error.request: ', error.request);
                            errors.push(error.request);
                        } else {
                            console.log('error.else: ', error.message ? error.message : error);
                            errors.push(error.message ? error.message : 'error.message not found');
                        }
                        if (error.response && error.response.data && error.response.data.message) {
                            if (typeof error.response.data.message == 'string') {
                                errors.push(error.response.data.message);
                            } else if (typeof error.response.data.message == 'object') {
                                for (let prop in error.response.data.message) {
                                    if (error.response.data.message.hasOwnProperty(prop)) {
                                        errors.push(error.response.data.message[prop]);
                                    }
                                }
                            }
                        }
                        errors.forEach((val) => {
                            errorDisplay += val + '<br>';
                        });
                        this.vueDialogShow('Error!', errorDisplay);
                    });
                } catch (err) {
                    console.log('err: ', err);
                    this.vueDialogShow('Error!', err.message ? err.message : err);
                }
            } else {
                this.promptForListItemDelete(index, itemId);
            }
        },
        removeListItems(index, itemId) {
            try {
                console.log('ACC: removeListItems: ', this.listDisplay.length, this.listDisplay, this.listDisplayQuery);
                axios({
                    method      : 'patch',
                    url         : this.listItemsRemoveUrl,
                    data        : {
                        data            : this.listDisplay,
                        listDisplayQuery: this.listDisplayQuery
                    },
                    responseType: 'json'
                }).then(response => {
                    console.log('ACC: response/data: ', response.data ? response.data : response);
                    if (response.data && response.data.data) {
                        this.listDisplay = response.data.data['data'];
                        this.listDisplay2 = response.data.data['data'];
                        this.vueListItemsCheckboxAll = null;
                        this.$notify(response.data.data['notify']);
                    } else {
                        this.vueDialogShow('Error!', 'Data Not Found!');
                    }
                }).catch(error => {
                    //console.log('ACC: error: ', error);
                    let errors = [];
                    let errorDisplay = '';
                    //errors.push("Failed to perform operation");
                    if (error.response) {
                        console.log('error.response: ', error.response);
                        errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                    } else if (error.request) {
                        console.log('error.request: ', error.request);
                        errors.push(error.request);
                    } else {
                        console.log('error.else: ', error.message ? error.message : error);
                        errors.push(error.message ? error.message : 'error.message not found');
                    }
                    if (error.response && error.response.data && error.response.data.message) {
                        if (typeof error.response.data.message == 'string') {
                            errors.push(error.response.data.message);
                        } else if (typeof error.response.data.message == 'object') {
                            for (let prop in error.response.data.message) {
                                if (error.response.data.message.hasOwnProperty(prop)) {
                                    errors.push(error.response.data.message[prop]);
                                }
                            }
                        }
                    }
                    errors.forEach((val) => {
                        errorDisplay += val + '<br>';
                    });
                    this.vueDialogShow('Error!', errorDisplay);
                });
            } catch (err) {
                console.log('err: ', err);
                this.vueDialogShow('Error!', err.message ? err.message : err);
            }
        },
        removePageItem(item) {
            try {
                console.log('ACC: removePageFormItem: ', item);
                axios({
                    method      : 'patch',
                    url         : this.pageItemRemoveUrl,
                    data        : {
                        data: {id: item.id}
                    },
                    responseType: 'json'
                }).then(response => {
                    console.log('ACC: response/data: ', response.data ? response.data : response);
                    if (response.data && response.data.data) {
                        // this.vuePageForm.reset();
                        this.$v.$reset();
                        this.resetOption();
                        this.resetDatepickers();
                        this.$notify(response.data.data['notify']);
                    } else {
                        this.vueDialogShow('Error!', 'Data Not Found!');
                    }
                }).catch(error => {
                    //console.log('ACC: error: ', error);
                    let errors = [];
                    let errorDisplay = '';
                    //errors.push("Failed to perform operation");
                    if (error.response) {
                        console.log('error.response: ', error.response);
                        errors.push(error.response.statusText ? error.response.statusText : 'statusText not found');
                    } else if (error.request) {
                        console.log('error.request: ', error.request);
                        errors.push(error.request);
                    } else {
                        console.log('error.else: ', error.message ? error.message : error);
                        errors.push(error.message ? error.message : 'error.message not found');
                    }
                    if (error.response && error.response.data && error.response.data.message) {
                        if (typeof error.response.data.message == 'string') {
                            errors.push(error.response.data.message);
                        } else if (typeof error.response.data.message == 'object') {
                            for (let prop in error.response.data.message) {
                                if (error.response.data.message.hasOwnProperty(prop)) {
                                    errors.push(error.response.data.message[prop]);
                                }
                            }
                        }
                    }
                    errors.forEach((val) => {
                        errorDisplay += val + '<br>';
                    });
                    this.vueDialogShow('Error!', errorDisplay);
                });
            } catch (err) {
                console.log('err: ', err);
                this.vueDialogShow('Error!', err.message ? err.message : err);
            }
        },
        newPageFormItem() {
            /*if (this.vuePageForm.hasData()) {
                this.promptForPageFormReset('Warning!', 'Are you sure you want to reset the form?');
            } else {
                this.vuePageForm.reset();
                this.$v.$reset();
                this.resetOption();
                this.resetDatepickers();
            }
            console.log('newPageFormItem: ', this.vuePageForm);*/
        },
        goToListFromPage(routerName) {
            /*if (this.vuePageForm.hasData()) {
                this.promptForGotoList('Warning!', 'Are you sure you want to discard current inputs?', routerName);
            } else {
                this.$router.push({
                    name: routerName
                });
            }
            console.log('customerTypeSelect: ', this.vuePageForm);*/
        },
        vueDialogShow(title, text) {
            this.$modal.show('dialog', {
                title  : title,
                text   : text,
                buttons: [
                    {
                        title  : 'Close',
                        default: true,
                    }
                ]
            })
        },
        promptForListItemDelete(index, itemId) {
            console.log('promptForListItemDelete: ', this.listDisplay.length, this.listDisplay);
            this.$modal.show('dialog', {
                title  : 'Warning!',
                text   : 'Are you sure you want to delete?',
                buttons: [
                    {
                        title  : 'Yes',
                        handler: () => {
                            this.removeListItem(index, itemId, true);
                            this.$modal.hide('dialog');
                        }
                    },
                    {
                        title  : 'No',
                        default: true,
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    },
                ]
            })
        },
        promptForPageFormReset(title, text) {
            this.$modal.show('dialog', {
                title  : title,
                text   : text,
                buttons: [
                    {
                        title  : 'Yes',
                        handler: () => {
                            // this.vuePageForm.reset();
                            this.$v.$reset();
                            this.resetOption();
                            this.resetDatepickers();
                            this.$modal.hide('dialog');
                        }
                    },
                    {
                        title  : 'No',
                        default: true,
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    },
                ]
            })
        },
        promptForPageItemDelete(item) {
            this.$modal.show('dialog', {
                title  : 'Warning!',
                text   : 'Are you sure you want to delete this item?',
                buttons: [
                    {
                        title  : 'Yes',
                        handler: () => {
                            this.removePageItem(item);
                            this.$modal.hide('dialog');
                        }
                    },
                    {
                        title  : 'No',
                        default: true,
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    },
                ]
            })
        },
        promptForListItemsDelete() {
            console.log('promptForListItemsDelete: ', this.listDisplay.length, this.listDisplay);
            if (this.listDisplay.some(e => e.selected === true)) {
                this.$modal.show('dialog', {
                    title  : 'Warning!',
                    text   : 'Are you sure you want to delete the selected item(s)?',
                    buttons: [
                        {
                            title  : 'Yes',
                            handler: () => {
                                this.removeListItems();
                                this.$modal.hide('dialog');
                            }
                        },
                        {
                            title  : 'No',
                            default: true,
                            handler: () => {
                                this.$modal.hide('dialog')
                            }
                        },
                    ]
                })
            } else {
                this.vueDialogShow('Alert!', 'Please select item before deleting!');
            }
        },
    },
}
