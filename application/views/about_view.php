<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $this->load->view('basic/cssLoad'); ?>
</head>

<body>

    <?php $this->load->view('basic/navBar'); ?>
    <?php $this->load->view('basic/crumbsArea'); ?>    
    <!-- service area start -->
    <div class="service-details ptb--100">
        <div class="container">
            <div class="row">
                <!-- main content start -->
                <div class=" col-md-12">
                    <div class="s_content-details">
                        <div class="s_thumb text-center">
                            <img src="<?php echo base_url() ?>dist/assets/images/about/01.jpg" alt="image">
                        </div>
                        <h2>
                            <a href="javascript:void(0)">第一章 總則</a>
                        </h2>
                        <p>第一條　依據本校學生自治團體設置及輔導辦法第三條成立應屆畢業生聯合會（以下簡稱畢聯會）及樹德科技大學應屆畢業生聯合會組織章程（以下簡稱本章程）。<br>第二條　本會宗旨為辦理本校畢業季相關活動及辦理畢業照拍攝業務等事宜，以聯絡應屆畢業學生感情。</p>

                        <h2>
                            <a href="javascript:void(0)">第二章 會員權利及義務</a>
                        </h2>
                        <p></p>
                        <p>第三條　本校應屆畢業生為本會當然會員；繳交會費者使得為本會優先會員。會員權利義務行使時間為應屆畢業學年度。<br>第四條　當然會員享有下列權利：<br>　　一、  透過畢業班學生代表向本會反映意見。<br>　　二、  選舉及罷免本會會長及該班畢代之權利。<br>　　三、  參加本會舉辦之任何活動。<br>第五條　優先會員享有下列權利：<br>　　一、  享有當然會員之權利。<br>　　二、  優先參加本會各項活動並享有活動優待及特別活動參與權利。<br>第六條　會員應盡下列義務：<br>　　一、維護本會聲譽。<br>　　二、會員有繳交會費之義務。<br>　　三、遵守本章程及畢業班學生代表會議之決議。</p>

                        <a class="text-center btn btn-outline-success" href="<?php echo base_url('dist/畢聯會組織章程.pdf') ?>" target="_blank">畢業生聯合會組織章程</a>
                    </div>
                </div>
                <!-- main content end -->
            </div>
        </div>
    </div>
    <!-- service area end -->
    <?php $this->load->view('basic/footer'); ?>
    <?php $this->load->view('basic/jsLoad'); ?>
</body>

</html>
