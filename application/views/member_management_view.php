<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link active" href="<?php echo base_url('member_management') ?>">會員管理</a>
            <a class="nav-link" href="<?php echo base_url('member_management/check') ?>">會員名單確認</a>
        </nav>
    </div>

    <div class="container">
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h5 class="border-bottom border-gray pb-2 mb-0">會員管理</h5>
            <div style="padding-top: 1em">
                <button type="button" class="btn btn-primary"  data-toggle="modal" data-target=".add-modal">新增繳費班級</button>
                <button type="button" class="btn btn-success"  data-toggle="modal" data-target=".edit-modal">新增補繳會員</button>
            </div>
            <div class="media text-muted pt-3">
                <table id="memberTable" class="table table-striped table-bordered" style="color: black;background-color:white;">
                    <thead>
                        <tr>
                            <th style="width: 10%">功能</th>
                            <th style="width: 25%">系級</th>
                            <th style="width: 25%">學制</th>
                            <th style="width: 25%">班級</th>
                            <th style="width: 35%">學號</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php $this->load->view('basic/system/jsLoad'); ?>
    <script src="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.js"></script>
    <script src="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>

    <!-- 新增 -->
    <?php  $this->load->view('member/add'); ?>
    <!-- 新增 -->

    <!-- 補繳 -->
    <?php  $this->load->view('member/edit'); ?>
    <!-- 補繳 -->

    <script type="text/javascript">
        $(window).load(function() {
            loadTable();
        });

        function loadTable(){
             $('#memberTable').DataTable({
                "language": {
                    "lengthMenu": "顯示 _MENU_ 筆消息",
                    "emptyTab le": "沒有資料",
                    "info": "目前顯示 _START_ 至 _END_ 筆的資料，共 _TOTAL_ 筆資料",
                    "infoFiltered": "，從 _MAX_ 筆資料中過濾",
                    "infoEmpty": "沒有資料能夠顯示",
                    "zeroRecords":"沒有資料，可以鍵入其他內容進行搜索",
                    "search": "搜索會員：",
                    "paginate": {
                        "next": "下一頁",
                        "previous": "上一頁"
                    },
                },
                bServerSide : true,
                bStateSave : true,
                destroy: true,
                "ajax":{
                    url:base_url('member_management/datatable'),
                    type:'POST',
                    data:{
                        classValue :"",
                        systemValue:"",
                        classKey:""
                    }
                }
            });
            $('#memberTable_wrapper').css({"width":"100%","margin-right":"auto","margin-left":"auto"});
            $('#memberTable').attr('class','table table-hover  dataTable no-footer');
        }

        function delMember(str){
            if(confirm('確定要刪除這個會員？這個動作無法回復！')){
                $.ajax({
                    url: base_url('member_management/delMember'),
                    type: 'POST',
                    dataType: 'text',
                    data: {id:str},
                })
                .done(function(e) {
                    if(e==0){
                        alert('資料庫連線失敗，請重新送出');
                    }else if (e == 1){
                        alert('成功');
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
    </script>


</body>
</html>
