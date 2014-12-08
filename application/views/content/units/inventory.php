<? if ($action == "release" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Der ausgebildete Bürger wurde von seinem Einheitsstatus befreit!</div>
<? endif; ?>
<? if ($action == "release" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Der ausgebildetete Bürger konnte von seinem Einheitsstatus nicht befreit werden!</div>
<? endif; ?>
<table class="table">
  <thead>
    <tr>
      <th>Titel</th>
      <th>Volumen</th>
      <th>Ausbildungszeit</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($units as $id => $unit): ?>
    <tr>
      <td><?=$unit["title"]?> [<?=$unit["number"]?>] <abbr title="<?=$unit["text"]?>">?</abbr></td>
      <td><?=get_numeric_value($unit["volume"])?></td>
      <td><?=date("d.m.Y H:i:s", $unit["time"])?></td>
      <td><a href="<?=base_url()?>units/inventory/release/<?=$id?>">Befreien</a></td>
    </tr>
    <? endforeach; ?>
  </tbody>
</table>