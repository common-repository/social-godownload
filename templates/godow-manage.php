<div class="wrap">
	<div id="icon-upload" class="icon32"><br /></div><h2><?php _e('Manage','godow') ?><a class="button add-new-h2" href="admin.php?page=social-godownloads-upload"><?php _e('Add New','godow'); ?></a></h2>

	<form method="get" action="#" id="posts-filter">
		<div class="tablenav">
			<div class="alignleft actions">
				<select class="select-action" name="task">
					<option selected="selected" value=""><?php _e('Bulk Actions','godow'); ?></option>
					<option value="delete-up"><?php _e('Delete Permanently','godow'); ?></option>
				</select>
				<input type="hidden" name="page" value="social-godownloads" />
				<input type="submit" class="button-secondary action" name="doaction" value="<?php _e('Apply','godow'); ?>">
			</div>
			<br class="clear" />
		</div>
		<div class="clear"></div>

		<table cellspacing="0" class="widefat fixed">
		<thead>
			<tr>
				<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th>
				<th style="" class="manage-column column-icon" id="icon" scope="col"><?php _e('Thumbnail','godow') ?></th>
				<th style="" class="manage-column column-media" id="media" scope="col"><?php _e('File','godow') ?></th>
				<th style="" class="manage-column column-parent" id="cat" scope="col"><?php _e('Category','godow') ?></th>
				<th style="" class="manage-column column-parent" id="hits" scope="col"><?php _e('Downloads','godow') ?></th>
				<th style="" class="manage-column column-parent" id="created" scope="col"><?php _e('Created','godow') ?></th>
			</tr>
		</thead>
		<tfoot>
		<tr>
			<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th>
				<th style="" class="manage-column column-icon" id="icon" scope="col"><?php _e('Thumbnail','godow') ?></th>
				<th style="" class="manage-column column-media" id="media" scope="col"><?php _e('File','godow') ?></th>
				<th style="" class="manage-column column-parent" id="cat" scope="col"><?php _e('Category','godow') ?></th>
				<th style="" class="manage-column column-parent" id="hits" scope="col"><?php _e('Hits','godow') ?></th>
				<th style="" class="manage-column column-parent" id="created" scope="col"><?php _e('Created','godow') ?></th>
			</tr>
		</tfoot>
		<tbody class="list:post" id="the-list">
		<?php
			if(count($list_uploads)>0) {
				foreach($list_uploads as $download) {
					echo '<tr valign="top" class="alternate author-self status-inherit" id="post-'.$download->id.'">';
					echo '<th class="check-column" scope="row"><input type="checkbox" value="'.$download->id.'" name="id[]" /></th>';
					echo '<td class="column-icon media-icon"><img title="'.$download->name_file.'" alt="'.$download->name_file.'" class="attachment-80x60" src="'.site_url().'/'.$this->plugin_dir.'timthumb.php?src='.site_url().'/'.$this->plugin_dir.'files/'.$download->image.'&h=50&w=50&zc=1" /></td>';
					echo '<td class="media column-media"><strong><a title="Edit" href="admin.php?page=social-godownloads-upload&amp;task=edit-up&amp;id='.$download->id.'">'.$download->name_file.'</a></strong><br />
<code>File: '.basename($download->url_file).'</code><br>
<div class="row-actions"><span class="edit"><a href="admin.php?page=social-godownloads-upload&amp;task=edit-up&amp;id='.$download->id.'">'.__('Edit','godow').'</a> | </span><span class="delete"><a href="admin.php?page=social-godownloads&amp;task=delete-up&amp;id='.$download->id.'" onclick="return showNotice.warn();" class="submitdelete">'.__('Delete Permanently','godow').'</a></span></div>
				</td>';
					echo '<td class="parent column-parent">'.$download->name_cat.'</td>';
					echo '<td class="parent column-parent">'.$download->hits.'</td>';
					echo '<td class="parent column-parent">'.$download->created.'</td>';
					echo '</tr>';
				}
			} else {
				echo '<tr><td colspan="6">'.__('Empty','godow').'</td></tr>';
			}
		?>
		</tbody>
		</table>

		<div id="ajax-response"></div>
		<div class="tablenav">
			<div class="alignleft actions">
				<select class="select-action" name="action2">
					<option selected="selected" value=""><?php _e('Bulk Actions','godow'); ?></option>
					<option value="delete-up"><?php _e('Delete Permanently','godow'); ?></option>
				</select>
				<input type="submit" class="button-secondary action" id="doaction2" name="doaction2" value="<?php _e('Apply','godow'); ?>">
			</div>
			<br class="clear" />
		</div>
	</form>
</div>