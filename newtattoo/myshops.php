<?php
	session_start();
	unset($_SESSION['SHOPNO']);
	include_once('db_conn.php');
	include_once('db_func.php');
?>
<?php
	if(! isset($_SESSION['ADMINUSER']) || !$_SESSION['ADMIN']  ) {
		echo '<script>alert("只有店家可以使用這個網頁！");'.   
		'location.href = "login.php";</script> '; 
	}
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
		<!-- ****提示**** 以下『一條』指令要改  -->
		<!-- ****提示**** 這個店家會員的姓名 在 $_SESSION['ADMINNAME'] 裡  -->
	<title><?php echo $_SESSION['ADMINNAME'];?>的店</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script>
		function goback_myshops() {
			window.location="myshops.php";
		}
	</script>
</head>
<body>
	<div id="background">
		<div id="page">
			<div id="header">
				<div id="logo">
					<a href="index.html"><img src="images/slogo.jpg" alt="LOGO" width=386 height=53></a>
				</div>
				<div id="navigation">
					<ul id="primary">
						<li class="selected">
							<a href="allproducts.php">首頁</a>
						</li>
						<li>
							<a href="allproducts.php">瀏覽所有商品</a>
						</li>
						<li>
							<a href="checkout.php?gotocart=1">圖案暫存區</a>
						</li>
						<li>
							<a href="http://blog.xuite.net/tom5205202003/twblog/139024814-%E9%AD%81%E7%B4%8B%E8%BA%AB%E9%A4%A8%E6%90%AC%E9%81%B7%E4%B8%AD~%E9%AD%81%E7%B4%8B%E8%BA%AB%E9%A4%A8%E4%B8%89%E9%87%8D%E5%B8%82%E5%BA%97%E6%9A%AB%E5%81%9C%E7%87%9F%E6%A5%AD~%E8%8B%A5%E6%9C%89%E9%9C%80%E8%A6%81%E5%88%BA%E9%9D%92%E7%85%A9%E4%BE%86%E9%9B%BB0987431430">部落格</a>
						</li>
						<li>
							<a href="https://www.facebook.com/pages/%E9%AD%81%E7%B4%8B%E8%BA%AB%E5%88%BA%E9%9D%92%E9%A4%A8tattoo/718942681468920?__mref=message_bubble">FB粉絲專頁</a>
						</li>
						<li class="highlight">
							<a href="https://www.facebook.com/login.php?next=https%3A%2F%2Fwww.facebook.com%2Fgroups%2F595058067188760%2F%3F__mref%3Dmessage_bubble">FB社團</a>
						</li>
						<li class="highlight">
							<a href="https://tw.bid.yahoo.com/tw/user/Y4938519234;_ylt=A8tUwZiMd5NVzUQAiPRr1gt.;_ylu=X3oDMTEyaG8wc3JoBGNvbG8DdHcxBHBvcwMxBHZ0aWQDQTAyMDZfMQRzZWMDc3I">網路商店</a>
						</li>
						<li class="selected">
							<a href="members.php">會員</a>
						</li>
					</ul>
					<ul id="secondary">
						<li>
							<a href="login.php"><?php if(! isset($_SESSION['ADMINUSER']) || !$_SESSION['ADMIN'] ) {
															echo 'Login'; 
													  }
													  else {
															echo 'Logout'; }
												?></a>| <a href="newmember.php">註冊</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="contents">
						<!-- ****提示**** 以下『一條』指令要改  -->
						<!-- ****提示**** 這個店家會員的姓名 在 $_SESSION['ADMINNAME'] 裡  -->
				<h4><span><?php echo $_SESSION['ADMINNAME'];?>的店</span></h4>
				<div id="stocks">
					<ul>
                       <?php
					   		//****提示**** 以下『兩條』指令要改	
							//****提示**** 目前登入系統的這個會員，他的帳號 在 $_SESSION['ADMINUSER'] 裡
							$SQLStr = "SELECT * from 會員 where 手機號碼='".$_SESSION['ADMINUSER']."'";
							$rs = db_query($SQLStr);   
							if (mysql_num_rows($rs)>0) { 
								$total = mysql_num_rows($rs); 
								for ($i=0; $i<$total; $i++)      {
									$row = mysql_fetch_array($rs);
									echo "<li>";
									echo  '<a href="product.html" class="preview" title="Preview">';
									//****提示**** 以下『一條』指令要改	
									//****提示**** 每一間商店的代號，都在 $row['商店代號'] 裡
									//****提示**** 每一間商店的名稱，都在 $row['商店名稱'] 裡
									echo  '<img src="images/1.jpg" alt="Img"> <span><form action="addandbrowse.php" method="POST"><input type=submit name="browsemyshop" value="進入商店" class="btn-cart"></form></span>';
									echo  '</li>';                                                                                                                                                                                                                                      
								}
							}
							$_SESSION['OPERATION']="ADMIN";
						?>                        
					</ul>
				</div>
					<div class="footer">
					<h4><span>本店作品</span></h4>
					<ul class="items">

                    <?php
                    
					   for ($i=4;$i>=1;$i--) {
					   	
						//echo "<li>";
						echo '<a href="product.html">';
						echo '<img src="images/picture'.$i.'.jpg" alt="Img"> </a>';
						echo '</li>';
					   }
					?>
					</ul>
				</div>
			<div id="footer">
				<div class="background">
					<div id="connect">
						<h5>Get Social With us!</h5>
						<ul>
							<li>
								<a href="http://freewebsitetemplates.com/go/facebook/" target="_blank" class="facebook"></a>
							</li>
							<li>
								<a href="http://freewebsitetemplates.com/go/twitter/" target="_blank" class="twitter"></a>
							</li>
							<li>
								<a href="http://www.freewebsitetemplates.com/go/googleplus/" target="_blank" class="linkin"></a>
							</li>
						</ul>
					</div>
					<ul class="navigation">
						<li>
							<h5>Mens</h5>
							<a href="mens.html">Sneakers</a> <a href="mens.html">Boots</a> <a href="mens.html">Winter socks</a> <a href="mens.html">Lace-ups</a>
						</li>
						<li>
							<h5>Womens</h5>
							<a href="womens.html">Sneakers</a> <a href="womens.html">Boots</a> <a href="womens.html">Winter socks</a> <a href="womens.html">Lace-ups</a>
						</li>
						<li class="latest">
							<h5>New Arrivals</h5>
							<a href="new.html">Cheverlyn Zespax</a> <a href="new.html">Alta Ulterior</a> <a href="new.html">Mikee</a> <a href="new.html">Jeeroks Copy</a>
						</li>
						<li class="latest">
							<h5>On Sale Items</h5>
							<a href="sale.html">Cheverlyn Zespax</a> <a href="sale.html">Alta Ulterior</a> <a href="sale.html">Mikee</a> <a href="sale.html">Jeeroks Copy</a>
						</li>
					</ul>
					<p class="footnote">
						&copy; Copyirght &copy; 2011. <a href="index.html">Company name</a> all rights reserved.
					</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>