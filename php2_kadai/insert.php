<?php

require_once('funcs.php');

//1. POSTデータ取得
$book_name = $_POST['book_name'];
$book_URL = $_POST['book_URL'];
$coment = $_POST['coment'];

//2. DB接続します
try {
    //ID:'root', Password: 'root'
    $pdo = new PDO('mysql:dbname=bookmark@me;charset=utf8;host=localhost', 'root', 'root');
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, book_name, book_URL, coment, date)
                        VALUES(NULL, :book_name, :book_URL, :coment, sysdate())");

//  2. バインド変数を用意
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_URL', $book_URL, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':coment', $coment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

//  3. 実行
$status = $stmt->execute();
//４．データ登録処理後
if ($status == false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMessage:" . $error[2]);
} else {
    //５．index.phpへリダイレクト 白背景に飛ばず、そのままの画面になる
    header('Location: index.php');
}
?>
