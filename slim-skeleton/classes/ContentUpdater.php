<?php
/**
 * Created by PhpStorm.
 * User: afror
 * Date: 7/20/2017
 * Time: 9:43
 */

class ContentUpdater
{
  function decrypt($encrypted)
  {
    try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }
    $data = base64_decode($encrypted);
    $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
    $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, hash('sha256', $key, true) , substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)) , MCRYPT_MODE_CBC, $iv) , "\0");

    return $decrypted;
  }

  function encrypt($string)
  {
    try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC) , MCRYPT_DEV_URANDOM);
    $encrypted = base64_encode($iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_128, hash('sha256', $key, true) , $string, MCRYPT_MODE_CBC, $iv));

    return $encrypted;
  }
    function UpdateContent ($page_title, $page_url, $page_content) {
        try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }

        $conn = new mysqli($sqlserver, $sqluser, $sqlpass, $sqldb);

        $page_title = mysqli_escape_string($conn, $page_title);
        $page_url = mysqli_escape_string($conn, $page_url);
        $page_content = mysqli_escape_string($conn, $page_content);


        $sql = "UPDATE `pages` SET `name`='{$page_url}',`page-title`='{$page_title}',`content`='{$page_content}',`last-modified`= current_timestamp WHERE `name` = '{$page_url}'";

        $return = "SOMETHING SOMETHING SOMETHING ERROR";

        if (!mysqli_query($conn, $sql)) {
            $result = mysqli_error($conn);
        } else {
            $result = "Success";
        }

        return $result;
    }

    function UpdatePost ($title, $content) {
        try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }


        $conn = new mysqli($sqlserver, $sqluser, $sqlpass, $sqldb);

        $title = mysqli_escape_string($conn, $title);
        $content = mysqli_escape_string($conn, $content);

        $sql = "UPDATE `blog` SET `title`='{$title}',`content`='{$content}' WHERE `title`='{$title}'";

        $return = "SOMETHING SOMETHING SOMETHING ERROR";

        if (!mysqli_query($conn, $sql)) {
            $result = mysqli_error($conn);
        } else {
            $result = "Success";
        }

        return $result;
    }

    function WriteContent ($page_title, $page_url, $page_content) {
        try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }


        $conn = new mysqli($sqlserver, $sqluser, $sqlpass, $sqldb);

        $page_title = mysqli_escape_string($conn, $page_title);
        $page_url = mysqli_escape_string($conn, $page_url);
        $page_content = mysqli_escape_string($conn, $page_content);

        $sql = "INSERT INTO `pages` (`name`, `page-title`, `content`, `is-fullwidth`) VALUES ('{$page_url}', '{$page_title}', '{$page_content}', FALSE)";

        $return = "SOMETHING SOMETHING SOMETHING ERROR";

        if (!mysqli_query($conn, $sql)) {
            $result = mysqli_error($conn);
        } else {
            $result = "Success";
        }

        return $result;
    }

    function WritePost ($title, $content) {
        try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }


        $conn = new mysqli($sqlserver, $sqluser, $sqlpass, $sqldb);

        $title = mysqli_escape_string($conn, $title);
        $content = mysqli_escape_string($conn, $content);

        $sql = "INSERT INTO `blog` (`title`, `content`) VALUES ('{$title}', '{$content}')";

        $return = "SOMETHING SOMETHING SOMETHING ERROR";

        if (!mysqli_query($conn, $sql)) {
            $result = mysqli_error($conn);
        } else {
            $result = "Success";
        }

        return $result;
    }

    function AddFile ($filename, $filetype) {
        try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }


        $conn = new mysqli($sqlserver, $sqluser, $sqlpass, $sqldb);

        $filename = mysqli_escape_string($conn, $filename);

        $sql = "INSERT INTO `files` (`filename`, `filetype`) VALUES ('{$filename}', '{$filetype}')";

        $return = "SOMETHING SOMETHING SOMETHING ERROR";

        if (!mysqli_query($conn, $sql)) {
            $result = mysqli_error($conn);
        } else {
            $result = "Success";
        }

        return $result;
    }

    function UpdateCSS($newcss) {
        $myfile = fopen("../public/css/bootstrap-theme.css", "w") or die("Unable to open file!");
        fwrite($myfile, $newcss);
        fclose($myfile);
        return "Success";
    }

    function UpdateTemplate($template, $content) {
        $myfile = fopen("../templates/{$template}", 'w') or die("Unable to open file!");
        fwrite($myfile, $content);
        fclose($myfile);
        return "Success";
    }

    function DeletePage($name) {
      try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }


      $conn = new mysqli($sqlserver, $sqluser, $sqlpass, $sqldb);

      $sql = "DELETE FROM `pages` WHERE `name` = '{$name}'";

      if (!mysqli_query($conn, $sql)) {
          $result = mysqli_error($conn);
      } else {
          $result = "Success";
      }

      return $result;
    }

    function DeletePost($name) {
        try { include '../config.php'; } catch (Exception $e) { include '../ex-config.php'; }


        $conn = new mysqli($sqlserver, $sqluser, $sqlpass, $sqldb);

        $sql = "DELETE FROM `blog` WHERE `id` = '{$name}'";

        if (!mysqli_query($conn, $sql)) {
            $result = mysqli_error($conn);
        } else {
            $result = "Success";
        }

        return $result;
    }

    function CreateAll($user, $pass) {
      include '../config.php';
      $conn = new mysqli($sqlserver, $sqluser, $sqlpass, $sqldb);
      $sql = "CREATE TABLE `afroraydude-site`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(32) NOT NULL , `password` VARCHAR(256) NOT NULL , `token` VARCHAR(1024) NOT NULL , `joined_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `last_login_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM;";
      if (!mysqli_query($conn, $sql)) {
        $result = mysqli_error($conn);
      } else {
        $result = "Success";
      }
      $sql = "CREATE TABLE `afroraydude-site`.`blog` ( `id` INT NOT NULL AUTO_INCREMENT , `title` TINYTEXT NOT NULL , `content` TEXT NOT NULL , `created_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM;";
      if (!mysqli_query($conn, $sql)) {
        $result = mysqli_error($conn);
      } else {
        $result = "Success";
      }
      $sql = "CREATE TABLE `afroraydude-site`.`files` ( `id` INT NOT NULL AUTO_INCREMENT , `filename` VARCHAR(32) NOT NULL , `fullurl` TINYTEXT NOT NULL , `filetype` VARCHAR(10) NOT NULL , `upload_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM;";
      if (!mysqli_query($conn, $sql)) {
        $result = mysqli_error($conn);
      } else {
        $result = "Success";
      }
      $sql = "CREATE TABLE `afroraydude-site`.`pages` ( `id` INT NOT NULL AUTO_INCREMENT , `name` TINYTEXT NOT NULL , `page-title` VARCHAR(32) NOT NULL , `is-fullwidth` TINYINT(1) NOT NULL , `content` TEXT NOT NULL , `last-modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = MyISAM;";
      if (!mysqli_query($conn, $sql)) {
        $result = mysqli_error($conn);
      } else {
        $result = "Success";
      }

      # INSERTS
      $pass = $this->encrypt($pass);
      $untoken = bin2hex(random_bytes(8)) . $user . bin2hex(random_bytes(8));
      $token = $this->encrypt($untoken);
      $sql = "INSERT INTO `users`(`username`, `password`, `token`) VALUES ('{$user}','{$pass}','{$token}')";
      if (!mysqli_query($conn, $sql)) {
        $result = mysqli_error($conn);
      } else {
        $result = "Success";
        $_SESSION['token'] = $token;
        $_SESSION['username'] = $user;
      }
      return $result;
    }
}