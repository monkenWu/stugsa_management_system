<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <style media="print">
        .table-bordered,
        .table-bordered th,
        .table-bordered td{
            border: 1px solid #000000!important;
        }
    </style>

</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link" href="<?php echo base_url('activity_management') ?>">活動管理</a>
            <a class="nav-link" href="<?php echo base_url('activity_management/checkin') ?>">活動簽到</a>
            <a class="nav-link active" href="<?php echo base_url('activity_management/result') ?>">輸出報表</a>
        </nav>
    </div>

    <div class="container" >

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">輸出報表</h6>
            <div class="media text-muted pt-3">
                <table id="activityTable" class="table table-striped table-bordered" style="color: black;background-color:white;">
                    <thead>
                        <tr>
                            <th style="width: 20%">功能</th>
                            <th style="width: 30%">活動名稱</th>
                            <th style="width: 25%">開始時間</th>
                            <th style="width: 25%">結束時間</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>

    <div class="container" id="print">
        
        
           
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php $this->load->view('basic/system/jsLoad'); ?>
    <script src="<?php echo base_url('dist/') ?>assets/js/datatable/datatables.min.js"></script>
    <script src="<?php echo base_url('dist/') ?>assets/js/datatable/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>
         $(window).load(function() {
            loadTable();
            //$("#print").hide();
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
                    url:base_url('activity_management/resultDatatable'),
                    type:'POST'
                }
            });
            $('#activityTable_wrapper').css({"width":"100%","margin-right":"auto","margin-left":"auto"});
            $('#activityTable').attr('class','table table-hover  dataTable no-footer');
        }

        function unJoinActivity(a_key){
            $.ajax({
                url: base_url('activity_management/getUnJoinMemberList'),
                type: 'POST',
                dataType: 'json',
                data: {a_key : a_key},
            })
            .done(function(e) {
                for(var i=0; i<e.length ;i++){
                    $('#print').append(`
                        <h4 class="text-center" style="padding-bottom: 15px"><b>尚未參與${e[0]['a_name']}之名單</b></h4>
                    `);
                    var nowHtml = `
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-right">活動名稱：</th>
                                    <td>${e[i]['a_name']}</td>
                                    <th class="text-right">數量：</th>
                                    <td>${e[i]['length']}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">學制：</th>
                                    <td >${e[i]['s_name']}</td>
                                    <th class="text-right">班級：</th>
                                    <td >${e[i]['c_name']}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">系名：</th>
                                    <td colspan="3">${e[i]['d_name']}</td>
                                </tr>
                                <tr class="text-center">
                                    <th style="width: 25%">學號</th>
                                    <th style="width: 25%">簽名</th>
                                    <th style="width: 25%">學號</th>
                                    <th style="width: 25%">簽名</th>
                                </tr>
                    `;

                    nowHtml += student(e[i]['student']);

                    nowHtml += `
                            </tbody>
                        </table>
                    `;

                    $('#print').append(nowHtml);

                    if(i != e.length-1){
                        $('#print').append('<p style="page-break-after:always"></p>');
                    }
                }
                printDiv('print');
            })
            .fail(function() {
                alert('伺服器連線失敗，請確認網路連線或重新送出');
            });
        }

        function student(studentArr){
            var returnHtml = ``;
            for(var i=0;i<studentArr.length;i=i+2){
                if(studentArr.length == 1 || (i+1) == studentArr.length){
                    returnHtml += `
                        <tr class="text-center">
                            <td>${studentArr[i]}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    `;
                }else{
                    returnHtml += `
                        <tr class="text-center">
                            <td>${studentArr[i]}</td>
                            <td></td>
                            <td>${studentArr[i+1]}</td>
                            <td></td>
                        </tr>
                    `;
                }    
            }
            return returnHtml;
        }


        function printDiv(divName){
            var printContents = document.getElementById(divName).innerHTML;
            document.body.innerHTML = printContents;
            $('body').attr('style', 'padding-top:0');
            window.print();
            location.reload();
        }
    </script>

</body>
</html>
