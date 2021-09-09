<div class="content">
  <?php print($main_navigation); ?>
  <main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form" method="post" autocomplete="off">
      <div class="form__row">
        <label class="form__label" for="project_name">Название <sup>*</sup></label>

        <input class="form__input <?php if (isset($form_errors['project_name'])): ?> form__input--error<?php endif;?>" type="text" name="project_name" id="project_name" value="<?php if(isset($_POST['send'])):?><?php print($project_name); ?><?php endif;?>" placeholder="Введите название проекта">
        <?php if (isset($form_errors['project_name'])): ?>
          <p class="form__message"><?php print($form_errors['project_name']); ?></p>
        <?php endif;?>
      </div>

      <div class="form__row form__row--controls">
        <input class="button" type="submit" name="send" value="Добавить">
      </div>
    </form>
  </main>
</div>