<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
    <style>
        .flip_wrap{
            display:inline-block;
            width:100%;
            height:220px;
            perspective:800px;
            box-sizing:border-box;
        }
        .flip{
            width: 100%;
            height:100%;
            backface-visibility:hidden;
            transition: all 1s ease;
            transform-style:preserve-3d;
        }
        .side{
            width:100%;
            height: 100%;
            position:absolute;
            left:0;
            top:0;
            /*   color: #fff; */
            text-align:ceter;
            opacity:0.5;
        }
        .front{
            backface-visibility:hidden;
            border: 1px solid #ccc;
            font-size: 18px;
            background:#ffced9;
            position: relative;
        }
        .frontImg{
            position: absolute;
            top:45%;
            margin-top: -35px;
        }
        .back{
            backface-visibility:hidden;
            transform: rotateY(180deg);
            background:#ffd484;
            box-sizing:border-box;
        }
        /* .flip_wrap:hover .flip{
            animation: flip ease-in 2s;
            animation-fill-mode: forwards;
        } */
        @keyframes flip {
            from {
                transform : rotateY(0deg);
            }
            to {
                transform : rotateY(180deg);
            }
        }

    </style>

    <style media="print">
        .table-bordered,
        .table-bordered th,
        .table-bordered td{
            border: 1px solid #000000!important;
        }
    </style>
</head>

<body class="bg-light" >
    <div id="allView">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link active" href="<?php echo base_url('lottery_game') ?>">抽獎活動</a>
        </nav>
    </div>

    <div class="container">

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">抽獎活動</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 text-center">
                        <h5 style="margin-top:15px">市在畢得市集參加統計</h5>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th scope="col">總會員數</th>
                                    <th scope="col">參與人數</th>
                                    <th scope="col">未參加人數</th>
                                    <th scope="col">參加率</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="part">
                                    <td>1680</td>
                                    <td>380</td>
                                    <td>1180</td>
                                    <td>10%</td>
                                </tr>
                            </tbody>
                         </table>
                    </div>

                    <div class="col-md-12 text-center">
                        <h5 style="margin-top:15px">即時抽獎資訊</h5>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th scope="col">參與人數</th>
                                    <th scope="col">剩餘獎品數</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="nowNum">1680</td>
                                    <td id="nowPre">24</td>
                                </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 text-center">
                        <h5 style="margin-top:15px">獎項區</h5>
                    </div>
                    <div class="col-md-12" id="giftArea">
                        
                    </div>
                </div>

                <div class="col-md-12" id="print">
                    <div class="col-md-12 text-center">
                        <h5 style="margin-top:15px">得獎資訊</h5>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th scope="col">獎品名稱</th>
                                    <th scope="col">得獎人</th>
                                </tr>
                            </thead>
                            <tbody id="nowGet">
                                <!-- <tr>
                                    <td id="nowNum">1680</td>
                                    <td id="nowPre">24</td>
                                </tr> -->
                            </tbody>
                         </table>
                    </div>
                </div>
                <div class="col-md-12 text-center" >
                    <button type="button" class="btn btn-secondary" onclick="printDiv('print')">列印得獎名單</button>
                </div>
            </div>


        </div>


    </div>
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php $this->load->view('basic/system/jsLoad'); ?>

    <?php $this->load->view('lottery/getGift'); ?>

    <script>
        $(window).load(function() {
            chartActivity('Nw==');
            renderGift();
            getAllUnMember();
        });

        function chartActivity(key){
            $.ajax({
                url: base_url('activity_management/getChartActivity'),
                type: 'POST',
                dataType: 'json',
                data: {key : key},
            })
            .done(function(e) {
                if(e.status == 1){
                    renderChart(e);
                }else{
                    alert('取得失敗，請重試');
                }
            })
            .fail(function() {
                alert('伺服器連線失敗，請確認網路連線或重新送出');
            });
        }

        function renderChart(activityData){
            $('#part').html(`
                <td>${activityData['allMember']}</td>
                <td>${activityData['check']}</td>
                <td>${activityData['uncheck']}</td>
                <td>${activityData['rate']}%</td>
            `);
            $('#nowNum').html(activityData['uncheck']);
        }

        function pushGiftArea(memberInfo,pushGifeName){
            $('#nowGet').append(`
                <tr>
                    <td id="nowNum">${pushGifeName}</td>
                    <td id="nowPre">
                        ${memberInfo.s_name}-
                        ${memberInfo.d_name}-
                        ${memberInfo.c_name}班-
                        ${memberInfo.studentid}
                    </td>
                </tr>
            `);
        }

        var allMember = [];
        function getAllUnMember(){
            $.ajax({
                url: base_url('lottery_game/getAllUnMember'),
                type: 'GET',
                dataType: 'json'
            })
            .done(function(e) {
                allMember = e;
                allMember.sort(function() {
                    return (0.5-Math.random());
                });
            })
            .fail(function() {
                alert('伺服器連線失敗，請確認網路連線或重新送出');
            });
        }

        function getRandom(x){
            return Math.floor(Math.random()*x);
        };

        function getOneMember(){
            var randomNumber = getRandom(allMember.length);
            var thisMember = allMember[randomNumber];
            allMember.splice(randomNumber,1);
            $('#nowNum').html(allMember.length);
            $('#nowPre').html(($('#nowPre').html())-1);
            allMember.sort(function() {
                return (0.5-Math.random());
            });
            return thisMember;
        }


        var gift = [
            {
                name:"switch",
                amount:1
            },
            {
                name:"小米掃地機器人",
                amount:1
            },
            {
                name:"小米空氣清淨機",
                amount:1
            },
            {
                name:"小米手環3",
                amount:1
            },
            {
                name:"快煮鍋",
                amount:1
            },
            {
                name:"24吋行李箱",
                amount:1
            },
            {
                name:"夏慕尼餐券一張",
                amount:2
            },
            {
                name:"海港餐券一張",
                amount:3
            },
            {
                name:"西堤餐券一張",
                amount:2
            },
            {
                name:"統一超商兩百元禮卷",
                amount:7
            },
            {
                name:"威秀電影套票",
                amount:4
            }
        ];

        function renderGift(){
            var amount=0;
            for(var i=0;i<gift.length;i++){
                $('#giftArea').append(`
                    <button type="button" class="btn btn-success" style="margin-bottom:20px" onclick="lottery('${gift[i].name}',${gift[i].amount},this)">${gift[i].name}</button>
                `);
                amount += gift[i].amount;
            }
            $('#nowPre').html(amount);
        }

        function printDiv(divName){
            var printContents = document.getElementById(divName).innerHTML;
            var allView = document.getElementById('allView').innerHTML;
            document.body.innerHTML = printContents;
            $('body').attr('style', 'padding-top:0');
            window.print();
            document.body.innerHTML = allView;
            $('body').removeAttr('style');
            //location.reload();
        }
        
    </script>

</body>
</html>
