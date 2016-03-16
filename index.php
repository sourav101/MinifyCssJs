<!DOCTYPE html>
<html>
    <head>
        <title>Simple JS/CSS Minifier</title>
        <style type="text/css">
        body > div{width:300px;margin:20%auto;background:#f3f3f3;border:1px solid #bbb;padding:50px;}
        body > div > h2{color:#FF9900;text-align:center}
        body > div > form{padding:10px}
        form > select,form > input{width:138px;border:1px solid #bbb;background:#EBF8A4;font-weight:bolder;box-shadow:1px 2px 0px gray}
        body > div > p{background:#EBF8A4;border:1px solid #bbb;text-center;padding:10px}
        </style>
    </head>
    <body>
        <div>
            <h2>Simple JS/CSS Minifier</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
            <select name="ext">
                <option value="css">Css</option>
                <option value="js">Js</option>
            </select>
            <input type="submit" value="Minify">
            </form>

            <p>
            <?php
            if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['ext'])){ 
                $dir         = "input/";
                $new_dir     = "output/";
                $ext         = $_POST['ext'];
                $minify_file = "style.min.".$ext;

                $dh  = opendir($dir);
                $dir_list = array($dir);
                while (false !== ($filename = readdir($dh))) {
                    if($filename!="."&&$filename!=".."&&is_dir($dir.$filename))
                        array_push($dir_list, $dir.$filename."/");
                }

                $data   = null;
                $buffer = null;
                        echo "Installation Progress ...<br/>";
                foreach ($dir_list as $sdir) {
                    foreach (glob($sdir."*.".$ext) as $file_data){ 
                        echo "$file_data ...<br/>";
                        $buffer = file_get_contents($file_data);
                        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
                        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
                        $data   .= $buffer;
                    }
                }
                 
                if(!file_exists($new_dir.$minify_file)):
                    @mkdir($new_dir,0777);
                    if(file_put_contents($new_dir.$minify_file, $data)):
                      echo "Created successfull! <br/>";
                      echo "Location : ".$new_dir.$minify_file;
                    endif; 
                elseif(file_exists($new_dir.$minify_file)):
                    @unlink($new_dir.$minify_file);
                    if(file_put_contents($new_dir.$minify_file, $data)):
                      echo "Created successfull! <br/>";
                      echo "Location : ".$new_dir.$minify_file;
                    endif; 
                endif;
            }
            ?>
            </p>
        </div> 
    </body>
</html>

