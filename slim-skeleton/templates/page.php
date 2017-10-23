<?php
require '../config.php';

if ($name !== 'blog' && $name !== 'blog-content') {
    $conn = new PDO("mysql:host=$sqlserver;dbname=$sqldb", $sqluser, $sqlpass);
    
    if (isset($name)) {
        $page_name = htmlspecialchars($name);
        //$page_name = mysqli_real_escape_string($conn, $page_name);
        
    } else {
        $page_name = "index";
    }
    
    $return = 'Something something something error';
    /**
     * if ($conn->connect_error) {
     * die("Connection failed: " . $conn->connect_error);
     * }
     */
    $sql    = "SELECT * FROM `afroraydude-site`.`pages` WHERE `name` LIKE '{$page_name}'";
    
    $stmt = $conn->query($sql);
    
    if (0 !== $stmt->rowCount()):
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $page_title = $row['page-title'];
            $page_id    = $row['id'];
            $text       = $row['content'];
            $template = $row['template'];
        }
    else:
        $page_title = "404 Page Not Found";
    endif;
    // end header processing
    
    if (!empty($text)) {
        if (empty($messages) == false):
            $error = $messages['Error'];
?>
       <div class="alert alert-danger alert-dismissable"><p><?= $error[0] ?></p></div>
    <?php
        endif;
        //include_once 'themes/{$theme}/header.phtml';
        include_once "themes/{$theme}/{$template}";
        //include_once 'themes/{$theme}/footer.phtml';
    } else {
        include_once '404.phtml';
    }
} else if ($name !== 'blog-content') {
    include_once "themes/{$theme}/blog.phtml";
} else {
    include_once "themes/{$theme}/blog-content.phtml";
}
?>
