<!-- messages -->
<? if ($action === "construct" && $action_status == TRUE): ?>
<div class="alert alert-danger" role="alert">Der Aufbau des Gebäudes wurde begonnen!</div>
<? endif; ?>
<? if ($action === "construct" && $action_status == FALSE): ?>
<div class="alert alert-success" role="alert">Der Aufbau des Gebäudes konnte nicht begonnen werden!</div>
<? endif; ?>
<? if ($action === "pause" && $action_status == TRUE): ?>
<div class="alert alert-danger" role="alert">Der Aufbau des Gebäudes wurde pausiert!</div>
<? endif; ?>
<? if ($action === "pause" && $action_status == FALSE): ?>
<div class="alert alert-success" role="alert">Der Aufbau des Gebäudes konnte nicht pausiert werden!</div>
<? endif; ?>
<? if ($action == "demolish" && $action_status == TRUE): ?>
<div class="alert alert-success" role="alert">Das Gebäude wurde erfolgreich abgerissen!</div>
<? endif; ?>
<? if ($action == "demolish" && $action_status == FALSE): ?>
<div class="alert alert-danger" role="alert">Das Gebäude konnte nicht abgerissen werden!</div>
<? endif; ?>
<!-- list -->
