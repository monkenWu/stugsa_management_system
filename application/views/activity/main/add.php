<div class="modal fade add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">新增活動</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="activity_info_form"　>
                    <div class="form-group">
                        <label for="name"><text>*</text>活動名稱</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="content"><text>*</text>活動內容</label>
                        <textarea name="content" id="content" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="startDate"><text>*</text>開始時間</label>
                                <input type="date" name="startDate" id="startDate" class="form-control">
                                <input type="time" name="startTime" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="endDate"><text>*</text>結束時間</label>
                                <input type="date" name="endDate" id="endDate" class="form-control">
                                <input type="time" name="endTime" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="feedback">回饋量表（如果有，貼網址）</label>
                        <input type="url" name="feedback" id="feedback" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addActivity()">新增活動</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#activity_info_form').submit(function(event) {
        event.preventDefault();
    });

    function checkValue(arrData){
        for(var i=0;i<arrData.length;i++){
            if(arrData[i]['value'] == "" && arrData[i]['name'] != "feedback"){
                return true;
            }
        }
        return false;
    }

    function postData(arrData){
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
        return postArr;
    }

    function addActivity(){
        var inputArr = $("#activity_info_form").serializeArray();
        if(checkValue(inputArr)){
            alert('請確認所有必填欄位都已經輸入');
        }else{
            if(confirm('確定新增活動嗎？')){
                $.ajax({
                    url: base_url('activity_management/addActivity'),
                    type: 'POST',
                    dataType: 'text',
                    data: {activityData : JSON.stringify(postData(inputArr))},
                })
                .done(function(e) {
                    if(e == 0){
                        alert('已有相同的活動名稱，請確認');
                    }else if(e == 1){
                        alert('新增成功！');
                        document.getElementById("activity_info_form").reset();
                        $('.add-modal').modal('hide');
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