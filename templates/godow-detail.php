<?php $url = $_SERVER["SCRIPT_URI"].'?'.$_SERVER["QUERY_STRING"]; ?>
<div id="godow_detail">
	<div style="float: left; width: 49%;">
		<div id="godow_deimg"><img src="<?php echo site_url().'/'.$this->plugin_dir.'files/'.$array_detail->image; ?>" alt="<?php echo $array_detail->name; ?>" rel="image_src" /></div>
		
		<div id="godow_shared" style="width:99%; position:relative;">
			
			<div id="godow_shared_block" style="<?php echo (isset($_COOKIE['godowid'])&&$_COOKIE['godowid']==$array_detail->id?'display:none;':''); ?>">
				<?php _e('To unlock the download, You have to share it at least in one social network','godow'); ?>
			</div>
			
			<div id="godow_shared_link">
				<?php $param = str_replace('godow_id','goaction=process&godow_id',$_SERVER["QUERY_STRING"]); ?>
				<a href="<?php echo home_url().'/?'.$param; ?>"><?php _e('Download File','godow'); ?></a>
			</div>
		</div>
		
		<div id="godow_social">
				<div id="godow_wrap_twitter" style="position:relative; float:left; background-color: #3BD; height: 90px; width: <?php echo $percent; ?>">
					<div class="godow_social_shared">
						<a href="https://twitter.com/share" class="twitter-share-button"  data-dnt="true" data-via="<?php echo $input_twitter; ?>" data-lang="en" data-count="vertical"  data-text="<?php echo $array_detail->name; ?>" data-url="<?php echo $url ?>" data-counturl="<?php echo $url ?>" data-related="<?php echo $input_twitter; ?>:Follow Me">Tweet</a>
						<script>
							window.twttr = (function (d,s,id) {
								var t, js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
								js.src="//platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
								return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
							}(document, "script", "twitter-wjs"));
							
							twttr.ready(function (twttr) {
								twttr.events.bind("tweet", display_download );
								/*twttr.events.bind("retweet", display_download );
								twttr.events.bind("click", display_download );*/
								
								function display_download() {
									var date = new Date();

  									date.setTime(date.getTime() + (1*60*60*1000)); //1 hour
									document.cookie = 'godowid=<?php echo $array_detail->id; ?>; expires='+date.toGMTString()+'; PATH=/';

									var idshare = document.getElementById('godow_shared_block');
									idshare.style.display = 'none';
								}
							});
						</script>
					</div>
				</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div style="float: right; width: 49%;">
		<h2><?php echo $array_detail->name; ?></h2>
		<div><?php echo $array_detail->description; ?></div>
	</div>
	<div style="clear:both;"></div>
</div>