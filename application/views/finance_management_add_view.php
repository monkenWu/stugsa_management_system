<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
    <link href="<?php echo base_url('dist/assets/js/bootstrap-datetimepicker/bootstrap-datetimepicker.css'); ?>" rel="stylesheet">
</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>
    <?php $this->load->view('basic/system/jsLoad'); ?>
    <script src="<?php echo base_url('dist/assets/js/fullcalendar/moment.js'); ?>"></script>
    <script src="<?php echo base_url('dist/assets/js/fullcalendar/zh-tw.js'); ?>"></script>
    <script src="<?php echo base_url('dist/assets/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js'); ?>"></script>


    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link " href="<?php echo base_url('finance_management') ?>">歷月報表查閱</a>
            <a class="nav-link active" href="#">月報表撰寫</a>
        </nav>
    </div>

    <div class="container">
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">月報表撰寫</h6>
            <div class="media text-muted pt-3">
                <div class="col-md-12" id ="addBudegt" >
                    <form style="margin: 0px auto;">
                        <?php  $this->load->view("finance_add/yearSelect");  ?>
                    </form>
                    <div calss="text-left" style="padding-top: 10px;padding-bottom: 15px">
                        <button type="button" class="btn btn-dark hideButton" onclick="itemModal()">編輯會計項目</button>
                    </div>
                    <div id="tableAllDiv">
                        <table class="table table-bordered　 table-responsive">
                            <thead>
                                <tr>
                                <th style="width:5%">功能</th>
                                <th style="width:10%">日期</th>
                                <th style="width:15%">會計項目</th>
                                <!--
                                <th style="width:23%">預計日期</th>
                                -->
                                <th style="width:29%">內容</th>
                                <th style="width:10%">屬性</th>
                                <th style="width:11%">金額</th>
                                </tr>
                            </thead>
                            <?php  $this->load->view("finance_add/table");  ?>
                        </table>
                    </div>
                    <div class="text-right">
                        <div class="text-left">
                            <button type="button" class="btn btn-default hideButton" onclick="addOneCost()">新增一筆帳目</button>
                        </div> 
                        <button type="button" class="btn btn-primary hideButton" onclick="temporaryThisFinance()" >暫存報表</button>
                        <button type="button" class="btn btn-success hideButton" onclick="submitNewFinance()" >完成本月月報表</button>
                    </div>
                    <div id="costForms">

                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view("finance_add/itemModal");  ?>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script>
        $('#tableAllDiv').hide();
        $('.hideButton').hide();

        function submitNewFinance(){
            var submitBoolean = false;
            for(i=1;i<=costNum;i++){
                var tableArray = $('#cost'+i).serializeArray();
                if(tableArray.length!=0){
                    if(tableArray[0]['value']==""){
                        submitBoolean = true;
                        break;
                    }else if (tableArray[2]['value']==""){
                        submitBoolean = true;
                        break;
                    }else if (tableArray[4]['value']==""){
                        submitBoolean = true;
                        break;
                    }
                }
            }
            if(submitBoolean){
                alert('請填寫完所有帳目內容');
            }else{
                var thisJsonCode={};
                var jasonNum = 1;
                thisJsonCode[0] = [];
                thisJsonCode[0][0] = "";
                thisJsonCode[0][1] = "-1";
                thisJsonCode[0][2] = $('#openContent').val();
                thisJsonCode[0][3] = 0;
                thisJsonCode[0][4] = thisCount;
                for(i=1;i<=costNum;i++){
                    var tableArray = $('#cost'+i).serializeArray();
                    if(tableArray.length!=0){
                        thisJsonCode[jasonNum] = [];
                        thisJsonCode[jasonNum][0] = tableArray[0]['value'];
                        thisJsonCode[jasonNum][1] = tableArray[1]['value'];
                        thisJsonCode[jasonNum][2] = tableArray[2]['value'];
                        thisJsonCode[jasonNum][3] = tableArray[3]['value'];
                        thisJsonCode[jasonNum][4] = tableArray[4]['value'] == "" ? 0 :parseInt(tableArray[4]['value']);
                        jasonNum++;
                    }
                }
                if(confirm('確定要將這張月報表送出嗎？為確保帳目的正確性與合法性，將月報表送出後，將無法進行任何形式的更改。')){
                    $.ajax({
                        url: base_url('finance_management/addNewFinance'),
                        dataType: 'text',
                        async:false,
                        type:'post',
                        data: {content : JSON.stringify(thisJsonCode)},
                        error:function(){alert("網路或未知的錯誤，無法送出您的月報表。");},
                        success: function(){
                            alert('送出成功');
                            location.reload();
                        }
                    });
                }
            }
        }

        function temporaryThisFinance(){
            var submitBoolean = false;
            for(i=1;i<=costNum;i++){
                var tableArray = $('#cost'+i).serializeArray();
                if(tableArray.length!=0){
                    if(tableArray[0]['value']==""){
                        submitBoolean = true;
                        break;
                    }else if (tableArray[2]['value']==""){
                        submitBoolean = true;
                        break;
                    }else if (tableArray[4]['value']==""){
                        submitBoolean = true;
                        break;
                    }
                }
            }
            if(submitBoolean){
                alert('請填寫完所有帳目內容');
            }else{
                var thisJsonCode={};
                var jasonNum = 1;
                thisJsonCode[0] = [];
                thisJsonCode[0][0] = "";
                thisJsonCode[0][1] = "-1";
                thisJsonCode[0][2] = $('#openContent').val();
                thisJsonCode[0][3] = 0;
                thisJsonCode[0][4] = thisCount;
                for(i=1;i<=costNum;i++){
                    var tableArray = $('#cost'+i).serializeArray();
                    if(tableArray.length!=0){
                        thisJsonCode[jasonNum] = [];
                        thisJsonCode[jasonNum][0] = tableArray[0]['value'];
                        thisJsonCode[jasonNum][1] = tableArray[1]['value'];
                        thisJsonCode[jasonNum][2] = tableArray[2]['value'];
                        thisJsonCode[jasonNum][3] = tableArray[3]['value'];
                        thisJsonCode[jasonNum][4] = tableArray[4]['value'] == "" ? 0 :parseInt(tableArray[4]['value']);
                        jasonNum++;
                    }
                }
                if(confirm('暫存報表後，將會保存目前所編寫的報表內容至系統中，確定要保存目前的編輯狀態嗎？')){
                    $.ajax({
                        url: base_url('finance_management/temporaryThisFinance'),
                        dataType: 'text',
                        async:false,
                        type:'post',
                        data: {content : JSON.stringify(thisJsonCode)},
                        error:function(){alert("網路或未知的錯誤，無法送出您的月報表。");},
                        success: function(){
                            alert('暫存成功！');
                            location.reload();
                        }
                    });
                }
            }
        }
    </script>
    

</body>
</html>
