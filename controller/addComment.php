<?php

header("Content-Type: text/html; charset=utf-8");
class addComment{
    public $db = null;
    public function __construct(){
        $this->db = new PDO("mysql:host=localhost; dbname=blog", "padilo","padilo300");
        $this->index();
    }
   
    public function index(){
        var_dump($_POST);
        if(isset($_POST['autor']) && isset($_POST['text']) && isset($_POST['id']) ){
            //тут чистим наши данные
            $id         = trim(urldecode(htmlspecialchars($_POST['id'])));
            $autor      = mb_convert_case(mb_strtolower(trim(urldecode(htmlspecialchars($_POST['autor']  ))), 'UTF-8'), MB_CASE_TITLE, "UTF-8"); // Пишем имя автора с большой буквы
            $text       = trim(urldecode(htmlspecialchars($_POST['text'])));
            try{
                $query      = $this->db->prepare("INSERT INTO coments (autor, text, id_post) VALUES (?,?, ?)");
                $params     = array($autor,$text,$id);
                $query->execute($params)                        ; // запускаем запрос
                $this->db = null                                ; // обнуляем соединение
                header("Location: ".$_SERVER['HTTP_REFERER'])   ; // возвращаем пользователя назад
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
}
$set = new addComment();
