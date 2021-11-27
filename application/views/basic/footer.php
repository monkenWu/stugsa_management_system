<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="262825057772122"
  logged_in_greeting="需要幫忙嗎？"
  logged_out_greeting="需要幫忙嗎？">
</div>

<footer>
    <!-- footer top area start -->
    <div class="footer-top ptb--100">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widget widget_company">
                        <a href="index.html">
                            <!-- <img src="<?php echo base_url('dist/') ?>assets/images/icon/logo-black.png" alt="logo"> -->
                        </a>
                        <p>不要錯過你的權益，關注我們的社群平台，你將可以獲取最新的畢業生訊息！</p>
                        <ul class="f_social">
                            <li>
                                <a href="https://www.facebook.com/pg/109STUGSA" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="widget widget_quick-link">
                        <h2 class="fwidget-title">快速連結</h2>
                        <ul class="quick-links">
                            <li>
                                <a title="" href="<?php echo base_url()?>"> 首頁 </a>
                            </li>
                            <li>
                                <a title="" href="<?php echo base_url('calendar')?>"> 行事曆 </a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget widget_categories">
                        <h2 class="fwidget-title">　　</h2>
                        <ul class="categories_list">
                           <li>
                                <a title="" href="<?php echo base_url('finance')?>"> 財務徵信</a>
                            </li>
                            <li>
                                <a title="" href="<?php echo base_url('about')?>"> 本會職能</a>
                            </li>
                            <li>
                                <a title="" href="<?php echo base_url('contact')?>"> 聯絡我們</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget widget_recent-post">
                        <h2 class="fwidget-title">指導單位</h2>
                        <div class="f_recent-post">
                            <div class="fs-post">
                                <h2>
                                    <a target="_blank" href="http://activity.sao.stu.edu.tw/main.php">樹德科技大學學生事務處課外活動暨服務學習組</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer top area end -->
    <!-- footer bottom area start -->
    <div class="footer-bottom">
        <div class="container">
            <p>COPYRIGHT 2019 STUGA-樹德科技大學109級畢業生聯合會.版權所有</p>
			<p>Author by 資訊工程系-WU,MENG-XIAN , YEH CHUN-WEI</>
        </div>
    </div>
    <!-- footer bottom area end -->
</footer>