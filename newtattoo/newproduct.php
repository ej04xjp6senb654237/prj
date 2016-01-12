<?php
	header('content-type:text/html;charset=utf-8');
	session_start();
	unset($_SESSION['OPERATION']);
	$_SESSION['OPERATION']="ADMIN";
?>
<?php
	include_once('db_conn.php');
	include_once('db_func.php');
?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>魁紋身</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="background">
		<div id="page">
			<div id="header">
				<div id="logo">
					<a href="index.html"><img src="images/slogo.jpg" alt="LOGO"></a>
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
					</ul>
					<ul id="secondary">
						<li>
							<a href="checkout.html">Cart</a>
						</li>
						<li>
							<a href="index.html">Login</a> | <a href="index.html">Signup</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="contents">
				<div id="adbox">
					<div id="search">
						<h3>建立新商品的資料</h3>
						<?php
							$SQLStr = " select max(商品.代號) as maxpno from 商品";
							$rs = db_query($SQLStr);
							$row = db_fetch_array($rs);
							if ($row["maxpno"]==null){
								$newpno = 1;
							}
							else{
								$newpno = $row["maxpno"]+1;
							}
						?>
						<form action="addandbrowse.php" method="post" enctype="multipart/form-data"><p>
							新商品的代號<input name="newproductno" type="text" size="5" maxlength="5" value=<?php echo $newpno; ?> readonly></p>
							<p>商品照片 <input type="file" name="newproductphoto" value="img9.jpg" id="color" /></p>
							<ul>
								
								<li>
								<input name="newproductname" type="text" value="龍" size="20" maxlength="50" id="color">
								</li>
								<li>
								<input name="newproductprice" type="text" value="1000" size="20" maxlength="4" id="brand">
								</li>
								
							</ul>
							<input type="submit" name="adminok" value="確定新增" class="button">
							<input type="submit" name="adminok" value="直接瀏覽" class="button">
						</form>
					</div>
					<img src="images/blogo.jpg" height="355" width="618" alt="Promo"> <a href="index.html" class="button"></a> <span></span>
				</div>
			</div>
		</div>
	</div>
</body>
</html>