<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

get_instance()->load->helper('url'); 

?><!doctype html>
<html>
<head>
  <title>Verification</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="<?php echo base_url('meine-emails/styles/main.css'); ?>">
</head>
<body>
  <section class="l_centered">
   <p><?php echo $respond; ?></p>
  </section>
</body>
</html>