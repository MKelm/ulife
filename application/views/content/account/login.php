<? if ($confirmation_status === TRUE): ?>
<div class="alert alert-success" role="alert">Registrierung bestätigt, du kannst dich nun anmelden!</div>
<? endif; ?>
<? if ($confirmation_status === FALSE): ?>
<div class="alert alert-danger" role="alert">Registrierung fehlerhaft, Bestätigung nicht erfolgreich!</div>
<? endif; ?>
<?=validation_errors()?>
<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title"><strong>Anmelden</strong></h3></div>
  <div class="panel-body">
    <form role="form" name="login" action="<?=base_url()?>/account/login/send" method="post" accept-charset="utf-8">
      <div class="form-group <?form_field_error_status($field_errors, "name")?>">
        <label for="name">Benutzername</label>
        <input type="text" name="name" class="form-control" placeholder="Benutzername" value="<?=set_value("name")?>">
        <?form_field_error_glyph($field_errors, "name")?>
      </div>
      <div class="form-group <?form_field_error_status($field_errors, "password")?>">
        <label for="password">Passwort</label>
        <input type="password" name="password" class="form-control" placeholder="Passwort" value="<?=set_value("password")?>">
        <?form_field_error_glyph($field_errors, "password")?>
      </div>
      <button type="submit" class="btn btn-sm btn-default">Anmelden</button>
    </form>
  </div>
</div>