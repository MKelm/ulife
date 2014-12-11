<? if ($action == "release" && $action_status == TRUE):
alert(ALERT_LEVEL_SUCCESS, "Der ausgebildete Bürger wurde von seinem Einheitsstatus befreit!");
elseif ($action == "release" && $action_status == FALSE):
alert(ALERT_LEVEL_DANGER, "Der ausgebildetete Bürger konnte von seinem Einheitsstatus nicht befreit werden!");
endif;
if (empty($units)): // no units message
alert(ALERT_LEVEL_WARNING, "Keine Einheiten verfügbar, bitte bilde zuerst Einheiten aus!");
else: ?>
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