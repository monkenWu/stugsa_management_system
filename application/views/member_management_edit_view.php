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
            <a class="nav-link" href="<?php echo base_url('member_management') ?>">會員管理</a>
            <a class="nav-link active" href="<?php echo base_url('member_management/check') ?>">會員名單確認</a>
        </nav>
    </div>

    <div class="container">
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h5 class="border-bottom border-gray pb-2 mb-0">會員名單確認</h5>
            <div class="col-md-12" style="margin-top: 10px">
                <div class="form-group">
                    <form id="class_info_form">
                        <div class="row">
                                <div class="col-md-6">
                                    <label for="classSelect">班級</label>
                                    <select class="form-control" id="edit_classSelect" name="classSelect">
                                        <option value="1">甲</option>
                                        <option value="2">乙</option>
                                        <option value="3">丙</option>
                                        <option value="4">丁</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="systemSelect">學制</label>
                                    <select class="form-control" id="edit_systemSelect" name="systemSelect">
                                        <option value="1">日間四技</option>
                                        <option value="2">四技進修</option>
                                        <option value="3">二技日間</option>
                                        <option value="4">二技進修</option>
                                        <option value="5">進修二專</option>
                                        <option value="6">產學四技學士專班</option>
                                        <option value="7">二技進修</option>
                                        <option value="8">碩士班</option>
                                        <option value="9">碩士在職專班</option>
                                        <option value="10">博士班</option>
                                    </select>
                                </div>
                        </div>
                    </form>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="class_name">系所名稱</label>
                            <select class="form-control" id="editClass_name" name="class_name">
                                <option value="0">==========資料庫並無此班級與此學制的資料==========</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="summernote">輸入學號（按下enter確認下一筆）</label>
                                <form id="check_number_form">
                                    <input type="text" class="form-control" id="new_number" placeholder="" disabled="disabled">
                                </form>
                        </div>
                        <div class="col-md-6" style="margin-top: 10px">
                            <button type="button" class="btn btn-primary" onclick="loadClassData()">開始確認名單</button>
                            <text style="color:red;" id="historyTime"></text>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="classSelect">本班學號</label>
                    <div class="row" id="numberCard">
                        

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('basic/system/jsLoad'); ?>
    <script type="text/javascript">

        $(window).load(function() {
            randerEditSelect();
        });

        $( "#edit_classSelect" ).change(function() {
            randerEditSelect();
        });

        $( "#edit_systemSelect" ).change(function() {
            randerEditSelect();
        });

        function randerEditSelect(){
            var classData = $("#class_info_form").serializeArray();
            $.ajax({
                url: base_url('member_management/getEditSelect'),
                type: 'POST',
                dataType: 'json',
                data: {classValue: classData[0]['value'],
                       systemValue: classData[1]['value']},
            })
            .done(function(e) {
                $('#editClass_name').html('');
                if(e.length == 0){
                    $('#editClass_name').html('<option value="0">==========資料庫並無此班級與此學制的資料==========</option>');
                }else{
                    for(var i=0 ;i<e.length ;i++){
                        $('#editClass_name').append('<option value="'+e[i]['key']+'">'+e[i]['name']+'</option>');
                    }
                }
            })
            .fail(function() {
                $('#editClass_name').html('<option value="0">==========資料庫連線失敗==========</option>');
            });
        }

        function loadClassData(){
            var classNameKey = $('#editClass_name').val();
            if(classNameKey == 0){
                alert('請選擇正確的系所名稱');
            }else{
                getListHistory(classNameKey);
                $.ajax({
                    url: base_url('member_management/getClassAllMember'),
                    type: 'POST',
                    dataType: 'json',
                    data: {d_key: classNameKey},
                })
                .done(function(e) {
                    newMemberList = [];
                    $('#numberCard').html('');
                    $('#new_number').removeAttr('disabled');
                    if(e.status == 1){
                        //console.log(e.length);
                        for(var i=0;i<(e.length);i++){
                            $('#numberCard').append(`
                                <div class="col-md-2" id="${e[i]['studentid']}">
                                    <div class="card bg-light" style="max-width: 18rem;" id="${e[i].studentid+"card"}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">${e[i].studentid}</h5>
                                        </div>
                                    </div>
                                </div>
                            `);
                        }
                        $('#numberCard').append(`
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-success" onclick="checkSuccess('${classNameKey}')">名單確認完成</button>
                            </div>
                        `);
                    }else{
                        newMemberList = [];
                        $(this).attr('disabled', 'disabled');
                        $('#numberCard').html('');
                        alert('資料獲取失敗');
                    }
                })
                .fail(function() {
                    newMemberList = [];
                    $(this).attr('disabled', 'disabled');
                    $('#numberCard').html('');
                    alert('資料庫連線失敗');
                });
            }
        }

        function getListHistory(classNameKey) {
            $("#historyTime").html('');
            $.ajax({
                url: base_url('member_management/getListHistory'),
                type: 'POST',
                dataType: 'json',
                data: {d_key: classNameKey},
            })
            .done(function(e) {
                if(e.status == 1){
                    if(e.isTime){
                        $("#historyTime").html("以在"+e.time+"確認過。");
                    }else{
                        $("#historyTime").html('');
                    }
                }else{
                    alert('歷史資料獲取失敗');
                }
            })
            .fail(function() {
                alert('歷史資料庫連線失敗');
            });
        }

        var newMemberList = [];
        $("#check_number_form").submit(function(event){
            //阻止自動提交
            event.preventDefault();
            var thisNumber = $('#new_number').val();
            var thisDom = $("#"+thisNumber+"card");

            if(thisNumber == ""){
                alert('學號不可為空。');
                return;
            }

            if(thisDom.length>0){ 
                if(thisDom.hasClass("bg-light")){
                    thisDom.removeClass("bg-light");
                    thisDom.addClass('bg-success text-white');
                    $('#new_number').val('');
                }else{
                    alert('這筆學號已經確認過');
                }
            }else{
                if(confirm('這個學號並沒有在資料庫被建檔，需要立即建檔嗎？')){
                    newMemberList[newMemberList.length] = {value : thisNumber};
                    $('#new_number').val('');
                    $('#numberCard').append(`
                        <div class="col-md-2" id="${thisNumber}" onclick="delNumber('${thisNumber}')">
                            <div class="card text-white bg-info" style="max-width: 18rem;" id="${thisNumber+"card"}">
                                <div class="card-body text-center">
                                    <h5 class="card-title">${thisNumber}</h5>
                                </div>
                            </div>
                        </div>
                    `);
                    alert('建檔完畢，送出本次確認表後才會進入資料庫。');
                }
            }
        });

        function delNumber(number){
            if(confirm('是否要刪除這筆新增項？')){
                if(delArray(number)){
                    $("#"+number).remove();
                }else{
                    alert("刪除失敗");
                }
            }
        }

        function delArray(number){
            for(var i=0;i<newMemberList.length;i++){
                if(newMemberList[i].value == number){
                    newMemberList.splice(i,1);
                    return true;
                }
            }
            return false;
        }

        function checkSuccess(d_key){
            if(confirm('確定要送出此次確認的內容嗎？')){
                $.ajax({
                    url: base_url('member_management/checkSuccess'),
                    type: 'POST',
                    dataType: 'json',
                    data: {studentData : JSON.stringify(newMemberList),
                           d_key : d_key},
                })
                .done(function(e) {
                    if(e['status'] == 0){
                        alert(e['noticeText']);
                    }else if(e['status'] == 1){
                        alert('確認成功！');
                        window.location.reload();
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
