<?php defined('KOOWA') or die('Restricted access'); ?>

<?php $page = @service('repos:pages.page')->getEntity()->reset() ?>

<form class="composer-form" action="<?= @route() ?>" method="post">
	<fieldset>
		<legend><?= @text('COM-PAGES-PAGE-ADD') ?></legend>
	
		<div class="control-group">
			<label class="control-label" for="page-title"><?= @text('COM-PAGES-PAGE-TITLE') ?></label>
			<div class="controls">
				<input id="page-title" class="input-block-level" name="title" value="" maxlength="255" type="text" required>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="page-description"><?= @text('COM-PAGES-PAGE-DESCRIPTION') ?></label>
			<div class="controls">
			    <textarea id="page-description" class="input-block-level" name="body" cols="10" rows="5" maxlength="5000" required></textarea>				
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="page-excerpt"><?= @text('COM-PAGES-PAGE-EXCERPT') ?></label>
			<div class="controls">
				<input id="page-excerpt" class="input-block-level" name="excerpt" maxlength="250" type="text" required>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" id="privacy" ><?= @text('LIB-AN-PRIVACY-FORM-LABEL') ?></label>
			<div class="controls">
				<?= @helper('ui.privacy',array('entity'=>$page, 'auto_submit'=>false, 'options'=>$actor)) ?>
			</div>
		</div>
		
		<div class="form-actions">			 
			<button type="submit" class="btn btn-primary">
			    <?= @text('LIB-AN-ACTION-PUBLISH') ?>
			</button>
		</div>
		
	</fieldset>
</form>