<?php 
session_start();
include( $_SERVER['DOCUMENT_ROOT'] . "/../bb0/config.php");
require_once 'check-session.php';
require_once 'components.php';
?>
    <body>
        <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-boxed">

            <nav id="sidebar">
                <!-- Sidebar Scroll Container -->
                <div id="sidebar-scroll">
                    <!-- Sidebar Content -->
                    <div class="sidebar-content">
                        <!-- Side Header -->
                        <div class="content-header content-header-fullrow px-15">
                            <!-- Mini Mode -->
                            <div class="content-header-section sidebar-mini-visible-b">
                                <!-- Logo -->
                                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                    <span class="text-dual-primary-dark">c</span><span class="text-info">b</span>
                                </span>
                                <!-- END Logo -->
                            </div>
                            <!-- END Mini Mode -->

                            <!-- Normal Mode -->
                            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                                <!-- END Close Sidebar -->

                                <!-- Logo -->
                                <div class="content-header-item">
                                    <a class="link-effect font-w700" href="#">
                                        <i class="si si-fire text-primary"></i>
                                        <span class="font-size-xl text-dual-primary-dark">Ikan</span><span class="font-size-xl text-info">Ku</span>
                                    </a>
                                </div>
                                <!-- END Logo -->
                            </div>
                            <!-- END Normal Mode -->
                        </div>
                        <!-- END Side Header -->

                        <!-- Side User -->
                        <div class="content-side content-side-full content-side-user px-10 align-parent">
                            <!-- Visible only in mini mode -->
                            <!-- END Visible only in mini mode -->

                            <!-- Visible only in normal mode -->
                            <div class="sidebar-mini-hidden-b text-center">
                                <ul class="list-inline mt-10">
                                    <li class="list-inline-item">
                                        <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="#">
                                            <?php
                                            $nama = explode(' ', $_SESSION['full_name']);
                                            echo $nama[0];
                                            ?>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="profile">
                                            <i class="si si-user"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="link-effect text-dual-primary-dark" href="../logout<?php echo $ext ?>">
                                            <i class="si si-power"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- END Visible only in normal mode -->
                        </div>
                        <!-- END Side User -->

                        <!-- Side Navigation -->
                        <div class="content-side content-side-full">
                            <ul class="nav-main">
                                <li>
                                    <a class="active nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-cup"></i><span class="sidebar-mini-hide">BERANDA</span></a>
                                    <ul>
                                        <li>
                                            <a href="report.php">Laporan</a>
                                        </li>
                                    </ul>                              
                                </li>
                                <?php
                                foreach($_SESSION['nav_header'] as $key => $value)  { ?>
                                <li>
                                    <a class="active nav-submenu" data-toggle="nav-submenu" href="#"><i class="<?php echo $value['header_icon'] ?>"></i><span class="sidebar-mini-hide"><?php echo $value['header_name'] ?></span></a>
                                    <ul>
                                        <?php
                                        foreach($_SESSION['nav_items'] as $key2 => $value2) {
                                            if($value['header_id']==$value2['nav_header_id']) {
                                            $url_menu = explode('.', $value2['url']);

                                            if($ext <> '') { $url = $url_menu[1]; } 
                                        ?>
                                        <li>
                                            <a href="<?php echo $url_menu[0].$ext ?>"><?php echo $value2['name'] ?></a>
                                        </li>
                                        <?php }} ?>
                                    </ul>
                                </li>
                                <?php } ?>                                
                            </ul>
                        </div>
                        <!-- END Side Navigation -->
                    </div>
                    <!-- Sidebar Content -->
                </div>
                <!-- END Sidebar Scroll Container -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- END Toggle Sidebar -->
                    </div>
                    <!-- END Left Section -->
                </div>
                <!-- END Header Content -->
            </header>
            <!-- END Header -->