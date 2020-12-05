<?php
    // htmlspecialchars関数を実行するだけの関数 h() を定義
    function h($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
    
    $id = $_GET["book_id"];    
    // MySQLサーバ接続に必要な値を変数に代入
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'bookshelf';

    // 変数を設定して、MySQLサーバに接続
    $database = mysqli_connect($host, $username, $password, $db_name);

    // 接続を確認し、接続できていない場合にはエラーを出力して終了する
    if ($database == false) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }

    // MySQL に utf8 で接続するための設定をする
    $charset = 'utf8';
    mysqli_set_charset($database, $charset);
    $sql = 'SELECT * FROM books WHERE id='.$id; 

    // セクション6で後述しますが、この部分に if-elseif-else 文を後ほど挿入します
    // いずれかの $sql を実行して $result に代入する
    $result = mysqli_query($database, $sql);


     if ($result) {
        while ($record = mysqli_fetch_assoc($result)) {
             // 1レコード分の値をそれぞれ変数に代入する
            $id = $record['id'];
            $title = $record['title'];
            $image_url = $record['image_url'];
            $status = $record['status'];
            $memo = $record['memo'];
        }
     }
     
//     var_dump($id, $title,$image_url,$status,$memo);
    // MySQLを使った処理が終わると、接続は不要なので切断する
    mysqli_close($database);
    
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Bookshelf | カンタン！あなたのオンライン本棚</title>
        <link rel="stylesheet" href="bookshelf.css">
    </head>
    <body>
        <header>
            <div id="header">
                <div id="logo">
                    <a href="./bookshelf_index.php"><img src="./images/logo.png" alt="Bookshelf"></a>
                </div>
                <nav>
                    <a href="./bookshelf_form.php"><img src="./images/icon_plus.png" alt=""> 書籍登録</a>
                </nav>
            </div>
        </header>
        <div id="wrapper">
            <div id="main">
                <form action="bookshelf_index.php" method="post" class="form_book">
                    <input type="hidden" name="book_id" value="<?php print h($id); ?>">
                    <div class="book_memo">
                        <input type="text" name="edit_book_memo" placeholder="メモを入力" value="<?php print h($memo); ?>">
                    </div>
                    <div class="book_submit">
                        <input type="submit" name="submit_book_memo" value="更新">
                    </div>
                </form>
            </div>
        </div>
        <footer>
            <small>© 2019 Bookshelf.</small>
        </footer>
    </body>
</html>