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
    <p>Seite teilen: </p>
    <p>
      <a href="https://alpha.app.net/intent/post?text=Ich%20habe%20gerade%20eine%20E-Mail%20an%20den%20Bundesnachrichtendienst%20geschrieben.%20%C3%9Cberwacht%20mich%20nicht!%20http://ueberwacht-mich-nicht.de/%20%23bnd" target="_blank">App.net</a> <a href="https://twitter.com/home?status=Ich%20habe%20gerade%20eine%20E-Mail%20an%20den%20Bundesnachrichtendienst%20geschrieben.%20%C3%9Cberwacht%20mich%20nicht!%20http://ueberwacht-mich-nicht.de/%20%23bnd" target="_blank">Twitter</a> <a href="https://plus.google.com/share?url=http://ueberwacht-mich-nicht.de/meine-emails/" target="_blank">Google Plus</a> <a href="https://www.facebook.com/sharer/sharer.php?u=http://ueberwacht-mich-nicht.de/" target="_blank">Facebook</a>
    </p>
  </section>
</body>
</html>