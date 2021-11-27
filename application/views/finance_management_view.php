<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link active" href="#">歷月報表查閱</a>
            <a class="nav-link" href="<?php echo base_url('finance_management/add') ?>">月報表撰寫</a>
        </nav>
    </div>

    <div class="container">

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">月報表查閱</h6>
            <div class="media text-muted pt-3">
                <div class="col-md-12">
                    <div class="form-row align-items-cente" id="planSelect" style="padding-bottom: 10px">
                        <div class="my-1">
                            <h6 style="padding-top: 5px">選擇年度</h6>
                        </div>
                        <div class="col-sm-5 my-1">
                            <select class="form-control" id ="yearContentSelect">

                            </select>
                        </div>
                        <div class="my-1">
                            <h6 style="padding-top: 5px">選擇月份</h6>
                        </div>
                        <div class="col-sm-5 my-1">
                            <select class="form-control" id = "monthSelect">
                                <option value="0">請先選擇年度</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default hidden-xs print showHide" onclick="printDiv('print')">列印月報表</button>
                    <div id="print" class="text-center">
                        <div class="col-xs-12 col-md-12 col-sm-12" id="schoolName">
                            <h3 class="text-center">108級畢業生聯合會</h3>
                            <h3 class="text-center"><year id="yearContent"></year>度<type id="monthContent"></type></h3>
                            <h3 class="text-center">月報表</h3>
                        </div>

                        <div class="col-xs-12 col-md-12 col-sm-12">
                        </div>

                        <div class="col-xs-12 col-md-12 col-sm-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th style="width:15%">日期</th>
                                    <th style="width:15%">會計項目</th>
                                    <!--
                                    <th style="width:23%">預計日期</th>
                                    -->
                                    <th style="width:30%">內容</th>
                                    <th style="width:20%">屬性</th>
                                    <th style="width:20%">金額</th>
                                  </tr>
                                </thead>
                                <tbody id="tbodyIn" style="vertical-align: middle">
                                 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="4">結算</td>
                                        <td class="text-center" id="allCostCount">0</td>
                                    </tr>
                                </tfoot>
                            </table>
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
        $("#print").hide();
        $(".print").hide();
        function printDiv(divName){
            var printContents = document.getElementById(divName).innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            location.reload();
        }

        $(window).load(function() {
            getYearContentSelect();
        });

        thisContentYear = {};
        thisConYearKey = -1;
        thisConYearName="";

        function getYearContentSelect(){
            $.ajax({
                url: base_url('finance/getYearSelect'),
                dataType: 'json',
                async:false,
                error:function(){alert('Ajax request 發生錯誤');},
                success: function(json){
                    thisContentYear = json;
                    $("#yearContentSelect").html('');
                    if(thisContentYear.length == 0){
                        $("#yearContentSelect").html('<option value="-1">目前社團沒有撰寫任何財務報表</option>');
                    }else{
                        $("#yearContentSelect").html('<option value="-1">請選擇欲顯示的年度</option>');
                    }
                    for(i=0;i<thisContentYear.length;i++){
                        $("#yearContentSelect").append('<option value="'+thisContentYear[i]['year']+'">'+thisContentYear[i]['year']+'年</option>');
                    }
                    if(thisContentYear.length == 0){
                        thisConYearKey = -1;
                        thisConYearName="";
                    }else{
                        thisConYearKey = thisContentYear[0]['year'];
                        thisConYearName= thisContentYear[0]['year'];
                    }
                }
            });
        }

        $("#yearContentSelect").change(function(event) {
            $("option:selected", this).each(function(){
                thisConYearName = $(this).html();
                thisConYearKey = this.value;
                if(thisConYearKey == -1){
                    $("#print").hide();
                    $(".showHide").hide();
                    $("#monthSelect").html('<option value="-1">請先選擇年度</option>');
                }else{
                    getMonthSelect(thisConYearKey);
                }
            });
        });

        thisMonthType = {};
        thisMonthKey = -1;
        thisMonthName="";
        function getMonthSelect(str){
            $.ajax({
                url: base_url('finance/getAllMonth'),
                dataType: 'json',
                async:false,
                type: 'POST',
                data: {year: str},
                error:function(){alert('Ajax request 發生錯誤');},
                success: function(json){
                    thisMonthType = json;
                    $("#monthSelect").html('');
                    for(i=0;i<thisMonthType.length;i++){
                        thisMonthType = json;
                        for(i=0;i<thisMonthType.length;i++){
                            $("#monthSelect").append('<option value="'+thisMonthType[i]['key']+'">'+thisMonthType[i]['name']+'月</option>');
                        }
                    }
                    thisMonthKey = thisMonthType[0]['key'];
                    thisMonthName = thisMonthType[0]['name']+"月";
                    getContentTable(thisMonthKey,thisConYearName,thisMonthName);
                }
            });
        }

        $("#monthSelect").change(function(event) {
            $("option:selected", this).each(function(){
                thisMonthKey = this.value;
                thisMonthName = $(this).html();
                getContentTable(thisMonthKey,thisConYearName,thisMonthName);
            });
        });

        function getContentTable(str,year,month){
            $.ajax({
                url: base_url('finance/getTable'),
                dataType: 'json',
                async:false,
                type:'post',
                data: {key : str},
                error:function(){alert('Ajax request 發生錯誤');},
                success: function(json){
                    var thisSelectTable = json;
                    var sun = parseInt(thisSelectTable['table'][0]['money']);
                    $('#tbodyIn').html('');
                    console.log(thisSelectTable[0]);
                    $('#tbodyIn').append('<tr><td></td><td>經費</td><td>'+thisSelectTable['table'][0]['content']+'</td><td>上一月結餘</td><td>'+thisSelectTable['table'][0]['money']+'</td></tr>');
                    for(var i=1;i<thisSelectTable['table'].length;i++){
                        var type = thisSelectTable['table'][i]['type']=='0'? '收入':'支出';
                        $('#tbodyIn').append('<tr><td>'+thisSelectTable['table'][i]['date']+'</td><td>'+thisSelectTable['table'][i]['item']+'</td><td>'+thisSelectTable['table'][i]['content']+'</td><td>'+type+'</td><td>'+thisSelectTable['table'][i]['money']+'</td></tr>');
                        if(thisSelectTable['table'][i]['type']=='0'){
                            sun += parseInt(thisSelectTable['table'][i]['money']);
                        }else{
                            sun -= parseInt(thisSelectTable['table'][i]['money']);
                        }
                    }
                    $('#allCostCount').html(sun);
                }
            });

            $("#yearContent").html(year);
            $("#monthContent").html(month);
            $("#print").show();
            $(".showHide").show();
            
        }

    </script>

</body>
</html>
