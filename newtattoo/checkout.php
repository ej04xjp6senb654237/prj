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
		function qtyplus1(idx,maxqty){
			if (document.forms[idx].buyqty.value<maxqty) {
				document.forms[idx].buyqty.value=document.forms[idx].buyqty.value*1+1;
			}
			document.forms[idx].submit();
		}
		function qtyminus1(idx){
			if (document.forms[idx].buyqty.value>1) {
				document.forms[idx].buyqty.value=document.forms[idx].buyqty.value*1-1;
				document.forms[idx].submit();
			}
		}
		function qtychange(idx,maxqty,currqty){
			if (document.forms[idx].buyqty.value>1 && document.forms[idx].buyqty.value<maxqty) {
				document.forms[idx].submit();
			}
			else {
				document.forms[idx].buyqty.value=currqty;
			}
		}
		function goback_allproducts() {
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
							<p><input type=button name=backtobrowse value='回瀏覽商品' onclick='goback_allproducts();'></p>
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
							echo '<script>alert("請先登入～！");'.   
												'location.href = "login.php";</script> '; 
					}				
				?>
			
							
<?php
						// 因為按下某一樣商品的『加到購物車』按鈕，所以進到這個網頁裡面來				
						if (isset($_POST['addCartOK'])){
							// 查詢 此人的購物車中 是否已經有這樣商品
							//****提示**** 以下『兩條』指令要改	
							//****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡
							//****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡
								$SQLStr = "SELECT  * from 圖案暫存區 where 帳號='".$_SESSION['ADMINUSER']."' and 代號='".$_POST['buyproductno']."'";
							echo '<br>SQLStr ='.$SQLStr.'<br>';
							$rs = db_query($SQLStr); 		
							
								// 如果沒有→做 商品新增到購物車（買一個）
								// 問：這個商品的售價
								//****提示**** 以下『兩條』指令要改	
								//****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡
								$SQLStr = "SELECT     *
                                            FROM         商品
                                            where 代號='".$_POST['buyproductno'] ."'";
								$rs = db_query($SQLStr );  
								$row = mysql_fetch_array($rs);							
								date_default_timezone_set('Asia/Taipei'); 	//設定時區
								$datetime= date("Y/m/d H:i:s");				//問現在的系統日期、時間
								// 新增這個商品到購物車（買一個）
								//****提示**** 以下『兩條』指令要改
								//****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡								
								//****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡	
								//****提示**** 這個商品的購買數量 在 $_POST['buyqty'] 裡
								//****提示**** 這個商品的售價 在	$row['價錢'] 裡
								//****提示**** 這個商品加進購物車的時間 在 $datetime 裡
								$SQLStr = "INSERT into 圖案暫存區  values ('".$_SESSION['ADMINUSER']."','".$_POST['buyproductno']."','".$row['單價']."','".$datetime."')";
								echo '<br>SQLStr ='.$SQLStr.'<br>';
								$rs = db_query( $SQLStr);   
								echo("共新增".mysql_affected_rows()."個圖案暫存區中商品*****");
							
							
						}
						// 在購物車裡，因為按下某一樣商品的『Delete』按鈕，所以進到這個網頁裡面來
						// 不買了～　刪除 購物車中 這樣商品
						else if (isset($_POST['delCartOK'])){
								//****提示**** 以下『兩條』指令要改
								//****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡								
								//****提示**** 這個商品的代號 在 $_POST['buyproductno'] 裡	
								$SQLStr = "DELETE from 圖案暫存區 where 帳號='".$_SESSION['ADMINUSER']."' and 代號='".$_POST['buyproductno']."'";
								echo '<br>SQLStr ='.$SQLStr.'<br>';
								$rs = db_query( $SQLStr);   
								echo("共刪除".mysql_affected_rows()."個圖案暫存區中商品*****");
							}
							// 在購物車裡，因為按下某一樣商品的『+』或『-』按鈕，所以進到這個網頁裡面來（不是因為點了導覽列的『看購物車』）
							// 僅修改 購物車中 商品 購買數量
							
						?>
                       
					<h4><span>購物明細</span></h4>
					<table>
						<thead>
							<tr>
								<th>商品</th>
								
								<th>優惠價</th>
							</tr>
						</thead>
						<tbody>
							<?php
								// 查詢 這個會員的購物車中 所有 購買商品明細
								//****提示**** 以下『兩條』指令要改
								//****提示**** 這個會員的帳號 在 $_SESSION['ADMINUSER'] 裡	
								$SQLStr = "SELECT 圖案暫存區.代號,圖案暫存區.單價,商品.商品名稱,商品照片.圖檔名 from 圖案暫存區 inner join 商品 on 圖案暫存區.代號 = 商品.代號  left outer join 商品照片 on 商品.代號=商品照片.代號  where 帳號='".$_SESSION['ADMINUSER']."'";
								$rs = db_query( $SQLStr ); 
								if (mysql_num_rows($rs)>0) { 
									$total_paymet=0;
									//問：商品買幾樣、算：購物總金額
									$total = mysql_num_rows($rs); 
									for ($i=0; $i<$total; $i++)      {
										$row = mysql_fetch_array($rs);
										//****提示**** 以下『一條』指令要改
										//****提示**** 這個商品的售價 在 $row['售價'] 裡
										//****提示**** 這個商品的購買數量 在 $row['數量'] 裡
										$total_paymet=$total_paymet*1+$row['單價'];
								?>		
								<!-- 顯示 購物車中所有商品 每樣商品也都有自己的表單（為了做購買數量＋－或商品刪除） -->
								<tr>
								<form name="buyform" action="checkout.php" method="post">
									<!-- ****提示**** 以下『兩條』指令要改 -->
									<!-- ****提示**** 這個商品的照片圖檔名 在 $row['圖檔名'] 裡 -->
									<!-- ****提示**** 這個商品的名稱 在 $row['商品名稱'] 裡 -->
									<!-- ****提示**** 這個商品的類別名稱 在 $row['類別名稱'] 裡 -->
									<td><img src="images/<?php echo  $row['圖檔名'];?>" alt="Thumbnail"> <b><?php echo $row['商品名稱'];?></b>
										<p><?php echo $row['代號'];?></p></td>
									<td>
										<!-- ****提示**** 以下『三條』指令要改 -->
										<!-- ****提示**** 這個商品的購買數量 在 $row['數量'] 裡 -->
										<!-- ****提示**** 這個商品的庫存量 在 $row['庫存量'] 裡 -->
										<!-- ****提示**** 這個商品的代號 在 $row['商品代號'] 裡 -->
										
										
									</td>
									<td class="last"><div>
										<!-- ****提示**** 以下『一條』指令要改 -->
										<!-- ****提示**** 這個商品的售價 在 $row['售價'] 裡 -->
										<?php echo $row['單價'];?> 
										<input type=hidden name="buyproductno" value="<?php echo $row['代號'];?>">
										<input type="submit" name="delCartOK" value="Delete" class="btn-delete">
									</div></td>
								</form>
								</tr> 								
							<?php
									}
							?> 
								<tr>		
									<!-- ****提示**** 以下『兩條』指令要改 -->
									<!-- ****提示**** 這個購物車中商品的樣數 在 $total 裡 -->
									<!-- ****提示**** 這個購物車中購買商品的總金額 在 $total_paymet 裡 -->
									<td colspan=2 align=right>共<?php echo  $total;?>項商品</td>
									<td class="last">總計<?php echo "NT$". $total_paymet;?> </td>
								</tr> 								

						</tbody>
					</table>
				
                                          <form action="work.php" method="POST">	
						
						
						<input type=submit name="confirmOrder" value="選師傅" class="proceed-btn">
					</form>
					 <form action="size.php" method="POST">	
						
						
						<input type=submit name="confirmOrder" value="選尺寸" class="proceed-btn">
					</form>


					                   <form action="confirm.php" method="POST">	
						
					請選擇付款方式：
						<input type=radio name="logistics" value="付現">付現
						
						<input type=submit name="confirmOrder" value="結帳" class="proceed-btn">
					</form>
							<?php							
								}
								else {
									echo "圖案暫存區中無商品";
								}
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