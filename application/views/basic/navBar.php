<!-- preloader area start -->
<div id="preloader">
    <img src="<?php echo base_url('dist/') ?>assets/images/icon/loader.gif" alt="prealoader">
</div>
<!-- prealoader area end -->
<!-- header area start -->
<header id="header">
    
    <!-- header bottom area start -->
    <div class="header-bottom hb2-style bg-theme sticky-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-sm-5">
                    <div class="logo">
                        <a href="<?php echo base_url() ?>">
                            <img src="<?php echo base_url('dist/') ?>assets/images/icon/logo-rm.png" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 d-none d-lg-block">
                    <div class="main-menu">
                        <nav>
                            <ul id="nav_mobile_menu">
                                <?php
                                    /**
                                     * 自動載入menu內容
                                     */
                                    $thisIndex = $menu[0];
                                    for($i=1;$i<count($menu);$i++){
                                        if($menu[$i]['key'] == $thisIndex){
                                            echo '<li class="active">';
                                        }else{
                                            echo '<li>';
                                        }
                                        if($menu[$i]['multi']){
                                            $child = $menu[$i]['child'];
                                            echo '<a href="javascript:void(0)">'.$menu[$i]['name'].'</a><ul class="submenu">';
                                            for($j=0;$j<count($child);$j++){
                                                if($child[$j]['href']){
                                                   echo '<li><a href="'.$child[$j]['key'].'" target="_blank">'.$child[$j]['name'].'</a></li>';
                                                }else{
                                                    echo '<li><a href="'.base_url($child[$j]['key']).'">'.$child[$j]['name'].'</a></li>';
                                                }
                                            }
                                            echo '</ul></li>';
                                        }else{
                                            echo '<a href="'.base_url($menu[$i]['key']).'">'.$menu[$i]['name'].'</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-12 d-block d-lg-none">
                    <div id="mobile_menu"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- header bottom area end -->
</header>