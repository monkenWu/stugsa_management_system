<!doctype html>
<html lang="zh-tw">
<head>
    <?php $this->load->view('basic/system/cssLoad'); ?>
    <style>
      #frame {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
      }
    </style>
</head>

<body class="bg-light">
    <?php $this->load->view('basic/system/navBar'); ?>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
            <a class="nav-link active" href="#">系統使用教學</a>
        </nav>
    </div>

    <div class="container">

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">使用說明書</h6>
            <div class="media text-muted pt-3">
                <iframe
                id="frame"
                src="<?php echo base_url("dist/畢業生聯合會資訊管理系統開發及使用說明書.pdf"); ?>"
                frameborder="0"
                width="1000px"
                height="800px"
                ></iframe>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php $this->load->view('basic/system/jsLoad'); ?>

</body>
</html>
