<?php
print_r($_FILES);
$nameImage = "lucas.jpg";
move_uploaded_file($_FILES["file"]["tmp_name"], "/srv/www/upload/".$new_image_namenameImage);
?>