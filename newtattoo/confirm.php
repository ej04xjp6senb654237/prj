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
	
	<script>
		function goback_newphpdb() {
			window.location="allproducts.php";
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
							<p><input type=button name=backtobrowse value='回瀏覽所有商品' onclick='goback_newphpdb();'></p>
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
				<div id="checkout">
				<?php
					if(! isset($_SESSION['ADMINUSER'])) {
							echo '<script>alert("不可以直接進入這個網頁～請先登入！");'.   
												'location.href = "login.php";</script> '; 
					}				
				?>                     
				<h4><span>購物明細</span></h4>
					<table>
							<?php
								//*** 在購物車裡 按下 『下一步』按鈕 進來 這個網頁
								//*** 先查詢出 此人購物車裡的 所有商品的明細
								if (empty($_POST["confirmOK"])) {
									//*** 這個時候 還沒開始 產生訂單
									$confirm_finish="NO";
									// 查詢 購物車中 所有 購物明細
									//****提示**** 以下『一條』指令要改	
									//****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡  A
									$SQLStr = "SELECT 圖案暫存區.代號,圖案暫存區.單價,商品.商品名稱,商品照片.圖檔名 from 圖案暫存區 inner join 商品 on 圖案暫存區.代號 = 商品.代號  left outer join 商品照片 on 商品.代號=商品照片.代號  where 帳號='".$_SESSION['ADMINUSER']."'";
								}
								//*** 按下 『確認無誤結帳』按鈕 又進來 這個網頁
								//*** 現在要開始 產生 新的訂單
								else {	
										// 查詢 購物車 是否有商品 (為了防止 重新整理網頁時 購物車中沒有商品卻產生新訂單)
										//****提示**** 以下『兩條』指令要改	
										//****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡								
										$SQLStr = "SELECT count(代號) as 商品數量 FROM 圖案暫存區 WHERE 帳號='".$_SESSION['ADMINUSER']."'";
										echo '<br>查 圖案暫存區中是否有商品→'.$SQLStr."<br>";
										$rs = db_query($SQLStr); 
										$row = mysql_fetch_array($rs);
										if ($row['商品數量']==0) {
											die("購物車中無商品");
										}
										//確定 結帳
										//決定 新的訂單編號 
										//調整時區 問今天日期 年-月-日 時:分:秒 只問年 只問月 只問日
										date_default_timezone_set('Asia/Taipei');
										$datetime= date("Y-m-d H:i:s");
										$d= date("Y").date("m").date("d");
										// 查詢 某日 訂單 的訂單編號裡的流水號 最大值
										//****提示**** 以下『兩條』指令要改
										$SQLStr = "SELECT  max(substr(訂單編號,9,4)) as 最大流水號 from 訂單 where substr(訂單編號,1,8)='".$d."'";
										echo '<br>查 最大流水號→'.$SQLStr;
										$rs = db_query($SQLStr ); 
										$row = mysql_fetch_array($rs);
										// 決定 新訂單 的 訂單編號，並且儲存在 $orderno 變數裡
										//****提示**** 以下『兩條』指令要改
										//****提示**** 當日訂單 用的流水號最大值 在 $row['最大流水號'] 變數裡
										//****提示**** 當日 年月日 接起來 在 $d 變數裡
										if ($row['最大流水號']==null) {
											$orderno=$d.'1001';
										}
										//****提示**** 以下『一條』指令要改
										//****提示**** 當日訂單 用的流水號最大值 在 $row['最大流水號'] 變數裡
										//****提示**** 當日 年月日 接起來 在 $d 變數裡
										else {
											$orderno=$d.($row['最大流水號']+1);
										}
										echo '<br>新訂單編號→'.$orderno;
										//****新增一張新的訂單 **** 物流方式為『超商取貨』
										//****提示**** 以下『一條』指令要改
										//****提示**** 訂單編號 在 $orderno 變數裡， 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										//****提示**** 訂購日期 在 $datetime 變數裡，取貨門市代號在 $_POST['cvs711no'] 變數裡
										//****提示**** 物流方式 在 $_POST['logistics'] 變數裡
										
										//****新增一張新的訂單 **** 物流方式為『宅配』
										//****提示**** 以下『一條』指令要改
										//****提示**** 訂單編號 在 $orderno 變數裡， 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										//****提示**** 訂購日期 在 $datetime 變數裡，物流方式 在 $_POST['logistics'] 變數裡
										
											$SQLStr = "INSERT into 訂單  (訂單編號,帳號,訂購日期,付款方式) values ('".$orderno."','".$_SESSION['ADMINUSER']."','".$datetime."','".$_POST['logistics']."')";
										
										echo '<br>新增 訂單→'.$SQLStr;
										//****提示**** 以下『一條』指令要改
										//****提示**** SQL指令記得 送進 資料庫 執行
										$rs = db_query( $SQLStr); 
										echo("<br>共新增 <font color=red>".mysql_affected_rows()."</font> 張訂單*****");
										//****當 物流方式為『宅配』，還要新增一筆 宅配收貨資料，收貨代號 同訂單編號
										//****提示**** 以下『兩條』指令要改
										//****提示**** 收貨代號和訂單編號都 在 $orderno 變數裡
										
										//**** 購物車裡的購物明細  都加入 訂單明細 
										//**** 作法：查詢出購物車中所有購買商品之後，整批新增到訂單明細裡
										//****提示**** 以下『兩條』指令要改
										//****提示**** 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										//****提示**** 訂單編號 在 $orderno 變數裡
										//****提示**** 優惠方式 預設為'1'，處理狀態 預設為'收到訂單'
										$SQLStr = "INSERT into 訂單明細  SELECT  ".$orderno." as 訂單編號,代號,單價,'1' as 優惠方式,'收到訂單' as 處理狀態 FROM 圖案暫存區 WHERE 帳號='".$_SESSION['ADMINUSER']."'";
										echo '<br>加入 訂單明細→'.$SQLStr;
										$rs = db_query($SQLStr );
										echo("<br>共新增<font color=red>".mysql_affected_rows()."</font>筆訂單明細*****");
										//**** 修改 商品的庫存量(只能對這台 購物車裡的商品 減少 庫存量)
										//**** 作法：查詢出購物車中每一樣購買商品的數量之後，再由庫存 扣掉 購買的數量
										//****提示**** 以下『兩條』指令要改
										//****提示**** 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										
										//**** 清空 購物車（刪除購物車裡的　所有商品）
										//****提示**** 以下『兩條』指令要改
										//****提示**** 此會員帳號在$_SESSION['ADMINUSER'] 變數裡
										$SQLStr = "DELETE FROM 圖案暫存區 WHERE 帳號='".$_SESSION['ADMINUSER']."'";
										echo '<br>刪除 圖案暫存區→'.$SQLStr;
										$rs = db_query( $SQLStr);
										echo("<br>共刪除<font color=red>".mysql_affected_rows()."</font>筆圖案暫存區明細*****");
										//**** 終於結帳結好了，重新查詢 這張新訂單的訂單明細
										//****提示**** 以下『兩條』指令要改（其中一條在遠遠的那裡～）
										//****提示**** 此　訂單編號在　$orderno 變數裡										
										$SQLStr = "SELECT 訂單明細.訂單編號,訂單明細.單價,商品.商品名稱,商品照片.圖檔名  FROM 訂單明細 inner join 商品 on  訂單明細.代號=商品.代號   left outer join 商品照片 on 商品.代號=商品照片.代號 WHERE 訂單明細.訂單編號='".$orderno."'";
							?>
							<!-- ****顯示**** 從資料庫撈回來的訂單明細資料在網頁裡  -->
							<thead>
								<!-- ****提示**** 以下『一條』指令要改  -->
								<!-- ****提示**** 這張訂單的訂單編號   在　$orderno　變數裡 -->
								<tr>
									<th colspan=5>您的訂單編號是： <?php echo $orderno;?></th>
								</tr>
							<?php
								}							
								echo "<br>".$SQLStr;
								$rs = db_query($SQLStr ); //****提示**** 別忘了 這條指令 要修改  對到 A
							?>								
								<tr>
									<th>購買商品</th>
									
									<th>優惠價</th>
									<th>小計</th>
									
								</tr>
								</thead>
								<?php
								if (mysql_num_rows($rs)>0) { 
									$total_payment=0;
									$total = mysql_num_rows($rs); 
									for ($i=0; $i<$total; $i++)      {
										$row = mysql_fetch_array($rs);
										$total_payment=$total_payment*1+$row['單價'];
								?>	
						<tbody>							
								<tr>	
									<!-- ****提示**** 以下『七條』指令要改  -->
									<!-- ****提示**** 商品照片的圖檔名稱 在 $row['圖檔名'] 變數裡 -->
									<!-- ****提示**** 商品的名稱 在 $row['商品名稱'] 變數裡 -->
									<!-- ****提示**** 商品的購買數量 在 $row['數量'] 變數裡 -->
									<!-- ****提示**** 商品的價錢 在 $row['售價'] 變數裡 -->
									<!-- ****提示**** 記得計算 單項商品 的小計金額 -->
									<!-- ****提示**** 商品的庫存量 在 $row['庫存量'] 變數裡 -->
									<!-- ****提示**** 購買商品的項目 在 $total 變數裡 -->
									<!-- ****提示**** 消費總金額 在 $total_payment 變數裡 -->
									<td><img src="images/<?php echo $row['圖檔名'];?>" alt="NoPhoto"> <b><?php echo $row['商品名稱'];?></b></td>
									
									<td>
										<?php echo $row['單價'];?>
									</td>
									<td>
										<?php echo $row['單價'];?>
									</td>
									
								</tr> 								
							<?php
									}
							?> 
								<tr>								
									<td colspan=2 align=right>共<?php echo $total;?>項商品</td>
									<td class="last">總計<?php echo "NT$".$total_payment;?> </td>
								</tr> 								
							<?php							
								}
							?> 
						</tbody>
					</table>
					<?php
						//**** 如果物流方式 是 超商取貨
						//**** 在產生新訂單之前 要先 選擇一間 取貨門市
					
					 ?>
						<form name="form1" action="confirm.php" method="post">
						
							<input type="hidden" name="logistics" value="<?php echo $_POST['logistics']; ?>">
							<input type="submit" name="confirmOK" value="確認無誤結帳" class="proceed-btn" >
						</form>
					<?php 
						
					?>
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