<? if ($action == "release" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Der ausgebildete Bürger wurde von seinem Einheitsstatus befreit!</div>
<? endif; ?>
<? if ($action == "release" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Der ausgebildetete Bürger konnte von seinem Einheitsstatus nicht befreit werden!</div>
<? endif; ?>
<!-- no units message -->
<? if (empty($units)): ?>
<div class="alert alert-warning" role="alert">Keine Einheiten verfügbar, bitte bilde zuerst Einheiten aus!</div>
<? else: ?>
<!-- inventory table -->
<table class="table">
  <thead>
    <tr>
      <th>Titel</th>
      <th>Volumen</th>
      <th>Ausgebildet seit</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($units as $id => $unit): ?>
    <?$time = (time() - $update_time) + ($round_number - $unit["end_round"]) * $update_interval; ?>
    <tr>
      <td><?=$unit["title"]?> [<?=$unit["number"]?>] <abbr title="<?=$unit["text"]?>">?</abbr></td>
      <td><?=get_numeric_value($unit["volume"])?></td>
      <td><?=get_numeric_time_value($time)?></td>
      <td><a href="<?=base_url()?>units/inventory/release/<?=$id?>">Befreien</a></td>
    </tr>
    <? endforeach; ?>
  </tbody>
</table>
<? endif; ?>