<div class="container">
  <div class="row">
    <div class="col-sm-3">
      <ul class="nav nav-pills nav-stacked">
        <? if (!$valid_user): ?>
        <li <?page_nav_item_active("account/login", $page)?>><a href="<?=base_url()?>account/login">Anmeldung</a></li>
        <li <?page_nav_item_active("account/registration", $page)?>><a href="<?=base_url()?>account/registration">Registrierung</a></li>
        <li <?page_nav_item_active("help", $page)?>><a href="?page=help">Hilfe</a></li>
        <? elseif ($valid_user): ?>
        <li <?page_nav_item_active("start", $page)?>><a href="?page=start">Start</a></li>
        <li <?page_nav_item_active("research", $page)?>><a href="?page=research">Forschung</a></li>
        <li <?page_nav_item_active("buildings", $page)?>><a href="?page=buildings">Gebäude</a></li>
        <li <?page_nav_item_active("units", $page)?>><a href="?page=units">Einheiten</a></li>
        <li <?page_nav_item_active("help", $page)?>><a href="?page=help">Hilfe</a></li>
        <? endif; ?>
      </ul>
    </div>
    <div class="col-sm-9">
      <? echo $content; ?>
    </div>
  </div>
</div>