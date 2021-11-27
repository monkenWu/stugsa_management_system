<div class="modal fade lottery-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">抽出獎項</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title text-center" style="margin-bottom: 20px"  id="giftNameTitle">現正抽出：</h5>
                <div class="row" id="giftCardArea">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    // $(".flip").bind("click",function(event) {
        
    // });
    // $("span.msg-data").each(function() {
    //     $(this)[0].addEventListener("animationend",function(){
    //         $(this).css("animation","");
    //     });
    // });

    var nowAmount = 0;
    var allAmount = 0;
    var nowGift = "";
    function lottery(giftName,amount,object){
        allAmount = amount;
        nowAmount = 0;
        nowGift = giftName;
        $('#giftNameTitle').html('現正抽出：'+amount+'個「'+giftName+'」');
        $('#giftCardArea').html('');
        for(var i=0; i<amount; i++){
            $('#giftCardArea').append(renderNewCard());
        }
        $('.lottery-modal').modal('show');
        $(object).attr('disabled', 'disabled');
    }

    function renderNewCard(){
        var card = `
            <div class="col-md-3">
                <div class = "flip_wrap">
                    <div class = "flip" onclick="cardClick(this)">
                        <div class = "side front">
                            <img src="${base_url('dist/assets/images/logoCard.png')}" class="img-fluid frontImg" alt="Responsive image">
                        </div>
                            <!--反面-->
                        <div class = "side back">
                            <br>
                            <p class="text-center">
                                日間部四技
                            </p>
                            <p class="text-center">
                                資訊工程系
                            </p>
                            <p class="text-center">
                                甲班
                            </p>
                            <p class="text-center">
                                15115127
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        return card;
    }

    function cardClick(object){
        nowAmount++;
        var thisCardOneMember = getOneMember();
        $(object).children(".back").html(`
            <br>
            <p class="text-center">
                ${thisCardOneMember.s_name}
            </p>
            <p class="text-center">
                ${thisCardOneMember.d_name}
            </p>
            <p class="text-center">
                ${thisCardOneMember.c_name}班
            </p>
            <p class="text-center">
                ${thisCardOneMember.studentid}
            </p>
        `);
        $(object).css('animation', 'flip ease-in 1s');
        $(object).css('animation-fill-mode', 'forwards');
        pushGiftArea(thisCardOneMember,nowGift);
    }

    $('.lottery-modal').on('hidden.bs.modal ', function (e) {
        if(nowAmount != allAmount){
            alert('抽獎還沒結束！');
            $('.lottery-modal').modal('show');
        }
    })

</script>