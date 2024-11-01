<div class="godownload_class_wrap">
<?php
	/*echo '$_SERVER[\'REQUEST_URI\'] = '.$_SERVER['REQUEST_URI'].'<br />';
	echo '$_SERVER[\'PHP_SELF\'] = '.$_SERVER['PHP_SELF'].'<br />';
	echo '$_SERVER[\'HTTP_HOST\'] = '.$_SERVER['HTTP_HOST'].'<br />';
	echo '$_SERVER["QUERY_STRING"] = '.$_SERVER["QUERY_STRING"].'<br />';
	echo '$_SERVER["REDIRECT_URL"] = '.$_SERVER["REDIRECT_URL"].'<br />';
	echo '$_SERVER["SCRIPT_URI"] = '.$_SERVER["SCRIPT_URI"].'<br />';
	echo 'dirname(_SERVER["SCRIPT_FILENAME"]) = '.dirname($_SERVER["SCRIPT_FILENAME"]).'<br />';
	echo 'home_url() = '.home_url().'<br />';*/
?>
	<table class="godownload_class_table">
	<?php
		global $wp_query;
		$i=0; $open=0;
		foreach($array_data as $download) {
			if($i%3==0) {
				$open=1;
				echo '<tr class="godownload_class_tr">';
			}
			
			if(isset($_GET['godow_id']) && is_numeric($_GET['godow_id']))
				$param = str_replace('godow_id='.$_GET['godow_id'],'godow_id='.$download->id,$_SERVER["QUERY_STRING"]);
			elseif(empty($_SERVER["QUERY_STRING"]))
				$param = 'godow_id='.$download->id;
			else
				$param = $_SERVER["QUERY_STRING"].'&godow_id='.$download->id;
			
			echo '<td class="godownload_class_td"><a href="'.$_SERVER['SCRIPT_URI'].'?'.$param.'" title="'.$download->name.'">
			<img src="'.site_url().'/'.$this->plugin_dir.'timthumb.php?src='.site_url().'/'.$this->plugin_dir.'files/'.$download->image.'&h='.$thumb_height.'&w='.$thumb_width.'&zc=1" alt="'.$download->name.'" /></a></td>';
			$i++;
			
			if($i%3==0) {
				$open=0;
				echo '</tr>';
			}
		}
		
		if($open==1)
			echo '</tr>';
	?>
	</table>
</div>