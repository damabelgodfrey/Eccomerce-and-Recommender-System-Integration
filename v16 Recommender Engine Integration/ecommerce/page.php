
      <?php
      require_once 'core/init.php';
      include"includes/head.php";
      include"includes/navigation.php";
      //include"includes/headerpartial.php";
      $transactionType = 'CASH';
      $characters = 'BCDFGHJKLMNPQRSTUVWXWZbcdfghjklmnpqrstvwxyz0123456789';
      $string = '';
      $random_string_length =15;
      $max = strlen($characters) - 1;
        for ($i = 0; $i < $random_string_length; $i++) {
             $string .= $characters[mt_rand(0, $max)];
        }
      $chargeId = $transactionType.$string;
      var_dump($chargeId);
