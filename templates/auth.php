<div class="content">

      <section class="content__side">
        <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

        <a class="button button--transparent content__side-button" href="auth.php">Войти</a>
      </section>

      <main class="content__main">
        <h2 class="content__main-heading">Вход на сайт</h2>

        <form  class="form" method="post" autocomplete="off" enctype="multipart/form-data">
          <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input
             <?php if (isset($form_errors['email'])): ?> form__input--error<?php endif;?>
            " type="text" name="email" id="email" value="" placeholder="Введите e-mail">
            <?php if (isset($form_errors['email'])): ?>
            <p class="form__message"><?php print($form_errors['email']); ?></p>
            <?php endif;?>
          </div>

          <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>
            <input class="form__input
            <?php if (isset($form_errors['pass'])): ?> form__input--error<?php endif;?>
            " type="password" name="password" id="password" value="" placeholder="Введите пароль">
            <?php if (isset($form_errors['pass'])): ?>
            <p class="form__message"><?php print($form_errors['pass']); ?></p>
            <?php endif;?>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="send" value="Войти">
          </div>
        </form>

      </main>

    </div>