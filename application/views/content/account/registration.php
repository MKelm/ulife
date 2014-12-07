<div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title"><strong>Registrierung  </strong></h3></div>
  <div class="panel-body">
    <!-- messages -->
    <? if (!empty($confirmation_link)): ?>
    <div class="alert alert-warning" role="alert">Bitte bestätige deine Registrierung über <a href="<?=$confirmation_link?>">diesen Link</a>!</div>
    <? elseif ($registration_status === TRUE): ?>
    <div class="alert alert-success" role="alert">Registrierung erfolgreich, eine Bestätigungsemail wurde versand!</div>
    <? endif; ?>
    <?=validation_errors()?>
    <!-- form -->
    <form role="form" name="registration" action="<?=base_url()?>account/registration/send" method="post" accept-charset="utf-8">
      <div class="form-group <?form_field_error_status($field_errors, "name")?>">
        <label for="name">Benutzername</label>
        <input type="text" name="name" class="form-control" placeholder="Benutzername" value="<?=set_value("name")?>">
        <?form_field_error_glyph($field_errors, "name")?>
      </div>
      <div class="form-group <?form_field_error_status($field_errors, "email")?>">
        <label for="email">E-Mail</label>
        <input type="email" name="email" class="form-control" placeholder="deinname@email.de" value="<?=set_value("email")?>">
        <?form_field_error_glyph($field_errors, "email")?>
      </div>
      <div class="form-group <?form_field_error_status($field_errors, "password")?>">
        <label for="password">Passwort</label>
        <input type="password" name="password" class="form-control" placeholder="Passwort" value="<?=set_value("password")?>">
        <?form_field_error_glyph($field_errors, "password")?>
      </div>
      <div class="form-group <?form_field_error_status($field_errors, "password2")?>">
        <label for="password2">Passwort bestätigen</label>
        <input type="password" name="password2" class="form-control" placeholder="Passwort" value="<?=set_value("password2")?>">
        <?form_field_error_glyph($field_errors, "password2")?>
      </div>
      <button type="submit" class="btn btn-sm btn-default">Registrieren</button>
    </form>
  </div>
</div>