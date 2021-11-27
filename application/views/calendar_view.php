<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $this->load->view('basic/cssLoad'); ?>
    <link href="<?php echo base_url('dist/assets/js/fullcalendar/fullcalendar.min.css'); ?>" rel="stylesheet">
     <style>
        .fc-title{
            color: white;
        } 
        .fc-time{
            color: white;
        }
    </style>
</head>

<body>

    <?php $this->load->view('basic/navBar'); ?>
    <?php $this->load->view('basic/crumbsArea'); ?>    
    <!-- service area start -->
    <div class="all-service pt--100 pb--70">
        <div class="container">
            <div id='calendar'></div>
        </div>
    </div>

    <!-- 查閱 -->
    <div class="modal fade edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-mb">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">活動詳情</h5>
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
                                    <input type="text" class="form-control" id="edit_title" name="title" readonly="readonly">
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
                            <div class="form-group hide-type">
                                <label class="col-sm-3 control-label">行程類型</label>
                                <div class="col-sm-9" style="max-width:100%">
                                    <input type="checkbox" name="isallday" id="edit_check_all" value="1" class="flat" checked /> 全天行程
                                    <input type="checkbox" name="isend" id="edit_check_over" value="1" class="flat" /> 結束時間
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">簡述</label>
                                <div class="col-sm-9" style="max-width:100%" id="edit_content">
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">離開</button>
                </div>
            </div>
        </div>
    </div>
    <div id="fc_edit" data-toggle="modal" data-target=".edit-modal"></div>
    <!-- 查閱 -->
    <!-- service area end -->
    <?php $this->load->view('basic/footer'); ?>
    <?php $this->load->view('basic/jsLoad'); ?>
    <script src="<?php echo base_url('dist/assets/js/fullcalendar/moment.js'); ?>"></script>
    <script src="<?php echo base_url('dist/assets/js/fullcalendar/zh-tw.js'); ?>"></script>
    <script src="<?php echo base_url('dist/assets/js/fullcalendar/fullcalendar.js'); ?>"></script>

    <script>
        function AllInputInitialize(str){
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
        AllInputInitialize('edit');
        function modelInitialize(ctrlName,title,content,startTime,endTime,startTimeMin,EndTimeMin,checkAll,checkOver){
            $('#'+ctrlName+'_start_time').val(startTime);
            $('#'+ctrlName+'_end_time').val(endTime);
            $('#'+ctrlName+'_start_time_min').val(startTimeMin);
            $('#'+ctrlName+'_end_time_min').val(EndTimeMin);
            $('#'+ctrlName+'_title').val(title);
            $('#'+ctrlName+'_content').html(content);

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
        $('.hide-type').hide();
    </script>
    <script>

        var calendar = $('#calendar').fullCalendar({
			defaultView: 'listMonth',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'listMonth,month'
            },
            eventSources: [
                // your event source
                {
                    url: base_url('calendar/getAllEvents'),
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
                listMonth:'所有行程'
            },
            firstDay:1,
            longPressDelay:100,
            eventLongPressDelay:100,
            allDaySlot: false,
            timeFormat: 'H(:mm)',
            axisFormat: 'H:mm',
            slotLabelFormat:"HH:mm",
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
            selectable: false,
            editable: false,
            lang: 'da',
            eventClick: function(calEvent, jsEvent, view) {
                //alert(calEvent._id);
                $.ajax({
                    url: base_url("calendar/getEvents"),
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
            }
        });
    </script>

</body>

</html>
