<?php 
    include_once('config.php');
    include_once(LOCAL_PATH.'/header.php');
    include_once(LOCAL_PATH.'/functions.php');
    spl_autoload_register(function($class){
    require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});
    use \Michelf\Markdown;
?>
<div id="news">
<?php
    echo "<a class='title' href='".URL."'><div>rhétorique logiciel</div></a>";
    //$title = array();
    $title = $_GET['title'];
    $content_path = LOCAL_PATH.'/data'.'/'.$title;
    /*parse folder name*/
    $art_info = split_name($title);
    
    $t= preg_replace('/_/',' ', $art_info[1]);
    $t= preg_replace('/axc/','\'', $t);
    echo "<p class='t_a'>".$t."</p>";
    echo "<p class='date'>".$art_info[0]."</p>";
    if(false !== file_exists($content_path)){
        $image_array = array();
        $image_ext = array("jpeg", "jpg", "png");
        $text_ext = array("txt", "md");
        $preview = "p";
        $text_content = "";
        $folder = opendir($content_path);
        while(false !== ($files = readdir($folder))){
            /*remove preview image*/
            $ext = explode('.', basename($files));
            $p = explode('_',$ext[0]);
            $file_extension = end($ext);
            if(in_array($file_extension, $image_ext) && false == ($p[0] == $preview)){
                array_push($image_array, $files);
            }
            if(in_array($file_extension, $text_ext)){
                $text_md = file_get_contents($content_path.'/'.$files);
                $text_html =  Markdown::defaultTransform($text_md);

                
                //$text_content = str_replace("\n", "<br />", $text);                        
            }
        }
        foreach ($image_array as $name) {
            echo "<img src='/data/".$title."/".$name."'>";
        }
        //echo "<p class='text'>".$text_content."</p>";
        echo $text_html;
    }
    
?>
</div><!--end news-->
<div id="credits"></div>
<?php include_once(LOCAL_PATH.'/footer.php'); ?>