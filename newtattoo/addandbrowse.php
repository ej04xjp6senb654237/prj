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
							<a href="newproduct.php">新增商品</a>
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
						<li class="selected">
							<a href="members.php">會員</a>
						</li>
					</ul>
					<ul id="secondary">
						<li>
							<a href="checkout.html">Cart</a>
							<input type=button name=backtobrowse value='回我的店' onclick='goback_myshops();'>
						</li>
						<li>
							<a href="login.php"><?php if(! isset($_SESSION['ADMINUSER']) || !$_SESSION['ADMIN'] ) {
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
						//******壓縮圖檔 用 函數******
							function mkthumb( $orig, $thumb, $maxLength ){
						  	$ext = strtolower(strrchr($orig, "."));
						  	//依照副檔名, 使用不同函式將原始照片載入記憶體
						  	switch ($ext){
						  	case '.jpg':
						    	$picSrc = imagecreatefromjpeg($orig);
						    	break;
						  	case '.png':
						    	$picSrc = imagecreatefrompng($orig);
						    	break;
						  	case '.gif':
						    	$picSrc = imagecreatefromgif($orig);
						    	break;
						  	case '.bmp':
						    	$picSrc = imagecreatefrombmp($orig);
						    	break;
						  	default:
						    	//傳回錯誤訊息
						    	return "不支援 $ext 圖檔格式";
						  	}

						  	//取得原始圖的高度 ($picSrc_y) 與寬度 ($picSrc_x)
						  	$picSrc_x = imagesx($picSrc);
						  	$picSrc_y = imagesy($picSrc);

						  	//依照 $maxLength 參數, 計算縮圖應該使用的
						  	//高度 ($picDst_y) 與寬度 ($picDst_x)
						  	if ($picSrc_x > $picSrc_y) {
						    	$picDst_x = $maxLength;
						    	//intval() 可取得數字的整數部分
						    	$picDst_y = intval($picSrc_y / $picSrc_x * $maxLength);
						  	} else {
						    	$picDst_y = $maxLength;
						    	$picDst_x = intval($picSrc_x / $picSrc_y * $maxLength);
						  	}

						  //在記憶體中建立新圖
						  $picDst = imagecreatetruecolor($picDst_x, $picDst_y);

						  //將原始照片複製並且縮小到新圖
						  imagecopyresized($picDst, $picSrc, 0, 0, 0, 0,
						                   $picDst_x, $picDst_y, $picSrc_x, $picSrc_y);

						  //將新圖寫入 $thumb 參數指定的縮圖檔名
						  imagejpeg($picDst, $thumb);

						  return 'ok';
						}

						// ******顯示 指定資料夾的內容******
							function showdir($cuurDIR) {
							$arrDirFile=scandir($cuurDIR);
							unset($arrDirFile[0]);unset($arrDirFile[1]);
							$html='<table border=2><tr><th>資料夾中的檔案</th></tr>';
							foreach($arrDirFile as $name){
	  							$html .= '<tr><td>'.'<a href='.$cuurDIR.$name.'>'.$name.'</a></td></tr>';
							}
								$html .= '</table>';
							unset($arrDirFile);
							return $html;
							}
						
						if(! isset($_SESSION['ADMINUSER']) || !$_SESSION['ADMIN']  ) {
							echo '<script>alert("請以『店家』身分登入後、再使用這個網頁！");'.   
												'location.href = "login.php";</script> '; 
						}
						if(! isset($_SESSION['OPERATION']) ) {
							die("請由確定新增、修改或刪除→進入這個網頁");
						}
						else {
								if (@$_POST["OK"]=="刪除"){
									$_SESSION['OPERATION']="DELONE";
								}
								else if (@$_POST["adminok"]=="確定修改"){
										$_SESSION['OPERATION']="UPDONE";
								}
								if (@$_POST["adminok"]=="確定新增") {
									$_SESSION['OPERATION']="ADDNEW";
								}
						}
						

					if($_SESSION['OPERATION']=="ADDNEW") {
						//******上傳檔案******
							$upload_dir='./upload/'.'images'.'/'; //儲存 原圖 的資料
							$thumb_dir='./images/'; //儲存 壓縮過的圖 的資料夾

							echo '$upload_dir='.$upload_dir; //程式寫好後可刪
							if (!is_dir($upload_dir)) mkdir($upload_dir);
							if (!is_dir($thumb_dir)) mkdir($thumb_dir);
							$sourcefile=$_FILES['newproductphoto']['name'];
							if (move_uploaded_file($_FILES['newproductphoto']['tmp_name'],$upload_dir.$sourcefile)){
								//顯示上傳的檔案的相關訊息
								echo '上傳成功...'; //程式寫好後可刪
								echo '<br />原始檔名:' . $_FILES['newproductphoto']['name']; //程式寫好後可刪
								echo '<br />檔案類型:' . $_FILES['newproductphoto']['type']; //程式寫好後可刪
								echo '<br />檔案大小:' . $_FILES['newproductphoto']['size']; //程式寫好後可刪
								echo '<br />暫存檔名:' . $_FILES['newproductphoto']['tmp_name']; //程式寫好後可刪
								$err=mkthumb( $upload_dir.$sourcefile, $thumb_dir.$sourcefile, 168 );
								if ($err != 'OK') {
									echo '圖檔壓縮錯誤<br>';
								}
								echo "成功儲存".$sourcefile."在".$thumb_dir.'<br>';
							}
							else {
								echo '同名檔案已存在('.$upload_dir . $_FILES['newproductphoto']['name'].')<br>';
							}
							echo '<br>'.showdir($upload_dir); //顯示指定的資料夾裡的內容

						//******新增 商品資料 商品照片資料 到資料庫裡*****
							//echo "類別代號=".$_POST['productcategory']."號"; //程式寫好後可刪
							$SQLStr = "insert into 商品 values(".$_POST['newproductno'].",'".$_POST['newproductname']."',".$_POST['newproductprice'].")";
							echo "<p>SQL=".$SQLStr."</p>"; //程式寫好後可刪
							$rs=mysql_query($SQLStr); //執行SQL新增指令
							if (mysql_error()){
								die( "新增商品 發生錯誤" . mysql_error());
							}
							$SQLStr = "insert into 商品照片 values('".$_FILES['newproductphoto']['name']."',".$_POST['newproductno'].")";
							echo "<p>SQL=".$SQLStr."</p>"; //程式寫好後可刪
							$rs=mysql_query($SQLStr); //執行SQL新增指令
							if (mysql_error()){
								die( "新增商品照片 發生錯誤 " .mysql_error());
							}
						}
					else if($_SESSION['OPERATION']=="DELONE") {
							//******照片圖檔名暫存於二維陣列******
								$upload_dir='./upload/'.'images'.'/';//儲存原圖資料夾
								$thumb_dir='./images/';//儲存壓縮過的圖的資料夾
								$SQLStr = "select 商品照片.* from 商品照片 where 商品照片.代號 =".$_POST['delproductno'];
								$rs = db_query($SQLStr);
								if (mysql_num_rows($rs)>0) {
									$total = mysql_num_rows($rs);
									for ($i=0; $i<$total; $i++) {
										$row = mysql_fetch_array($rs);
										$filename[]=$upload_dir.$row['圖檔名'];
										$filename[]=$thumb_dir.$row['圖檔名'];
									}
									$filenames[]=$filename;
								}
							//******刪除商品照片******
								$SQLStr = "delete from 商品照片 where 商品照片.代號 =".$_POST['delproductno'];
								echo "<p>SQL=".$SQLStr."</p>";//程式寫好後可刪
								$rs=mysql_query($SQLStr);//執行SOL新增指令
								if (mysql_error()) {
									die( "刪除商品照片 發生錯誤" . mysql_error() );
								}
								else {
									echo "刪除".mysql_affected_rows()."筆";
									$message="商品照片 (".$_POST['delproductno'].") 已刪除";
									echo "<script type='text/javascript'>alert('".$message."');</script>";

									//******刪除照片圖檔(從 二維陣列裡 拿出 原圖和小圖 的路徑和檔名)******
										foreach ($filenames as $fi) {
											if(@unlink($fi[0]) && @unlink($fi[1])) {
												$message="已經成功刪除圖檔(".$fi[0].'與'.$fi[1].")";
												echo "<script type='text/javascript'>alert('".$message."');</script>";
											}
											else {
												$message="無法刪除照片檔案 請自行刪除(".$fi[0].' 與 '.$fi[1].")";
												echo "<script type='text/javascript'>alert('".$message."');</script>";
											}
										}
								}
							//******刪除商品資料******
								$SQLStr = "delete from 商品 where 商品.代號 =".$_POST['delproductno'];
								echo $_SESSION['OPERATION']."<p>SQL=".$SQLStr."</p>";//程式寫好後可刪
								$rs=mysql_query($SQLStr);//執行SOL新增指令
								if (mysql_error()) {
									die( "刪除商品 發生錯誤" . mysql_error() ); 
								}
								else {
									echo "刪除".mysql_affected_rows()."筆";								
									echo '<script> alert("(商品'.$_POST['delproductno'].'")已刪除"); </script>'; 
								}
						}
						else if($_SESSION['OPERATION']=="UPDONE") {
							$upload_dir='./upload/'.'images'.'/';//儲存 原圖 的資料夾
							$thumb_dir='./images/';//儲存 壓縮過的圖 的資料夾
							$sourcefile=$_FILES['newproductphoto']['name'];
							if (empty($sourcefile)) {
								@$sourcefile=$_SESSION['PHOTOfilename'];
								echo "新是空 用舊的 ".$sourcefile;
							}
							//修改 商品照片資料表的 圖檔名欄位值
							$SQLStr = "update 商品照片 set 商品照片.圖檔名 ='".$sourcefile."' where 商品照片.代號=".$_POST['updproductno'];
							echo "<p>SQL=".$SQLStr."</p>";//程式寫好後可刪
							$rs=mysql_query($SQLStr);//執行SOL新增指令
							if (mysql_error()){
								die ( "修改商品照片 發生錯誤 " . mysql_error());
							}
							else{
								echo "修改".mysql_affected_rows()."筆";
								$message="商品照片 (".$_POST['updproductno'].") 已修改";
								echo"<script type='text/javascript'>alert('".$message."');</script>";
								//***************刪除舊的 上傳新的
								if (mysql_affected_rows()>0){//刪除舊的照片圖檔
									if(!empty($_SESSION['PHOTOfilename'])){
										if (@unlink($upload_dir.$_SESSION['PHOTOfilename']) && @unlink($thumb_dir.$_SESSION['PHOTOfilename'])){
											$message="已經成功刪除圖檔(".$upload_dir.$_SESSION['PHOTOfilename'].' 與 '.$thumb_dir.$_SESSION['PHOTOfilename'].")";
											echo "<script type='text/javascript'>alert('".$message."');</script>";
										}
										else{
											$message="無法刪除照片檔案,請自行刪除(".$upload_dir.$_SESSION['PHOTOfilename'].' 與 '.$thumb_dir.$_SESSION['PHOTOfilename'].")";
											echo"<script type='text/javascript'>alert('".$message."');</script>";
										}
									} 
									if (!empty($sourcefile)){//上傳新的照片圖檔
										if (move_uploaded_file($_FILES['newproductphoto']['tmp_name'],$upload_dir.$sourcefile)){
											$err=mkthumb( $upload_dir.$sourcefile, $thumb_dir.$sourcefile, 168 );
											if ($err != 'ok'){
												echo '圖檔壓縮錯誤<br>';
											}
										}
									}
								}
							}
							$SQLStr = "update 商品 set 商品.商品名稱='".$_POST['newproductname']."', 商品.單價=".$_POST['newproductprice']." where 商品.代號=".$_POST['updproductno'];
							echo $_SESSION['OPERATION']."<p>SQL=".$SQLStr."</p>";//可刪
							$rs=mysql_query($SQLStr);
							if (mysql_error()){
								die( "修改商品 發生錯誤 " . mysql_error());
							}
							else{
								echo "修改".mysql_affected_rows()."筆";
								echo '<script> alert("商品'.$_POST['updproductno'].'")已修改");</script>';
							}
							$_SESSION['OPERATION']="ADMIN";
						}
				//****提示**** 以下『兩條』指令要改	
				//****提示**** 查詢這一間商店的所有商品，這一間商店的代號 在 $_SESSION['SHOPNO'] 裡
				//****提示**** 需要挑出來的欄位有：商店的類別名稱、商品的代號、商品的照片、商品的名稱、商品的價錢
				//****提示**** 商品可能沒有照片
				//****提示**** 顯示商品資料時，按照以下順序排好：類別代號、商品代號
				$SQLStr = "SELECT * from 商品  where 代號<9 || 代號>20";

				$rs = db_query($SQLStr);   
				if (mysql_num_rows($rs)>0) { 
					$total = mysql_num_rows($rs); 
					for ($i=0; $i<$total; $i++)      {
						$row = mysql_fetch_array($rs);
						echo "<li>";
						echo  '<a href="product.html" class="preview" title="Preview">';
						//****提示**** 以下『一條』指令要改	
						//****提示**** 商品照片的檔名在 $row["圖檔名"] 裡、單價在 $row["價錢"] 裡、商品的名稱在 $row["商品名稱"] 裡、商品的類別名稱在 $row["類別名稱"] 裡
						echo  '<img src="images/'.$row["代號"].'.jpg " alt="Img"> <span class="icon"></span></a> '. $row["商品名稱"].' <form action="addandbrowse.php" method="POST"><input type=submit name="OK" value="刪除" class="btn-cart"><input type=hidden name="delproductno" value="'.$row['代號'].'"></form><form action="editproduct.php" method="POST"> <input type=submit name="OK" value="修改" class="btn-wish"><input type=hidden name="updproductno" value="'.$row['代號'].'"></form>';
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
						echo '<img src="images/picture'.$i.'.jpg" alt="Img"> <span>0912345678</span>魁紋身</a>';
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