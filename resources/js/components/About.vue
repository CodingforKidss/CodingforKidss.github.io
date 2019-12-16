<template>
    <div>
        <!-- Bootstrap -->
        <link type = "text/css" rel = "stylesheet" href = "css/bootstrap.min.css"/>
        <!-- Custom stlylesheet -->
        <link type = "text/css" rel = "stylesheet" href = "css/home-style.css"/>
        <!-- Header -->
        <header id = "header">
            <div class = "container">

                <div class = "navbar-header">
                    <!-- Logo -->
                    <div class = "navbar-brand">
                        <a class = "logo" href = "/dashboard">
                            <img src = "img/logo.png" alt = "logo">
                        </a>
                    </div>
                    <!-- /Logo -->

                    <!-- Mobile toggle -->
                    <button class = "navbar-toggle">
                        <span></span>
                    </button>
                    <!-- /Mobile toggle -->
                </div>

                <!-- Navigation -->
                <nav id = "nav">
                    <ul class = "main-menu nav navbar-nav navbar-right" style = "-webkit-box-orient: horizontal; display: block;">
                        <li>
                            <a href = "" @click.prevent = "toRoute('dashboard')">Home</a>
                        </li>
                        <li>
                            <a href = "" @click.prevent = "toRoute('about')">About</a>
                        </li>
                        <li>
                            <a href = "" @click.prevent = "toRoute('courses')">Courses</a>
                        </li>
                        <li>
                            <a href = "" @click.prevent = "toRoute('contact')">Contact</a>
                        </li>
                        <li @click.prevent = "logout()">
                            <a>Logout</a>
                        </li>
                    </ul>
                </nav>
                <!-- /Navigation -->

            </div>
        </header>
        <!-- /Header -->

        <!-- Hero-area -->
        <div class = "hero-area section">

            <!-- Backgound Image -->
            <div class = "bg-image bg-parallax overlay" style = "background-image:url(img/page-background.jpg)"></div>
            <!-- /Backgound Image -->

            <div class = "container">
                <div class = "row">
                    <div class = "col-md-10 col-md-offset-1 text-center">
                        <ul class = "hero-area-tree">
                            <li>
                                <a href = "/dashboard">Home</a>
                            </li>
                            <li>About</li>
                        </ul>
                        <h1 class = "white-text">Who We Are</h1>

                    </div>
                </div>
            </div>

        </div>
        <!-- /Hero-area -->

        <!-- Contact -->
        <div id = "contact" class = "section">

            <!-- container -->
            <div class = "container">

                <!-- row -->
                <div class = "row">

                    <!-- contact form -->
                    <div class = "col-md-12">
                        So wait a minute. Let’s start at the beginning. What exactly is coding?

                        For the uninitiated, coding is a term for computer programming.

                        Coding is a creative process executed by computer programmers to tell a computer how to perform a task.

                        Coding involves writing computer programs using programming languages that can range from visual drag and drop languages to text-based languages like Java or Python.

                        Kids coding is usually taught using content that is both educational and entertaining.
                    </div>
                    <!-- /contact form -->
                </div>
                <!-- /row -->

            </div>
            <!-- /container -->

        </div>
        <!-- /Contact -->

        <!-- Footer -->
        <footer id = "footer" class = "section">

            <!-- container -->
            <div class = "container">

                <!-- row -->
                <div class = "row">

                    <!-- footer logo -->
                    <div class = "col-md-6">
                        <div class = "footer-logo">
                            <a class = "logo" href = "/dashboard">
                                <img src = "img/logo.png" alt = "logo">
                            </a>
                        </div>
                    </div>
                    <!-- footer logo -->

                    <!-- footer nav -->
                    <div class = "col-md-6">
                        <ul class = "footer-nav">
                            <li>
                                <a href = "" @click.prevent = "toRoute('dashboard')">Home</a>
                            </li>
                            <li>
                                <a href = "" @click.prevent = "toRoute('about')">About</a>
                            </li>
                            <li>
                                <a href = "" @click.prevent = "toRoute('courses')">Courses</a>
                            </li>
                            <li>
                                <a href = "" @click.prevent = "toRoute('contact')">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /footer nav -->

                </div>
                <!-- /row -->

                <!-- row -->
                <div id = "bottom-footer" class = "row">

                    <!-- social -->
                    <div class = "col-md-4 col-md-push-8">
                        <ul class = "footer-social">
                            <li>
                                <a href = "#" class = "facebook">
                                    <i class = "fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href = "#" class = "twitter">
                                    <i class = "fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href = "#" class = "google-plus">
                                    <i class = "fa fa-google-plus"></i>
                                </a>
                            </li>
                            <li>
                                <a href = "#" class = "instagram">
                                    <i class = "fa fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href = "#" class = "youtube">
                                    <i class = "fa fa-youtube"></i>
                                </a>
                            </li>
                            <li>
                                <a href = "#" class = "linkedin">
                                    <i class = "fa fa-linkedin"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /social -->

                    <!-- copyright -->
                    <div class = "col-md-8 col-md-pull-4">
                        <div class = "footer-copyright">
                            <span>Made with care.</span>
                        </div>
                    </div>
                    <!-- /copyright -->

                </div>
                <!-- row -->

            </div>
            <!-- /container -->

        </footer>
        <!-- /Footer -->

        <!-- preloader -->
        <!--  <div id = 'preloader'>
              <div class = 'preloader'></div>
          </div>-->
        <!-- /preloader -->

    </div>
</template>
<script>
    import FormMixin from '../FormMixin';
    import MyConstant from '../variables';

    export default {
        mixins: [FormMixin],
        data() {
            return {
                page    : {
                    title      : 'Contacts',
                    subTitle   : 'View Various Data',
                    vuexKey    : null,
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    ItemGetUrl : '/api/v1/auth/dashboard-info',
                },
                paginate: ['items'],
            }
        },

        created() {
            // this.setLayout('layout-dashboard');
            this.onLoadPageData(this.page.ItemGetUrl, null, this.page.vuexKey, 'loading', false, null);
            console.log('created: ', this.page.title, ': ', this.$route.params, this.timer);
        },
        mounted() {
        },
        computed: {
            dataTable() {
                let data = this.$store.getters.dataTable(this.page.vuexKey);
                if (data && data['data'] && data['data'].length > 0) {
                    data['data'].forEach((d, i) => {
                        data['data'][i] = {
                            'id': d['id'],
                        }
                    });
                }
                console.log('computed: dataTable: ', this.page.vuexKey, data);
                return data;
            },
            user() {
                let data = this.$store.getters.user;
                console.log('computed: user: ', data);
                return data;
            },
            emptyArray() {
                return this.dataTable['data'].length == 0
            }
        },
        watch   : {
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
        methods : {
            updateTime() {
            },
        }
    }
</script>
