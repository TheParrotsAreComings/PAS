  <div class="body">
    <div class="add-view column">
      <div class="button-add-signal" data-ix="add-mobile-showhide-2"></div>
      <div class="add-cont scroll1" data-ix="page-load-fade-in">
        <div class="add-header">
          <div class="add-field-h1">Create a cat</div><img class="add-picture" height="90" src="http://uploads.webflow.com/img/image-placeholder.svg" width="90">
        </div>
        <?= $this->Form->create($cat) ?>
        <div class="add-input-form-wrap w-form">
          <form class="add-input-form" data-name="Email Form 4" id="email-form-4" name="email-form-4">
            <label class="add-field-h2" for="First-Name">personal information</label>
            <div class="add-field-seperator"></div>
            <!--<label class="add-field-h3" for="cat_name-2">name:</label>
            <input autofocus="autofocus" class="add-input w-input" data-name="cat_name" id="cat_name-2" maxlength="256" name="cat_name" placeholder="Bella" required="required" type="text">-->
            <?php echo $this->Form->input('cat_name', array('label' => ['text' => 'Cat Name:', 'class' => 'add-field-h3'], 'class' => 'add-input w-input', 'placeholder' => 'Bella')); ?>
            <label class="add-field-h3">Date of birth:</label>
            <div class="date-cont">
            <?php echo $this->Form->month('dob', array('name' => 'dob[month]', 'class' => 'date-month w-select', 'empty' => 'Month')); ?>
            <?php echo $this->Form->day('dob', array('name' => 'dob[day]', 'class' => 'date-day w-select',  'empty' => 'Day')); ?>
            <?php echo $this->Form->year('dob', array('name' => 'dob[year]', 'class' => 'date-year w-select', 'empty' => 'Year')); ?>
            </div>
            <?php echo $this->Form->input('breed_color_coat', array('label' => ['text' => 'Breed/Color/Coat', 'class' => 'add-field-h3'], 'class' => 'add-input w-input', 'placeholder' => 'Siamese Brown Shorthair')); ?>
            <label class="add-field-h3" for="E-mail">gender:</label>
            <div class="gender-cont">
              <div class="gender-switch w-embed" data-ix="gender-switch">
                <style>
                  /* ---------- SWITCH ---------- */
                  .switch {
                    background: #eee;
                    border-radius: 32px;
                    display: block;
                    height: 32px;
                    position: relative;
                    width: 80px;
                  }
                  .switch input {
                    height: 32px;
                    left: 0;
                    opacity: 0;
                    position: absolute;
                    top: 0;
                    width: 80px;
                    z-index: 2;
                  }
                  .switch input:checked~.toggle {
                    left: 4px;
                  }
                  .switch input~:checked~.toggle {
                    left: 50px;
                  }
                  .switch input:checked {
                    z-index: 0;
                  }
                  .toggle {
                    background: #0172ff;
                    border-radius: 50%;
                    height: 28px;
                    left: 0;
                    position: absolute;
                    top: 2px;
                    -webkit-transition: left .2s ease;
                    -moz-transition: left .2s ease;
                    -ms-transition: left .2s ease;
                    -o-transition: left .2s ease;
                    transition: left .2s ease;
                    width: 28px;
                    z-index: 1;
                  }
                </style>
                <div class="switch white">
                  <input type="radio" name="switch" id="female" checked>
                  <input type="radio" name="switch" id="male">
                  <span class="toggle"></span>
                </div>
              </div>
              <div class="gender-female">male</div>
              <div class="gender-male">female</div>
            </div>
            <label class="add-field-h3" for="E-mail">kitten:</label>
            <div class="gender-cont">
              <div class="gender-switch w-embed" data-ix="gender-switch">
                <style>
                  /* ---------- SWITCH ---------- */
                  .switch-kitten {
                    background: #eee;
                    border-radius: 32px;
                    display: block;
                    height: 32px;
                    position: relative;
                    width: 80px;
                  }
                  .switch-kitten input {
                    height: 32px;
                    left: 0;
                    opacity: 0;
                    position: absolute;
                    top: 0;
                    width: 80px;
                    z-index: 2;
                  }
                  .switch-kitten input:checked~.toggle {
                    left: 4px;
                  }
                  .switch-kitten input~:checked~.toggle {
                    left: 50px;
                  }
                  .switch-kitten input:checked {
                    z-index: 0;
                  }
                  .toggle {
                    background: #0172ff;
                    border-radius: 50%;
                    height: 28px;
                    left: 0;
                    position: absolute;
                    top: 2px;
                    -webkit-transition: left .2s ease;
                    -moz-transition: left .2s ease;
                    -ms-transition: left .2s ease;
                    -o-transition: left .2s ease;
                    transition: left .2s ease;
                    width: 28px;
                    z-index: 1;
                  }
                </style>
                <div class="switch white">
                  <input type="radio" name="switch-kitten" id="kitten">
                  <input type="radio" name="switch-kitten" id="adult">
                  <span class="toggle"></span>
                </div>
              </div>
              <div class="gender-female">adult</div>
              <div class="gender-male">kitten</div>
            </div>
           <!-- <label class="add-field-h2" for="First-Name">care Information</label>
            <div class="add-field-seperator"></div>
            <label class="add-field-h3" for="microchip-2">microchip #:</label>
            <input class="add-input w-input" data-name="microchip" id="microchip-2" maxlength="256" name="microchip" placeholder="A1B2C3D4E5" required="required" type="text">
            <label class="add-field-h3" for="adoption_fee">adoption fee:</label>
            <div class="w-clearfix">
              <input class="add-input currency w-input" data-name="adoption_fee" id="adoption_fee" maxlength="256" name="adoption_fee" placeholder="65" required="required" type="text">
              <div class="symbol-dollar">$</div>
            </div>
            <label class="add-field-h3" for="State">State:</label>
            <input class="add-input w-input" data-name="State" id="State" maxlength="256" name="State" placeholder="Alabama" required="required" type="text">
            <label class="add-field-h3" for="Phone">Phone:`</label>
            <input class="add-input w-input" data-name="Phone" id="Phone" maxlength="256" name="Phone" placeholder="(123) 456-7890" required="required" type="email">
            -->
            <div class="add-button-cont"><a class="add-cancel" href="cat-list.html">Cancel</a>
              <input class="add-submit w-button" data-wait="Please wait..." type="submit" value="Submit">
            </div>
            
          </form>
          <div class="w-form-done">
            <div>Thank you! Your submission has been received!</div>
          </div>
          <div class="w-form-fail">
            <div>Oops! Something went wrong while submitting the form</div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?= $this->Form->end() ?>