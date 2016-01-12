<?php
header('content-type:text/html;charset=utf-8');
session_start();
unset($_SESSION['OPERATION']);
unset($_SESSION['ADMINUSER']);
unset($_SESSION['ADMINPWD']);
unset($_SESSION['ADMINNAME']);
unset($_SESSION['ADMIN']);
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
	<!-- ****提示**** 以下『一條』指令要改  -->
	<!-- ****提示**** 網頁標題   改成自己的姓名、學號 -->
	<title>魁紋身</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script type = "text/javascript">
		function getCaptcha() {     
			var d = new Date();
			document.getElementById("captchaImage").
			setAttribute('src' , '../captcha/captcha.php?r='+ d.getTime());
		}
	</script>
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
						<li class="selected">
							<a href="login.php"><?php if(! isset($_SESSION['ADMINUSER']) ) {
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
				<div id="adbox">
					<div id="search">
						<?php 
							if (!isset($_POST['currUser']) && !isset($_POST['currPwd'])) {
						?>	
						<h3>登入系統</h3>
						<form action="login.php" method="post" enctype="multipart/form-data"><p>
							<ul>
								<li>
                                帳號：<input name="currUser" type="text" value="0915369373" size="15" maxlength="20" id="color">
								</li>
								<li>
                                密碼：<input name="currPwd" type="password"  value="ej04xjp6" size="15" maxlength="20" id="brand">
								</li>
							</ul>								
							   <img id="captchaImage" src="../captcha/captcha.php">
							   <input type="button" value = "換一組驗證數字" class="btn-another" onclick = "getCaptcha();">
								<p>請輸入圖中數字:	<input type="text" name="captcha" style="width: 80px"></p>
                            <input type="submit" name="loginok" value="登入" class="button">
						</form>
						<?php 
							}
							else {  //檢查輸入的『帳號、密碼、驗證碼』 是否正確
									$_SESSION['ADMINUSER']=$_POST['currUser'];
									$_SESSION['ADMINPWD']=$_POST['currPwd'];
									$_SESSION['Scaptcha']=$_POST['captcha'];
								//****提示**** 以下『兩條』指令要改	
								//****提示**** 輸入的會員帳號 在 $_SESSION['ADMINUSER'] 裡
								//****提示**** 輸入的會員密碼 在 $_SESSION['ADMINPWD'] 裡
								$SQLStr = "SELECT * FROM 會員 where 會員.手機號碼='".$_SESSION['ADMINUSER']."'"." and 會員.密碼='".$_SESSION['ADMINPWD']."'";
								$rs = db_query($SQLStr); 
								if (db_num_rows($rs)==0) { 
									echo '<script>alert("帳號或密碼錯誤！");' .    
										'location.href = "login.php"; </script>';   
									die();
								}
								
								if (isset($_POST['loginok'])){
								//****提示**** 以下『一條』指令要改	
								//****提示**** 輸入的驗證數字 在 $_POST['captcha'] 裡
									if ($_SESSION['captchaText'] != $_POST['captcha'] ) {                 
										echo '<script>alert("圖形驗證錯誤！");'.   
												'location.href = "login.php";</script> ';           
										die();
									}				
								}
								//登入成功，查詢這個會員是否『有開商店』？
								$row=db_fetch_array($rs);
								$_SESSION['ADMINNAME']=$row['姓名'];
								//****提示**** 以下『兩條』指令要改	
								//****提示**** 登入成功的這個會員，會員帳號 在 $_SESSION['ADMINUSER'] 裡
								
								

								$_SESSION['OPERATION']="ADMIN";
								//echo '店家='.$rs['權限'].$rs['手機號碼'].$rs['密碼'].'<br>';
								if ($row['權限']=='店家'){
									$_SESSION['ADMIN']=true;	
								//****提示**** 以下『一條』指令要改	
								//****提示**** 登入成功的這個會員，會員姓名 在 $_SESSION['ADMINNAME'] 裡									
									echo '<script>alert("'.$row['姓名'].'【店家】 登入成功！");'.   
												'location.href = "myshops.php";</script> '; 
								}
								else {
									$_SESSION['ADMIN']=false;
									//****提示**** 以下『一條』指令要改	
									//****提示**** 登入成功的這個會員，會員姓名 在 $_SESSION['ADMINNAME'] 裡	
									echo '<script>alert("'.$row['姓名'].'【一般會員】 登入成功！");'.   
												'location.href = "allproducts.php";</script> ';
								}
							}	
						?>
					</div>
					<img src="images/blogo.jpg" height="355" width="618" alt="Promo"> <a href="index.html" class="button"></a> <span></span>
				</div>
				<div id="main">
					<!-- 只要連到登入網頁，就要顯示所有商店 -->
						<h4><span>隨機圖案</span></h4>
						<?php 
						//****提示**** 以下『兩條』指令要改	
						//****提示**** 查詢所有商店
						$SQLStr = " select * from 商品 where 代號 < 5 ";
						$rs = db_query($SQLStr); 
						if (mysql_num_rows($rs)>0) { 
								$total = mysql_num_rows($rs); 
								for ($i=0; $i<$total; $i++)      {
									if (($i % 4)==0) {
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
					</div>
					<div id="sale">
						<h4><span>外部連結</span></h4>
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