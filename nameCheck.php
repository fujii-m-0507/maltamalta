<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>フォーム入力チェック</title>
  <link href="../../css/style.css" rel="stylesheet">
</head>
<body>
<div>

<?php
  require_once("lib/util.php");
  // 文字エンコードの検証
  if (!cken($_POST)){
    $encoding = mb_internal_encoding();
    $err = "Encoding Error! The expected encoding is " . $encoding ;
    // エラーメッセージを出して、以下のコードをすべてキャンセルする
    exit($err);
  }
  // HTMLエスケープ（XSS対策）
  $_POST = es($_POST);
?>

<?php
  // エラーフラグ
 $error = [];
  // 名前を取り出す----------------------------------
  if (isset($_POST['name'])){
    $name = trim($_POST['name']);
    if ($name===""){
      // 空白のときエラー
      $name = "error";
      $error [] = "名前にエラーがありました。";
    }
  } else {
    // 未設定のときエラー
    $name = "error";
    $error [] = "名前にエラーがありました。";
  } 
  //メールを取り出す----------------------------------
  if (isset($_POST['email'])){
    $email = trim($_POST['email']);
    if ($email===""){
      // 空白のときエラー
      $email = "error";
      $error [] = "メールにエラーがありました。";
    }
  } else {
    // 未設定のときエラー
    $email = "error";
    $error [] = "メールにエラーがありました。";
  }
//チェックボックスを取り出す----------------------------
if (isset($_POST['checkbox'])){
  $checkbox = ["旅行", "留学", "その他"];
  $diffValue = array_diff($_POST['checkbox'], $checkbox);
  if (count($diffValue)==0){
    // 空白のときエラー
    $mealChecked = $_POST["checkbox"];
  } else {
  // 未設定のときエラー
  $mealChecked = [];
  $error [] = "質問内容にエラーがありました。";
  }
} else {
  $mealChecked = [];
}

//テキストエリアを取り出す----------------------------------
if (isset($_POST["your-message"])){
  $note = $_POST["your-message"];
  $note = strip_tags($note);
  $note = mb_substr($note, 0, 150);
  $note = es($note);
} else {
  $note = "";
}
?>


<!-- 送信時画面 ----------------------------------------->
<?php if(count($error)>0):?>
  <span class="error">入力していない箇所があります</span>
  <form action="contact.html" method="POST">
    <input type="submit" value="戻る">
  </form>
<?php else: ?>
  <span>
  <?= $name;?>さん、入力ありがとうございました。
  </span>
<?php endif; ?>

<?php
//チェックボックス
$isSelected = count($mealChecked) > 0;
if ($isSelected){
  echo "<HR>";
  echo "質問内容が入力されました","<br>";
} else{
  echo "<HR>";
  echo "エラー";
}

//テキスト入力時
$length = mb_strlen($note);
if ($length>0){
  echo "<HR>";
  $note_br = nl2br($note, false);
  echo $note_br;
}
?>
</div>
</body>
</html>s
