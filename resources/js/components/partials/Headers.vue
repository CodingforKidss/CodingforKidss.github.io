<template>
    <div class = "container-fluid">
        <div class = "navbar-wrapper">
            <div class = "navbar-toggle">
                <button class = "navbar-toggler" type = "button">
                    <span class = "navbar-toggler-bar bar1"></span>
                    <span class = "navbar-toggler-bar bar2"></span>
                    <span class = "navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <img onerror = "src='/img/avatar.png'" src = "/img/logo.png" style = "width: 80px; height: 40px; object-fit: contain; margin-right: 10px;">
            <router-link :to = "{ name: 'dashboard' }" class = "navbar-brand">Coding for Kids</router-link>
        </div>
        <button aria-controls = "navigation-index" aria-expanded = "false" aria-label = "Toggle navigation"
                class = "navbar-toggler" data-target = "#navigation" data-toggle = "collapse" type = "button">
            <span class = "navbar-toggler-bar navbar-kebab"></span>
            <span class = "navbar-toggler-bar navbar-kebab"></span>
            <span class = "navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class = "collapse navbar-collapse justify-content-end" id = "navigation">
            <form class = "paper-form">
                <div class = "input-group no-border">
                    <input class = "form-control" placeholder = "Search..." type = "text" value = "">
                    <div class = "input-group-append">
                        <div class = "input-group-text">
                            <i class = "nc-icon nc-zoom-split"></i>
                        </div>
                    </div>
                </div>
            </form>
            <ul class = "navbar-nav">
                <li class = "nav-item">
                    <router-link :to = "{ name: 'dashboard' }" class = "nav-link btn-magnify">
                        <i class = "nc-icon nc-layout-11"></i>
                        <p>
                            <span class = "d-lg-none d-md-block">Dashboard</span>
                        </p>
                    </router-link>
                </li>
                <li class = "nav-item btn-rotate dropdown">
                    <a aria-expanded = "false" aria-haspopup = "true" class = "nav-link dropdown-toggle"
                       data-toggle = "dropdown" href = "" id = "navbarDropdownMenuLink">
                        <i class = "nc-icon nc-bell-55"></i>
                        <p>
                            <span class = "d-lg-none d-md-block">Some Actions</span>
                        </p>
                    </a>
                    <div aria-labelledby = "navbarDropdownMenuLink" class = "dropdown-menu dropdown-menu-right">
                        <router-link :to = "{ name: 'dashboard.settings' }" class = "dropdown-item">Settings</router-link>
                        <button @click.prevent = "logoutFinal()" class = "dropdown-item" type = "button"
                                v-if = "user && user['role'] && user['role']['name'] && user['role']['name'] === 'Employee'">
                            End Shift
                        </button>
                        <button @click.prevent = "logout()" class = "dropdown-item" type = "button">
                            Logout
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    import FormMixin from '../../FormMixin';

    export default {
        mixins: [FormMixin],

        mounted() {
            console.log('Header Component mounted.')
        },
        computed: {
            user() {
                let data = this.$store.getters.user;
                console.log('computed: user: ', data);
                return data;
            }
        },
        methods : {
            logoutFinal() {
                console.log('handler: user: ', this.user);
                if (this.user['attendance'] && this.user['attendance']['time_in'] && !this.user['attendance']['time_out']) {
                    this.$modal.show('dialog', {
                        title  : 'Logout!',
                        text   : '<div style = "text-align: center">Are You Sure You Want To Logout and End your Shift?<br><br>Please note that this will End your Shift Now and Count in Attendance Time.</div>',
                        buttons: [
                            {
                                title  : 'Yes',
                                handler: () => {
                                    let data                    = this.user;
                                    data['logout_confirmation'] = true;
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
                } else {
                    this.$modal.show('dialog', {
                        title  : 'Logout!',
                        text   : '<div style = "text-align: center">Sorry! You have already closed your shift for today.<br><br>Please Click on Logout Instead.</div>',
                        buttons: [
                            {
                                title  : 'Close',
                                default: true,
                                handler: () => {
                                    this.$modal.hide('dialog')
                                }
                            },
                            {
                                title  : 'Logout',
                                default: true,
                                handler: () => {
                                    this.$modal.hide('dialog')
                                    this.logout();
                                }
                            },
                        ]
                    })
                }
            },

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
        }
    }
</script>
