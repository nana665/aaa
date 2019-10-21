<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body>

<?php
//データベース接続
	$dsn='mysql:dbname=データベース名;host=localhost';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成(テーブル名:mission5)
			$sql="CREATE TABLE IF NOT EXISTS mission5-1"
			."("
			."id INT AUTO_INCREMENT PRIMARY KEY,"
			."name char(32),"
			."comment TEXT,"
			."date TEXT,"
			."pass TEXT"
			.");";
			$stmt=$pdo->query($sql);

//投稿機能
			if(!empty($_POST["btn1"])){ //投稿ボタンを押したら
			if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password_1"])){
						$name=$_POST["name"];
						$comment=$_POST["comment"];
						$date=date("H/m/d G:i:s");//投稿時間
						$pass=$_POST["password_1"];//パスワード
						$id=$_POST["hensyuno"];
			if(!empty($_POST["hensyuno"])){//編集モード
						$sql='update mission5-1 set name=:name,comment=:comment, date=:date, pass=:pass where id=:id';
						$stmt=$pdo->prepare($sql);
						$stmt->bindParam(':name', $name, PDO::PARAM_STR);
						$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
						$stmt->bindParam(':date', $date, PDO::PARAM_STR);
						$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
						$stmt->bindParam(':id', $id, PDO::PARAM_INT);
						$stmt->execute();
					}else{//新規投稿モード
						$sql=$pdo->prepare("INSERT INTO mission5 (name,comment,date,pass) VALUES (:name, :comment, :date, :pass)");
						$sql->bindParam(':name', $name, PDO::PARAM_STR);
						$sql->bindParam(':comment', $comment, PDO::PARAM_STR);
						$sql->bindParam(':date', $date, PDO::PARAM_STR);
						$sql->bindParam(':pass', $pass, PDO::PARAM_STR);
						$sql->execute();  
					}
			}
			}
//削除機能
		if(!empty($_POST["btn2"])){ //削除ボタンを押したら
		if(!empty($_POST["delete"]) && !empty($_POST["password_2"])){
//各行ごとに配列に取り出す
					$id=$_POST["delete"];//削除番号
					$sql='SELECT * FROM mission5-1';
					$stmt=$pdo->query($sql);
					$results=$stmt->fetchAll();
//行を探す
foreach($results as $word){
	if($word['id']==$id){//削除番号が一致したら
	if($word['pass']==$_POST["password_2"]){//パスワード確認
					$sql='delete from mission5-1 where id=:id';
					$stmt=$pdo->prepare($sql);
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
				}else if($word['pass']!=$_POST["password_2"]){
								echo "パスワードが違います";
																							}
									}	
											}
			}
			}
//編集機能
if(!empty($_POST["btn3"])){
if(!empty($_POST["hensyu"]) && !empty($_POST["password_3"])){
					$id=$_POST["hensyu"];//編集機能					
 					$sql='SELECT * FROM mission5-1';
					$stmt=$pdo->query($sql);
					$results=$stmt->fetchAll();
//行を探す
foreach($results as $word_1){
						if($word_1['id']==$id){
						if($word_1['pass']==$_POST["password_3"]){//パスワード確認
foreach($results as $word_2){
						if($word_2['id']==$id){//編集番号が一致したら
							$editnumber=$word_2['id'];//編集したい番号を取り出す
							$editname=$word_2['name'];//編集したい名前を取り出す
							$editcomment=$word_2['comment'];//編集したいコメントを取り出す
															}
												}
								$stmt->execute();
							}
															}
												}
}
}
?>

<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">


<input type="hidden" name="hensyuno" value="<?php 
    if(isset($_POST["btn3"])&&!empty($editnumber)){
    print $editnumber;
    }
    ?>"
>
<br/>
<input type ="text" name="name" placeholder="名前"
                         value="<?php 
                         
                         if(isset($_POST["btn3"])&&!empty($editname)){
                          print $editname;
                         }
                         ?>"
><br/>

                     
                            
<input type ="text" name="comment" placeholder="コメント" 
           value="<?php 
           
           if(isset( $_POST["btn3"])&&!empty($editcomment)){
              print $editcomment; 
            }
              ?>"
><br/>
<input type="text" name="password_1" placeholder="パスワード">
<input type ="submit" name="btn1" value="送信"/><br><br>

<input type="text" name="delete" placeholder="削除対象番号"><br>
<input type="text" name="password_2" placeholder="パスワード">
<input type="submit" name="btn2" value="削除"><br><br>

<input type="text" name="hensyu" placeholder="編集対象番号"><br>
<input type="text" name="password_3" placeholder="パスワード">
<input type="submit" name="btn3" value="編集"><br><br>


</form>

<?php
if(!empty($_POST["btn1"])||!empty($_POST["btn2"])||!empty($_POST["btn3"])){
				//データベース接続
			$dsn='mysql:dbname=’データベース名’;host=localhost';
			$user='ユーザー名';
			$password='パスワード';
			$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


	$sql='SELECT * FROM mission5-1';
	$stmt=$pdo->query($sql);
	$results=$stmt->fetchAll();
	foreach($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
		echo "<hr>";
	}
}
?>
</body>
</html>
