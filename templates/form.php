<main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form"  action="add.php" method="post" autocomplete="off">
          <div class="form__row">
          <?php
              if (isset($errors['name'])) {
                print '<p class="form__message">'.$errors['name'].'</p>';
              }
            ?>
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input
            <?php
              if (isset($errors['name'])) {
                print 'form__input--error';
              }
            ?>
            " type="text" name="name" id="name" value="" placeholder="Введите название">
          </div>

          <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select" name="project" id="project">
             <?php foreach ($categories as $project) {
               print('<option value="'.$project['id'].'">'.$project['name'].'</option>');
             }
             ?>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
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
            <input class="button" type="submit" name="" value="Создать">
          </div>
        </form>
      </main>