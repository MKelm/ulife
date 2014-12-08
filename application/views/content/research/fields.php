<!-- messages -->
<? if ($action === "start" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Forschung konnte nicht gestartet werden!</div>
<? endif; ?>
<? if ($action === "start" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Forschung wurde erfolgreich gestartet!</div>
<? endif; ?>
<? if ($action === "cancel" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Forschung konnte nicht abgebrochen werden!</div>
<? endif; ?>
<? if ($action === "cancel" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Forschung wurde erfolgreich abgebrochen!</div>
<? endif; ?>
<!-- research table -->
<table class="table">
  <thead>
    <tr>
      <th>Feld</th>
      <th>Level</th>
      <th>Forscher</th>
      <th>Fortschritt</th>
      <th>Restzeit</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($research_fields as $field_id => $field):
        foreach ($field["levels"] as $level_id => $level):
          if (!empty($level["user"])):
            $time = $level["user"]["end_time"] - time();
            $progress = 100 -
              (100/($level["user"]["end_time"] - $level["user"]["start_time"])) *
                ($level["user"]["end_time"] - time());
          else:
            $progress = 0;
            $time = 0;
          endif;
      ?>
    <tr>
      <td><?=$field["title"]?> <abbr title="<?=$field["text"]?>">?</abbr></td>
      <td><?=$level["number"]?> <abbr title="<?=$level["experience"]?> Erfahrungspunkte zu erforschen">?</abbr></td>
      <td><?=$level["researchers"]?> <abbr title="Bessere Forscher werden zuerst eingeteilt">?</abbr></td>
      <td><div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%;">
          <?=get_numeric_value($progress)?>%
        </div>
      </div></td>
      <td><?=get_numeric_time_value($time)?></td>
      <? if (empty($level["user"])): ?>
      <td><a href="<?=base_url()?>research/fields/<?=$selected_field_id?>/start/<?=$field_id?>/<?=$level_id?>">Starten</a></td>
      <? else: ?>
      <td><a href="<?=base_url()?>research/fields/<?=$selected_field_id?>/cancel/<?=$field_id?>/<?=$level_id?>">Abbrechen</a></td>
      <? endif; ?>
    </tr>
    <? endforeach;
    endforeach; ?>
  </tbody>
</table>