<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">編輯會計項目</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" >
                  <thead>
                    <tr>
                      <th style="width:40%">選擇</th>
                      <th style="width:80%">會計項目名稱</th>
                    </tr>
                  </thead>
                  <tbody class="text-center" id="editItemTable">
                    
                  </tbody>
                </table>
                <div class="row">
                  <div class="col-md-9">
                    <button type="button" class="btn btn-info hide-type"  onclick="showItemEdit('add')">新增項目</button>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">完成</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
    function itemModal(){
        getItem();
        $('#itemModal').modal('show');
    }

    thisItem=[];
    function getItem(){
        $.ajax({
            url:  base_url('finance_management/getAllItem'),
            type: 'POST',
            dataType: 'json',
        })
        .done(function(e) {
            thisItem = e;
            $("#editItemTable").html('');
            for(i=0;i<thisItem.length;i++){
            $("#editItemTable").append('<tr id="item-'+thisItem[i]['key']+'"><td><button type="button" class="btn btn-danger" onclick="showItemEdit(\'del\','+thisItem[i]['key']+')">刪除</button>　<button type="button" class="btn btn-warning" id="itemEdit_'+thisItem[i]['key']+'" data-itemKey="'+thisItem[i]['key']+'" onclick="showItemEdit(\'edit\','+thisItem[i]['key']+')">編輯</button><button type="button" class="btn typeEditOver btn-success" id="itemEditOver_'+thisItem[i]['key']+'" onclick="showItemEdit(\'submit\','+thisItem[i]['key']+')">完成</button></td><td id="itemName_'+thisItem[i]['key']+'">'+thisItem[i]['name']+'</td></tr>');
            }
            $('.typeEditOver').hide();
            })
        .fail(function() {
            alert('取得會計項目失敗 ');
        });
    }

    function changeSelect(){
        $.ajax({
            url: base_url('finance_management/getAllItem'),
            type: 'POST',
            dataType: 'json',
        })
        .done(function(e) {
            thisItem = e;
            $(".add_budgetItem").html('');
            for(i=0;i<thisItem.length;i++){
                $(".add_budgetItem").append('<option value="'+thisItem[i]['key']+'">'+thisItem[i]['name']+'</option>');
            }
        })
        .fail(function() {
            swal('錯誤','連線或未知的錯誤，無法取得會計項目','error');
        });
    }

    function showItemEdit(str,key){
        if(str == "add"){
            $.ajax({
            url: base_url('finance_management/addItem'),
            dataType: 'text',
            async:false,
            error:function(){alert('Ajax request 發生錯誤');},
            success: function(key){
                $('#editItemTable').append('<tr id="item-'+key+'"><td><button type="button" class="btn btn-danger" onclick="showItemEdit(\'del\','+key+')">刪除</button>　<button type="button" class="btn btn-warning" id="itemEdit_'+key+'" data-itemKey="'+key+'" onclick="showItemEdit(\'edit\','+key+')">編輯</button><button type="button" class="btn typeEditOver btn-success" id="itemEditOver_'+key+'" onclick="showItemEdit(\'submit\','+key+')">完成</button></td><td id="itemName_'+key+'">請編輯新的項目</td></tr>');
                $('#itemEditOver_'+key).hide();
                changeSelect();
            }
            });
        }else if(str == "submit"){
          if($('#itemNameEdit_'+key).val()==""){
            alert('請填入會計項目名稱才能完成');
          }else{
            $.ajax({
                url: base_url('finance_management/editItem'),
                dataType: 'text',
                async:false,
                type:'post',
                data: {key : key,
                 name : $('#itemNameEdit_'+key).val()},
                error:function(){alert('Ajax request 發生錯誤');},
                success: function(){
                    $('#itemName_'+key).html($('#itemNameEdit_'+key).val());
                    $('#itemEditOver_'+key).hide();
                    $('#itemEdit_'+key).show();
                    changeSelect();
                }
            });
          }
        }else if(str == "del"){
            if(confirm('確定要刪除這個項目嗎？')){
                $.ajax({
                    url: base_url('finance_management/delItem'),
                    dataType: 'text',
                    async:false,
                    type:'post',
                    data: {key : key},
                    error:function(){alert('Ajax request 發生錯誤');},
                    success: function(e){
                        if(e == 0){
                            alert('這個會計項目已在使用中');
                        }else{
                            getItem();
                            changeSelect();
                        }
                    }
                });
            }
        }else if(str == "edit"){
          $('#itemName_'+key).html('<input class="form-control text-center" type="text" id="itemNameEdit_'+key+'" value="'+ $('#itemName_'+key).html()+'">');
          $('#itemName_'+key).html();
          $('#itemEditOver_'+key).show();
          $('#itemEdit_'+key).hide();
        }
      }

    /*
    
    */
</script>