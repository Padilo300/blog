<?php

header("Content-Type: text/html; charset=utf-8");
class addPost{
    public $db = null;
    public function __construct(){
        $this->db = new PDO("mysql:host=localhost; dbname=blog", "padilo","padilo300");
        $this->index();
    }
    public function getDate(){
        // Вывод даты на русском
        $monthes = array(
            1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
            5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
            9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
        );

        // Вывод дня недели
        $days = array(
            'Воскресенье', 'Понедельник', 'Вторник', 'Среда',
            'Четверг', 'Пятница', 'Суббота'
        );

        $date = (string) (date('d ') . $monthes[(date('n'))] . date(' Y, H:i') . ' ' . $days[(date('w'))]);
        
        return $date;
    }
    public function index(){
        if(isset($_POST['autor']) && isset($_POST['text'] ) ){
            $date = $this->getDate();
            //тут чистим наши данные
            $autor      = mb_convert_case(mb_strtolower(trim(urldecode(htmlspecialchars($_POST['autor']  ))), 'UTF-8'), MB_CASE_TITLE, "UTF-8"); // Пишем имя автора с большой буквы
            $text       = trim(urldecode(htmlspecialchars($_POST['text'])));
            try{
                $query      = $this->db->prepare("INSERT INTO posts (autor, content, date) VALUES (?,?,?)");
                $params     = array($autor,$text,$date);
                $query->execute($params)      ; // запускаем запрос
                $this->db = null              ; // обнуляем соединение
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
}
$set = new addPost();
