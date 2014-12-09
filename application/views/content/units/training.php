<? if ($action == "pause" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Die Ausbildung eines Bürgers zur Einheit wurde pausiert!</div>
<? endif; ?>
<? if ($action == "pause" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Die Ausbildung eines Bürgers zur Einheit konnte nicht pausiert werden!</div>
<? endif; ?>
<!-- no units message -->
<? if (empty($units)): ?>
<div class="alert alert-warning" role="alert">Derzeit werden keine Einheiten ausgebildet, bitte bilde Einheiten über die Auswahl aus!</div>
<? else: ?>
<!-- training table -->
<table class="table">
  <thead>
    <tr>
      <th>Titel</th>
      <th>Volumen</th>
      <th>Fortschritt</th>
      <th>Restrunden</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($units as $id => $unit):
        $progress = floor(
          100 - (100/$unit["t_rounds"]) * $unit["rounds"]
        ); ?>
    <tr>
      <td><?=$unit["title"]?> [<?=$unit["number"]?>] <abbr title="<?=$unit["text"]?>">?</abbr></td>
      <td><?=get_numeric_value($unit["volume"])?></td>
      <td><div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%;">
          <?=$progress?>%
        </div>
      </div></td>
      <td><?=get_numeric_value($unit["rounds"])?></td>
      <td><a href="<?=base_url()?>units/training/pause/<?=$id?>">Pausieren</a></td>
    </tr>
    <? endforeach; ?>
  </tbody>
</table>
<? endif; ?>