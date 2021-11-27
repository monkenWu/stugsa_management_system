<div class="modal fade chart-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">活動參與狀況統計</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="text-center">參與學生與未參與學生占比</h5>
                        <div id="chart-div">
                            <canvas id="chart-area" style="display: block; width: 634px; height: 317px;" width="634" height="317" class="chartjs-render-monitor"></canvas>
                        </div>
                         
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
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
                    <div class="col-md-2"></div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

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
                $('.chart-modal').modal('show');
            }else{
                alert('取得失敗，請重試');
            }
        })
        .fail(function() {
            alert('伺服器連線失敗，請確認網路連線或重新送出');
        });
    }

    function renderChart(activityData){
        $('#chart-div').html(`<canvas id="chart-area" style="display: block; width: 634px; height: 317px;" width="634" height="317" class="chartjs-render-monitor"></canvas>`);
        var ctx = document.getElementById('chart-area').getContext('2d');
        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        activityData['check'],
                        activityData['uncheck']
                    ],
                    backgroundColor: [
                        '#ff6384',
                        '#4bc0c0'
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    '參與本活動成員',
                    '未參加學生'
                ]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };
        window.myDoughnut = new Chart(ctx, config);
        $('#part').html(`
            <td>${activityData['allMember']}</td>
            <td>${activityData['check']}</td>
            <td>${activityData['uncheck']}</td>
            <td>${activityData['rate']}%</td>
        `);
    }

</script>