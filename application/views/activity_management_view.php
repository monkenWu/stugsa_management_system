<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
    <style>
        text{
            color: red;
        }   
    </style>
</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link active" href="<?php echo base_url('activity_management') ?>">活動管理</a>
            <a class="nav-link" href="<?php echo base_url('activity_management/checkin') ?>">活動簽到</a>
            <a class="nav-link" href="<?php echo base_url('activity_management/result') ?>">輸出報表</a>
        </nav>
    </div>

    <div class="container">
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h5 class="border-bottom border-gray pb-2 mb-0">活動管理</h5>
            <div style="padding-top: 1em">
                <button type="button" class="btn btn-primary"  data-toggle="modal" data-target=".add-modal">新增活動</button>
            </div>
            <div class="media text-muted pt-3">
                <table id="activityTable" class="table table-striped table-bordered" style="color: black;background-color:white;">
                    <thead>
                        <tr>
                            <th style="width: 26%">功能</th>
                            <th style="width: 20%">活動名稱</th>
                            <th style="width: 10%">回饋量表</th>
                            <th style="width: 22%">開始時間</th>
                            <th style="width: 22%">結束時間</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <!-- 新增 -->
    <?php  $this->load->view('activity/main/add'); ?>
    <!-- 新增 -->

    <!-- 修改 -->
    <?php  $this->load->view('activity/main/edit'); ?>
    <!-- 修改 -->

    <!-- 統計 -->
    <?php  $this->load->view('activity/main/chart'); ?>
    <!-- 統計 -->

    <script>
        $(window).load(function() {
            loadTable();
        });

        function loadTable(){
             $('#activityTable').DataTable({
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
                    url:base_url('activity_management/datatable'),
                    type:'POST'
                }
            });
            $('#activityTable_wrapper').css({"width":"100%","margin-right":"auto","margin-left":"auto"});
            $('#activityTable').attr('class','table table-hover  dataTable no-footer');
        }

        function delActivity(key){
            if(confirm('確定要刪除活動嗎？這個動作無法還原')){
                $.ajax({
                    url: base_url('activity_management/delActivity'),
                    type: 'POST',
                    dataType: 'json',
                    data: {key : key},
                })
                .done(function(e) {
                    if(e.status == 1){
                        alert('刪除成功');
                        loadTable();
                    }else if(e.status == 0){
                        alert('這個活動已有簽到記錄，為求資料完整性無法刪除這個活動。');
                    }else{
                        alert('未知的錯誤。');
                    }
                })
                .fail(function() {
                    alert('伺服器連線失敗，請確認網路連線或重新送出');
                });
            }
        }


    </script>
</body>
</html>
