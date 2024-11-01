<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div><h2><?php _e('Settings','godow') ?></h2>
	<form method="POST" action="">
		<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="userlevel"><?php _e('Minimum User Access Level for settings','godow'); ?>:</label></th>
				<td>
					<select name="userlevel">
						<option value="level_10" <?php echo ($userlevel=='level_10'?'SELECTED':''); ?>><?php _e('Administrator','godow'); ?></option>
						<option value="level_5" <?php echo ($userlevel=='level_5'?'SELECTED':''); ?>><?php _e('Editor','godow'); ?></option>
						<option value="level_2" <?php echo ($userlevel=='level_2'?'SELECTED':''); ?>><?php _e('Author','godow'); ?></option>
					</select>
				</td>
				<td rowspan="4">
					<script type="text/javascript"><!--
						google_ad_client = "ca-pub-4622287947957408";
						/* Plugin GoDownload Settings */
						google_ad_slot = "2481174653";
						google_ad_width = 160;
						google_ad_height = 600;
						//-->
					</script>
					<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="thumbnail"><?php _e('Thumbnails','godow'); ?></label></th>
				<td>
					<input name="thumb_width" type="text" id="thumb_width" value="<?php echo $thumb_width; ?>" class="small-text" /> x 
					<input name="thumb_height" type="text" id="thumb_height" value="<?php echo $thumb_height; ?>" class="small-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="social"><?php _e('Social','godow'); ?></label></th>
				<td>
					<label for="facebook"><input type="checkbox" id="facebook" value="1" DISABLED /><span><?php _e('Facebook','godow'); ?></span></label><br />
					<label for="google"><input type="checkbox" id="google" value="1" DISABLED /><span><?php _e('Google','godow'); ?></span></label><br />
					<div><a class="button-secondary" href="http://www.gopymes.pe/shopping/wp-plugin-social-godownload/?utm_campaign=godownload&utm_medium=link&utm_source=plugin_free&utm_content=descarga" target="_blank"><?php _e('For Facebook and Twitter, go to the Premiun Version','godow'); ?></a></div><br />
					<label for="twitter"><input type="checkbox" id="twitter" value="1" CHECKED DISABLED /><span><?php _e('Twitter','godow'); ?></span></label>
					<label for="input_twitter">@<input type="text" name="input_twitter" id="input_twitter" value="<?php echo $input_twitter; ?>" /></label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="style"><?php _e('Style','godow'); ?></label></th>
				<td><textarea name="style" cols="50" rows="30"><?php echo $style; ?></textarea>
			</tr>
		</tbody>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes','godow'); ?>"></p>
	</form>
	<form method="POST" action="">
		<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="checkreset"><?php _e('Reset Settings','godow'); ?></label></th>
				<td>
					<input type="checkbox" name="checkreset" id="checkreset" value="1" />
					<input type="submit" name="breset" class="button-secondary" value="<?php _e('Reset Settings','godow'); ?>" />
				</td>
			</tr>
		</tbody>
		</table>
	</form>
</div>