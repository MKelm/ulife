<!-- messages -->
<? if ($action === "construct" && $action_status == TRUE): ?>
<div class="alert alert-danger" role="alert">Der Aufbau des Gebäudes wurde begonnen!</div>
<? endif; ?>
<? if ($action === "construct" && $action_status == FALSE): ?>
<div class="alert alert-success" role="alert">Der Aufbau des Gebäudes konnte nicht begonnen werden!</div>
<? endif; ?>
<!-- table -->
<table class="table">
  <thead>
    <tr>
      <th>Titel</th>
      <th>Volumen</th>
      <th>Holz</th>
      <th>Steine</th>
      <th>Arbeiter</th>
      <th>Runden</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($buildings as $id => $building):
        foreach ($building["levels"] as $level_id => $level): ?>
    <tr>
      <td><?=$building["title"]?> [<?=$level["number"]?>] <abbr title="<?=$building["text"]?>">?</abbr></td>
      <td><?=get_numeric_value($level["volume"])?></td>
      <td><?=get_numeric_value($level["c_wood"])?></td>
      <td><?=get_numeric_value($level["c_stones"])?></td>
      <td><?=get_numeric_value($level["c_workers"])?></td>
      <td><?=get_numeric_value($level["c_rounds"])?></td>
      <td><a href="<?=base_url()?>/selection/construct/<?=$id?>/<?=$level_id?>">Aufbauen</a></td>
    </tr>
    <? endforeach;
    endforeach; ?>
  </tbody>
</table>