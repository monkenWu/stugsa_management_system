	<?php $this->load->view("basic/begin");?>
		<style>
		</style>
	</head>

	<body class="gray-bg">
		<div class="middle-box text-center animated fadeInDown">
			<h1>404</h1>
			<h3 class="font-bold">未找尋到頁面</h3>
			<div class="error-desc">
				請確認您輸入的網址沒有錯誤或該頁面維護中，如有疑問可於上班時間內聯絡平台管理人。
                <div>
                    <hr>
                    <button type="submit" class="btn btn-primary" onclick="javascript:history.back()">回上一頁</button>
                </div>
			</div>
		</div>

		<!-- Mainly scripts -->
		<script src="/codeigniter/dist/js/jquery-2.1.1.js"></script>
		<script src="/codeigniter/dist/js/bootstrap.min.js"></script>
	</body>
</html>