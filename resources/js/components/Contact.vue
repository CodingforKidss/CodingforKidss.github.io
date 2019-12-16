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
                            <li>Contact</li>
                        </ul>
                        <h1 class = "white-text">Get In Touch</h1>

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
                    <div class = "col-md-6">
                        <div class = "contact-form">
                            <h4>Send A Message</h4>
                            <form>
                                <input class = "input" type = "text" name = "name" placeholder = "Name">
                                <input class = "input" type = "email" name = "email" placeholder = "Email">
                                <input class = "input" type = "text" name = "subject" placeholder = "Subject">
                                <textarea class = "input" name = "message" placeholder = "Enter your Message"></textarea>
                                <button class = "main-button icon-button pull-right">Send Message</button>
                            </form>
                        </div>
                    </div>
                    <!-- /contact form -->

                    <!-- contact information -->
                    <div class = "col-md-5 col-md-offset-1">
                        <h4>Contact Information</h4>
                        <ul class = "contact-details">
                            <li>
                                <i class = "fa fa-envelope"></i>
                                CodingforKids@email.com
                            </li>
                            <li>
                                <i class = "fa fa-phone"></i>
                                011-247-854-555
                            </li>
                            <li>
                                <i class = "fa fa-map-marker"></i>
                                40 KL Sentral, Selangor
                            </li>
                        </ul>

                        <!-- contact map -->
                        <div id = "contact-map"></div>
                        <!-- /contact map -->

                    </div>
                    <!-- contact information -->

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
