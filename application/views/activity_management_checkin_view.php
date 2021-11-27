<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link" href="<?php echo base_url('activity_management') ?>">活動管理</a>
            <a class="nav-link active" href="<?php echo base_url('activity_management/checkin') ?>">活動簽到</a>
            <a class="nav-link" href="<?php echo base_url('activity_management/result') ?>">輸出報表</a>
        </nav>
    </div>

    <div class="container">

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h5 class="border-bottom border-gray pb-2 mb-0">活動簽到</h5>
            <div class="media text-muted pt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label for="number_form"><b>輸入學號（按下enter輸入）</b></label>
                                    <form id="number_form">
                                        <input type="text" class="form-control" id="add_number" placeholder="">
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <label for="nowMember"><b>目前所查詢之會員：</b></label>
                                    <h6 id="nowMember" style="color:red"></h6>
                                </div>
                                <div class="col-md-12" style="height: 400px;overflow: auto;">
                                    <label for="edit_number_form"><b>活動列表</b></label>
                                    <form id="edit_number_form">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%">簽到</th>
                                                    <th style="width: 80%">活動名稱</th>
                                                </tr>
                                            </thead>
                                            <tbody id="newActivityArea">
                                            </tbody>
                                        </table>
                                        <!-- <div class="text-right">
                                            <button type="submit" class="btn btn-success">送出</button>
                                        </div> -->
                                    </form>
                                </div>
                            </div>
                            
                            <div class="col-md-6" style="overflow: auto;">
                                <label for="number_form"><b>歷史參與紀錄</b></label>
                                <form id="edit_number_form">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%">功能</th>
                                                <th style="width: 80%">活動名稱</th>
                                            </tr>
                                        </thead>
                                        <tbody id="oldActivityArea">
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php $this->load->view('basic/system/jsLoad'); ?>
    <script>
        $("#number_form").submit(function(event){
            //阻止自動提交
            event.preventDefault();
            var number = $('#add_number').val();
            if(number==""){
                alert('學號請勿為空');
            }else{
                $.ajax({
                    url: base_url('activity_management/checkValue'),
                    type: 'POST',
                    dataType: 'json',
                    data: {number : number},
                })
                .done(function(e) {
                    if(e.status == 1){
                        getActicityList(number);
                        getOldActicityList(number);
                        $('#add_number').val('');
                        $('#nowMember').html(number);
                    }else{
                        $('#add_number').val('');
                        $('#nowMember').html('這個學號並非畢業生聯合會資料庫所記載之會員');
                        $('#newActivityArea').html('');
                        $('#oldActivityArea').html('');
                    }
                })
                .fail(function() {
                    alert('伺服器連線失敗，請確認網路連線或重新送出');
                });
            }
        });

        function getActicityList(number){
            $('#newActivityArea').html('');
            $.ajax({
                url: base_url('activity_management/getMemberNewActivity'),
                type: 'POST',
                dataType: 'json',
                data: {number : number},
            })
            .done(function(e) {
                for(var i=0;i<e.length;i++){
                    $('#newActivityArea').append(`
                        <tr>
                            <td>
                                <button type="button" onclick="checkin('${e[i].key}',this)" class="btn btn-outline-info functions-btn">簽到</button>
                            </td>
                            <td>
                                ${e[i].name}
                            </td>
                        </tr>
                    `);
                }
            })
            .fail(function() {
                alert('伺服器連線失敗，請確認網路連線或重新送出');
            });
            
        }

        function getOldActicityList(number){
           
            $('#oldActivityArea').html('');
            $.ajax({
                url: base_url('activity_management/getMemberOldActivity'),
                type: 'POST',
                dataType: 'json',
                data: {number : number},
            })
            .done(function(e) {
                for(var i=0;i<e.length;i++){
                    $('#oldActivityArea').append(`
                        <tr>
                            <td>
                                <button type="button" onclick="checkout('${e[i].key}')" class="btn btn-outline-danger functions-btn">移除</button>
                            </td>
                            <td>
                                ${e[i].name}
                            </td>
                        </tr>
                    `);
                }
            })
            .fail(function() {
                alert('伺服器連線失敗，請確認網路連線或重新送出');
            });
            
        }

        function checkin(akey,obj){
            var thisNumber = $('#nowMember').html();
            var thisButton = obj;
            $(thisButton).attr("disabled","");
            if(confirm('確定簽到所選取的活動？')){
                $.ajax({
                    url: base_url('activity_management/joinActivity'),
                    type: 'POST',
                    dataType: 'json',
                    data: {akey : akey,
                            number:thisNumber},
                })
                .done(function(e) {
                    if(e.status == 1){
                        alert('簽到成功！');
                        getActicityList(thisNumber);
                        getOldActicityList(thisNumber);
                    }else if(e.status == 3){
                        alert('email系統發生問題，簽到成功。若需要重新發送回饋量表信件，請移除簽到後重新簽到。');
                        getActicityList(thisNumber);
                        getOldActicityList(thisNumber);
                    }else{
                        alert('未知的錯誤。');
                    }
                    $(thisButton).removeAttr("disabled");
                })
                .fail(function() {
                    alert('伺服器連線失敗，請確認網路連線或重新送出');
                });
            }else{
                $(thisButton).removeAttr("disabled");
            }
        }

        function checkout(akey){
            var thisNumber = $('#nowMember').html();
            if(confirm('你確定要取消這筆簽到記錄嗎？')){
                $.ajax({
                    url: base_url('activity_management/delJoinActivity'),
                    type: 'POST',
                    dataType: 'json',
                    data: {akey : akey,
                            number:thisNumber},
                })
                .done(function(e) {
                    if(e.status == 1){
                        alert('取消成功！');
                        getActicityList(thisNumber);
                        getOldActicityList(thisNumber);
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
