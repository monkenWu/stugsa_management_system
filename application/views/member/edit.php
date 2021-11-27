<div class="modal fade edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">新增補繳會員</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_class_info_form">
                    <div class="form-group">
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
                    </div>
                    <div class="form-group">
                        <label for="class_name">系所名稱</label>
                        <select class="form-control" id="editClass_name" name="class_name">
                            <option value="0">==========資料庫並無此班級與此學制的資料==========</option>
                        </select>
                    </div>
                </form>
                <div class="form-group">
                    <label for="summernote">輸入學號（按下enter新增下一筆）</label>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="edit_add_number_form">
                                <input type="text" class="form-control" id="edit_new_number" placeholder="">
                            </form>
                        </div>
                        <div class="col-md-6" id="edit_newInputArea" style="height: 200px;overflow: auto;">
                            <form id="edit_edit_number_form">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col-6">功能</th>
                                            <th scope="col-6">學號</th>
                                        </tr>
                                    </thead>
                                    <tbody id="edit_classArea">
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="editMember()">送出補繳會員</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var editClassAreaCount = 1;
    $("#edit_add_number_form").submit(function(event){
        //阻止自動提交
        event.preventDefault();
        var newNumber = $('#edit_new_number').val();
        if(newNumber==""){
            alert('學號請勿為空');
        }else if(editCheckValue(newNumber)){
            alert('這個學號已經重複，請確認');
        }else{
            $('#edit_classArea').append('<tr id="edot_overArea_newNumber'+editClassAreaCount+'"><td><button type="button" onclick="editDeleteNumberArea('+editClassAreaCount+')" class="btn btn-outline-danger functions-btn">刪除</button></td><td><input type="text" class="form-control" name="number" value="'+newNumber+'"></td></tr>');
            editClassAreaCount++;
            $('#edit_new_number').val('');
            $('#edit_newInputArea').scrollTop($('#edit_newInputArea').prop("scrollHeight"));
        }
    });

    $('#edit_newInputArea').submit(function(event) {
        event.preventDefault();
    });

    function editCheckValue(input){
        var inputArr = $("#edit_newInputArea").serializeArray();
        for(var i=0;i<inputArr.length;i++){
            if(inputArr[i]['value'] == input){
                return true;
            }
        }
        return false;
    }

    function editDeleteNumberArea(key){
        $('#edot_overArea_newNumber'+key).remove();
    }

    $('.edit-modal').on('show.bs.modal', function (e) {
        randerEditSelect();
    })

    $( "#edit_classSelect" ).change(function() {
        randerEditSelect();
    });

    $( "#edit_systemSelect" ).change(function() {
        randerEditSelect();
    });


    function randerEditSelect(){
        var classData = $("#edit_class_info_form").serializeArray();
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

    function editMember(){
        var inputArr = $("#edit_edit_number_form").serializeArray();
        var newNumber = $('#add_new_number').val();
        var classNameKey = $('#editClass_name').val()
        if(classNameKey == 0){
            alert('請選擇正確的系所名稱');
        }else if(inputArr.length ==0 ){
            alert('請至少輸入一筆學號資料');
        }else{
            if(confirm('確定新增嗎？')){
                $.ajax({
                    url: base_url('member_management/editMember'),
                    type: 'POST',
                    dataType: 'json',
                    data: {studentData : JSON.stringify(inputArr),
                           classKey : classNameKey},
                })
                .done(function(e) {
                    if(e['status'] == 0){
                        alert(e['noticeText']);
                    }else if(e['status'] == 1){
                        alert(e['noticeText']);
                        $('#edit_classArea').html('');
                        $('#add_new_number').val('');
                        $('.edit-modal').modal('hide');
                        editClassAreaCount=1;
                        loadTable();
                    }else{
                        alert('未知的錯誤。');
                    }
                })
                .fail(function() {
                    alert('伺服器連線失敗，請確認網路連線或重新送出');
                });
            }
        }
    }


</script>