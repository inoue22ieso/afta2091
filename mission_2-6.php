<html>
<title>�v���O���~���O�׋����L</title>
<head></head>
<body>

<?php
$filename = 'kadai2-2.txt';//�t�@�C���̖��O�w��
echo "�y���m�点�z<br>";

if(!empty($_GET['comment']) and !empty($_GET['name']) and !empty($_GET['password']))//�R�����g�Ɩ��O�ƃp�X���[�h�����M�����Ύ��s
{
	if(!empty($_GET["mode"]))//�ҏW���[�h�ł���Ύ��s
	{
		$txt_retsu = file($filename);//txt���s���Ƃɔz��ɕۑ�
		$fp = fopen($filename,'w');//txt���J���D
		foreach($txt_retsu as $line)//�s���Ƃɏ��������s
		{
			$word_retsu = explode("<>",$line);//1�s(������)��<>�ŋ�؂��Ĕz��ɂ���
			if($word_retsu[0] == $_GET["ed_num2"])//������v���Ă����
			{
				fwrite($fp,
				$_GET["ed_num2"]."<>".
				$_GET["name"]."<>".
				$_GET["comment"]."<>".
				date("Y/m/d G:i:s")."<>".
				$_GET["password"]."<>\n");
			}//�ҏW�ԍ��C������̖��O�C������̃R�����g�C���ɂ��C�p�X���[�h����������
			else
			{
				fwrite($fp,$line);
			}//�Y���s�̊����̓��e�����̂܂ܓ���
		}
		fclose($fp);//txt�����D
		echo "�ҏW���܂����B�i".$_GET["ed_num2"]."�ԁj";
	}
	else//�ҏW���[�h�łȂ���Ύ��s
	{
		$fp = fopen($filename,'a');//txt���J��
		$i = count( file( $filename ));//�s�����J�E���g
		$i++;//i��1����
		fwrite($fp,$i."<>".$_GET["name"]."<>".$_GET["comment"]."<>".date("Y/m/d G:i:s")."<>".$_GET["password"]."\n");//�ԍ��C���O�C�R�����g�C�����C�p�X���[�h����������
		fclose($fp);//txt�����
		echo "���e���܂����B (".$i."�ԁj";
	}
}//���M���e��ҏW���[�h�C�ʏ탂�[�h�ɕ�����txt�ɕۑ�
elseif(empty($_POST['del_num']) and empty($_POST['ed_num']))
{
	echo "���O�ƃR�����g�ƃp�X���[�h��S�ē��͂��Ă��������B";
}//���M���ɕs�����������炷�ׂē��͂�����B


if(!empty($_POST['del_num']))//�폜���M������Ύ��s
{
	$txt_retsu = file($filename);//txt���s���Ƃɔz��ɕۑ�
	$fp = fopen($filename,'w');//txt���J���D�i�㏑���������݁j
	foreach($txt_retsu as $line)//�s���Ƃɏ��������s
	{
		$word_retsu = explode("<>",$line);//�Y���s(������)��<>�ŋ�؂��Ĕz��ɂ���
		if($word_retsu[0] == $_POST['del_num'])//�utxt�̊Y���s�̍��[�̔ԍ����폜�ԍ��v�Ȃ���s
		{
			if($word_retsu[2] === "�폜���܂���")//�폜�ςłȂ����
			{
				echo "���ɍ폜���ꂽ���e�ł��B�i".$word_retsu[0]."�ԁj";
				fwrite($fp,$line);//�Y���s�̊����̓��e�����̂܂ܓ���
			}
			else//�폜�ςł����
			{
				if($_POST['del_password'] === trim($word_retsu[4]))//���e�p�X���[�h���폜�p�X���[�h�Ȃ�
				{
					echo "�폜���܂����B�i".$word_retsu[0]."�ԁj";
					fwrite($fp,$word_retsu[0]."<><>�폜���܂���<><>".trim($word_retsu[4])."<>\n");//�u�ԍ� �폜���܂����v�Ə����ĉ��s
				}
				else//���e�p�X���[�h���폜�p�X���[�h�Ȃ�
				{
					echo "�������p�X���[�h����͂��Ă��������B�i".$word_retsu[0]."�ԁj";
					fwrite($fp,$line);//�Y���s�̊����̓��e�����̂܂ܓ���
				}
			}
		}
		else//�utxt�̊Y���s�̍��[�̔ԍ����폜�ԍ��v�Ȃ���s
		{
			fwrite($fp,$line);//�Y���s�̊����̓��e�����̂܂ܓ���
		}
	}
	if($word_retsu[0] < $_POST['del_num'])
	{
		echo $_POST['del_num']."�Ԃ̓��e�͑��݂��܂���B�B";
	}//�폜�ԍ��������Ƃ��̏���
	fclose($fp);//kadai_2-2/txt�����D
}//�폜�ԍ��̓��e�폜�����������e�L�X�g���㏑���ۑ�


if(!empty($_POST['ed_num']))//�ҏW���M������Ύ��s
{
	$txt_retsu = file($filename);//txt���s���Ƃɔz��ɕۑ�
	foreach($txt_retsu as $line)//�s���Ƃɏ��������s
	{
		$word_retsu = explode("<>",$line);//�Y���s(������)��<>�ŋ�؂��Ĕz��ɂ���
		if($word_retsu[0] == $_POST['ed_num'])//�utxt�̊Y���s�̍��[�̔ԍ����폜�ԍ��v�Ȃ���s
		{
			if($word_retsu[2] === "�폜���܂���")//�폜�ςłȂ����
			{
				echo "���ɍ폜���ꂽ���e�ł��B�i".$word_retsu[0]."�ԁj";
			}
			else
			{
				if($_POST['edit_password'] === trim($word_retsu[4]))//�p�X���[�h����������Ύ��s
				{
					$ed_num2 = $word_retsu[0];//�ҏW�ԍ�
					$ed_name = $word_retsu[1];//�ҏW���O
					$ed_com = $word_retsu[2];//�ҏW�R�����g
					$ed_pass = $word_retsu[4];//�ҏW�p�X���[�h
					$mode = 'hide';//�ҏW���[�h����
					echo "���e���C�����Ă��������B(".$ed_num2."��)";
				}
				else
				{
					echo "�������p�X���[�h����͂��Ă��������B�i".$word_retsu[0]."�ԁj";
				}
			}
		}
	}
	if($word_retsu[0] < $_POST['ed_num'])
	{
		echo $_POST['ed_num']."�Ԃ̓��e�͑��݂��܂���B";
	}//�폜�ԍ��������Ƃ��̏���
}//�ҏW����s�̔ԍ��C���O�C�R�����g��ǂݎ��D�ҏW���[�h�𔭓�������D
?>

	<form action ="mission_2-6.php" method ="get">
	<p>
	�E���O<br/><input type = "text" name = "name" value = <?php echo $ed_name; ?>><br/><br/><!-���O(�ҏW���閼�O)->
	�E�R�����g<br/><textarea name = "comment" rows  = "1" cols = "20"><?php echo $ed_com ?></textarea><br/><br/><!-�R�����g(�ҏW����R�����g)->
	�E�p�X���[�h<br/><input type = "password" name = "password" value = <?php echo $ed_pass; ?>><br/><br/><!-�p�X���[�h->
	<input type = "hidden" name = "mode" value = <?php echo $mode; ?>><!-���[�h�i��\���j->
	<input type = "hidden" name = "ed_num2" value = <?php echo $ed_num2; ?>><!-�ҏW�ԍ��i��\���j->
	<input type = "submit"value = "���M"><br/><br/>
	</p>
	</form>

	<form action ="mission_2-6.php" method ="post">
	<p>
	�E�폜�Ώ۔ԍ�<br/><input type = "text"name = "del_num"><br/><br/><!-�폜�ԍ��̓��͗�->
	�E�p�X���[�h<br/><input type = "password" name = "del_password"><br/><br/><!-�폜�p�X���[�h�̓��͗�->
	<input type = "submit"value = "�폜"><br/><br/>
	</p>
	</form><!-���M�t�H�[�����->

	<form action ="mission_2-6.php" method ="post">
	<p>
	�E�ҏW�Ώ۔ԍ�<br/><input type = "text" name = "ed_num"><br/><br/><!-�ҏW�ԍ��̓��͗�->
	�E�p�X���[�h<br/><input type = "password" name = "edit_password"><br/><br/><!-�ҏW�p�X���[�h�̓��͗�->
	<input type = "submit"value = "�ҏW�J�n"><br/><br/>
	</p>
	</form><!-���M�t�H�[�����->


<?php
$txt_retsu = file($filename);//txt���s���Ƃɔz��ŕۑ�
foreach($txt_retsu as $line)//�e�s�ɂ��ď��������s
{
	$word_retsu = explode("<>",$line);//�Y���s(������)��<>�ŋ�؂��Ĕz��ɂ���
	for( $i = 0 ; $i <= 3 ;$i++ )//�e������ɂ��ď��������s
	{
		echo " ".$word_retsu[$i];//�󗓁C�Y����������o��
	}
echo "<br>";//���s
}//�e�L�X�g�̓��e��html�ŕ\��
?>
</body>
</html>
