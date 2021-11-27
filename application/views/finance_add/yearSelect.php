<div class="form-row align-items-cente">
    <div class="my-1">
        <h6 style="padding-top: 5px">年份:</h6>
    </div>
    <div class="col-sm-5 my-1">
        <select class="form-control" id ="add_budgetYear">

        </select>
    </div>
    <div class="my-1">
        <h6 style="padding-top: 5px">月份:</h6>
    </div>
    <div class="col-sm-5 my-1">
        <select class="form-control" id = "add_budgetMonth">
            <option value="0">請先開帳</option>
        </select>
    </div>
    
    <button type="button" class="btn btn-info" onclick="billing()" >報表開帳</button>
</div>

<script>
    $(window).load(function() {
        checkYear();
    });

    thisYear=-1;
    thisType=-1;
    thisCount=0;
    function checkYear(){
        $.ajax({
            url: base_url('finance_management/checkYear'),
            dataType: 'json'
        })
        .done(function(e) {
            var yearJson = e;
            if(yearJson['type'] == 0){
                $('#add_budgetYear').html('<option>初次使用系統，按下按鈕開帳</option>');
            }else if(yearJson['type'] == 1){
                $('#add_budgetYear').html('<option>前一年度報表已完成，按下按鈕進行下一年度開帳</option>');
            }else if(yearJson['type'] == 2){
                $('#add_budgetYear').html('<option>前一月份報表已完成，按下按鈕進行下一月份開帳</option>');
            }else if(yearJson['type'] ==3){
                $('#add_budgetYear').html('<option>'+yearJson['year']+'</option>');
                $('#add_budgetMonth').html('<option>'+yearJson['month']+'</option>');
                thisYear = yearJson['key'];
                thisCount = yearJson['count'];
                if(yearJson['month']==1){
                    $('#openContent').val('本年度開帳金額');
                }else{
                    $('#openContent').val('本月份開帳金額');
                }
                $('#openCost').val(thisCount);
                $('#allCostCount').html(thisCount);
                changeSelect();
                $('#tableAllDiv').show();
                $('.hideButton').show();
            }else if(yearJson['type'] ==4){
                $('#add_budgetYear').html('<option>'+yearJson['year']+'</option>');
                $('#add_budgetMonth').html('<option>'+yearJson['month']+'</option>');
                thisYear = yearJson['key'];
                thisCount = yearJson['count'];
                if(yearJson['month']==1){
                    $('#openContent').val('本年度開帳金額');
                }else{
                    $('#openContent').val('本月份開帳金額');
                }
                $('#openCost').val(thisCount);
                $('#allCostCount').html(thisCount);
                changeSelect();
                $('#tableAllDiv').show();
                $('.hideButton').show();
                setTimeout('temporaryContent()',200);
            }
            thisType = yearJson['type'];
        })
        .fail(function() {
            alert('未知的連線錯誤，無法取得報表年度');
        //swal('錯誤','未知的連線錯誤，無法取得報表年度','error');
        });
    }

    function billing(){
        text = "";
        if(thisType==0){
            text = "初次使用系統，開帳後將從今年一月、並且金額從0開始。";
        }else if(thisType==1){
            text = "按下確定便可以開始進行下個年度的月報表撰寫。";
        }else if(thisType==2){
            text = "按下確定便可以開始進行下個月份的月報表撰寫。";
        }else if(thisType==3 || thisType==4){
            alert('必須完成這個月的帳目才能替下個月的報表開帳');
            return 0;
        }
        if(confirm("確定要開帳嗎？")){
            $.ajax({
                url: base_url('finance_management/billing'),
                dataType: 'json'
            })
            .done(function(e) {
                var billingJson = e;
                    if(billingJson['type'] == 0){
                    checkYear();
                }else if(billingJson['type'] == 1){
                    alert('必須完成這個月的帳目才能替下個月的報表開帳');
                }
            })
            .fail(function() {
                alert('未知的連線錯誤，無法取得開帳資訊');
            });
        }
    }

    function temporaryContent(){
        $.ajax({
            url:  base_url('finance_management/getTemporaryContent'),
            type: 'POST',
            dataType: 'json'
        })
        .done(function(e) {
            var jsonData = e;
            for(var i = 0;i<jsonData['table'].length;i++){
                if(i!=0){
                    temporaryOneCost(jsonData['table'][i],i);
                }
            }
            setTimeout('sunAllCost()',200);
        })
        .fail(function() {
            alert('未知的連線錯誤，無法取得暫存內容');
        });
    }
  

</script>
