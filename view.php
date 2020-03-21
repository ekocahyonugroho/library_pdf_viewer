<?php
if(isset($_GET['id'])){
    session_start();
    if (isset($_SESSION['code_viewer']) and $_SESSION['code_viewer'] == $_GET['id']) {

        include "conn.php";

        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $key = "bladeyeshibbir?1%59#";
        $decryptext = base64_decode(str_pad(strtr($_GET['id'], '-_', '+/'), strlen($_GET['id']) % 4, '=', STR_PAD_RIGHT));
        $decrypted_id = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $decryptext, MCRYPT_MODE_ECB, $iv);

        $id = $decrypted_id;

        $query = "select * from file where id = '" . $id . "'";
        $result = mysql_query($query);
        $count = mysql_num_rows($result);
        if ($count <> 0) {
            $download = mysql_fetch_array($result);

            $name = str_replace('%20', ' ', $download['file_name']);
            $type = $download['file_type'];
            $size = $download['file_size'];
            $content = $download['file'];

            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
            header("Content-length: " . $size . "");
            header("Content-type: $type");
            echo $content;
            unset($_SESSION['code_viewer']);
            exit;
        }
    }
}
?>