<div class="modal fade add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">新增繳費班級</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="class_info_form">
                    <div class="form-group">
                        <label for="add_notice_title">系所名稱</label>
                        <input type="text" class="form-control" id="class_name" name="class_name" placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="add_notice_title">班級</label>
                                <select class="form-control" name="classSelect">
                                    <option value="1">甲</option>
                                    <option value="2">乙</option>
                                    <option value="3">丙</option>
                                    <option value="4">丁</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="add_notice_title">學制</label>
                                <select class="form-control" name="systemSelect">
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
                </form>
                <div class="form-group">
                    <label for="summernote">輸入學號（按下enter新增下一筆）</label>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="new_number_form">
                                <input type="text" class="form-control" id="add_new_number" placeholder="">
                            </form>
                        </div>
                        <div class="col-md-6" id="newInputArea" style="height: 400px;overflow: auto;">
                            <form id="edit_number_form">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col-6">功能</th>
                                            <th scope="col-6">學號</th>
                                        </tr>
                                    </thead>
                                    <tbody id="classArea">
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addMember()">送出繳費會員</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var classAreaCount = 1;
    $("#new_number_form").submit(function(event){
        //阻止自動提交
        event.preventDefault();
        var newNumber = $('#add_new_number').val();
        if(newNumber==""){
            alert('學號請勿為空');
        }else if(checkValue(newNumber)){
            alert('這個學號已經重複，請確認');
        }else{
            $('#classArea').append('<tr id="overArea_newNumber'+classAreaCount+'"><td><button type="button" onclick="deleteNumberArea('+classAreaCount+')" class="btn btn-outline-danger functions-btn">刪除</button></td><td><input type="text" class="form-control" name="number" value="'+newNumber+'"></td></tr>');
            classAreaCount++;
            $('#add_new_number').val('');
            $('#newInputArea').scrollTop($('#newInputArea').prop("scrollHeight"));
        }
    });

    $('#edit_number_form').submit(function(event) {
        event.preventDefault();
    });

    function checkValue(input){
        var inputArr = $("#edit_number_form").serializeArray();
        for(var i=0;i<inputArr.length;i++){
            if(inputArr[i]['value'] == input){
                return true;
            }
        }
        return false;
    }

    function deleteNumberArea(key){
        $('#overArea_newNumber'+key).remove();
    }

    function addMember(){
        var inputArr = $("#edit_number_form").serializeArray();
        var newNumber = $('#add_new_number').val();
        var className = $('#class_name').val();
        var classData = $("#class_info_form").serializeArray();
        if(className == ""){
            alert('請輸入班級名稱');
        }else if(inputArr.length ==0 ){
            alert('請至少輸入一筆學號資料');
        }else{
            if(confirm('確定新增嗎？')){
                $.ajax({
                    url: base_url('member_management/addMember'),
                    type: 'POST',
                    dataType: 'text',
                    data: {studentData : JSON.stringify(inputArr),
                           classData : JSON.stringify(classData)},
                })
                .done(function(e) {
                    if(e == 0){
                        alert('這個班級已經新增過了，請確認系所名稱、班級、學制是否有誤');
                    }else if(e == 1){
                        alert('新增成功！');
                        $('#classArea').html('');
                        $('#add_new_number').val('');
                        $('#class_name').val('');
                        $('.add-modal').modal('hide');
                        classAreaCount = 1;
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