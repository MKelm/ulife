<!-- messages -->
<? if ($action === "start" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Forschung konnte nicht gestartet werden!</div>
<? endif; ?>
<? if ($action === "start" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Forschung wurde erfolgreich gestartet!</div>
<? endif; ?>
<? if ($action === "stop" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Forschung konnte nicht gestoppt werden!</div>
<? endif; ?>
<? if ($action === "stop" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Forschung wurde erfolgreich gestoppt!</div>
<? endif; ?>
<!-- research table -->
<table class="table">
  <thead>
    <tr>
      <th>Feld</th>
      <th>Level</th>
      <th>Forscher</th>
      <th>Fortschritt</th>
      <th>Restrunden</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($research_fields as $field_id => $field):
        foreach ($field["levels"] as $level_id => $level):
          if (!empty($level["user"])):
            $experience = $level["user"]["experience"];
            $progress = (100/$level["experience"]) * $experience;
            $rounds = $level["user"]["rounds"];
          else:
            $experience = 0;
            $progress = 0;
            $rounds = 0;
          endif;
      ?>
    <tr>
      <td><?=$field["title"]?> <abbr title="<?=$field["text"]?>">?</abbr></td>
      <td><?=$level["number"]?> <abbr title="<?=$level["experience"]?> Erfahrungspunkte zu erforschen">?</abbr></td>
      <td><?=$level["researchers"]?> <abbr title="Bessere Forscher werden zuerst eingeteilt">?</abbr></td>
      <td><div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%;">
          <?=$progress?>%
        </div>
      </div></td>
      <td><?=$rounds?></td>
      <? if (empty($level["user"])): ?>
      <td><a href="<?=base_url()?>research/fields/<?=$selected_field_id?>/start/<?=$field_id?>/<?=$level_id?>">Starten</a></td>
      <? elseif ($level["user"]["time"] == 0): ?>
      <td><a href="<?=base_url()?>research/fields/<?=$selected_field_id?>/start/<?=$field_id?>/<?=$level_id?>">Weiter</a></td>
      <? else: ?>
      <td><a href="<?=base_url()?>research/fields/<?=$selected_field_id?>/pause/<?=$field_id?>/<?=$level_id?>">Pausieren</a></td>
      <? endif; ?>
    </tr>
    <? endforeach;
    endforeach; ?>
  </tbody>
</table>