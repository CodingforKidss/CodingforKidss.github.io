<template>
    <div>
        <!-- Bootstrap -->
        <link type = "text/css" rel = "stylesheet" href = "css/bootstrap.min.css"/>
        <!-- Custom stlylesheet -->
        <link type = "text/css" rel = "stylesheet" href = "css/home-style.css"/>
        <!-- Header -->
        <header id = "header" class = "transparent-nav">
            <div class = "container">

                <div class = "navbar-header">
                    <!-- Logo -->
                    <div class = "navbar-brand">
                        <a class = "logo" href = "/dashboard">
                            <img src = "img/logo.png" alt = "logo"> &nbsp;&nbsp;&nbsp;<span style = "color: white;">Coding for Kids</span>
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

        <!-- Home -->
        <div id = "home" class = "hero-area">

            <!-- Backgound Image -->
            <div class = "bg-image bg-parallax overlay" style = "background-image:url(img/home-background.jpg)"></div>
            <!-- /Backgound Image -->

            <div class = "home-wrapper">
                <div class = "container">
                    <div class = "row">
                        <div class = "col-md-8">
                            <h1 class = "white-text">Coding for Kids Free Kids Teaching Platform</h1>
                            <p class = "lead white-text">Teach your kids better programming Online.</p>
                            <a class = "main-button icon-button" href = "#">Get Started!</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Home -->

        <!-- About -->
        <div id = "about" class = "section">

            <!-- container -->
            <div class = "container">

                <!-- row -->
                <div class = "row">

                    <div class = "col-md-6">
                        <div class = "section-header">
                            <h2>Welcome to Coding for Kids</h2>
                            <p class = "lead">We offer a range of services and courses.</p>
                        </div>

                        <!-- feature -->
                        <div class = "feature">
                            <i class = "feature-icon fa fa-flask"></i>
                            <div class = "feature-content">
                                <h4>Online Courses </h4>
                                <p>Learn Programming Online with our descriptive and extensive materials.</p>
                            </div>
                        </div>
                        <!-- /feature -->

                        <!-- feature -->
                        <div class = "feature">
                            <i class = "feature-icon fa fa-users"></i>
                            <div class = "feature-content">
                                <h4>Extensive Materials</h4>
                                <p>Our course materials are easy to read and suits your kids mental age.</p>
                            </div>
                        </div>
                        <!-- /feature -->

                        <!-- feature -->
                        <div class = "feature">
                            <i class = "feature-icon fa fa-comments"></i>
                            <div class = "feature-content">
                                <h4>Online Compiler</h4>
                                <p>Test your skill and progress online by compiling codes in our platform</p>
                            </div>
                        </div>
                        <!-- /feature -->

                    </div>

                    <div class = "col-md-6">
                        <div class = "about-img">
                            <img src = "img/about.png" alt = "">
                        </div>
                    </div>

                </div>
                <!-- row -->

            </div>
            <!-- container -->
        </div>
        <!-- /About -->

        <!-- Courses -->
        <div id = "courses" class = "section">

            <!-- container -->
            <div class = "container">

                <!-- row -->
                <div class = "row">
                    <div class = "section-header text-center">
                        <h2>Explore Courses</h2>
                        <p class = "lead">Select Course and Start Learning Today.</p>
                    </div>
                </div>
                <!-- /row -->

                <!-- courses -->
                <div id = "courses-wrapper">

                    <!-- row -->
                    <div class = "row">

                        <!-- single course -->
                        <div class = "col-md-3 col-sm-6 col-xs-6">
                            <div class = "course">
                                <a href = "#" class = "course-img">
                                    <img src = "img/course01.jpg" alt = "">
                                    <i class = "course-link-icon fa fa-link"></i>
                                </a>
                                <a class = "course-title" href = "#">HTML</a>
                                <div class = "course-details">
                                    <span class = "course-category">Web Design</span>
                                    <span class = "course-price course-free">Free</span>
                                </div>
                            </div>
                        </div>
                        <!-- /single course -->

                        <!-- single course -->
                        <div class = "col-md-3 col-sm-6 col-xs-6">
                            <div class = "course">
                                <a href = "#" class = "course-img">
                                    <img src = "img/course02.jpg" alt = "">
                                    <i class = "course-link-icon fa fa-link"></i>
                                </a>
                                <a class = "course-title" href = "#">CSS</a>
                                <div class = "course-details">
                                    <span class = "course-category">Web Design</span>
                                    <span class = "course-price course-premium">Free</span>
                                </div>
                            </div>
                        </div>
                        <!-- /single course -->

                        <!-- single course -->
                        <div class = "col-md-3 col-sm-6 col-xs-6">
                            <div class = "course">
                                <a href = "#" class = "course-img">
                                    <img src = "img/course03.jpg" alt = "">
                                    <i class = "course-link-icon fa fa-link"></i>
                                </a>
                                <a class = "course-title" href = "#">JAVA</a>
                                <div class = "course-details">
                                    <span class = "course-category">Programming</span>
                                    <span class = "course-price course-premium">Free</span>
                                </div>
                            </div>
                        </div>
                        <!-- /single course -->

                        <div class = "col-md-3 col-sm-6 col-xs-6">
                            <div class = "course">
                                <a href = "#" class = "course-img">
                                    <img src = "img/course04.jpg" alt = "">
                                    <i class = "course-link-icon fa fa-link"></i>
                                </a>
                                <a class = "course-title" href = "#">Javascript</a>
                                <div class = "course-details">
                                    <span class = "course-category">Web Development</span>
                                    <span class = "course-price course-free">Free</span>
                                </div>
                            </div>
                        </div>
                        <!-- /single course -->

                    </div>
                    <!-- /row -->
                </div>
                <!-- /courses -->

                <div class = "row">
                    <div class = "center-btn">
                        <a class = "main-button icon-button" href = "#">View Details</a>
                    </div>
                </div>

            </div>
            <!-- container -->

        </div>
        <!-- /Courses -->

        <!-- Call To Action -->
        <div id = "cta" class = "section">

            <!-- Backgound Image -->
            <div class = "bg-image bg-parallax overlay" style = "background-image:url(img/cta1-background.jpg)"></div>
            <!-- /Backgound Image -->

            <!-- container -->
            <div class = "container">

                <!-- row -->
                <div class = "row">

                    <div class = "col-md-6">
                        <h2 class = "white-text">Programming for the future</h2>
                        <p class = "lead white-text">Get ahead of the weave and teach your kids today to stay ahead of the competition.</p>
                        <a class = "main-button icon-button" href = "#">Get Started!</a>
                    </div>

                </div>
                <!-- /row -->

            </div>
            <!-- /container -->

        </div>
        <!-- /Call To Action -->

        <!-- Why us -->
        <div id = "why-us" class = "section">

            <!-- container -->
            <div class = "container">

                <!-- row -->
                <div class = "row">
                    <div class = "section-header text-center">
                        <h2>Why Coding for Kids</h2>
                        <p class = "lead">It's easy and interective.</p>
                    </div>

                    <!-- feature -->
                    <div class = "col-md-4">
                        <div class = "feature">
                            <i class = "feature-icon fa fa-flask"></i>
                            <div class = "feature-content">
                                <h4>Online Courses</h4>
                                <p>From Learning to Practicing, everythig you can do online.</p>
                            </div>
                        </div>
                    </div>
                    <!-- /feature -->

                    <!-- feature -->
                    <div class = "col-md-4">
                        <div class = "feature">
                            <i class = "feature-icon fa fa-users"></i>
                            <div class = "feature-content">
                                <h4>Evaluation</h4>
                                <p>As parent you can monitor your kids progress and whay they are learning.</p>
                            </div>
                        </div>
                    </div>
                    <!-- /feature -->

                    <!-- feature -->
                    <div class = "col-md-4">
                        <div class = "feature">
                            <i class = "feature-icon fa fa-comments"></i>
                            <div class = "feature-content">
                                <h4>Fun to Learn</h4>
                                <p>As the course taught with short, informative and interective way, your kids will not get bored to learn.</p>
                            </div>
                        </div>
                    </div>
                    <!-- /feature -->

                </div>
                <!-- /row -->

                <hr class = "section-hr">

            </div>
            <!-- /container -->

        </div>
        <!-- /Why us -->

        <!-- Contact CTA -->
        <div id = "contact-cta" class = "section">

            <!-- Backgound Image -->
            <div class = "bg-image bg-parallax overlay" style = "background-image:url(img/cta2-background.jpg)"></div>
            <!-- Backgound Image -->

            <!-- container -->
            <div class = "container">

                <!-- row -->
                <div class = "row">

                    <div class = "col-md-8 col-md-offset-2 text-center">
                        <h2 class = "white-text">Contact Us</h2>
                        <p class = "lead white-text">Coding for Kids Kids Teaching Center</p>
                        <a class = "main-button icon-button" href = "#">Contact Us Now</a>
                    </div>

                </div>
                <!-- /row -->

            </div>
            <!-- /container -->

        </div>
        <!-- /Contact CTA -->

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
    import moment from 'moment';

    export default {
        mixins  : [FormMixin],
        data() {
            return {
                page    : {
                    title      : 'Dashboard',
                    subTitle   : 'View Various Data',
                    vuexKey    : 'dashboard',
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
        methods : {}
    }
</script>
