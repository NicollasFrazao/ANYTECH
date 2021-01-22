<html>
  <head>
  </head>
  <body>
    <?php
      $aux = 'qrcode/php/qr_img.php?';
      $aux .= 'd=www.anytech.com.br?id=2&';
      $aux .= 'e=H&';
      $aux .= 's=4&';
      $aux .= 't=P';
    ?>
    <img src="<?php echo $aux; ?>">
  </body>
</html>
