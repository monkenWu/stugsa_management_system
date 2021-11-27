<tbody id="butgetTbody">
    <tr id="butgetCost_1">
    <td class="text-center"></td>
    <td>
      
    </td>
    <td>
        <select class="form-control" name="cost" disabled >
            <option value="0" >資金</option>
        </select>
    </td>
    <td class="costAllTable">
        <input class="form-control col-sm-12" type="text" name="cost" placeholder="簡述這筆項目內容" id="openContent" disabled >
    </td>
    <td class="costAllTable">
        <select class="form-control" name="cost" disabled >
            <option value="0">收入</option>
        </select>
    </td>
    <td class="text-center" id="costSun_0">
        <input class="form-control col-sm-12" type="number" name="cost" id="openCost" disabled >
    </td>
    </tr>
    <form id="cost1">
        <tr>
            <td class="text-center"></td>
            <td>
                <input class="form-control col-sm-12" type="date" id="dateInput1" name="cost">
            </td>
            <td>
            <select class="form-control add_budgetItem" id="selectCost1" name="cost">
                <option value="0">文書費</option>
                <option value="1">講座鐘點費</option>
                <option value="2">餐費</option>
            </select>
            </td>
            <td class="costAllTable">
                <input class="form-control col-sm-12" type="text" name="cost" id="contentInput1" placeholder="簡述這筆項目內容">
            </td>
            <td class="costAllTable" id="costSelect1">
                <select class="form-control" name="cost" onchange="sunAllCost()">
                    <option value="0">收入</option>
                    <option value="1">支出</option>
                </select>
            </td>
            <td class="text-center" id="costSun_1">
                <input class="form-control col-sm-12" type="number" name="cost" id="moneyInput1" min="0" onchange="sunAllCost()">
            </td>
        </tr>
    </form>
</tbody>
<tfoot>
    <tr>
        <td class="text-right" colspan="5">結算</td>
        <td class="text-center" id="allCostCount">0</td>
    </tr>
</tfoot>
<script>
    costNum = 1;
    function addOneCost(){
        costNum++;
        $('#costForms').append('<form id="cost'+costNum+'"><form>');
        $('#butgetTbody').append('<tr id="butgetCost_'+costNum+'"></tr>');
        $('#butgetCost_'+costNum).append('<td class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="delCost(\'#butgetCost_'+costNum+'\')">x</button></td>');
        $('#butgetCost_'+costNum).append('<td><input class="form-control col-sm-12" type="date" name="cost" id="dateInput'+costNum+'" form="cost'+costNum+'"></td>');
        $('#butgetCost_'+costNum).append('<td><select class="form-control add_budgetItem" name="cost" id="selectCost'+costNum+'" form="cost'+costNum+'"></select></td>');
        for(i=0;i<thisItem.length;i++){
            $("#selectCost"+costNum).append('<option value="'+thisItem[i]['key']+'">'+thisItem[i]['name']+'</option>');
        }
        $('#butgetCost_'+costNum).append('<td class="costAllTable"><input class="form-control col-sm-12" type="text" name="cost" placeholder="簡述這筆項目內容" form="cost'+costNum+'"></td>'); 
        $('#butgetCost_'+costNum).append('<td class="costAllTable"><select class="form-control" name="cost" form="cost'+costNum+'" onchange="sunAllCost()"><option value="0">收入</option><option value="1">支出</option></select></td>'); 
        $('#butgetCost_'+costNum).append('<td class="text-center" id="costSun_1"><input class="form-control col-sm-12" type="number" name="cost" min="0" form="cost'+costNum+'" onchange="sunAllCost(this.value)"></td>');
  }

  function temporaryOneCost(oneData,num){
    if(num == 1){
        $('#dateInput1').val(oneData['date']);
        $('#contentInput1').val(oneData['content']);
        if(oneData['type'] == '1'){
            $('#costSelect1').html('<select class="form-control" name="cost" form="cost'+costNum+'" onchange="sunAllCost()"><option value="0">收入</option><option value="1" selected>支出</option></select>');
        }else{
            $('#costSelect1').html('<select class="form-control" name="cost" form="cost'+costNum+'" onchange="sunAllCost()"><option value="0" selected>收入</option><option value="1">支出</option></select>');
        }
        $('#selectCost1').html('');
        for(i=0;i<thisItem.length;i++){
            if(thisItem[i]['name'] == oneData['item']){
                $("#selectCost1").append('<option value="'+thisItem[i]['key']+'" selected>'+thisItem[i]['name']+'</option>');
            }else{
                $("#selectCost1").append('<option value="'+thisItem[i]['key']+'">'+thisItem[i]['name']+'</option>');
            }
        }
        $('#moneyInput1').val(oneData['money']);
    }else{
        costNum++;
        $('#costForms').append('<form id="cost'+costNum+'"><form>');
        $('#butgetTbody').append('<tr id="butgetCost_'+costNum+'"></tr>');
        $('#butgetCost_'+costNum).append('<td class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="delCost(\'#butgetCost_'+costNum+'\')">x</button></td>');
        $('#butgetCost_'+costNum).append('<td><input class="form-control col-sm-12" type="date" name="cost" id="dateInput'+costNum+'" form="cost'+costNum+'"></td>');
        $('#dateInput'+costNum).val(oneData['date']);
        $('#butgetCost_'+costNum).append('<td><select class="form-control add_budgetItem" name="cost" id="selectCost'+costNum+'" form="cost'+costNum+'"></select></td>');
        for(i=0;i<thisItem.length;i++){
            if(thisItem[i]['name'] == oneData['item']){
                $("#selectCost"+costNum).append('<option value="'+thisItem[i]['key']+'" selected>'+thisItem[i]['name']+'</option>');
            }else{
                $("#selectCost"+costNum).append('<option value="'+thisItem[i]['key']+'">'+thisItem[i]['name']+'</option>');
            }
        }
        $('#butgetCost_'+costNum).append('<td class="costAllTable"><input class="form-control col-sm-12" type="text" name="cost" placeholder="簡述這筆項目內容" form="cost'+costNum+'" value="'+oneData['content']+'"></td>');
        if(oneData['type'] == '1'){
            $('#butgetCost_'+costNum).append('<td class="costAllTable"><select class="form-control" name="cost" form="cost'+costNum+'" onchange="sunAllCost()"><option value="0">收入</option><option value="1" selected>支出</option></select></td>');
        }else{
            $('#butgetCost_'+costNum).append('<td class="costAllTable"><select class="form-control" name="cost" form="cost'+costNum+'" onchange="sunAllCost()"><option value="0" selected>收入</option><option value="1">支出</option></select></td>');
        }
        $('#butgetCost_'+costNum).append('<td class="text-center" id="costSun_1"><input class="form-control col-sm-12" type="number" name="cost" min="0" form="cost'+costNum+'" onchange="sunAllCost(this.value)" value="'+oneData['money']+'"></td>');
    }
    
  }

  function delCost(idStr){
    if(confirm('按下確定後將會刪除這筆帳目')){
        $(idStr).remove();
        sunAllCost();
    }
  }

  function sunAllCost(){
    var sun = thisCount;
    for(i=1;i<=costNum;i++){
        var tableArray = $('#cost'+i).serializeArray();
        console.log(tableArray);
        if(tableArray.length!=0){
            if(tableArray[3]['value'] == "0"){
                sun += tableArray[4]['value'] == "" ? 0 :parseInt(tableArray[4]['value']);
            }else{
                sun -= tableArray[4]['value'] == "" ? 0 :parseInt(tableArray[4]['value']);
            }
        }
    }
    $('#allCostCount').html(sun);
  }


  /*
  

  */
</script>