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
                            <li>{{item && item['name'] ? item['name'] : ''}}</li>
                        </ul>
                        <h1 class = "white-text">Course Details</h1>
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
                    <!--                    <div id = "main" class = "col-md-9" v-if = "item && item['name'] === 'HTML'">-->
                    <div id = "main" class = "col-md-9">
                        <!-- blog post -->
                        <div v-if = "item && item['name'] === 'JAVA'">
                            <div v-if = "page.pageIndex === 0">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Intro to JAVA
                                            </a>
                                        </div>
                                    </h2>
                                    <img src = "img/211.jpg" alt = "logo">
                                    <br> <br>
                                    <div class = "free-text">Java is a high-level programming language originally developed by Sun Microsystems and released in 1995. Java runs on a variety of platforms, such as Windows, Mac OS, and the various versions of UNIX. This tutorial gives a complete understanding of Java. This reference will take you through simple and practical approaches while learning Java Programming language.
                                    </div>
                                    <br>
                                    <div class = "free-text">Why to Learn java Programming? <br> <br>
                                        <ul>
                                            <li><p>Object Oriented − In Java, everything is an Object. Java can be easily extended since it is based on the Object model.</p></li>

                                            <li>
                                                <p>Platform Independent − Unlike many other programming languages including C and C++, when Java is compiled, it is not compiled into platform specific machine, rather into platform independent byte code. This byte code is distributed over the web and interpreted by the Virtual Machine (JVM) on whichever platform it is being run on.</p>
                                            </li>

                                            <li><p>Simple − Java is designed to be easy to learn. If you understand the basic concept of OOP Java, it would be easy to master.</p></li>

                                            <li>
                                                <p>Secure − With Java's secure feature it enables to develop virus-free, tamper-free systems. Authentication techniques are based on public-key encryption.</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 1">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Hello World using Java Programming.
                                            </a>
                                        </div>
                                    </h2>
                                    <img src = "img/212.png" alt = "logo">
                                    <br> <br>
                                    <div class = "free-text">Just to give you a little excitement about Java programming, I'm going to give you a small conventional C Programming Hello World program.
                                    </div>
                                    <br>
                                    <pre class = "prettyprint notranslate prettyprinted" style = ""><span class = "kwd">public</span><span class = "pln"> </span><span class = "kwd">class</span><span
                                            class = "pln"> </span><span class = "typ">MyFirstJavaProgram</span><span class = "pln"> </span><span class = "pun">{</span><span class = "pln">

   </span><span class = "com">/* This is my first java program.
    * This will print 'Hello World' as the output
    */</span><span class = "pln">

   </span><span class = "kwd">public</span><span class = "pln"> </span><span class = "kwd">static</span><span class = "pln"> </span><span class = "kwd">void</span><span class = "pln"> main</span><span
                                            class = "pun">(</span><span class = "typ">String</span><span class = "pln"> </span><span class = "pun">[]</span><span class = "pln">args</span><span class = "pun">)</span><span
                                            class = "pln"> </span><span class = "pun">{</span><span class = "pln">
      </span><span class = "typ">System</span><span class = "pun">.</span><span class = "kwd">out</span><span class = "pun">.</span><span class = "pln">println</span><span class = "pun">(</span><span
                                            class = "str">"Hello World"</span><span class = "pun">);</span><span class = "pln"> </span><span class = "com">// prints Hello World</span><span class = "pln">
   </span><span class = "pun">}</span><span class = "pln">
</span><span class = "pun">}</span></pre>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 2">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Basic Syntax
                                            </a>
                                        </div>
                                    </h2>
                                    <div class = "free-text">
                                        <ul class = "list">
                                            <li><p><b>Case Sensitivity</b> − Java is case sensitive, which means identifier <b>Hello</b> and <b>hello</b> would have different meaning in Java.</p></li>
                                            <li><p>
                                                <b>Class Names</b> − For all class names the first letter should be in Upper Case. If several words are used to form a name of the class, each inner word's first letter should be in Upper Case.
                                            </p>
                                                <p><b>Example:</b>
                                                    <i>class MyFirstJavaClass</i>
                                                </p>
                                            </li>
                                            <li><p>
                                                <b>Method Names</b> − All method names should start with a Lower Case letter. If several words are used to form the name of the method, then each inner word's first letter should be in Upper Case.
                                            </p>
                                                <p><b>Example:</b>
                                                    <i>public void myMethodName()</i>
                                                </p>
                                            </li>
                                            <li><p><b>Program File Name</b> − Name of the program file should exactly match the class name.</p>
                                                <p>When saving the file, you should save it using the class name (Remember Java is case sensitive) and append '.java' to the end of the name (if the file name and the class name do not match, your program will not compile).</p>
                                                <p>But please make a note that in case you do not have a public class present in the file then file name can be different than class name. It is also not mandatory to have a public class in the file.</p>
                                                <p><b>Example:</b> Assume 'MyFirstJavaProgram' is the class name. Then the file should be saved as
                                                    <i>'MyFirstJavaProgram.java'</i>
                                                </p>
                                            </li>
                                            <li><p>
                                                <b>public static void main(String args[])</b> − Java program processing starts from the main() method which is a mandatory part of every Java program.
                                            </p></li>
                                        </ul>
                                    </div>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/81piDKqPxjQ"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 3">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Java Variables
                                            </a>
                                        </div>
                                    </h2>
                                    <p>Following are the types of variables in Java −</p><br>
                                    <ul class = "list">
                                        <li>Local Variables</li>
                                        <li>Class Variables (Static Variables)</li>
                                        <li>Instance Variables (Non-static Variables)</li>
                                    </ul>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/haI01OWwFPk"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 4">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Java Keywords
                                            </a>
                                        </div>
                                    </h2>
                                    <p>The following list shows the reserved words in Java. These reserved words may not be used as constant or variable or any other identifier names.</p>
                                    <table class = "table table-bordered" style = "text-align:center;">
                                        <tbody>
                                        <tr>
                                            <td>abstract</td>
                                            <td>assert</td>
                                            <td>boolean</td>
                                            <td>break</td>
                                        </tr>
                                        <tr>
                                            <td>byte</td>
                                            <td>case</td>
                                            <td>catch</td>
                                            <td>char</td>
                                        </tr>
                                        <tr>
                                            <td>class</td>
                                            <td>const</td>
                                            <td>continue</td>
                                            <td>default</td>
                                        </tr>
                                        <tr>
                                            <td>do</td>
                                            <td>double</td>
                                            <td>else</td>
                                            <td>enum</td>
                                        </tr>
                                        <tr>
                                            <td>extends</td>
                                            <td>final</td>
                                            <td>finally</td>
                                            <td>float</td>
                                        </tr>
                                        <tr>
                                            <td>for</td>
                                            <td>goto</td>
                                            <td>if</td>
                                            <td>implements</td>
                                        </tr>
                                        <tr>
                                            <td>import</td>
                                            <td>instanceof</td>
                                            <td>int</td>
                                            <td>interface</td>
                                        </tr>
                                        <tr>
                                            <td>long</td>
                                            <td>native</td>
                                            <td>new</td>
                                            <td>package</td>
                                        </tr>
                                        <tr>
                                            <td>private</td>
                                            <td>protected</td>
                                            <td>public</td>
                                            <td>return</td>
                                        </tr>
                                        <tr>
                                            <td>short</td>
                                            <td>static</td>
                                            <td>strictfp</td>
                                            <td>super</td>
                                        </tr>
                                        <tr>
                                            <td>switch</td>
                                            <td>synchronized</td>
                                            <td>this</td>
                                            <td>throw</td>
                                        </tr>
                                        <tr>
                                            <td>throws</td>
                                            <td>transient</td>
                                            <td>try</td>
                                            <td>void</td>
                                        </tr>
                                        <tr>
                                            <td>volatile</td>
                                            <td>while</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/f8lCiYquj28"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 5">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Method Calling
                                            </a>
                                        </div>
                                    </h2>
                                    <p>For using a method, it should be called. There are two ways in which a method is called i.e., method returns a value or returning nothing (no return value).</p>
                                    <br>
                                    <div class = "free-text"><pre class = "prettyprint notranslate prettyprinted" style = ""><span class = "kwd">public</span><span class = "pln"> </span><span class = "kwd">class</span><span
                                            class = "pln"> </span><span class = "typ">ExampleMinNumber</span><span class = "pln"> </span><span class = "pun">{</span><span class = "pln">

   </span><span class = "kwd">public</span><span class = "pln"> </span><span class = "kwd">static</span><span class = "pln"> </span><span class = "kwd">void</span><span class = "pln"> main</span><span
                                            class = "pun">(</span><span class = "typ">String</span><span class = "pun">[]</span><span class = "pln"> args</span><span class = "pun">)</span><span class = "pln"> </span><span
                                            class = "pun">{</span><span class = "pln">
      </span><span class = "kwd">int</span><span class = "pln"> a </span><span class = "pun">=</span><span class = "pln"> </span><span class = "lit">11</span><span class = "pun">;</span><span class = "pln">
      </span><span class = "kwd">int</span><span class = "pln"> b </span><span class = "pun">=</span><span class = "pln"> </span><span class = "lit">6</span><span class = "pun">;</span><span class = "pln">
      </span><span class = "kwd">int</span><span class = "pln"> c </span><span class = "pun">=</span><span class = "pln"> minFunction</span><span class = "pun">(</span><span class = "pln">a</span><span
                                            class = "pun">,</span><span class = "pln"> b</span><span class = "pun">);</span><span class = "pln">
      </span><span class = "typ">System</span><span class = "pun">.</span><span class = "kwd">out</span><span class = "pun">.</span><span class = "pln">println</span><span class = "pun">(</span><span
                                            class = "str">"Minimum Value = "</span><span class = "pln"> </span><span class = "pun">+</span><span class = "pln"> c</span><span class = "pun">);</span><span
                                            class = "pln">
   </span><span class = "pun">}</span><span class = "pln">

   </span><span class = "com">/** returns the minimum of two numbers */</span><span class = "pln">
   </span><span class = "kwd">public</span><span class = "pln"> </span><span class = "kwd">static</span><span class = "pln"> </span><span class = "kwd">int</span><span class = "pln"> minFunction</span><span
                                            class = "pun">(</span><span class = "kwd">int</span><span class = "pln"> n1</span><span class = "pun">,</span><span class = "pln"> </span><span class = "kwd">int</span><span
                                            class = "pln"> n2</span><span class = "pun">)</span><span class = "pln"> </span><span class = "pun">{</span><span class = "pln">
      </span><span class = "kwd">int</span><span class = "pln"> min</span><span class = "pun">;</span><span class = "pln">
      </span><span class = "kwd">if</span><span class = "pln"> </span><span class = "pun">(</span><span class = "pln">n1 </span><span class = "pun">&gt;</span><span class = "pln"> n2</span><span class = "pun">)</span><span
                                            class = "pln">
         min </span><span class = "pun">=</span><span class = "pln"> n2</span><span class = "pun">;</span><span class = "pln">
      </span><span class = "kwd">else</span><span class = "pln">
         min </span><span class = "pun">=</span><span class = "pln"> n1</span><span class = "pun">;</span><span class = "pln">

      </span><span class = "kwd">return</span><span class = "pln"> min</span><span class = "pun">;</span><span class = "pln">
   </span><span class = "pun">}</span><span class = "pln">
</span><span class = "pun">}</span></pre>
                                    </div>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/0kDMKHAZdQk"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                        </div>

                        <div v-if = "item && item['name'] === 'Python'">
                            <div v-if = "page.pageIndex === 0">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Intro to Python
                                            </a>
                                        </div>
                                    </h2>
                                    <img src = "img/112.png" alt = "logo">
                                    <br>
                                    <div class = "free-text">Python is a general-purpose interpreted, interactive, object-oriented, and high-level programming language. It was created by Guido van Rossum during 1985- 1990. Like Perl, Python source code is also available under the GNU General Public License (GPL). This tutorial gives enough understanding on Python programming language.
                                    </div>
                                    <br>
                                    <div class = "free-text">Why to Learn Python?<br> <br>
                                        <ul>
                                            <li><p>Object Oriented − In Java, everything is an Object. Java can be easily extended since it is based on the Object model.</p></li>

                                            <li>
                                                <p>Python is Interpreted − Python is processed at runtime by the interpreter. You do not need to compile your program before executing it. This is similar to PERL and PHP.</p>
                                            </li>

                                            <li><p>Python is Interactive − You can actually sit at a Python prompt and interact with the interpreter directly to write your programs.</p></li>

                                            <li>
                                                <p>Python is Object-Oriented − Python supports Object-Oriented style or technique of programming that encapsulates code within objects.</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <br>
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Python Fundamentals
                                            </a>
                                        </div>
                                    </h2>
                                    <div class = "free-text">The following are the five fundamentals required to master Python:<br><br> Datatypes<br> Flow Control<br> Functions<br> File Handling<br> Object & Class<br>
                                    </div>
                                    <img src = "img/111.png" alt = "logo">
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 1">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Hello World using Python.
                                            </a>
                                        </div>
                                    </h2>
                                    <img src = "img/113.jpeg" alt = "logo">
                                    <br>
                                    <div class = "free-text">Just to give you a little excitement about Python, I'm going to give you a small conventional Python Hello World program.
                                    </div>
                                    <br>
                                    <pre class = "prettyprint notranslate prettyprinted" style = ""><span class = "kwd">print</span><span class = "pln"> </span><span class = "pun">(</span><span class = "str">"Hello, Python!"</span><span
                                            class = "pun">);</span></pre>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 2">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Python Identifiers
                                            </a>
                                        </div>
                                    </h2>
                                    <div class = "free-text">
                                        <p>A Python identifier is a name used to identify a variable, function, class, module or other object. An identifier starts with a letter A to Z or a to z or an underscore (_) followed by zero or more letters, underscores and digits (0 to 9).</p>
                                        <p>Python does not allow punctuation characters such as @, $, and % within identifiers. Python is a case sensitive programming language. Thus,
                                            <b>Manpower</b> and <b>manpower</b> are two different identifiers in Python.</p>
                                        <ul class = "list">
                                            <li><p>Class names start with an uppercase letter. All other identifiers start with a lowercase letter.</p></li>
                                            <li><p>Starting an identifier with a single leading underscore indicates that the identifier is private.</p></li>
                                            <li><p>Starting an identifier with two leading underscores indicates a strongly private identifier.</p></li>
                                            <li><p>If the identifier also ends with two trailing underscores, the identifier is a language-defined special name.</p></li>
                                        </ul>
                                    </div>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/eXBD2bB9-RA"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 3">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Reserved Words
                                            </a>
                                        </div>
                                    </h2>
                                    <p>The following list shows the Python keywords. These are reserved words and you cannot use them as constant or variable or any other identifier names. All the Python keywords contain lowercase letters only.</p>
                                    <br>
                                    <table class = "table table-bordered" style = "text-align:center;">
                                        <tbody>
                                        <tr>
                                            <td>and</td>
                                            <td>exec</td>
                                            <td>not</td>
                                        </tr>
                                        <tr>
                                            <td>assert</td>
                                            <td>finally</td>
                                            <td>or</td>
                                        </tr>
                                        <tr>
                                            <td>break</td>
                                            <td>for</td>
                                            <td>pass</td>
                                        </tr>
                                        <tr>
                                            <td>class</td>
                                            <td>from</td>
                                            <td>print</td>
                                        </tr>
                                        <tr>
                                            <td>continue</td>
                                            <td>global</td>
                                            <td>raise</td>
                                        </tr>
                                        <tr>
                                            <td>def</td>
                                            <td>if</td>
                                            <td>return</td>
                                        </tr>
                                        <tr>
                                            <td>del</td>
                                            <td>import</td>
                                            <td>try</td>
                                        </tr>
                                        <tr>
                                            <td>elif</td>
                                            <td>in</td>
                                            <td>while</td>
                                        </tr>
                                        <tr>
                                            <td>else</td>
                                            <td>is</td>
                                            <td>with</td>
                                        </tr>
                                        <tr>
                                            <td>except</td>
                                            <td>lambda</td>
                                            <td>yield</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/FuPHs7GLxq8"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 4">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Python - Numbers
                                            </a>
                                        </div>
                                    </h2>
                                    <img src = "img/114.jfif" alt = "logo">
                                    <br> <br>
                                    <p>Here are some examples of numbers</p>
                                    <table class = "table table-bordered" style = "text-align:center;">
                                        <tbody>
                                        <tr>
                                            <th style = "text-align:center;">int</th>
                                            <th style = "text-align:center;">long</th>
                                            <th style = "text-align:center;">float</th>
                                            <th style = "text-align:center;">complex</th>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>51924361L</td>
                                            <td>0.0</td>
                                            <td>3.14j</td>
                                        </tr>
                                        <tr>
                                            <td>100</td>
                                            <td>-0x19323L</td>
                                            <td>15.20</td>
                                            <td>45.j</td>
                                        </tr>
                                        <tr>
                                            <td>-786</td>
                                            <td>0122L</td>
                                            <td>-21.9</td>
                                            <td>9.322e-36j</td>
                                        </tr>
                                        <tr>
                                            <td>080</td>
                                            <td>0xDEFABCECBDAECBFBAEL</td>
                                            <td>32.3+e18</td>
                                            <td>.876j</td>
                                        </tr>
                                        <tr>
                                            <td>-0490</td>
                                            <td>535633629843L</td>
                                            <td>-90.</td>
                                            <td>-.6545+0J</td>
                                        </tr>
                                        <tr>
                                            <td>-0x260</td>
                                            <td>-052318172735L</td>
                                            <td>-32.54e100</td>
                                            <td>3e+26J</td>
                                        </tr>
                                        <tr>
                                            <td>0x69</td>
                                            <td>-4721885298529L</td>
                                            <td>70.2-E12</td>
                                            <td>4.53e-7j</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Python Lists
                                            </a>
                                        </div>
                                    </h2>
                                    <p>Creating a list is as simple as putting different comma-separated values between square brackets. For example −</p>
                                    <pre class = "result notranslate">list1 = ['physics', 'chemistry', 1997, 2000];list2 = [1, 2, 3, 4, 5 ];list3 = ["a", "b", "c", "d"]
</pre>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 5">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Calling a Function
                                            </a>
                                        </div>
                                    </h2>
                                    <p>Defining a function only gives it a name, specifies the parameters that are to be included in the function and structures the blocks of code.</p><br>
                                    <pre class = "prettyprint notranslate prettyprinted" style = ""><span class = "com">#!/usr/bin/python</span><span class = "pln">

</span><span class = "com"># Function definition is here</span><span class = "pln">
</span><span class = "kwd">def</span><span class = "pln"> printme</span><span class = "pun">(</span><span class = "pln"> str </span><span class = "pun">):</span><span class = "pln">
   </span><span class = "str">"This prints a passed string into this function"</span><span class = "pln">
   </span><span class = "kwd">print</span><span class = "pln"> str
   </span><span class = "kwd">return</span><span class = "pun">;</span><span class = "pln">

</span><span class = "com"># Now you can call printme function</span><span class = "pln">
printme</span><span class = "pun">(</span><span class = "str">"I'm first call to user defined function!"</span><span class = "pun">)</span><span class = "pln">
printme</span><span class = "pun">(</span><span class = "str">"Again second call to the same function"</span><span class = "pun">)</span></pre>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/9Os0o3wzS_I"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                        </div>

                        <div v-if = "item && item['name'] === 'HTML'">
                            <div v-if = "page.pageIndex === 0">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Intro to HTML
                                            </a>
                                        </div>
                                    </h2>
                                    <img src = "img/311.png" alt = "logo">
                                    <br>
                                    <div class = "free-text">HTML is the markup language that you surround content with, to tell browsers about headings, lists, tables, etc. CSS is the stylesheet language that you style the page with, to tell browsers to change the color, font, layout, and more.
                                    </div>
                                    <br>
                                    <div class = "free-text">Originally, HTML was developed with the intent of defining the structure of documents like headings, paragraphs, lists, and so forth to facilitate the sharing of scientific information between researchers. Now, HTML is being widely used to format web pages with the help of different tags available in HTML language.
                                    </div>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 1">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Why Learn HTML
                                            </a>
                                        </div>
                                    </h2>
                                    <img src = "img/322.jpg" alt = "logo">
                                    <br>
                                    <div class = "free-text">HTML is a MUST for students and working professionals to become a great Software Engineer specially when they are working in Web Development Domain. I will list down some of the key advantages of learning HTML:
                                        <br> <br>
                                        <ul>
                                            <li><p>Create Web site - You can create a website or customize an existing web template if you know HTML well.</p></li>

                                            <li><p>Become a web designer - If you want to start a carrer as a professional web designer, HTML and CSS designing is a must skill.</p></li>

                                            <li><p>Understand web - If you want to optimize your website, to boost its speed and performance, it is good to know HTML to yield best results.</p></li>

                                            <li>
                                                <p>Learn other languages - Once you understands the basic of HTML then other related technologies like javascript, php, or angular are become easier to understand.</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 2">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">Basic HTML Document
                                            </a>
                                        </div>
                                    </h2>
                                    <div class = "free-text">Just to give you a little excitement about HTML, I'm going to give you a small conventional HTML Hello World program.
                                    </div>
                                    <br>
                                    <pre class = "prettyprint notranslate prettyprinted" style = ""><span class = "dec">&lt;!DOCTYPE html&gt;</span><span class = "pln">
</span><span class = "tag">&lt;html&gt;</span><span class = "pln">
   </span><span class = "tag">&lt;head&gt;</span><span class = "pln">
      </span><span class = "tag">&lt;title&gt;</span><span class = "pln">This is document title</span><span class = "tag">&lt;/title&gt;</span><span class = "pln">
   </span><span class = "tag">&lt;/head&gt;</span><span class = "pln">
   </span><span class = "tag">&lt;body&gt;</span><span class = "pln">
      </span><span class = "tag">&lt;h1&gt;</span><span class = "pln">This is a heading</span><span class = "tag">&lt;/h1&gt;</span><span class = "pln">
      </span><span class = "tag">&lt;p&gt;</span><span class = "pln">Hello World!</span><span class = "tag">&lt;/p&gt;</span><span class = "pln">
   </span><span class = "tag">&lt;/body&gt;</span><span class = "pln">
</span><span class = "tag">&lt;/html&gt;</span></pre>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/RjHflb-QgVc"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 3">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">HTML Tags
                                            </a>
                                        </div>
                                    </h2>
                                    <div class = "free-text">
                                        <p>As told earlier, HTML is a markup language and makes use of various tags to format the content. These tags are enclosed within angle braces
                                            <b>&lt;Tag Name&gt;</b>. Except few tags, most of the tags have their corresponding closing tags. For example, <b>&lt;html&gt;</b> has its closing tag
                                            <b>&lt;/html&gt;</b> and <b>&lt;body&gt;</b> tag has its closing tag <b>&lt;/body&gt;</b> tag etc.</p>
                                        <p>Above example of HTML document uses the following tags −</p>
                                        <table class = "table table-bordered">
                                            <tbody>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th style = "text-align:center;">Tag &amp; Description</th>
                                            </tr>
                                            <tr>
                                                <td class = "ts">1</td>
                                                <td>
                                                    <b>&lt;!DOCTYPE...&gt;</b>
                                                    <p>This tag defines the document type and HTML version.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class = "ts">2</td>
                                                <td>
                                                    <b>&lt;html&gt;</b>
                                                    <p>This tag encloses the complete HTML document and mainly comprises of document header which is represented by &lt;head&gt;...&lt;/head&gt; and document body which is represented by &lt;body&gt;...&lt;/body&gt; tags.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class = "ts">3</td>
                                                <td>
                                                    <b>&lt;head&gt;</b>
                                                    <p>This tag represents the document's header which can keep other HTML tags like &lt;title&gt;, &lt;link&gt; etc.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class = "ts">4</td>
                                                <td>
                                                    <b>&lt;title&gt;</b>
                                                    <p>The &lt;title&gt; tag is used inside the &lt;head&gt; tag to mention the document title.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class = "ts">5</td>
                                                <td>
                                                    <b>&lt;body&gt;</b>
                                                    <p>This tag represents the document's body which keeps other HTML tags like &lt;h1&gt;, &lt;div&gt;, &lt;p&gt; etc.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class = "ts">6</td>
                                                <td>
                                                    <b>&lt;h1&gt;</b>
                                                    <p>This tag represents the heading.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class = "ts">7</td>
                                                <td>
                                                    <b>&lt;p&gt;</b>
                                                    <p>This tag represents a paragraph.</p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <iframe width = "100%"
                                            height = "420"
                                            src = "https://www.youtube.com/embed/dmovVa0jseU"
                                            frameborder = "0"
                                            allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen = ""></iframe>
                                </div>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 4">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">HTML Document Structure
                                            </a>
                                        </div>
                                    </h2>
                                    <p>A typical HTML document will have the following structure −</p><br>
                                    <pre class = "prettyprint notranslate prettyprinted" style = ""><span class = "tag">&lt;html&gt;</span><span class = "pln">

   </span><span class = "tag">&lt;head&gt;</span><span class = "pln">
      Document header related tags
   </span><span class = "tag">&lt;/head&gt;</span><span class = "pln">

   </span><span class = "tag">&lt;body&gt;</span><span class = "pln">
      Document body related tags
   </span><span class = "tag">&lt;/body&gt;</span><span class = "pln">

</span><span class = "tag">&lt;/html&gt;</span></pre>
                                </div>
                                <br>
                                <iframe width = "100%"
                                        height = "420"
                                        src = "https://www.youtube.com/embed/zLrPVNXNeUI"
                                        frameborder = "0"
                                        allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen = ""></iframe>
                                <!-- /blog post --><br><br>
                            </div>
                            <div v-if = "page.pageIndex === 5">
                                <div class = "blog-post">
                                    <h2 class = "free-h2">
                                        <div class = "fre-title">
                                            <a href = "">HTML Formatting
                                            </a>
                                        </div>
                                    </h2>
                                    <h2>Bold Text</h2>
                                    <p>Anything that appears within <b>&lt;b&gt;...&lt;/b&gt;</b> element, is displayed in bold as shown below −</p>
                                    <h3>Example</h3>
                                    <pre class = "prettyprint notranslate prettyprinted" style = ""><span class = "dec">&lt;!DOCTYPE html&gt;</span><span class = "pln">
</span><span class = "tag">&lt;html&gt;</span><span class = "pln">

   </span><span class = "tag">&lt;head&gt;</span><span class = "pln">
      </span><span class = "tag">&lt;title&gt;</span><span class = "pln">Bold Text Example</span><span class = "tag">&lt;/title&gt;</span><span class = "pln">
   </span><span class = "tag">&lt;/head&gt;</span><span class = "pln">

   </span><span class = "tag">&lt;body&gt;</span><span class = "pln">
      </span><span class = "tag">&lt;p&gt;</span><span class = "pln">The following word uses a </span><span class = "tag">&lt;b&gt;</span><span class = "pln">bold</span><span class = "tag">&lt;/b&gt;</span><span
                                            class = "pln"> typeface.</span><span class = "tag">&lt;/p&gt;</span><span class = "pln">
   </span><span class = "tag">&lt;/body&gt;</span><span class = "pln">

</span><span class = "tag">&lt;/html&gt;</span></pre>
                                    <h2>Italic Text</h2>
                                    <p>Anything that appears within <b>&lt;i&gt;...&lt;/i&gt;</b> element is displayed in italicized as shown below −</p>
                                    <h3>Example</h3>
                                    <pre class = "prettyprint notranslate prettyprinted" style = ""><span class = "dec">&lt;!DOCTYPE html&gt;</span><span class = "pln">
</span><span class = "tag">&lt;html&gt;</span><span class = "pln">

   </span><span class = "tag">&lt;head&gt;</span><span class = "pln">
      </span><span class = "tag">&lt;title&gt;</span><span class = "pln">Italic Text Example</span><span class = "tag">&lt;/title&gt;</span><span class = "pln">
   </span><span class = "tag">&lt;/head&gt;</span><span class = "pln">

   </span><span class = "tag">&lt;body&gt;</span><span class = "pln">
      </span><span class = "tag">&lt;p&gt;</span><span class = "pln">The following word uses an </span><span class = "tag">&lt;i&gt;</span><span class = "pln">italicized</span><span class = "tag">&lt;/i&gt;</span><span
                                            class = "pln"> typeface.</span><span class = "tag">&lt;/p&gt;</span><span class = "pln">
   </span><span class = "tag">&lt;/body&gt;</span><span class = "pln">

</span><span class = "tag">&lt;/html&gt;</span></pre>
                                </div>
                                <br>
                                <iframe width = "100%"
                                        height = "420"
                                        src = "https://www.youtube.com/embed/4ZunanytE88"
                                        frameborder = "0"
                                        allow = "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen = ""></iframe>
                                <!-- /blog post --><br><br>
                            </div>
                        </div>

                        <button @click.prevent = "previousPage()" class = "btn btn-secondary" type = "button" v-if = "page.pageIndex > 0 && page.pageIndex <= 5">
                            Previous Page
                        </button>
                        <button @click.prevent = "nextPage()"
                                class = "btn btn-primary"
                                type = "button"
                                v-if = "page.pageIndex >= 0 && page.pageIndex < 2 && item && item['name'] === 'JAVA' || (page.purchased[0] === 1 && page.pageIndex >= 0 && page.pageIndex < 5)">
                            Next Page
                        </button>
                        <button @click.prevent = "nextPage()"
                                class = "btn btn-primary"
                                type = "button"
                                v-if = "page.pageIndex >= 0 && page.pageIndex < 2 && item && item['name'] === 'Python' || (page.purchased[1] === 1 && page.pageIndex >= 0 && page.pageIndex < 5)">
                            Next Page
                        </button>
                        <button @click.prevent = "nextPage()"
                                class = "btn btn-primary"
                                type = "button"
                                v-if = "page.pageIndex >= 0 && page.pageIndex < 2 && item && item['name'] === 'HTML' || (page.purchased[2] === 1 && page.pageIndex >= 0 && page.pageIndex < 5)">
                            Next Page
                        </button>
                        <button @click.prevent = "purchase(0)"
                                class = "btn btn-danger"
                                type = "button"
                                v-if = "item && item['name'] === 'JAVA' && page.purchased[0] === 0 && page.pageIndex >= 2 && page.pageIndex < 5">
                            Purchase & Unlock
                        </button>
                        <button @click.prevent = "purchase(1)"
                                class = "btn btn-danger"
                                type = "button"
                                v-if = "item && item['name'] === 'Python' && page.purchased[1] === 0 && page.pageIndex >= 2 && page.pageIndex < 5">
                            Purchase & Unlock
                        </button>
                        <button @click.prevent = "purchase(2)"
                                class = "btn btn-danger"
                                type = "button"
                                v-if = "item && item['name'] === 'HTML' && page.purchased[2] === 0 && page.pageIndex >= 2 && page.pageIndex < 5">
                            Purchase & Unlock
                        </button>

                        <div v-if = "item && (item['name'] === 'JAVA' || item['name'] === 'Python')">
                            <br> <br> <br> <br>
                            <h2 class = "free-h2">
                                <div class = "fre-title">
                                    <a href = "">Online Playground
                                    </a>
                                </div>
                            </h2>
                            <div class = "free-text">Type your code below to see install result using our compiler:</div>
                            <br>
                            <textarea rows = "10" style = "height : 240px" class = "input" name = "sourceCode" v-model = "sourceCode[0]" v-if = "item['name'] === 'JAVA'"></textarea>
                            <textarea rows = "10" style = "height : 240px" class = "input" name = "sourceCode" v-model = "sourceCode[1]" v-if = "item['name'] === 'Python'"></textarea>
                            <button class = "btn btn-primary" type = "button" @click.prevent = "runCode('modalEdit')">
                                RUN
                                <i :class = "[modalEdit.isSubmitting ? 'fas fa-spinner fa-spin' : 'fas fa-save']" aria-hidden = "true"></i>
                            </button>
                            <br> <br>
                            <h4> Output </h4>
                            <div class = "output-div" v-html = "outputResult"></div>
                        </div>
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
                page        : {
                    title      : 'Contacts',
                    subTitle   : 'View Various Data',
                    vuexKey    : null,
                    loading    : false,
                    searching  : false,
                    searchText : '',
                    searchType : 'jsText', // js, jsText or db
                    searchTitle: 'Enter keyword to search...',
                    ItemGetUrl : '/api/v1/auth/dashboard-info',
                    pageIndex  : 0,
                    purchased  : [0, 0, 0],
                },
                paginate    : ['items'],
                item        : null,
                sourceCode  : ['public class Main {\n' +
                '    public static void main(String[] args) {\n' +
                '      System.out.println("hello, world");\n' +
                '\n' +
                '      int x=10;\n' +
                '      int y=25;\n' +
                '      int z=x+y;\n' +
                '\n' +
                '      System.out.println("Sum of x+y = " + z);\n' +
                '    }\n' +
                '}', 'print("Hello World.");\n\n' +
                'list = [\'physics\', \'chemistry\', 1997, 2000];\n\n' +
                'print("List: ", list)\n'],
                language_id : ["27", "34"],
                outputResult: "Press Run to see Result.",
                modalEdit   : {
                    statusDiv   : {
                        show    : true,
                        class   : 'alert-json-error',
                        style   : '',
                        messages: [],
                    },
                    isSubmitting: false,
                    formKey     : 'modalEdit',
                    inputs      : [],
                },
            }
        },

        created() {
            // this.setLayout('layout-dashboard');
            // this.onLoadPageData(this.page.ItemGetUrl, null, this.page.vuexKey, 'loading', false, null);
            this.item = this.$route.params['item'];
            console.log('created: ', this.page.title, ': ', this.$route.params);
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
        },
        watch   : {},
        methods : {
            previousPage() {
                if (this.page.pageIndex > 0 && this.page.pageIndex <= 5) {
                    this.page.pageIndex--;
                }
            },
            nextPage() {
                if (this.page.pageIndex >= 0 && this.page.pageIndex < 5) {
                    this.page.pageIndex++;
                }
            },
            purchase(i) {
                this.$modal.show('dialog', {
                    title  : 'Confirmation of Purchase!',
                    text   : 'You can unlock the course by paying <b>RM 10.00</b>. Are you sure you want to purchase?',
                    buttons: [
                        {
                            title  : 'Yes',
                            handler: () => {
                                this.$modal.hide('dialog');
                                this.page.purchased[i] = 1;
                                let notifyData = {
                                    'group': 'edited',
                                    'type' : 'warn',
                                    'title': 'Purchased Successfully!',
                                    'text' : 'You have successfully unlock the course.'
                                };
                                this.$notify(notifyData);
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
            runCode0(formKey) {
                this[formKey].isSubmitting = true;
                this.outputResult = 'Processing';
                let postData = {
                    "script"      : "<?php echo \"Hellow PHP\" ?>",
                    "language"    : "php",
                    "versionIndex": "0",
                    "clientId"    : "dfaf1c558dc43412b835e5f995477a75",
                    "clientSecret": "6034ec4a80e202840a2930088d36b90ece0e01cf74f97cc09829c4bb3b138431"
                };
                axios({
                    method      : 'POST',
                    url         : 'https://api.jdoodle.com/v1/execute',
                    data        : postData,
                    responseType: 'json',
                }).then(response => {
                    console.log('response/data: ', response.data ? response.data : response);
                    if (response.data && response.data.token) {
                        this[formKey].isSubmitting = false;
                    } else {
                        this[formKey].isSubmitting = false;
                        this.outputResult = 'Error! Failed to Compile, Please check your code';
                        alert('Error, Data Not Found!')
                    }
                }).catch(error => {
                    this[formKey].isSubmitting = false;
                    this.outputResult = 'Error! Failed to Compile, Please check your code';
                    console.log('catch-error: ', error);
                    console.log('catch-error: response: ', error.response);
                    console.log('catch-error: request: ', error.request);
                    alert('Invalid, Please Try Again.')
                });
            },
            runCode(formKey) {
                this.outputResult = 'Processing...';
                this[formKey].isSubmitting = true;
                let postData = {
                    "source_code"                               : this.item['name'] === 'JAVA' ? this.sourceCode[0] : this.sourceCode[1],
                    "language_id"                               : this.item['name'] === 'JAVA' ? this.language_id[0] : this.language_id[1],
                    "number_of_runs"                            : "1",
                    "stdin"                                     : "Judge0",
                    "expected_output"                           : "hello, Judge0",
                    "cpu_time_limit"                            : "2",
                    "cpu_extra_time"                            : "0.5",
                    "wall_time_limit"                           : "5",
                    "memory_limit"                              : "128000",
                    "stack_limit"                               : "64000",
                    "max_processes_and_or_threads"              : "30",
                    "enable_per_process_and_thread_time_limit"  : false,
                    "enable_per_process_and_thread_memory_limit": true,
                    "max_file_size"                             : "1024"
                }
                axios({
                    method      : 'POST',
                    url         : 'https://api.judge0.com/submissions',
                    data        : postData,
                    responseType: 'json',/*
                    headers     : {
                        'Connection': 'keep-alive',
                    },*/
                }).then(response => {
                    console.log('response/data: ', response.data ? response.data : response);
                    if (response.data && response.data.token) {
                        setTimeout(() => {
                            this.runCode2(formKey, response.data.token);
                        }, 5000)
                    } else {
                        this.outputResult = 'Error! Failed to Compile, Please check your code';
                        alert('Error, Data Not Found!');
                        this[formKey].statusDiv.messages.push('Error, Data Not Found!');
                    }
                }).catch(error => {
                    this[formKey].isSubmitting = false;
                    this.outputResult = 'Error! Failed to Compile, Please check your code';
                    console.log('catch-error: ', error);
                    console.log('catch-error: response: ', error.response);
                    console.log('catch-error: request: ', error.request);
                    alert('Invalid, Please Try Again.')
                });
            },
            runCode2(formKey, token) {
                const api = 'https://api.judge0.com/submissions/' + token;
                axios({
                    method : 'GET',
                    url    : api,
                    timeout: 8000,
                }).then(response => {
                    this[formKey].isSubmitting = false;
                    console.log('response/data: ', response.data ? response.data : response, api);
                    console.log('response/data: ', response.data['stdout']);
                    if (response.data && response.data.time) {
                        this[formKey].isSubmitting = false;
                        this.outputResult = response.data['stdout'];
                    } else {
                        this[formKey].isSubmitting = false;
                        this.outputResult = 'Error! Failed to Compile, Please check your code';
                        alert('Error, Data Not Found!')
                        this[formKey].statusDiv.messages.push('Error, Data Not Found!');
                    }
                }).catch(error => {
                    this[formKey].isSubmitting = false;
                    this.outputResult = 'Error! Failed to Compile, Please check your code';
                    console.log('catch-error: ', error);
                    console.log('catch-error: response: ', error.response);
                    console.log('catch-error: request: ', error.request);
                    alert('Invalid, Please Try Again.')
                });/*
                let _this = this;
                const api = 'https://api.judge0.com/submissions/' + token;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        _this[formKey].isSubmitting = false;
                        console.log('response/data: ', xhr.responseText);
                    } else {
                        // _this[formKey].isSubmitting = false;
                        // alert('Error, Data Not Found!');
                    }
                }
                xhr.open('GET', api, true);
                xhr.send(null);*/
            }
        }
    }
</script>
