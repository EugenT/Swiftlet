<div class="no-grid">
	<h1><?php echo $model->t($contr->pageTitle) ?></h1>

	<?php if ( !empty($view->error) ): ?>
	<p class="message error"><?php echo $view->error ?></p>
	<?php endif ?>

	<?php if ( !empty($view->notice) ): ?>
	<p class="message notice"><?php echo $view->notice ?></p>
	<?php endif ?>

	<?php if ( $view->action == 'edit' && $model->perm->check('admin page edit') ): ?>
	<h2><?php echo $model->t('Edit page') ?></h2>

	<p>
		<?php if ( $model->perm->check('admin page create') ): ?>
		<a class="button" href="./"><?php echo $model->t('Create a new page') ?></a>
		<?php endif ?>
		<a class="button" href="<?php echo $model->route($view->path) ?>"><?php echo $model->t('View this page') ?></a>
		<?php if ( $model->perm->check('admin page delete') ): ?>
		<a class="button" href="./?action=delete&id=<?php echo $view->id ?>"><?php echo $model->t('Delete this page') ?></a>
		<?php endif ?>
	</p>
	<?php elseif ( $model->perm->check('admin page create') ): ?>
	<h2><?php echo $model->t('New page') ?></h2>
	<?php endif ?>

	<?php if ( $model->perm->check('admin page create') || $view->action == 'edit' && $model->perm->check('admin page edit') ): ?>

	<form id="formPage" method="post" action="./<?php echo $view->id ? '?action=edit&id=' . $view->id : '' ?>">
		<?php foreach ( $view->languages as $i => $language ): ?>
		<fieldset>
			<dl>
				<strong><?php echo $model->h($model->t($language)) ?></strong>
			</dl>
			<dl>
				<dt><label for="title_<?php echo $i ?>"><?php echo $model->t('Title') ?></label></dt>
				<dd>
					<input type="text" name="title[<?php echo $model->h($language) ?>]" id="title_<?php echo $i ?>" value="<?php echo $model->POST_html_safe['title'][$language] ?>"/>
					
					<?php if ( isset($model->form->errors['title_' . $i]) ): ?>
					<span class="error"><?php echo $model->form->errors['title_' . $i] ?></span>
					<?php endif ?>
				</dd>
			</dl>
			<dl>
				<dt><label for="body<?php echo $i ?>"><?php echo $model->t('Body') ?></label></dt>
			</dl>
			<dl>
				<textarea class="large code ckeditor" name="body[<?php echo $model->h($language) ?>]" id="body_<?php echo $i ?>" cols="25" rows="5"><?php echo $model->POST_html_safe['body'][$language] ?></textarea>
			</dl>
		</fieldset>
		<?php endforeach ?>
		<fieldset>
			<dl>
				<dt><label for="published"><?php echo $model->t('Published') ?></label></dt>
				<dd>
					<input type="checkbox" name="published" id="published" value="1"<?php echo $model->POST_html_safe['published'] ? ' checked="checked"' : '' ?>/>
				</dd>
			</dl>
			<dl>
				<dt><label for="parent"><?php echo $model->t('Parent page') ?></label></dt>
				<dd>
					<select class="select" name="parent" id="parent">
						<option value="<?php echo node::rootId ?>"<?php echo $model->POST_html_safe['parent'] == node::rootId ? ' selected="selected"' : '' ?>><?php echo $model->t('None') ?></option>
						<?php foreach ( $view->nodesParents as $node ): ?>
						<option value="<?php echo $node['id'] ?>"<?php echo $model->POST_html_safe['parent'] == $node['id'] ? ' selected="selected"' : '' ?>><?php echo str_repeat('&nbsp;', $node['level'] * 3) . $node['title'] ?></option>
						<?php endforeach ?>
					</select>
				</dd>
			</dl>
		</fieldset>
		<fieldset>
			<dl>
				<dt><label for="home"><?php echo $model->t('Set as home page') ?></label></dt>
				<dd>
					<input type="checkbox" name="home" id="home" value="1"<?php echo $model->POST_html_safe['home'] ? ' checked="checked"' : '' ?>/>
				</dd>
			</dl>
			<dl>
				<dt>
					<label for="path"><?php echo $model->t('Custom path') ?></label>
					<em>E.g. "some/path"</em></dt>
				</dt>
				<dd>
					<input type="text" name="path" id="path" value="<?php echo $model->POST_html_safe['path'] ?>"/>
					
					<?php if ( isset($model->form->errors['path']) ): ?>
					<span class="error"><?php echo $model->form->errors['path'] ?></span>
					<?php endif ?>
				</dd>
			</dl>
		</fieldset>
		<fieldset>
			<dl>
				<dt><br/></dt>
				<dd>
					<input type="hidden" name="auth-token" value="<?php echo $model->authToken ?>"/>

					<input type="submit" name="form-submit" id="form-submit" value="<?php echo $model->t('Save page') ?>"/>
				</dd>
			</dl>
		</fieldset>
	</form>
	<?php endif ?>

	<a name="pages"></a>

	<h2><?php echo $model->t('All pages') ?></h2>

	<?php if ( $view->nodes ): ?>
	<p class="pagination">
		<?php echo $view->nodesPagination['html'] ?>
	</p>

	<table>
		<thead>
			<tr>
				<th><?php echo $model->t('Title') ?></th>
				<th><?php echo $model->t('Created on') ?></th>
				<th><?php echo $model->t('Action') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $view->nodes as $node ): ?>
			<tr>
				<td>
					<?php echo str_repeat('&nbsp;', $node['level'] * 4) ?>
					<a href="<?php echo $model->route($node['path'] ? $node['path'] : 'node/' . $node['id']) ?>">
						<?php echo $node['title'] ?>
					</a>
				</td>
				<td>
					<?php echo $model->format_date($node['date'], 'date') ?>
				</td>
				<td>
					<?php if ( $model->perm->check('admin page edit') ): ?>
					<a class="button" href="?id=<?php echo $node['id'] ?>&amp;action=edit"><?php echo $model->t('Edit') ?></a>
					<?php endif ?>
					<?php if ( $model->perm->check('admin page delete') ): ?>
					<a class="button" href="?id=<?php echo $node['id'] ?>&amp;action=delete"><?php echo $model->t('Delete') ?></a>
					<?php endif ?>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<p class="pagination">
		<?php echo $view->nodesPagination['html'] ?>
	</p>
	<?php else: ?>
	<p>
		<em>No pages</em>
	</p>
	<?php endif ?>

	<script type="text/javascript">
		<!-- /* <![CDATA[ */
		// Focus the title field
		$('#title').focus();
		/* ]]> */ -->
	</script>
</div>
