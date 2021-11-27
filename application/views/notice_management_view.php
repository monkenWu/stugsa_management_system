<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
    <!-- datatable -->
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/summernote/summernote-bs4.css">
    <style>
        .functions-btn{
            margin-right: 1em;
        }
    </style>
</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link active" href="#">公告管理（新增修改移除公告）</a>
        </nav>
    </div>

    <div class="container">
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h5 class="border-bottom border-gray pb-2 mb-0">公告管理</h5>
            <div style="padding-top: 1em">
                <button type="button" class="btn btn-primary"  data-toggle="modal" data-target=".add-modal">新增公告</button>
            </div>
            <div class="media text-muted pt-3">
                <table id="noticeTable" class="table table-striped table-bordered" style="color: black;background-color:white;">
                    <thead>
                        <tr>
                            <th style="width: 25%">功能</th>
                            <th style="width: 55%">標題</th>
                            <th style="width: 20%">發布時間</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- 新增 -->
    <div class="modal fade add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新增公告</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_notice_title">公告標題</label>
                        <input type="text" class="form-control" id="add_notice_title" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="summernote">公告內容</label>
                        <div id="summernote_add"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-primary" onclick="addNotice()">送出公告</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 新增 -->

    <!-- 查閱 -->
    <div class="modal fade view-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <h2 id="notice_date" style="text-align: center;font-family: 'Oswald',sans-serif !important;font-weight: 100;color: #00d038;font-size: 3rem;letter-spacing: 3px;line-height:1.1;padding-top: 10px">27</h2>
                    <h3 id="notice_year" style="text-align: center;font-family: 'Oswald',sans-serif !important;font-weight: 100;color: #00d038;font-size: 1rem;margin: 2px;">2018</h3>
                    <b><p id="notice_title" style="text-align: center; font-weight: normal;font-size: 2rem;font-family: 微軟正黑體,Arial,Helvetica,sans-serif !important;">123</p></b>
                    <div id="notice_text" style="padding-bottom: 2em;padding-left: 1em;padding-right: 1em;">
                        123456
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 查閱 -->

    <!-- 修改 -->
    <div class="modal fade edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">修改公告</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_notice_title">公告標題</label>
                        <input type="text" class="form-control" id="edit_notice_title" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="summernote_edit">公告內容</label>
                        <div id="summernote_edit"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="editNoticeSubmit()">修改公告</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 修改 -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php $this->load->view('basic/system/jsLoad'); ?>
    <!-- datatable -->
    <script src="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.js"></script>
    <script src="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url('dist/') ?>assets/js/summernote/summernote-bs4.js"></script>
    <script src="<?php echo base_url('dist/') ?>assets/js/summernote/lang/summernote-zh-TW.min.js"></script>
    <script>
        $(window).load(function() {
            loadTable();
            $('#summernote_add').summernote({
                height: 300,
                lang: 'zh-TW',
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert',['link','table','picture']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        uploadPicture(files[0],'add');
                    }
                }
            });
            $('#summernote_edit').summernote({
                height: 300,
                lang: 'zh-TW',
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert',['link','table','picture']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        uploadPicture(files[0],'edit');
                    }
                }
            });
            editId = "";
        });

        function uploadPicture(file,obName){
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: base_url('notice_management/uploadPicture'),
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    var image = $('<img>').attr('src', url);
                    $('#summernote_'+obName).summernote('insertNode',image[0]);
                }
            });
        }

        function addNotice(){
            if(!$('#summernote_add').summernote('isEmpty')){
                var title = $('#add_notice_title').val();
                var code = $('#summernote_add').summernote('code');
                $.ajax({
                    url: base_url('notice_management/addNotice'),
                    type: 'POST',
                    dataType: 'text',
                    data: {title:title,
                           content:code},
                })
                .done(function(e) {
                    if(e==0){
                        alert('標題或內容請勿為空');
                    }else if(e == 2){
                        alert('資料庫連線失敗，請重新送出');
                    }else if (e == 1){
                        alert('新增成功！');
                        $('.add-modal').modal('hide');
                        loadTable();
                        $('#summernote_add').summernote('reset');
                        $('#add_notice_title').val('');
                    }else{
                        alert('未知的錯誤，若重複發生請洽系統管理員。');
                    }
                })
                .fail(function() {
                    alert('伺服器連線失敗，請重新送出');
                });
            }else{
                alert('內容請勿為空');
            }
        }

        function openNotice(str){
            $.ajax({
                url: base_url('notice_management/viewNotice'),
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

        function editNotice (str){
            editId = str;
            $.ajax({
                url: base_url('notice_management/viewNotice'),
                type: 'POST',
                dataType: 'json',
                data: {id: str}
                })
                .done(function(json) {
                    $('#edit_notice_title').val(json['title']);
                    $('#summernote_edit').summernote('reset');
                    $('#summernote_edit').summernote('code',json['content']);
                    $('.edit-modal').modal('show');
                })
                .fail(function() {
                    alert('無法取得公告內容，請再試一次');
            });
        }

        function editNoticeSubmit(){
            if(!$('#summernote_edit').summernote('isEmpty')){
                var title = $('#edit_notice_title').val();
                var code = $('#summernote_edit').summernote('code');
                $.ajax({
                    url: base_url('notice_management/editNotice'),
                    type: 'POST',
                    dataType: 'text',
                    data: {title:title,
                           content:code,
                           id:editId},
                })
                .done(function(e) {
                    if(e==0){
                        alert('標題或內容請勿為空');
                    }else if(e == 2){
                        alert('資料庫連線失敗，請重新送出');
                    }else if (e == 1){
                        alert('修改成功！');
                        $('.edit-modal').modal('hide');
                        loadTable();
                    }else{
                        alert('未知的錯誤，若重複發生請洽系統管理員。');
                    }
                })
                .fail(function() {
                    alert('伺服器連線失敗，請重新送出');
                });
            }else{
                alert('內容請勿為空');
            }
        }

        function delNotice(str){
            if(confirm("你確定要刪除這筆公告嗎？這個動作無法回朔！")){
                $.ajax({
                    url: base_url('notice_management/delNotice'),
                    type: 'POST',
                    dataType: 'text',
                    data: {id:str},
                })
                .done(function(e) {
                    if(e==0){
                        alert('資料庫連線失敗，請重新送出');
                    }else if (e == 1){
                        loadTable();
                    }else{
                        alert('未知的錯誤，若重複發生請洽系統管理員。');
                    }
                })
                .fail(function() {
                    alert('伺服器連線失敗，請重新送出');
                });
            }
        }

        function loadTable(){
            $('#noticeTable').DataTable({
                "language": {
                    "lengthMenu": "顯示 _MENU_ 筆消息",
                    "emptyTab le": "沒有資料",
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
                "ajax":{
                    url:base_url('notice_management/datatable'),
                    type:'POST'
                }
            });
            $('#noticeTable_wrapper').css({"width":"100%","margin-right":"auto","margin-left":"auto"});
            $('#noticeTable').attr('class','table table-hover  dataTable no-footer');
        }

    </script>

</body>
</html>
