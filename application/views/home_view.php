<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $this->load->view('basic/cssLoad'); ?>
    <!-- datatable -->
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">

    <style>
        #notice_text > p {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        
    </style>
</head>

<body>
    
    <?php $this->load->view('basic/navBar'); ?>

    <!-- header area end -->
    <!-- 輪播 -->
    <div class="slider-area s2-style owl-carousel ht_mt-75">
        <div class="slider-item" style="background: url(<?php echo base_url('dist/') ?>assets/images/header/01.jpg) center/cover no-repeat">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="slider-content">
                            <h2>交給我們吧</h2>
                            <h2>大學生活的最後一哩路</h2>
                            <p>我們將替你的大學生活畫下完美句點。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-item" style="background: url(<?php echo base_url('dist/') ?>assets/images/header/02.jpg) center/cover no-repeat">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="slider-content">
                            <h2>恭喜你</h2>
                            <h2>即將踏入新的歷程</h2>
                            <p>隨時關注本網站，參與畢業生系列活動，與我們一同狂歡！</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider area end -->

    <!-- 最新消息 -->
    <div class="case-study case-grid bg-gray ptb--100">
        <div class="container">
            <div class="section-title">
                <h2>最新消息</h2>
            </div>
            <div class="row">
                <table id="noticeTable" class="table table-striped table-bordered" style="color: black;background-color:white; ">
					<thead>
						<tr>
							<th style="width: 70%">標題</th>
							<th>發布時間</th>
						</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>
    
    <!-- case-study area end -->
    <!-- <div class="about-area ptb--100" style="padding-top: 100px;padding-bottom: 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="abt-left">
                        <span>樹德科技大學109th畢業歌</span>
                        <h2>方向感</h2>
                        <p>畢業的季節即將來臨<br>
                            新生入學彷彿是昨天的事<br>
                            還記得一起奮鬥做報告、<br>
                            一起揪團出去玩、<br>
                            一起並肩走在校園的點點滴滴嗎？
                        </p>
                    </div>
                </div>
                <div class="col-lg-9">
                    <iframe style="width: 100%" height="541" src="https://www.youtube.com/embed/OvNNusaaAL4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div> -->

    <!-- 本會職責 -->
    <div class="special-service sps2-style pt--100 pb--70">
        <div class="container">
            <div class="section-title">
                <h2>本會職責</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="sp-service">
                        <div class="icon">
                            <i class="fa fa-street-view"></i>
                        </div>
                        <div class="content">
                            <h2>專屬於你</h2>
                            <p>專門服務109級畢業生，在畢業前夕以各式各樣的活動充實最後的大學生活！</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sp-service">
                        <div class="icon">
                            <i class="fa fa-camera-retro"></i>
                        </div>
                        <div class="content">
                            <h2>喀嚓</h2>
                            <p>提供畢業生的畢業照拍攝，修片、佈景通通交給我們！為你留下最棒的回憶。</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sp-service">
                        <div class="icon">
                            <i class="fa fa-music"></i>
                        </div>
                        <div class="content">
                            <h2>畢業歌</h2>
                            <p>我們將負責109級畢業典禮的畢業歌曲，徵選最棒的畢業取以及製做充滿回憶的音樂錄影帶。</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sp-service">
                        <div class="icon">
                            <i class="fa fa-usd"></i>
                        </div>
                        <div class="content">
                            <h2>財務透明</h2>
                            <p>我們將提供明確的財務報表，讓你可以隨時掌握畢聯會的花費狀況，讓您安心繳納畢聯會費！</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sp-service">
                        <div class="icon">
                            <i class="fa fa-compass"></i>
                        </div>
                        <div class="content">
                            <h2>重點服務</h2>
                            <p>對於我們來說，畢業是所有人的大事，我們將提供高品質的服務與友善的交流。</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="sp-service">
                        <div class="icon">
                            <i class="fa fa-comment"></i>
                        </div>
                        <div class="content">
                            <h2>重要資訊</h2>
                            <p>我們將舉辦畢業班代表大會，並隨時更新畢業生相關資訊於本網站，讓你不錯過任何重要訊息！</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 本會職責 -->


<?php /*
    <!-- feature blog area start -->
    <div class="feature-blog-area ptb--100">
        <div class="container">
            <div class="section-title">
                <h2>BLOG</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-blog">
                        <div class="s_thumb">
                            <a href="blog.html">
                                <img src="<?php echo base_url('dist/') ?>assets/images/blog/01.jpg" alt="image">
                            </a>
                        </div>
                        <div class="s_conent">
                            <ul class="fblog-meta">
                                <li>
                                    <i class="fa fa-clock-o"></i>2018/09/20</li>
                            </ul>
                            <h2>
                                <a href="blog.html">標題標題標題標題</a>
                            </h2>
                            <p>簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述，簡述簡述簡述簡述簡述簡述，簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述簡述。</p>
                            <div class="btm-btns">
                                <a class="read_more" href="blog.html">看更多</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- feature blog area end -->
    */
?>
    <!-- 查閱 -->
    <div class="modal fade view-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <h2 id="notice_date" style="text-align: center;font-family: 'Oswald',sans-serif !important;font-weight: 100;color: #00d038;font-size: 5rem;letter-spacing: 3px;line-height:1.1;padding-top: 10px">27</h2>
                    <h3 id="notice_year" style="text-align: center;font-family: 'Oswald',sans-serif !important;font-weight: 100;color: #00d038;font-size: 2rem;margin: 2px;">2018</h3>
                    <b><p id="notice_title" style="text-align: center; font-weight: normal;font-size: 3rem;font-family: 微軟正黑體,Arial,Helvetica,sans-serif !important;">123</p></b>
                    <div id="notice_text" style="padding-bottom: 2em;padding-left: 1em;padding-right: 1em;">
                        123456
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 查閱 -->

    <?php $this->load->view('basic/footer'); ?>
    <?php $this->load->view('basic/jsLoad'); ?>
    
    <!-- datatable -->
    <script src="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.js"></script>
    <script src="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>


    <script>
    	$(window).load(function() {
			loadTable();
		});
    	function loadTable(){
			$('#noticeTable').DataTable({
				"language": {
					"lengthMenu": "顯示 _MENU_ 筆消息",
					"emptyTable": "沒有資料",
					"info": "目前顯示 _START_ 至 _END_ 筆的資料，共 _TOTAL_ 筆資料",
					"infoFiltered": "，從 _MAX_ 筆資料中過濾",
					"infoEmpty": "沒有資料能夠顯示",
					"zeroRecords":"沒有資料，可以鍵入其他內容進行搜索",
					"search": "搜索消息：",
					"paginate": {
						"next": "下一頁",
						"previous": "上一頁"
					},
				},
				destroy: true,
				lengthChange: false,
				searching: false,
				info:false,
				"ajax":{
                    url:base_url('home/getNotice'),
                    type:'POST'
                }
			});
			$('#noticeTable_wrapper').css({"width":"90%","margin-right":"auto","margin-left":"auto"});
			$('#noticeTable').attr('class','table table-hover  dataTable no-footer');
		}
        function viewNotice(str){
            $.ajax({
                url: base_url('home/viewNotice'),
                type: 'POST',
                dataType: 'json',
                data: {id: str}
            })
            .done(function(json) {
                $('#notice_date').html(json['date']);
                $('#notice_year').html(json['year']);
                $('#notice_title').html(json['title']);
                $('#notice_text').html(json['content']);
                $('.view-modal').modal('show');
            })
            .fail(function() {
                alert('無法取得公告內容，請再試一次');
            });
        }
    </script>


</body>

</html>
