<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <a class="logoText navbar-brand mr-auto mr-lg-0" href="#">STUGSA後台</a>
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <?php
              /**
               * 自動載入menu內容
               */
              $thisIndex = $menu[0];
              for($i=1;$i<count($menu);$i++){
                  if($menu[$i]['key'] == $thisIndex){
                      echo '<li class="nav-item active">';
                  }else{
                      echo '<li class="nav-item">';
                  }
                  echo '<a class="nav-link" href="'.base_url($menu[$i]['key']).'">'.$menu[$i]['name'].'</a></li>';
              }
          ?>
        </ul>
    <form class="form-inline my-2 my-lg-0" action="">
      <a class="btn btn-outline-primary my-2 my-sm-0" href="<?php echo base_url() ?>" target="_blank">打開使用者首頁</a>　
        <a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo base_url('login/logout') ?>">登出</a>
    </form>
    </div>
</nav>