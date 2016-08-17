<?php /* Template Name: Download page */ ?>

<?php get_header(); ?>

<div class="header">
        <div class="container">
            <i class="material-icons">get_app</i>
            <h1>Downloads</h1>
        </div>
    </div>
    <div class="content downloads">
        <div class="container">
            <div class="row">
                <div id="detect" class="col s12">
                </div>
                <div class="col s6 m3">
                    <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20Windows/">
                        <div class="card waves-effect waves-pink waves-block">
                            <div class="card-content">
                                <img src="<?php bloginfo('template_url');?>/img/windows.png" alt="">
                            </div>
                            <div class="card-action center">
                                Windows
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s6 m3">
                    <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20Linux/">
                        <div class="card waves-effect waves-block">
                            <div class="card-content">
                                <img src="<?php bloginfo('template_url');?>/img/linux.png" alt="">
                            </div>
                            <div class="card-action center">
                                Linux
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col s6 m3">
                    <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20Mac%20OS%20X/">
                        <div class="card waves-effect waves-block">
                            <div class="card-content">
                                <img src="<?php bloginfo('template_url');?>/img/macos.png" alt="">
                            </div>
                            <div class="card-action center">
                                macOS
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col m6 s12">
                    <div class="card">
                        <ul class="collection other-downloads">
                            <li class="waves-effect waves-block">
                                <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20External%20Plugins/">
                                External plugins
                                </a>
                            </li>
                            <li class="waves-effect waves-block">
                                <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20Source/">
                                Source Code
                                </a>
                            </li>
                            <li class="waves-effect waves-block">
                                <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20Runtime%20Libraries/">
                                Runtime Libraries
                                </a>
                            </li>
                            <li class="waves-effect waves-block">
                                <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20Virtual%20Machines/">
                                Virtual Machines
                                </a>
                            </li>
                            <li class="waves-effect waves-block">
                                <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20BSD/">
                                BSD
                                </a>
                            </li>
                            <li class="waves-effect waves-block">
                                <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20Solaris/">
                                Solaris
                                </a>
                            </li>
                            <li class="waves-effect waves-block">
                                <a href="https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20IRIX/">
                                IRIX
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // OS Detect
    if (navigator.appVersion.indexOf("Win")!=-1) {
        document.getElementById("detect").innerHTML = "<h5>Download BRL-CAD for Windows</h5><a class='btn green white-text waves-effect waves-light' href='https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20Windows/'>Download</a>"
    }
    else if (navigator.appVersion.indexOf("Mac")!=-1) {
        document.getElementById("detect").innerHTML = "<h5>Download BRL-CAD for macOS</h5><a class='btn green white-text waves-effect waves-light' href='https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20Mac%20OS%20X/'>Download</a>"
    }
    else if (navigator.appVersion.indexOf("Linux")!=-1) {
        document.getElementById("detect").innerHTML = "<h5>Download BRL-CAD for Linux</h5><a class='btn green white-text waves-effect waves-light' href='https://sourceforge.net/projects/brlcad/files/BRL-CAD%20for%20Linux/'>Download</a>"
    }
    else {
        document.getElementById("detect").style.display = "none";
    }  
    </script>

<?php get_footer(); ?>