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
          else:
            $experience = 0;
            $progress = 0;
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
      <td>0</td>
      <? if (empty($level["user"])): ?>
        <td><a href="?page=research&section=<?=$selected_field_id?>&action=start&field=<?=$field_id?>&level=<?=$level_id?>">Starten</a></td>
      <? else: ?>
      <td><a href="?page=research&section=<?=$selected_field_id?>&action=stop&field=<?=$field_id?>&level=<?=$level_id?>">Stoppen</a></td>
      <? endif; ?>
    </tr>
    <? endforeach;
    endforeach; ?>
  </tbody>
</table>