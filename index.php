<?php 
    header("Content-Type: text/html; charset=utf-8");
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);


    class Posts{
        public $db ="";
        public function __construct(){
            $this->db = new PDO("mysql:host=localhost; dbname=blog", "padilo","padilo300");
            /* $this->db->setAttribute(PDO::ATTR_ERRMOD, PDO::ERRMODE_EXCEPTION); */
            $this->index();
        }
        public function index(){
            $id         = 0;
            $posts      = array();
            $template   = "";

            /* смотрим в запрос */
            if(!empty($_GET['id'])){
                $id = $_GET['id'];
            }
            try{
                /* Смотрим хотятли смотреть весь список или конкретный пост */
                if(!empty($id)){
                    /* выбрать конкретный по id  */
                    $query      = $this->db->prepare("SELECT * FROM posts WHERE id = ? ");
                    $params     = array($id)        ;
                    $template   = __DIR__ .'/viev/singl-post.php' ;
                    $query->execute($params)            ; // запускаем запрос

                    for ($i = 0; $row = $query->fetch(); $i++){
                        // записываем ответ из базы
                        $posts[] = array(
                                        'id'        => $row['id']               , 
                                        'content'   => $row['content']          ,
                                        'autor'     => $row['autor']            ,
                                        'date'      => $row['date']             ,
                                        'contComm'  => $row['comments_count']   ,
                                        );
                    }
                    
                    $query      = $this->db->prepare("SELECT * FROM coments WHERE id_post = ? ");
                    $params     = array($id)        ;
                    $query->execute($params)        ; // запускаем запрос
                    if($query->fetch()){
                        for ($i = 0; $row = $query->fetch(); $i++){
                            // записываем ответ из базы
                            $comments[] = array(
                                'autor' => $row['autor']      , 
                                'text'  => $row['text'] ,
                                );
                        }
                    }

                    $this->db = null                ; // обнуляем соединение
                }else{
                    /* выбрать все */
                    $query      = $this->db->prepare("SELECT posts.*,COUNT(coments) AS `comments_count` FROM `posts` AS `posts`   LEFT JOIN `coments` AS `comm` ON (posts.id=comm.id_post) group by posts.id");
                    $params     = array()                           ;
                    $template   = __DIR__ . '/viev/list-posts.php'  ;
                    $query->execute($params)                        ; // запускаем запрос

                    for ($i = 0; $row = $query->fetch(); $i++){
                        // записываем ответ из базы
                        $posts[] = array(
                                        'id'        => $row['id']               , 
                                        'content'   => $row['content']          ,
                                        'autor'     => $row['autor']            ,
                                        'date'      => $row['date']             ,
                                        'contComm'  => $row['comments_count']   ,
                                        );
                    }
                    $this->db = null              ; // обнуляем соединение
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            require_once($template)       ; // загружаем нужный документ
        }
    }
    $posts = new Posts();
    
?>