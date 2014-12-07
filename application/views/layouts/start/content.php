<div class="container">
  <div class="row">
    <div class="col-sm-3">
      <? include_once(__DIR__."/../default/sidenav.php"); ?>
    </div>
    <div class="col-sm-9">
      <? include_once(__DIR__."/panelheader.php"); ?>
      <?=$content?>
      <? include_once(__DIR__."/panelfooter.php"); ?>
    </div>
  </div>
</div>