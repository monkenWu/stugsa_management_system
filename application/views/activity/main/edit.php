<div class="modal fade edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">編輯活動</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="activity_edit_form"　>
                    <div class="form-group">
                        <label for="name"><text>*</text>活動名稱</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="content"><text>*</text>活動內容</label>
                        <textarea name="content" id="edit_content" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="startDate"><text>*</text>開始時間</label>
                                <input type="date" name="startDate" id="edit_startDate" class="form-control">
                                <input type="time" name="startTime" id="edit_startTime" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="endDate"><text>*</text>結束時間</label>
                                <input type="date" name="endDate" id="edit_endDate" class="form-control">
                                <input type="time" name="endTime" id="edit_endTime" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="feedback">回饋量表（如果有，貼網址）</label>
                        <input type="url" name="feedback" id="edit_feedback" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="editSubmitActivity()">編輯活動</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var thisEditKey = "";

    function editActivity(key){
        $.ajax({
            url: base_url('activity_management/getOneActivity'),
            type: 'POST',
            dataType: 'json',
            data: {key : key},
        })
        .done(function(e) {
            if(e.status == 1){
                thisEditKey = key;

                $('#edit_name').val(e.name);
                $('#edit_content').val(e.content);
                $('#edit_startDate').val(e.startDate);
                $('#edit_startTime').val(e.startTime);
                $('#edit_endDate').val(e.endDate);
                $('#edit_endTime').val(e.endTime);
                $('#edit_feedback').val(e.feedback);

                $('.edit-modal').modal('show');
            }else{
                alert('取得失敗，請重試');
            }
        })
        .fail(function() {
            alert('伺服器連線失敗，請確認網路連線或重新送出');
        });
    }

    $('#activity_edit_form').submit(function(event) {
        event.preventDefault();
    });

    function checkEditValue(arrData){
        for(var i=0;i<arrData.length;i++){
            if(arrData[i]['value'] == "" && arrData[i]['name'] != "feedback"){
                return true;
            }
        }
        return false;
    }

    function postEditData(arrData){
        var postArr = {};
        var time = {};
        var date = {};
        for(var i=0;i<arrData.length;i++){
            if(arrData[i]['name'] == "startTime" || arrData[i]['name'] == "endTime"){
                time[arrData[i]['name']] = arrData[i]['value'];
            }else if(arrData[i]['name'] == "startDate" || arrData[i]['name'] == "endDate"){
                date[arrData[i]['name']] = arrData[i]['value'];
            }else{
                postArr[arrData[i]['name']] = arrData[i]['value'];
            }
        }
        postArr['start_time'] = date['startDate'] +" "+time['startTime'];
        postArr['end_time'] = date['endDate'] +" "+time['endTime'];
        postArr['key'] = thisEditKey;
        return postArr;
    }

    function editSubmitActivity(){
        var inputArr = $("#activity_edit_form").serializeArray();
        if(checkEditValue(inputArr)){
            alert('請確認所有必填欄位都已經輸入');
        }else{
            if(confirm('確定新增活動嗎？')){
                $.ajax({
                    url: base_url('activity_management/editActivity'),
                    type: 'POST',
                    dataType: 'json',
                    data: {activityData : JSON.stringify(postEditData(inputArr))},
                })
                .done(function(e) {
                    if(e.status == 1){
                        alert('新增成功！');
                        document.getElementById("activity_edit_form").reset();
                        $('.edit-modal').modal('hide');
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