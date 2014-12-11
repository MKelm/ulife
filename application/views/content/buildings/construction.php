<!-- messages -->
<? if ($action === "construct" && $action_status == TRUE):
alert(ALERT_LEVEL_SUCCESS, "Der Aufbau des Gebäudes wurde begonnen!");
elseif ($action === "construct" && $action_status == FALSE):
alert(ALERT_LEVEL_DANGER, "Der Aufbau des Gebäudes konnte nicht begonnen werden!");
elseif ($action === "pause" && $action_status == TRUE):
alert(ALERT_LEVEL_SUCCESS, "Der Aufbau des Gebäudes wurde pausiert!");
elseif ($action === "pause" && $action_status == FALSE):
alert(ALERT_LEVEL_DANGER, "Der Aufbau des Gebäudes konnte nicht pausiert werden!");
elseif ($action == "demolish" && $action_status == TRUE):
alert(ALERT_LEVEL_SUCCESS, "Das Gebäude wurde erfolgreich abgerissen!");
elseif ($action == "demolish" && $action_status == FALSE):
alert(ALERT_LEVEL_DANGER, "Das Gebäude konnte nicht abgerissen werden!");
endif; ?>
<!-- list -->
