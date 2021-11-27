<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
    <link href="<?php echo base_url('dist/assets/js/fullcalendar/fullcalendar.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('dist/assets/js/bootstrap-datetimepicker/bootstrap-datetimepicker.css'); ?>" rel="stylesheet">
    <style>
        .fc-title{
            color: white;
        }

        .fc-time{
            color: white;
        }
		
		.fc-widget-content{
			color: black;
		}
        
    </style>
</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link active" href="#">行事曆管理</a>
        </nav>
    </div>

    <div class="container">

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">行事曆管理</h6>
            <div class="media text-muted pt-3">
                <div id='calendar'></div>
            </div>
        </div>

    </div>

    <!-- 新增 -->
    <div class="modal fade add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-mb">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">建立活動</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="testmodal">
                        <form id="addEvents" class="form-horizontal calender" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">標題</label>
                                <div class="col-sm-9"  style="max-width:100%">
                                    <input type="text" class="form-control" id="add_title" name="title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">開始時間</label>
                                <div class="col-sm-9"  style="max-width:100%">
                                    <div class="input-group add_time needsclick" >
                                        <input type="text" class="form-control" id="add_start_time" name="startdate" readonly="readonly">
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div class="input-group add_time_min needsclick" >
                                        <input type="text" class="form-control" id="add_start_time_min" name="starttime" readonly="readonly">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="add_end_time_div">
                                <label class="col-sm-3 control-label">結束時間</label>
                                <div class="col-sm-9"  style="max-width:100%">
                                    <div class="input-group add_time needsclick" >
                                        <input type="text" class="form-control" id="add_end_time" name="enddate" readonly="readonly">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div class="input-group add_time_min needsclick">
                                        <input type="text" class="form-control" id="add_end_time_min" name="endtime" readonly="readonly">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">行程類型</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" name="isallday" id="add_check_all" value="1" class="flat"  checked/> 全天行程
                                    <input type="checkbox" name="isend" id="add_check_over" value="1" class="flat" /> 結束時間
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">簡述</label>
                                <div class="col-sm-9"  style="max-width:100%">
                                    <textarea class="form-control" style="height:55px;" id="add_content" name="content" placeholder="行程地點或是其他資訊"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">關閉</button>
                    <button type="button" class="btn btn-primary submit" data-str="add" >新增</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 新增 -->

    <!-- 修改 -->
    <div class="modal fade edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-mb">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">編輯活動</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-width:100%">
                    <div id="testmodal2" style="padding: 5px 20px;">
                        <form id="editEvents" class="form-horizontal calender" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">標題</label>
                                <div class="col-sm-9" style="max-width:100%">
                                    <input type="text" class="form-control" id="edit_title" name="title">
                                    <input type="hidden" id="edit_key" name="pca_key" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">開始時間</label>
                                <div class="col-sm-9" style="max-width:100%">
                                    <div class="input-group edit_time needsclick" >
                                        <input type="text" class="form-control" id="edit_start_time" name="startdate" readonly="readonly">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div class="input-group edit_time_min needsclick" >
                                        <input type="text" class="form-control" id="edit_start_time_min" name="starttime" readonly="readonly">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="edit_end_time_div">
                                <label class="col-sm-3 control-label">結束時間</label>
                                <div class="col-sm-9" style="max-width:100%">
                                    <div class="input-group edit_time needsclick" >
                                        <input type="text" class="form-control" id="edit_end_time" name="enddate" readonly="readonly">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <div class="input-group edit_time_min needsclick">
                                        <input type="text" class="form-control" id="edit_end_time_min" name="endtime" readonly="readonly">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">行程類型</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" name="isallday" id="edit_check_all" value="1" class="flat" checked /> 全天行程
                                    <input type="checkbox" name="isend" id="edit_check_over" value="1" class="flat" /> 結束時間
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">簡述</label>
                                <div class="col-sm-9" style="max-width:100%">
                                    <textarea class="form-control" style="height:55px;" id="edit_content" name="content" placeholder="行程地點或是其他資訊"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="editDel()">刪除</button>
                    <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">關閉</button>
                    <button type="button" class="btn btn-primary submit" data-str='edit'>儲存</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 修改 -->

    <div id="fc_add" data-toggle="modal" data-target=".add-modal"></div>
    <div id="fc_edit" data-toggle="modal" data-target=".edit-modal"></div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php $this->load->view('basic/system/jsLoad'); ?>
    <script src="<?php echo base_url('dist/assets/js/fullcalendar/moment.js'); ?>"></script>
    <script src="<?php echo base_url('dist/assets/js/fullcalendar/zh-tw.js'); ?>"></script>
    <script src="<?php echo base_url('dist/assets/js/fullcalendar/fullcalendar.js'); ?>"></script>
    <script src="<?php echo base_url('dist/assets/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js'); ?>"></script>
    <script>
        function AllInputInitialize(str){
            $('#'+str+'_start_time').datetimepicker({
                format:"YYYY-MM-DD",
                locale:"zh-tw",
                ignoreReadonly: true,
                allowInputToggle: true,
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            });

            $("#"+str+"_start_time").on("dp.change", function (e) {
                $('#'+str+'_end_time').data("DateTimePicker").minDate(e.date);
            }); 

            $('#'+str+'_end_time').datetimepicker({
                format:"YYYY-MM-DD",
                locale:"zh-tw",
                ignoreReadonly: true,
                allowInputToggle: true,
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            });

            // $("#"+str+"_end_time").on("dp.change", function (e) {
            //     $('#'+str+'_start_time').data("DateTimePicker").maxDate(e.date);
            // });

            $('.'+str+'_time_min').datetimepicker({
                format:"HH:mm",
                locale:"zh-tw",
                ignoreReadonly: true,
                allowInputToggle: true,
                widgetPositioning: {
                horizontal: 'left',
                    vertical: 'bottom'
                }
            });
            $('#'+str+'_end_time_div').hide();
            $('.'+str+'_time_min').hide();

            //屬性框定義
            allDay = true;
            overTime = false;
            $('#'+str+'_check_all').change(function(){
               if($('#'+str+'_check_all').prop("checked")){
                    $('.'+str+'_time_min').hide();
                    allDay = true;
               }else{
                    $('.'+str+'_time_min').show();
                    allDay = false;
               }
            });

            $('#'+str+'_check_over').change(function(){
               if($('#'+str+'_check_over').prop("checked")){
                    $('#'+str+'_end_time_div').show();
                    overTime = true;
               }else{
                    $('#'+str+'_end_time_div').hide();
                    overTime = false;
               }
            });
        }
        AllInputInitialize('add');
        AllInputInitialize('edit');
        function ModalClose(str){
            $('.'+str+'-modal').modal('hide');
        }

        function modelInitialize(ctrlName,title,content,startTime,endTime,startTimeMin,EndTimeMin,checkAll,checkOver){
            $('#'+ctrlName+'_start_time').val(startTime);
            $('#'+ctrlName+'_end_time').val(endTime);
            $('#'+ctrlName+'_start_time_min').val(startTimeMin);
            $('#'+ctrlName+'_end_time_min').val(EndTimeMin);
            $('#'+ctrlName+'_title').val(title);
            $('#'+ctrlName+'_content').val(content);

            if(checkAll){
                $('#'+ctrlName+'_check_all').prop("checked", true);
                $('.'+ctrlName+'_time_min').hide();
                allDay = true;
            }else{
                $('#'+ctrlName+'_check_all').prop("checked", false);
                $('.'+ctrlName+'_time_min').show();
                allDay = false;
            }

            if(checkOver){
                $('#'+ctrlName+'_check_over').prop("checked", true);
                $('#'+ctrlName+'_end_time_div').show();
                overTime = true;
            }else{
                $('#'+ctrlName+'_check_over').prop("checked", false);
                $('#'+ctrlName+'_end_time_div').hide();
                overTime = false;
            }

            $('#fc_'+ctrlName).click();       
        }
    </script>
    <script>
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var started;
        var ended;
        var newEvent = {};
        var categoryClass;

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaDay,listMonth'
            },
            eventSources: [
                // your event source
                {
                    url: base_url('calendar_management/getAllEvents'),
                    type: 'POST',
                    error: function() {
                        alert('there was an error while fetching events!');
                    }
                }
                // any other sources...
            ],
            buttonText:{
                today: '移至今天',
                month: '月',
                week: '周',
                day: '日',
                listMonth:'本月所有行程'
            },
            firstDay:1,
            longPressDelay:100,
            eventLongPressDelay:100,
            allDaySlot: false,
            timeFormat: 'H(:mm)',
            axisFormat: 'H:mm',
			slotLabelFormat:'hh:mm',
            views:{ 
                week:{ 
                    titleFormat: "YYYY年 MMMM月 D日"
                },
                month:{
                    titleFormat: "YYYY年 MMMM月" 
                },
                day:{
                    titleFormat: "YYYY年 MMMM月 D日"
                },
				listMonth:{
					listDayFormat: "MMMM月 D日"
				}
            },
            monthNames: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
            dayNamesShort: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
            selectable: true,
            editable: true,
            lang: 'da',
            select: function(start, end, allDay, view) {
                if(view.name == "month"){
                    var month_start = moment(start).format('YYYY-MM-DD');
                    //alert(end);
                    var month_onend = moment(end).subtract(1, 'days').format('YYYY-MM-DD');
                    if(month_start == month_onend){
                        modelInitialize('add','','',month_start,month_onend,'00:00','00:00',true,false);
                    }else{
                        modelInitialize('add','','',month_start,month_onend,'00:00','00:00',true,true);
                    }
                }else if(view.name == "agendaDay"){
                    var month_start = moment(start).format('YYYY-MM-DD');
                    var month_onend = moment(end).format('YYYY-MM-DD');
                    var startHours = moment(start).format('HH:mm');
                    var endHours = moment(end).format('HH:mm');
                    modelInitialize('add','','',month_start,month_onend,startHours,endHours,false,true);
                }
                var startHours = moment(start).format('hh:mm'),
                started = start,
                ended = end;
                //alert(startHours);
                //Set value to selected time
                $("#event-start").val(startHours);
                //alert(startHours);
            },
            eventClick: function(calEvent, jsEvent, view) {
                //alert(calEvent._id);
                $.ajax({
                    url: base_url("calendar_management/getEvents"),
                    dataType: 'json',
                    type:'post',
                    async:false,
                    data: {id : calEvent.id},
                    error:function(){alert('Ajax request 發生錯誤');},
                    success: function(json){
                        var thisEvent = json;
                        $("#edit_title").val(calEvent.title);
                        modelInitialize('edit',thisEvent['title'],thisEvent['content'],thisEvent['start'],thisEvent['end'],thisEvent['startMin'],thisEvent['endMin'],thisEvent['checkAll'],thisEvent['checkOver']);
                        $("#edit_key").val(calEvent.id);
                    }
                });
                //calendar.fullCalendar('unselect');
            },
            eventDrop: function(event, delta, revertFunc) {
                isend = event.end?true:false ;
                if(isend){
                    //多天
                    $.ajax({ 
                        type: "POST", 
                        url: base_url("calendar_management/dropEvents"), 
                        data: {id:event.id,
                            startdate:event.start.format('YYYY-MM-DD'),
                            enddate:event.end.format('YYYY-MM-DD'),
                            starttime:event.start.format('HH:mm'),
                            endtime:event.end.format('HH:mm'),
                            isallDay:event.allDay,
                            isend:isend}, 
                        error:function(){alert('連線錯誤請重新執行');revertFunc();},
                        success: function(data) { 
                            if(data!=1){
                                //alert(data);
                                revertFunc(); //恢复原状
                                alert('發生錯誤，請重整頁面後重新執行動作');
                            }else{
                                $('#calendar').fullCalendar('refetchEvents');
                            }
                        }
                    });
                }else{
                    //一日
                    $.ajax({ 
                        type: "POST", 
                        url: base_url("calendar_management/dropEvents"), 
                        data: {id:event.id,
                                startdate:event.start.format('YYYY-MM-DD'),
                                starttime:event.start.format('HH:mm'),
                                isallDay:event.allDay,
                                isend:isend}, 
                        error:function(){alert('連線錯誤請重新執行');revertFunc();},
                        success: function(data){ 
                            if(data!=1){
                                //alert(data);
                                revertFunc(); //恢复原状
                                alert('發生錯誤，請重整頁面後重新執行動作');
                            }else{
                                $('#calendar').fullCalendar('refetchEvents');
                            }
                        }
                    });
                }
            },
            eventResize: function(event, delta, revertFunc) {
                var end = moment(event.end).format('YYYY-MM-DD');
                var endTime = event.end.format('HH:mm');
                $.ajax({ 
                    type: "POST", 
                    url: base_url("calendar_management/resizeEvents"), 
                    data: {id:event.id,
                            enddate:end,
                            endtime:endTime}, 
                    error:function(){alert('連線錯誤請重新執行');revertFunc();},
                    success: function(data) { 
                        if(data!=1){
                            revertFunc(); //恢复原状
                            alert('發生錯誤，請重整頁面後重新執行動作');
                        }else{
                            $('#calendar').fullCalendar('refetchEvents');
                        }
                    } 
                });
            }
        });

        $(".submit").on("click", function() {
            var thisStr=$(this).data("str");
            var title = $("#"+thisStr+"_title").val();
            var content = $("#"+thisStr+"_content").val();
            if(title=="" || content==""){
                alert('請確認所有欄位都撰寫完畢');
            }else{
              $.ajax({ 
                type: "POST", 
                url: base_url("calendar_management/"+thisStr+"Events"), 
                data: $("#"+thisStr+"Events").serialize(), 
                success: function(data) 
                { 
                    alert('成功');
                    ModalClose(thisStr);
                    $('#calendar').fullCalendar('refetchEvents');
                } 
              });
            }
        });

        function editDel(){
            var editKey = $("#edit_key").val();
            if(confirm('按下確定後便會刪除這個活動')){
                $.ajax({ 
                    type: "POST", 
                    url: base_url("calendar_management/deleteEvent"), 
                    data: {editKey : editKey}, 
                    success: function(data) {
                        alert('成功');
                        ModalClose('edit');
                        $('#calendar').fullCalendar('refetchEvents');
                    } 
                });
            }
        }

    </script>

   

</body>
</html>
