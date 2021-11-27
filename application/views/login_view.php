<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="">

        <title>STUGSA管理系統</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="<?php echo base_url('dist/') ?>assets/css/bootstrap.min.css">

        <!-- Custom styles for this template -->
        <style>
            html,
            body {
                font-family: '微軟正黑體', sans-serif;
                height: 100%;
            }

            body {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: center;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background: url(<?php echo base_url('dist/') ?>assets/images/header/02.jpg) center/cover no-repeat;
            }

            .form-signin {
                background-color: rgba(255, 255, 255, 0.6);
                border-radius:10px;
                width: 100%;
                max-width: 330px;
                padding: 50px;
                margin: auto;
            }
            .form-signin .checkbox {
                font-weight: 400;
            }
            .form-signin .form-control {
                position: relative;
                box-sizing: border-box;
                height: auto;
                padding: 10px;
                font-size: 16px;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="text"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }       
        </style>
    </head>

    <body class="text-center">
        <form class="form-signin" id="loginForm">
            <!-- <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
            <h1 class="h3 mb-3 font-weight-normal" style="color:#000000">登入系統</h1>
            <input type="text" id="inputId" class="form-control" placeholder="帳號" required autofocus>
            <input type="password" id="inputPassword" class="form-control" placeholder="密碼" required>
            <input type="hidden" id="token" class="form-control" value="<?php echo $token ?>">
            <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
            <p class="mt-5 mb-3" style="color:#444444">&copy; 2019 STUGSA-樹德科技大學109級畢業生聯合會.版權所有</p>
        </form>

        <?php $this->load->view('basic/jsLoad'); ?>
        <script>
            $("#loginForm").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: base_url('login/login'),
                    type: 'POST',
                    dataType: 'text',
                    data: {id: $('#inputId').val(),
                           pd: $('#inputPassword').val(),
                           token: $('#token').val()},
                })
                .done(function(e) {
                    if(e == "0"){
                        alert('帳號或密碼錯誤');
                    }else if (e == "2"){
                        alert('請確認輸入值是否正確');
                    }else if (e == "3"){
                        alert('請輸入帳號');
                    }else if (e == "4"){
                        alert('請輸入密碼');
                    }else if (e == "5"){
                        alert('登入請求有誤，請重新整理後再試');
                        //location.reload();
                    }else if(e == "1"){
                        location.reload();
                    }
                })
                .fail(function() {
                    alert('與伺服器連線失敗，請稍後再試');
                });
                
            });
        </script>

    </body>
    
</html>