<div class="wrap metabox-holder has-right-sidebar">
	<div class="icon32" id="icon-add-new-file"><br></div>
	<?php
		if(isset($_GET['task']) && $_GET['task']=='edit-up')
			echo '<h2>'.__('Edit Download','godow').'</h2>';
		else
			echo '<h2>'.__('Add New Download','godow').'</h2>';
	?>
	
	<form action="" method="POST" enctype="multipart/form-data">
		<div  style="width: 75%;float:left;">
			<table cellpadding="5" cellspacing="5" width="100%">
			<tbody>
			<tr>
				<td><input style="font-size:16pt;width:100%;color:<?php echo isset($file['name'])?'#000':'#ccc'; ?>" onfocus="if(this.value=='<?php _e('Enter title here','godow'); ?>') {this.value=''; jQuery(this).css('color','#000'); }" onblur="if(this.value==''||this.value=='<?php _e('Enter title here','godow'); ?>') {this.value='<?php _e('Enter title here','godow'); ?>'; }" type="text" value="<?php echo isset($file['name'])?$file['name']:__('Enter title here','godow'); ?>" name="up-name" /></td>
			</tr>
			<tr>
				<td valign="top"> 
					<div id="poststuff" class="postarea">
						<?php //the_editor(stripslashes($file['description']),'up-description','up-description', false); ?>
						<?php wp_editor(isset($file['description'])?stripslashes($file['description']):'','up-description', array('media_buttons'=>false, 'textarea_name'=>'up-description')); ?>
						<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
						<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
					</div>
				</td>
			</tr>
			</tbody>
			</table>
		</div>
		<div style="float: right;width:23%">
			<div class="postbox " id="action">
				<div title="Click to toggle" class="handlediv"><br /></div><h3 class="hndle"><span><?php _e('Actions','godow'); ?></span></h3>
				<div class="inside">
				<?php
					if (isset($_GET['task']) && isset($_GET['id']) && $_GET['task']=='edit-up' && is_numeric($_GET['id'])) {
						echo '<input type="hidden" name="up-id" value="'.$_GET['id'].'" />';
						echo '<input type="hidden" name="up-task" value="update" />';
					} else
						echo '<input type="hidden" name="up-task" value="insert" />';
				?>
					<input  type="reset" value="<?php _e('Reset','godow'); ?>" tabindex="9" class="button-secondary" class="add:the-list:newmeta" name="addmeta" id="addmetasub" />
					<input type="submit" name="submit" value="<?php echo isset($_GET['task'])&&$_GET['task']=='edit-up'?__('Update','godow'):__('Upload','godow'); ?>" accesskey="p" tabindex="5" id="publish" class="button-primary" name="publish" />
				</div>
			</div>
			<div class="postbox " id="upload_meta_box">
				<div title="Click to toggle" class="handlediv"><br /></div>
				<h3 class="hndle"><span><?php _e('Upload file from PC','godow'); ?></span></h3>
				<div class="inside">
					<div id="currentfiles">
					<?php if(isset($file['url_file']) && $file['url_file']!=''){ ?>
						<div class="cfile"> 
							<b style="float: left"><?php echo isset($file['url_file'])?basename($file['url_file']):''; ?></b>
							<div style="clear: both;"></div>
						</div>
					<?php } ?> 
					</div>
					<input type="file" id="file_upload" name="file_upload" style="width: 230px;" />
					<div class="clear"></div>
				</div>
			</div>
			
			<div class="postbox " id="categories_meta_box">
				<div title="Click to toggle" class="handlediv"><br /></div><h3 class="hndle"><span><?php _e('Categories','godow'); ?></span></h3>
					<div class="inside">
					<ul>
					<?php
						$i=0;
						foreach($list_categories as $category) {
							$i++;
							$selected = isset($file['category_id'])&&$file['category_id']==$category->id?'CHECKED':'';
							echo '<li><label for="cat-'.$category->id.'"><input type="radio" name="up-cat" id="cat-'.$category->id.'" value="'.$category->id.'" '.$selected.' />'.$category->name.'</label></li>';
						}
					?>
					</ul> 
				</div>
			</div>
			
			<div class="postbox " id="thumb_meta_box">
				<div title="Click to toggle" class="handlediv"><br /></div>
				<h3 class="hndle"><span><?php _e('Set default image','godow'); ?></span></h3>
				<div class="inside">
					<?php if(isset($file['image']) && $file['image']!=''){ ?>
						<div class="cfile"> 
							<b style="float: left"><?php echo isset($file['image'])?basename($file['image']):''; ?></b>
							<div style="clear: both;"></div>
						</div>
					<?php } ?> 
					<input type="file" id="image_upload" name="image_upload" style="width: 230px;" />
				</div>
			</div>
			
			<div style="text-align:center;">
				<script type="text/javascript"><!--
					google_ad_client = "ca-pub-4622287947957408";
					/* Plugin GoDownload Upload */
					google_ad_slot = "5530542657";
					google_ad_width = 250;
					google_ad_height = 250;
					//-->
				</script>
				<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
			</div>
		</div>
	</form>
</div>