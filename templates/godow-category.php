<div class="wrap">
	<div class="icon32" id="icon-categories"><br /></div>
	<h2>Categories</h2>
	<div style="margin-left:10px;float: left;width:47%">
		<table cellspacing="0" class="widefat fixed">
		<thead>
			<tr>
				<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th>
				<th style="" class="manage-column column-cb" id="media" scope="col"><?php _e('ID','godow'); ?></th>
				<th style="" class="manage-column column-media" id="media" scope="col"><?php _e('Category','godow'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox" /></th>
				<th style="" class="manage-column column-cb" id="media" scope="col"><?php _e('ID','godow'); ?></th>
				<th style="" class="manage-column column-media" id="media" scope="col"><?php _e('Category','godow'); ?></th>
			</tr>
		</tfoot>
		<tbody class="list:post" id="the-list">
		<?php
			foreach($list_categories as $category) {
				echo '<tr valign="top" class="alternate author-self status-inherit" id="post-'.$category->id.'">';
				echo '<th class="check-column" scope="row"><input type="checkbox" value="8" name="id[]"></th>';
				echo '<td>'.$category->id.'</td>';
				echo '<td class="column-icon media-icon" style="text-align: left;"><a href=""><b>'.$category->name.'</b></a>';
				echo '<div class="row-actions">
				<span class="edit"><a href="admin.php?page=social-godownloads-cat&amp;task=edit-cat&amp;id='.$category->id.'">'.__('Edit','godow').'</a> | </span>
				<span class="delete"><a href="admin.php?page=social-godownloads-cat&amp;task=delete-cat&amp;id='.$category->id.'" onclick="return showNotice.warn();" class="submitdelete">'.__('Delete Permanently','godow').'</a> | <input type="text" title="'.__('copy the code and place it anywhere inside your post or page','godow').'" value="[godow cat='.$category->id.']" readonly="readonly" onclick="this.select()" style="width:180px;font-size: 10px;"></span>
				</div>';
				echo '</td></tr>';
			}
		?>
		</tbody>
		</table>
	</div>

	<div style="margin-left:10px;float: right;width:45%;margin-top:-50px">
		<form action="" method="POST">
		<table cellspacing="0">
		<thead>
			<tr>
				<th style="padding-bottom: 10px" class="manage-column column-author" id="author" scope="col" align="left">
					<h2><?php _e('Add Category','godow'); ?></h2>
				</th>
			</tr>
		</thead>
		<tbody class="list:post" id="the-list">
			<tr valign="top" class="alternate author-self status-inherit" id="post-8">
				<td class="author column-author">
					<?php if(isset($array_cat)) { ?>
						<input type="hidden" name="cat-id" value="<?php echo $array_cat->id; ?>" />
						<input type="hidden" name="cat-task" value="update" />
					<?php } else { ?>
						<input type="hidden" name="cat-task" value="insert" />
					<?php } ?>
					
					<?php _e('Title','godow'); ?>:<br />
					<input type="text" style="width: 99%;font-size: 14pt" name="cat-name" value="<?php echo isset($array_cat->name)?$array_cat->name:''; ?>">
					<?php _e('Description','godow'); ?>:
					<textarea spellcheck="false" style="width: 99%;height:150px" name="cat-description"><?php echo isset($array_cat->description)?$array_cat->description:''; ?></textarea>
					<br />
					<input type="submit" name="submit" value="<?php echo $value_submit; ?>" class="button-primary" />
				</td>
			</tr>
		</tbody>
		</table>
		</form>
	</div>
</div>