
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
						<h3>修改商品的資料</h3>
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
							商品代號<input name="updproductno" type="text" size="5" maxlength="5" value=<?php echo $_POST['updproductno']; ?> readonly> </p>
							<?php
								$SQLStr = "select 商品.*,商品照片.圖檔名 from 商品 inner join 商品照片 
											where 商品.代號=商品照片.代號 and 商品.代號=".$_POST['updproductno'];
								$rs = db_query($SQLStr);
								if (mysql_num_rows($rs)>0) {
									$row = mysql_fetch_array($rs);
								}
								@$_SESSION['PHOTOfilename']=$row['圖檔名'];
							?>
							<p>商品照片 <input type="file" name="newproductphoto" id="color" /></p>
							<ul>
								
								<li>
									<input name="newproductname" type="text" value="<?php echo $row['商品名稱']; ?>" size="20" maxlength="50" id="color">
								</li>
								<li>
									<input name="newproductprice" type="text" value="<?php echo $row['單價']; ?>" size="20" maxlength="4" id="brand">
								</li>
								
							</ul>
							<input type="submit" name="adminok" value="確定修改" class="button">
							<input type="submit" name="adminok" value="直接瀏覽" class="button">
						</form>
					</div>
					<img src="images/blogo.jpg" height="355" width="618" alt="Promo"> <a href="index.html" class="button"></a> <span></span>
				</div>
				<div id="main">
					<div id="featured">
						<h4><span>推薦商品</span></h4>
						<ul class="items">
							<?php 
						//****提示**** 以下『兩條』指令要改	
						//****提示**** 查詢所有商店
						$SQLStr = " select * from 商品 where 代號 < 5 ";
						$rs = db_query($SQLStr); 
						if (mysql_num_rows($rs)>0) { 
								$total = mysql_num_rows($rs); 
								for ($i=0; $i<$total; $i++)      {
									if (($i % 4)==1) {
										echo '<ul class="items">';
									}
									$row = mysql_fetch_array($rs);
									echo "<li>";
									echo  '<a href="allproducts.php">';
									//****提示**** 以下『一條』指令要改	
									//****提示**** 商店名稱的值 在     $row['商店名稱']   裡
									echo  '<img src="images/'.$row["代號"] .'.jpg "alt="Img"> <br><span>'. $row['商品名稱'] .'</span>'.'</a>';
									echo "</li>";
									if (($i % 4)==3) {
										echo '</ul>';
									}
								}
							}
						?>
						</ul>
					</div>
					<div id="sale">
						<h4><span>其它商品</span></h4>
						<ul class="items">
							<li>
								<!-- ****提示**** 以下『一條』指令要改  -->
								<!-- ****提示**** 這個超鏈結 要連到第１題的截圖  -->
								<a href="http://blog.xuite.net/tom5205202003/twblog/139024814-%E9%AD%81%E7%B4%8B%E8%BA%AB%E9%A4%A8%E6%90%AC%E9%81%B7%E4%B8%AD~%E9%AD%81%E7%B4%8B%E8%BA%AB%E9%A4%A8%E4%B8%89%E9%87%8D%E5%B8%82%E5%BA%97%E6%9A%AB%E5%81%9C%E7%87%9F%E6%A5%AD~%E8%8B%A5%E6%9C%89%E9%9C%80%E8%A6%81%E5%88%BA%E9%9D%92%E7%85%A9%E4%BE%86%E9%9B%BB0987431430"> <img src="images/picture1.jpg" alt="Img"> 部落格</a>
							</li>
								<!-- ****提示**** 以下『一條』指令要改  -->
								<!-- ****提示**** 這個超鏈結 要連到第２題的截圖  -->
							<li>
								<a href="https://www.facebook.com/pages/%E9%AD%81%E7%B4%8B%E8%BA%AB%E5%88%BA%E9%9D%92%E9%A4%A8tattoo/718942681468920?__mref=message_bubble" target= blank> <img src="images/picture2.jpg" alt="Img">FB粉絲專頁</a>
							</li>
							<li>
								<a href="https://www.facebook.com/login.php?next=https%3A%2F%2Fwww.facebook.com%2Fgroups%2F595058067188760%2F%3F__mref%3Dmessage_bubble"> <img src="images/picture3.jpg" alt="Img">  FB社團</a>
							</li>
							<li>
								<a href="https://tw.bid.yahoo.com/tw/user/Y4938519234;_ylt=A8tUwZiMd5NVzUQAiPRr1gt.;_ylu=X3oDMTEyaG8wc3JoBGNvbG8DdHcxBHBvcwMxBHZ0aWQDQTAyMDZfMQRzZWMDc3I"> <img src="images/picture4.jpg" alt="Img"> 網路商店</a>
						</ul>
					</div>
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