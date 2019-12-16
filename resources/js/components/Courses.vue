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
                            <li>Courses</li>
                        </ul>
                        <h1 class = "white-text">Our List of Courses</h1>

                    </div>
                </div>
            </div>

        </div>
        <!-- /Hero-area -->

        <!-- Blog -->
        <div id = "blog" class = "section">
            <!-- container -->
            <div class = "container">
                <!-- row -->
                <div class = "row">
                    <!-- main blog -->
                    <div id = "main" class = "col-md-9">
                        <!-- row -->
                        <div class = "row">
                            <!-- single blog -->
                            <div class = "col-md-6" v-for = "(item, index) in dataTable['data']" @click.prevent = "goToRoute(item)">
                                <div class = "single-blog">
                                    <div class = "blog-img">
                                        <a href = "blog-post.html">
                                            <img :src = "'/img/' + item['photo']" onerror = "src='/img/avatar.png'">
                                        </a>
                                    </div>
                                    <h4>
                                        <a href = "blog-post.html">{{item['name']}}</a>
                                    </h4>
                                    <div class = "blog-meta">
                                        <span class = "blog-meta-author">By: <a href = "#">Online</a></span>
                                        <div class = "pull-right">
                                            <span>{{item['start_date']}}</span>
                                            <span class = "blog-meta-comments"><a href = "#"><i class = "fa fa-comments"></i> 1</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /single blog -->
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /main blog -->

                    <!-- aside blog -->
                    <div id = "aside" class = "col-md-3">

                        <!-- search widget -->
                        <div class = "widget search-widget">
                            <form>
                                <input class = "input" type = "text" name = "search">
                                <button>
                                    <i class = "fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <!-- /search widget -->

                        <!-- category widget -->
                        <div class = "widget category-widget">
                            <h3>Categories</h3>
                            <a class = "category" href = "#">Web
                                <span>2</span>
                            </a>
                            <a class = "category" href = "#">Css
                                <span>1</span>
                            </a>
                            <a class = "category" href = "#">Html
                                <span>1</span>
                            </a>
                            <a class = "category" href = "#">Programming
                                <span>1</span>
                            </a>
                        </div>
                        <!-- /category widget -->
                    </div>
                    <!-- /aside blog -->

                </div>
                <!-- row -->

            </div>
            <!-- container -->

        </div>
        <!-- /Blog -->

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
                page: {
                    title      : 'Contacts',
                    subTitle   : 'View Various Data',
                    vuexKey    : 'courses',
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                },

                paginate: ['items'],
                dbQuery : {
                    table     : 'Courses',
                    tableWith : [
                        'enrolments',
                    ],
                    matchThese: [
                        [
                            'active',
                            '=',
                            1
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
                        'id'         : 'id',
                        'course_no'  : 'course_no',
                        'name'       : 'name',
                        'short_name' : 'short_name',
                        'price'      : 'price',
                        'duration'   : 'duration',
                        'material'   : 'material',
                        'start_date' : 'start_date',
                        'start_time' : 'start_time',
                        'description': 'description',
                        'photo'      : 'photo',
                    },
                    sortBy    : {
                        relation: false, // false or relation name
                        field   : 'id',
                        desc    : true
                    },
                    pluck     : {
                        'id'         : 'id',
                        'course_no'  : 'course_no',
                        'name'       : 'name',
                        'short_name' : 'short_name',
                        'price'      : 'price',
                        'duration'   : 'duration',
                        'material'   : 'material',
                        'start_date' : 'start_date',
                        'start_time' : 'start_time',
                        'description': 'description',
                        'photo'      : 'photo',
                    }
                },
            }
        },

        created() {
            // this.setLayout('layout-dashboard');
            this.onLoadPageData(this.ItemGetUrl, this.dbQuery, this.page.vuexKey, 'loading', false, null);
            console.log('created: ', this.page.title, ': ', this.$route.params, this.timer);
        },
        mounted() {
        },
        computed: {
            dataTable() {
                let data = this.$store.getters.dataTable(this.page.vuexKey);
                /* if (data && data['data'] && data['data'].length > 0) {
                     data['data'].forEach((d, i) => {
                         data['data'][i] = {
                             'id': d['id'],
                         }
                     });
                 }*/
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
            goToRoute(item) {
                this.$router.push({
                    name  : 'course-details',
                    params: {'item': item}
                });
            },
        }
    }
</script>
