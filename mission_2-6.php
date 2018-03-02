<html>
<title>プログラミング勉強日記</title>
<head></head>
<body>

<?php
$filename = 'kadai2-2.txt';//ファイルの名前指定
echo "【お知らせ】<br>";

if(!empty($_GET['comment']) and !empty($_GET['name']) and !empty($_GET['password']))//コメントと名前とパスワードが送信されれば実行
{
	if(!empty($_GET["mode"]))//編集モードであれば実行
	{
		$txt_retsu = file($filename);//txtを行ごとに配列に保存
		$fp = fopen($filename,'w');//txtを開く．
		foreach($txt_retsu as $line)//行ごとに処理を実行
		{
			$word_retsu = explode("<>",$line);//1行(文字列)を<>で区切って配列にする
			if($word_retsu[0] == $_GET["ed_num2"])//もし一致していれば
			{
				fwrite($fp,
				$_GET["ed_num2"]."<>".
				$_GET["name"]."<>".
				$_GET["comment"]."<>".
				date("Y/m/d G:i:s")."<>".
				$_GET["password"]."<>\n");
			}//編集番号，訂正後の名前，訂正後のコメント，日にち，パスワードを書き込み
			else
			{
				fwrite($fp,$line);
			}//該当行の既存の内容をそのまま入力
		}
		fclose($fp);//txtを閉じる．
		echo "編集しました。（".$_GET["ed_num2"]."番）";
	}
	else//編集モードでなければ実行
	{
		$fp = fopen($filename,'a');//txtを開く
		$i = count( file( $filename ));//行数をカウント
		$i++;//iに1足す
		fwrite($fp,$i."<>".$_GET["name"]."<>".$_GET["comment"]."<>".date("Y/m/d G:i:s")."<>".$_GET["password"]."\n");//番号，名前，コメント，日時，パスワードを書き込み
		fclose($fp);//txtを閉じる
		echo "投稿しました。 (".$i."番）";
	}
}//送信内容を編集モード，通常モードに分けてtxtに保存
elseif(empty($_POST['del_num']) and empty($_POST['ed_num']))
{
	echo "名前とコメントとパスワードを全て入力してください。";
}//送信時に不備があったらすべて入力させる。


if(!empty($_POST['del_num']))//削除送信があれば実行
{
	$txt_retsu = file($filename);//txtを行ごとに配列に保存
	$fp = fopen($filename,'w');//txtを開く．（上書き書き込み）
	foreach($txt_retsu as $line)//行ごとに処理を実行
	{
		$word_retsu = explode("<>",$line);//該当行(文字列)を<>で区切って配列にする
		if($word_retsu[0] == $_POST['del_num'])//「txtの該当行の左端の番号＝削除番号」なら実行
		{
			if($word_retsu[2] === "削除しました")//削除済でなければ
			{
				echo "既に削除された投稿です。（".$word_retsu[0]."番）";
				fwrite($fp,$line);//該当行の既存の内容をそのまま入力
			}
			else//削除済であれば
			{
				if($_POST['del_password'] === trim($word_retsu[4]))//投稿パスワード＝削除パスワードなら
				{
					echo "削除しました。（".$word_retsu[0]."番）";
					fwrite($fp,$word_retsu[0]."<><>削除しました<><>".trim($word_retsu[4])."<>\n");//「番号 削除しました」と書いて改行
				}
				else//投稿パスワード≠削除パスワードなら
				{
					echo "正しいパスワードを入力してください。（".$word_retsu[0]."番）";
					fwrite($fp,$line);//該当行の既存の内容をそのまま入力
				}
			}
		}
		else//「txtの該当行の左端の番号≠削除番号」なら実行
		{
			fwrite($fp,$line);//該当行の既存の内容をそのまま入力
		}
	}
	if($word_retsu[0] < $_POST['del_num'])
	{
		echo $_POST['del_num']."番の投稿は存在しません。。";
	}//削除番号が無いときの処理
	fclose($fp);//kadai_2-2/txtを閉じる．
}//削除番号の投稿削除が完了したテキストを上書き保存


if(!empty($_POST['ed_num']))//編集送信があれば実行
{
	$txt_retsu = file($filename);//txtを行ごとに配列に保存
	foreach($txt_retsu as $line)//行ごとに処理を実行
	{
		$word_retsu = explode("<>",$line);//該当行(文字列)を<>で区切って配列にする
		if($word_retsu[0] == $_POST['ed_num'])//「txtの該当行の左端の番号＝削除番号」なら実行
		{
			if($word_retsu[2] === "削除しました")//削除済でなければ
			{
				echo "既に削除された投稿です。（".$word_retsu[0]."番）";
			}
			else
			{
				if($_POST['edit_password'] === trim($word_retsu[4]))//パスワードが正しければ実行
				{
					$ed_num2 = $word_retsu[0];//編集番号
					$ed_name = $word_retsu[1];//編集名前
					$ed_com = $word_retsu[2];//編集コメント
					$ed_pass = $word_retsu[4];//編集パスワード
					$mode = 'hide';//編集モード発動
					echo "投稿を修正してください。(".$ed_num2."番)";
				}
				else
				{
					echo "正しいパスワードを入力してください。（".$word_retsu[0]."番）";
				}
			}
		}
	}
	if($word_retsu[0] < $_POST['ed_num'])
	{
		echo $_POST['ed_num']."番の投稿は存在しません。";
	}//削除番号が無いときの処理
}//編集する行の番号，名前，コメントを読み取る．編集モードを発動させる．
?>

	<form action ="mission_2-6.php" method ="get">
	<p>
	・名前<br/><input type = "text" name = "name" value = <?php echo $ed_name; ?>><br/><br/><!-名前(編集する名前)->
	・コメント<br/><textarea name = "comment" rows  = "1" cols = "20"><?php echo $ed_com ?></textarea><br/><br/><!-コメント(編集するコメント)->
	・パスワード<br/><input type = "password" name = "password" value = <?php echo $ed_pass; ?>><br/><br/><!-パスワード->
	<input type = "hidden" name = "mode" value = <?php echo $mode; ?>><!-モード（非表示）->
	<input type = "hidden" name = "ed_num2" value = <?php echo $ed_num2; ?>><!-編集番号（非表示）->
	<input type = "submit"value = "送信"><br/><br/>
	</p>
	</form>

	<form action ="mission_2-6.php" method ="post">
	<p>
	・削除対象番号<br/><input type = "text"name = "del_num"><br/><br/><!-削除番号の入力欄->
	・パスワード<br/><input type = "password" name = "del_password"><br/><br/><!-削除パスワードの入力欄->
	<input type = "submit"value = "削除"><br/><br/>
	</p>
	</form><!-送信フォーム作る->

	<form action ="mission_2-6.php" method ="post">
	<p>
	・編集対象番号<br/><input type = "text" name = "ed_num"><br/><br/><!-編集番号の入力欄->
	・パスワード<br/><input type = "password" name = "edit_password"><br/><br/><!-編集パスワードの入力欄->
	<input type = "submit"value = "編集開始"><br/><br/>
	</p>
	</form><!-送信フォーム作る->


<?php
$txt_retsu = file($filename);//txtを行ごとに配列で保存
foreach($txt_retsu as $line)//各行について処理を実行
{
	$word_retsu = explode("<>",$line);//該当行(文字列)を<>で区切って配列にする
	for( $i = 0 ; $i <= 3 ;$i++ )//各文字列について処理を実行
	{
		echo " ".$word_retsu[$i];//空欄，該当文字列を出力
	}
echo "<br>";//改行
}//テキストの内容をhtmlで表示
?>
</body>
</html>
