<!-- messages -->
<? if ($action === "construct" && $action_status == TRUE):
alert(ALERT_LEVEL_SUCCESS, "Der Aufbau des Gebäudes wurde begonnen!");
elseif ($action === "construct" && $action_status == FALSE):
alert(ALERT_LEVEL_DANGER, "Der Aufbau des Gebäudes konnte nicht begonnen werden!");
endif; ?>
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
      <td><a href="<?=base_url()?>buildings/selection/construct/<?=$id?>/<?=$level_id?>">Aufbauen</a></td>
    </tr>
    <? endforeach;
    endforeach; ?>
  </tbody>
</table>