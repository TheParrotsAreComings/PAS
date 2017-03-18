<?= $this->Html->script('cats.js'); ?>
<div class="body">
    <div class="column profile scroll1">
      <div class="profile-cont" data-ix="page-load-fade-in">
        <div class="button profile-header">
            <a href = "<?= $this->Url->build(['controller' => 'litters', 'action' => 'index']) ?>" class="profile-back w-inline-block">
            <div>&lt; Back</div>
            </a>
            <div class="profile-id-cont">
                <div class="id-text">#</div>
                <div class="id-text"><?= h($litter->id) ?></div>
            </div>
        </div>
        <div class="profile-header"><img class="cat-profile-pic" src="http://uploads.webflow.com/img/image-placeholder.svg">
          <div>
            <div class="cat-profile-name"><?= h($litter->litter_name) ?></div>
            <div>
              <div class="profile-header-text"><?= h($litter->the_cat_count) ?> cat(s)</div>
              <div class="profile-header-text"><?= h($litter->kitten_count) ?> kitten(s)</div>
            </div>
            <div>
              <div class="profile-header-text">Date of Birth</div>
              <div class="profile-header-text"><?= h($litter->dob) ?></div>
            </div>
            <div>
              <div class="profile-header-text">Breed:</div>
              <div class="profile-header-text"><?= h($litter->breed) ?></div>
            </div>
            <div>
              <div class="profile-header-text">Estimated Arrival:</div>
              <div class="profile-header-text"><?= h($litter->est_arrival) ?></div>
            </div>
          </div>
          
        </div>
        <div class="profile-tabs-cont w-tabs">
          <div class="cat-profile-tabs-menu w-tab-menu">
            <a class="cat-profile-tabs-menu-cont tab-leftmost w--current w-inline-block w-tab-link" data-ix="overview-notification" data-w-tab="Tab 1"><img class="cat-profile-tabs-icon" src="/img/cat-01.png">
            </a>
            <!--<a class="cat-profile-tabs-menu-cont w-inline-block w-tab-link" data-ix="medical-notification" data-w-tab="Tab 2"><img class="cat-profile-tabs-icon" src="/img/medical-01.png">
            </a>
            <a class="cat-profile-tabs-menu-cont w-inline-block w-tab-link" data-ix="foster-notification" data-w-tab="Tab 3"><img id="fosterTab" class="cat-profile-tabs-icon" src="/img/cat-profile-foster-01.png">
            </a>
            <a class="cat-profile-tabs-menu-cont w-inline-block w-tab-link" data-ix="adopter-notification" data-w-tab="Tab 4"><img id="adopterTab" class="cat-profile-tabs-icon" src="/img/cat-profile-adopter-01.png">
            </a>-->
            <a class="cat-profile-tabs-menu-cont w-inline-block w-tab-link" data-ix="attachment-notification" data-w-tab="Tab 5"><img id="fileTab" class="cat-profile-tabs-icon" src="/img/attachments-01.png">
            </a>
            <a class="cat-profile-tabs-menu-cont tabs-rightmost w-inline-block w-tab-link" data-ix="more-notification" data-w-tab="Tab 6"><img id="moreTab" class="cat-profile-tabs-icon" src="/img/more-01.png">
            </a>
          </div>
          <div class="profile-tab-wrap scroll1 w-tab-content">
            <div class="profile-tab-cont w--tab-active w-clearfix w-tab-pane" data-w-tab="Tab 1">
              <div class="profile-content-cont">
                <div class="profile-text-header">Litter Information</div>
                <div class="profile-field-cont">
                  <div class="profile-field-name">Foster Notes</div>
                  <div class="block profile-field-text"><?= h($litter->foster_notes) ?></div>
                </div>  
                <div class="profile-field-cont">
                  <div class="profile-field-name">Notes</div>
                  <div class="block profile-field-text"><?= h($litter->notes) ?></div>
                </div>
              </div>
              <div class="profile-content-cont">
                <?php if(!empty($litter->cats)): ?>
                <div class="profile-text-header">Cats/Kittens in Litter</div>
                  <?php foreach($litter->cats as $cat): ?>
                    <div class="card-cont card-wrapper w-dyn-item">
                      <?php $cat_id = $cat->id ?>
                      <a class="card w-clearfix w-inline-block" href="<?= $this->Url->build(['controller'=>'cats', 'action'=>'view', $cat_id], ['escape'=>false]); ?>">
                      <img class="card-pic" src="<?= $this->Url->image('cat-01.png');?>">
                      <div class="card-h1"><?= h($cat->cat_name) ?></div>
                      <div class="card-field-wrap">
                        <div class="card-field-cont">
                          <div class="card-h2"><?= ($cat->is_kitten) ? "Kitten" : "Cat" ?></div> 
                          <div class="card-field-text"></div>
                        </div>
                        <div class="card-field-wrap">
                          <div class="card-field-cont">
                            <div class="card-field-cont">
                              <div class="card-h3">DOB:</div> 
                              <div class="card-field-text cat-dob"><?= $cat->dob ?></div>
                            </div>
                            <div class="card-field-cont">
                              <div class="card-h3">Age:</div> 
                              <div class="card-field-text cat-age"></div>
                            </div>
                          </div>
                          <div class="card-field-cont"> 
                            <div class="card-field-cont">
                              <div class="card-h3">Breed:</div> 
                              <div class="card-field-text"><?= $cat->breed ?></div>
                            </div>
                         </div> 
                        </div>
                        <div class="list-id-cont">
                          <div class="id-text">#</div>
                          <div class="id-text"><?= $cat->id ?></div>
                        </div>
                      </div>
                      </a>
                    </div>
                  <?php endforeach; ?>
                  <a class="card w-clearfix w-inline-block">
                    <a class="cat-add w-button attach-cat" data-ix="add-cat-click-desktop" href="javascript:void(0);">+ Add Cat</a>
                  </a>
                <?php else: ?>
                  <div class="card-h1">This litter currently has no cat(s) or kitten(s).</div>
                <?php endif; ?>
              </div>
            </div>
            <!--<div class="w-tab-pane" data-w-tab="Tab 2"></div>-->
            <!--<div class="w-tab-pane" data-w-tab="Tab 3" ></div>-->
            <!--<div class="w-tab-pane" data-w-tab="Tab 4"></div>-->
            <div class="w-tab-pane" data-w-tab="Tab 5"></div>
            <div class="w-tab-pane" data-w-tab="Tab 6"></div>
          </div>
        </div>
        <div class="profile-action-cont w-hidden-medium w-hidden-small w-hidden-tiny">
          <a class="profile-action-button-cont w-inline-block" href="<?= $this->Url->build(['controller'=>'litters', 'action'=>'edit', $litter->id]) ?> ">
            <div class="profile-action-button sofware">-</div>
            <div>edit</div>
          </a>
          <a class="profile-action-button-cont w-inline-block" href="#">
            <div class="extend profile-action-button">w</div>
            <div>upload</div>
          </a>
          <a class="profile-action-button-cont w-inline-block" href="#">
            <div class="basic profile-action-button"></div>
            <div>export</div>
          </a>
          <a class="profile-action-button-cont w-inline-block" data-ix="delete-click-desktop" href="#">
            <div class="basic profile-action-button"></div>
            <div>delete</div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="notify-cont w-hidden-main">
    <div class="notify-overview">Overview</div>
    <!--<div class="notify-medical">Medical Information</div>-->
    <div class="notify-foster">Foster Home</div>
    <div class="notify-adopter">Adopter</div>
    <div class="notify-attachments">Attachments</div>
    <div class="notify-more">More...</div>
  </div>
  <div class="floating-overlay">
    <div class="confirm-cont">
      <div class="confirm-text">Are you sure you want to delete this litter?</div>
      <div class="confirm-button-wrap w-form">
        <form class="confirm-button-cont" data-name="Email Form 2" id="email-form-2" name="email-form-2">
            <a class="cancel confirm-button w-button" data-ix="confirm-cancel" href="#">Cancel</a>
            <?= $this->Html->link('Delete', ['controller'=>'litters', 'action'=>'delete', $litter->id], ['class'=>'confirm-button delete w-button']); ?>
        </form>
      </div>
    </div>
  </div> 
  <div class="button-cont w-hidden-main">
    <a class="button-01 w-inline-block" href="<?= $this->Url->build(['controller'=>'litters', 'action'=>'edit', $litter->id]) ?> ">
      <div class="button-icon-text">Edit</div><img data-ix="add-click" src="/img/edit-01.png" width="55">
    </a>
    <div class="button-02">
      <div class="button-icon-text">Upload Attachments</div><img data-ix="add-click" src="/img/upload-01.png" width="55">
    </div>
    <div class="button-03" data-ix="add-click">
      <div class="button-icon-text">Export</div><img data-ix="add-click" src="/img/export-01.png" width="55">
    </div>
    <div class="button-04" data-ix="delete-click">
      <div class="button-icon-text">Delete</div><img data-ix="add-click" src="/img/delete-01.png" width="55">
    </div>
  </div><img class="button-paw" data-ix="paw-click" src="/img/add-paw.png" width="60">
<script>
  calculateAndPopulateAgeFields();
</script>