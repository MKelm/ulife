<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <a class="navbar-brand" href="<?=base_url()?>">
      <img alt="ULife" width="20" height="20" src="<?=base_url()?>images/ulbrand.png">
    </a>
    <a class="navbar-brand" href="<?=base_url()?>">ULife</a>
    <? if ($valid_user) { ?>
    <p class="navbar-text"><?get_numeric_value($user->wood)?> Holz</p>
    <p class="navbar-text"><?get_numeric_value($user->stones)?> Stein</p>
    <p class="navbar-text"><?get_numeric_value($user->food)?> Nahrung</p>
    <p class="navbar-text"><?get_numeric_value($user->coins)?> Münzen</p>
    <p class="navbar-text"><?get_numeric_value($user->citizen)?> Bürger</p>
    <p class="navbar-text"><?get_numeric_value($user->experience)?> XP</p>
    <? } ?>
    <p class="navbar-text navbar-right"><? if (!$valid_user) { ?>Nicht angemeldet<?
       } else { ?><?=$user->name?>, <a href="<?=base_url?>logout" class="navbar-link">abmelden</a><? } ?></p>
  </div>
</nav>