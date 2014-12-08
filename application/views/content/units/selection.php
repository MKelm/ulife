<? if ($action == "train" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Die Ausbildung eines Bürger zur Einheit wurde begonnen!</div>
<? endif; ?>
<? if ($action == "train" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Die Ausbildung eines Bürgers zur Einheit konnte nicht begonnen werden!</div>
<? endif; ?>
<table class="table">
  <thead>
    <tr>
      <th>Titel</th>
      <th>Volumen</th>
      <th>Münzen</th>
      <th>Runden</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($units as $id => $unit):
        foreach ($unit["levels"] as $level_id => $level): ?>
    <tr>
      <td><?=$unit["title"]?> [<?=$level["number"]?>] <abbr title="<?=$unit["text"]?>">?</abbr></td>
      <td><?=get_numeric_value($level["volume"])?></td>
      <td><?=get_numeric_value($level["t_coins"])?></td>
      <td><?=get_numeric_value($level["t_rounds"])?></td>
      <td><a href="<?=base_url()?>units/selection/train/<?=$id?>/<?=$level_id?>">Ausbilden</a></td>
    </tr>
    <? endforeach;
    endforeach; ?>
  </tbody>
</table>