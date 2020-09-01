<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false)
{
    print'ようこそゲスト様';
    print'<a href="member_login.html">会員ログイン</a><br />';
    print'<br />';
}
else
{
    print'ようこそ';
    print $_SESSION['member_name'];
    print'様　';
    print'<a href="member_logout.php">ログアウト</a><br />';
    print'<br />';
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>

<?php

try
{  

$cart= $_SESSION['cart'];
$max=count($cart);
$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach($cart as $key => $val)
{
    $sql = 'SELECT name,price,gazou FROM mst_product WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[0] = $val;
    $stmt->execute($data);
    
    $rec= $stmt->fetch(PDO::FETCH_ASSOC);
    
    $pro_name[]=$rec['name'];
    $pro_price[]=$rec['price'];
    if($rec['gazou']=='')
    {
        $pro_gazou[]='';
    }
    else
    {
        $pro_gazou[]='<img src="../shop/product/gazou/'.$rec['gazou'].'">';
    }
}
$dbh = null;

}
catch (Exception $e)
{
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}


?>

カートの中身 <br />
<br />
<?php for($i=0;$i<$max;$i++)
    {
?>
        <?php print $pro_name[$i]; ?>
        <?php print $pro_gazou[$i]; ?>
        <?php print $pro_price[$i];?> 円
        <br />
<?php
    }
?>

<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>