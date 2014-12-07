<div class="panel panel-default">
  <div class="panel-heading"><ul class="nav nav-pills">
    <? if ($selected_field_id > 0): ?>
    <li role="presentation"><a href="<?=base_url()?>research/fields">Allgemein</a></li>
    <? else: ?>
    <li role="presentation" <?page_nav_item_active("research/fields", $page)?>><a href="<?=base_url()?>research/fields">Allgemein</a></li>
    <? endif; ?>
    <? foreach ($main_research_fields as $id => $field) { ?>
    <li role="presentation" <?page_nav_item_active("research/fields/".$id, $page."/".$selected_field_id)?>><a href="<?=base_url()?>research/fields/<?=$id?>"><?=$field["title"]?></a></li>
    <? } ?>
  </ul></div>
  <div class="panel-body">