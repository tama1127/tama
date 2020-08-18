<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <tiele>mission5-1 掲示版とmysql合体する</tiele>
    </head>
    <body>
        <form action = "" method = "post">
            名前:
            <input type = "text" name= "name" placeholder = "名前を入力してください">
            コメント:
            <input type = "text" name = "comment" placeholder = "コメントを入力してください">
            <input type = "submit" name = "submit">
        </form>
        <?php
        //データベースの作成
        $dsn = 'mysql:dbname=*******db;host=localhost';
        $user = 'tb-*******';
        $password = 'PASSWORD';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //データテーブルの作成(postで受け取ったものの書き込み)書き込みがからでない場合の処理を行う
        //その処理を行わないと空欄でもそのまま記入されてしまう
        //空でなかったときにデータベースを動かし、記入させる
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        if(!empty($name) && !empty($comment)){
        $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> execute();
        }//記入させる終了
        //データベース内に記入したものを表示させる
        //mission4-6ではid=1を抽出させるためにwhereを使用していたが、ここでは抽出は行わないのでwhereは使用しなくてOK
        //またここではbindParamを使う必要はない
        $sql = 'SELECT * FROM tbtest'; //tbtestを用いてユーザー情報を取得したい場合に'SELECT*FORM tbtestで呼び出す
        $stmt = $pdo-> query ($sql);    //query→データベースに対する命令文のこと$sql 内を検索させている？
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
		echo "<hr>";
            
        }
        ?>
    </body>
</html>