<div class='embedwrapper'>
    <?php
        $content = str_ireplace("&lt;","<",$content);
        $content = str_ireplace("&gt;",">",$content);
        $content = str_ireplace("&#8221;",'"',$content);
        $content = str_ireplace("&#8243;",'"',$content);
        // &lt;iframe width=”560″ height=”315″ src=”https://www.youtube.com/embed/7c5S50Eh36k” title=”YouTube video player” frameborder=”0″ allow=”accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture” allowfullscreen&gt;&lt;/iframe&gt;    
    ?>
    <?php echo ($content) ?>    
</div>