<div class="content">

  <?php print($main_navigation); ?>

  <main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form" method="post" autocomplete="off" enctype="multipart/form-data">
      <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>
        <input class="form__input<?php if (isset($form_errors['task_name'])): ?> form__input--error<?php endif;?>" type="text" name="name" id="name" value="" placeholder="Введите название">
        <?php if (isset($form_errors['task_name'])): ?>
          <p class="form__message"><?php print($form_errors['task_name']); ?></p>
        <?php endif;?>
      </div>

      <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>

        <select class="form__input form__input--select <?php if (isset($form_errors['task_id_project'])): ?>form__input--error<?php endif;?>" name="project" id="project">
          <?php foreach ($projects as $project): ?>
          <option value="<?=$project['id']?>"><?=$project['name']?></option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($form_errors['task_id_project'])): ?>
        <p class="form__message"><?php print($form_errors['task_id_project']); ?></p>
        <?php endif;?>
      </div>

      <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?php if (isset($form_errors['task_date'])): ?>form__input--error<?php endif;?>" type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
        <?php if (isset($form_errors['task_date'])): ?>
        <p class="form__message"><?php print($form_errors['task_date']); ?></p>
        <?php endif;?>
      </div>

      <div class="form__row">
        <label class="form__label" for="file">Файл</label>

        <div class="form__input-file">
          <input class="visually-hidden" type="file" name="file" id="file" value="">

          <label class="button button--transparent" for="file">
            <span>Выберите файл</span>
          </label>
        </div>
      </div>

      <div class="form__row form__row--controls">
        <input class="button" type="submit" name="send" value="Добавить">
      </div>
    </form>
  </main>
</div>