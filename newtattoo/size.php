<?php
	session_start();
	include_once('db_conn.php');
	include_once('db_func.php');
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<!-- ****提示**** 以下『一條』指令要改  -->
	<!-- ****提示**** 網頁標題   改成自己的姓名、學號 -->
	<title>魁紋身</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<script type="text/javascript" src="script/jquery.js"></script>
    <script type="text/javascript" src="script/jquery-ui.js"></script>
    <script type="text/javascript" src="script/preview.js"></script>
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
							<a href="checkout.php">Cart</a>
							
						</li>
						<li>
							<a href="login.php"><?php if(! isset($_SESSION['ADMINUSER']) ) {
															echo 'Login'; 
													  }
													  else {
															echo 'Logout'; }
												?></a>| <a href="index.html">Signup</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="contents">
				<h4><span>所有商品</span></h4>
				<div id="stocks">
					<ul>
                       <?php
					   		//****提示**** 以下『兩條』指令要改	
							//****提示**** 查詢所有商店的所有商品
							//****提示**** 需要挑出來的欄位有：商店的代號、商店的名稱、商品的代號、商品的照片、商品的名稱、商品的價錢
							//****提示**** 商品可能沒有照片
							//****提示**** 顯示商品資料時，按照以下順序排好：商店代號、類別代號、商品代號
							$SQLStr = "SELECT * from 商品  where 代號>17 && 代號<21";
							$rs = db_query( $SQLStr  );   
							//echo("共有".mysql_num_rows($rs)."個商品*****");
							if (mysql_num_rows($rs)>0) { 
								$total = mysql_num_rows($rs); 
								for ($i=0; $i<$total; $i++)      {
									$row = mysql_fetch_array($rs);
									echo "<li>";
									//****提示**** 以下『一條』指令要改	
									//****提示**** 商品照片的檔名在 $row["圖檔名"] 裡、單價在 $row["價錢"] 裡、商品的名稱在 $row["商品名稱"] 裡
									echo  '<img src="images/'.$row["代號"] .'.jpg " alt="Img"> <span class="icon"></span></a> '.$row["商品名稱"].''.' <em>$'.$row["單價"].'</em><form action="checkout.php" method="POST"><input type=submit name="addCartOK" value="加到圖案暫存區" class="btn-cart"><input type=hidden name="buyproductno" value="'.$row['代號'].'"><input type=hidden name="buyqty" value="1"></form><a href="checkout.php" class="btn-wish">關注商品</a>';
									echo "</li>";
								}
							}
						?>                        
					</ul>
				</div>
				<div class="footer">
					<h4><span>本店作品</span></h4>
					<ul class="items">
                    <?php
					   for ($i=4;$i>=1;$i--) {
						echo "<li>";
						echo '<a href="product.html">';
						echo '<img src="images/picture'.$i.'.jpg" alt="Img"> 魁紋身</a>';
						echo '</li>';
					   }
					?>
					</ul>
				</div>
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