<ul class="nav nav-pills nav-stacked">
  <? if (!$valid_user): ?>
  <li <?page_nav_item_active("account/login", $page)?>><a href="<?=base_url()?>account/login">Anmeldung</a></li>
  <li <?page_nav_item_active("account/registration", $page)?>><a href="<?=base_url()?>account/registration">Registrierung</a></li>
  <li <?page_nav_item_active("help", $page)?>><a href="<?=base_url()?>help">Hilfe</a></li>
  <? elseif ($valid_user): ?>
  <li <?page_nav_item_active("start", $page)?>><a href="<?=base_url()?>start">Start</a></li>
  <li <?page_nav_item_active("research", $page)?>><a href="<?=base_url()?>research">Forschung</a></li>
  <li <?page_nav_item_active("buildings", $page)?>><a href="<?=base_url()?>buildings">Gebäude</a></li>
  <li <?page_nav_item_active("units", $page)?>><a href="<?=base_url()?>units">Einheiten</a></li>
  <li <?page_nav_item_active("help", $page)?>><a href="<?=base_url()?>help">Hilfe</a></li>
  <? endif; ?>
</ul>