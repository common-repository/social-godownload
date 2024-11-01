<?php
class godownload {
	protected $name_table_download = 'socialgodownload';
	protected $name_table_category = 'socialgocategory';
	
	protected $plugin_dir = 'wp-content/plugins/social-godownload/';
	protected $upload_base = 'wp-content/uploads/';
	protected $upload_dir = 'wp-content/uploads/social-godownloads/';
	protected $image_dir = 'wp-content/plugins/social-godownload/files/';
	
	protected $thumb_width = 185;
	protected $thumb_height = 240;
	
	function __construct() {}
	
	/*****************************
		INI : FUNCTION ADMIN
	******************************/
	function active() {
		global $wpdb;
		$name_table_category = $wpdb->prefix.$this->name_table_category;
		$name_table_download = $wpdb->prefix.$this->name_table_download;
		
		$sql = "CREATE TABLE ".$name_table_category." (
			id INT(4) NOT NULL auto_increment,
			name VARCHAR(50) NOT NULL DEFAULT '',
			description TEXT NOT NULL DEFAULT '',
			image VARCHAR(250) NOT NULL DEFAULT '',
			created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
			modify DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY (id)
		) ;";
		$wpdb->query($sql);
		
		$sql = "CREATE TABLE ".$name_table_download." (
			id INT(4) NOT NULL auto_increment,
			category_id INT(4) NOT NULL DEFAULT 0,
			name VARCHAR(50) NOT NULL DEFAULT '',
			description TEXT NOT NULL DEFAULT '',
			url_file VARCHAR(250) NOT NULL DEFAULT '',
			image VARCHAR(250) NOT NULL DEFAULT '',
			hits INT(8) NOT NULL DEFAULT 0,
			created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
			modify DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY (id),
			FOREIGN KEY (category_id) REFERENCES ".$name_table_category."(id)
		) ;";
		$wpdb->query($sql);

		$cat_count = $wpdb->get_var( 'SELECT COUNT(*) FROM '.$name_table_category );
		
		if($cat_count == 0)
			$wpdb->query('INSERT INTO '.$name_table_category.' (name, created, modify) VALUES ("free download",NOW(),NOW());');
		
		$style = "
#godow_detail h2{
	margin-bottom: 20px;
}

.godownload_class_td a {
	border: 1px solid #AAA;
	display: block;
}

.godownload_class_td a img{
	margin: 8px;
	max-width: 185px;
}

.godownload_td a:hover {
	background-color: #EEE;
}

.godow_deimg img {
	width: 99%;
}

.godow_social_shared{
	position: relative;
	left: 25%;
	top: 15px;
}

#godow_shared {
	color: #FFFFFF;
	display: block;
	font-weight: bold;
	height: 110px;
	margin: 10px 0;
	text-align: center;
}

#godow_shared div {
	position: absolute;
	left: 0;
	margin: 5px auto;
	padding: 10px 0;
}

#godow_shared_block {
	background-color: #444;
	z-index: 100;
	width: 100%;
	height: 75px;
}

#godow_shared_link {
	background-color: #FFBB00;
	width: 100%;
	height: 75px;
}

#godow_shared_link:hover {
	background-color: #fdcf53;
}

#godow_shared_link a {
	position: absolute;
	top: 40%;
	left: 35%;
}

/* DONT MODIFY */
.fb-like span,.fb-like, iframe.fb_ltr {
	position: relative;
	float: left;
	min-width: 450px;
	min-height: 61px;
}
";
		
		add_option( 'godownload_userlevel', 'level_10' );
		add_option( 'godownload_twitter', '' );
		add_option( 'godownload_thumbw', $this->thumb_width );
		add_option( 'godownload_thumbh', $this->thumb_height );
		add_option( 'godownload_style',$style);

		if(!file_exists(ABSPATH.$this->upload_base))
			@mkdir(ABSPATH.$this->upload_base,0777);
		@chmod(ABSPATH.$this->upload_base,0777);
		
		if(!file_exists(ABSPATH.$this->upload_dir)) {
			@mkdir(ABSPATH.$this->upload_dir,0777);
			@chmod(ABSPATH.$this->upload_dir,0777);
		}
		
		@chmod(ABSPATH.$this->image_dir,0777);

		return true;
	}
	
	function add_menu() {
		add_menu_page('Social GoDownloads', 'GoDownloads','edit_pages', 'social-godownloads', array(&$this,'add_menu_manage'));
		add_submenu_page('social-godownloads', __('Manage'), __('Manage'), 'edit_pages', 'social-godownloads',array(&$this,'add_menu_manage'));
		add_submenu_page('social-godownloads', __('Upload File'), __('Upload File'), 'edit_pages', 'social-godownloads-upload',array(&$this,'add_menu_upload'));
		add_submenu_page('social-godownloads', __('Categories'), __('Categories'), 'edit_pages', 'social-godownloads-cat',array(&$this,'add_menu_categories'));
		
		if(is_admin())
			add_submenu_page('social-godownloads', 'social-godownloads', __('Settings'), 'edit_pages', 'social-godownloads-settings',array(&$this,'add_menu_settings'));
		
		return true;
	}
	
	function add_menu_manage() {
		global $wpdb;
		$name_table_category = $wpdb->prefix.$this->name_table_category;
		$name_table_download = $wpdb->prefix.$this->name_table_download;
		
		if(isset($_GET['task']) && $_GET['task']=='delete-up' && isset($_GET['id'])) {
			if(is_array($_GET['id']))
				$wpdb->query('DELETE FROM '.$name_table_download.' WHERE id in ('.implode(',',$_GET['id']).')');
			else
				$wpdb->query('DELETE FROM '.$name_table_download.' WHERE id="'.$_GET['id'].'"');
				
			echo '<div id="message" class="updated">'.__('File Deleted','godow').'</div>';
		}
		
		$query = 'SELECT
					d.id AS id,
					d.name AS name_file,
					d.image AS image,
					d.hits AS hits,
					d.url_file AS url_file,
					d.created AS created,
					c.name AS name_cat
				FROM
					'.$name_table_download.' d
				JOIN
					'.$name_table_category.' c
				ON c.id=d.category_id';
		
		$list_uploads= $wpdb->get_results($query);
		
		include_once WP_PLUGIN_DIR.'/social-godownload/templates/godow-manage.php';
	}
	
	function add_menu_upload() {
		global $wpdb;
		$name_table_category = $wpdb->prefix.$this->name_table_category;
		$name_table_download = $wpdb->prefix.$this->name_table_download;
		
		$list_categories = $wpdb->get_results('SELECT * FROM '.$name_table_category);
		$error=0;
		
		/*	Verify if the fields are empty	*/
		if(isset($_POST['submit'])) {
			if(!empty($_POST['up-cat']) && !empty($_POST['up-name']) && !empty($_POST['up-task'])) {

				$filter_file=''; $filter_image='';
				if(!empty($_FILES['file_upload']['tmp_name']) || $_POST['up-task']=='insert') {
					if(is_uploaded_file($_FILES['file_upload']['tmp_name'])){
						$info_file = pathinfo($_FILES['file_upload']['name']);
						$name_file = file_exists(ABSPATH.$this->upload_dir.$_FILES['file_upload']['name'])?str_replace('.'.$info_file['extension'],'_'.uniqid().'.'.$info_file['extension'],$info_file['basename']):$_FILES['file_upload']['name'];
						if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], ABSPATH.$this->upload_dir . $name_file))
							$error++;
						else
							$filter_file = ', url_file="'.$name_file.'"';
					} else
						$error++;
				}
				
				/*	IMAGE	*/
				if(!empty($_FILES['image_upload']['tmp_name']) || $_POST['up-task']=='insert') {
					if(is_uploaded_file($_FILES['image_upload']['tmp_name'])){
						$info_image = pathinfo($_FILES['image_upload']['name']);
						$name_image = file_exists(ABSPATH.$this->plugin_dir.'files/'.$_FILES['image_upload']['name'])?str_replace('.'.$info_image['extension'],'_'.uniqid().'.'.$info_image['extension'],$info_image['basename']):$_FILES['image_upload']['name'];
						if(!move_uploaded_file($_FILES['image_upload']['tmp_name'], ABSPATH.$this->plugin_dir . 'files/' . $name_image))
							$error++;
						else
							$filter_image = ', image="'.$name_image.'"';
					} else
						$error++;
				}

				switch($_POST['up-task']) {
					case 'insert' :
						if(isset($_FILES['file_upload']) && isset($_FILES['image_upload']) && $error==0)
							$wpdb->query('INSERT INTO '.$name_table_download.' (category_id, name, description, url_file, image, created, modify) VALUES('.$_POST['up-cat'].',"'.$_POST['up-name'].'","'.nl2br($_POST['up-description']).'","'.$name_file.'","'.$name_image.'",NOW(),NOW())');
						else
							$error++;
					break;
					case 'update':
						if($error==0 && isset($_POST['up-id']) && is_numeric($_POST['up-id']))
							$wpdb->query('UPDATE '.$name_table_download.' SET category_id="'.$_POST['up-cat'].'", name="'.$_POST['up-name'].'",  description="'.nl2br($_POST['up-description']).'" '.$filter_file.' '.$filter_image.', modify=NOW() WHERE id="'.$_POST['up-id'].'"');
						else
							$error++;
					break;
				}
			} else
				$error++;
		
			if($error==0)
				echo '<div id="message" class="updated">'.__('File Uploaded','godow').'</div>';
			else
				echo '<div id="message" class="error">'.__('Error in File or Empty Fields','godow').'</div>';
		}
		
		/*	If edit	*/
		if(isset($_GET['task']) && $_GET['task']=='edit-up' && isset($_GET['id']) && is_numeric($_GET['id'])) {
			$file = $wpdb->get_row('SELECT * FROM '.$name_table_download.' WHERE id="'.$_GET['id'].'"',ARRAY_A);
		}
		
		include_once WP_PLUGIN_DIR.'/social-godownload/templates/godow-upload.php';
	}
	
	function add_menu_categories() {
		global $wpdb;
		$name_table_category = $wpdb->prefix.$this->name_table_category;
		$value_submit = __('Create Category','godow');
		
		if(isset($_POST['submit'])) {
			switch($_POST['cat-task']) {
				case 'insert': $wpdb->query('INSERT INTO '.$name_table_category.' (name,description,created,modify) VALUES("'.$_POST['cat-name'].'","'.$_POST['cat-description'].'",NOW(),NOW())'); break;
				case 'update': $wpdb->query('UPDATE '.$name_table_category.' SET name="'.$_POST['cat-name'].'", description="'.$_POST['cat-description'].'", modify=NOW() WHERE id="'.$_POST['cat-id'].'"'); break;
			}
		}
		
		if(isset($_GET['task']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
			switch($_GET['task']) {
				case 'edit-cat':
					$array_cat = $wpdb->get_row('SELECT * FROM '.$name_table_category.' WHERE id="'.$_GET['id'].'"', OBJECT);
					$value_submit = __('Update Category','godow');
					break;
				case 'delete-cat': $wpdb->query('DELETE FROM '.$name_table_category.' WHERE id="'.$_GET['id'].'"'); break;
			}
		}
		
		$list_categories = $wpdb->get_results('SELECT * FROM '.$name_table_category);
		
		include_once WP_PLUGIN_DIR.'/social-godownload/templates/godow-category.php';
	}
	
	function add_menu_settings() {
		if (!current_user_can('manage_options')) 
			wp_die( __('You do not have sufficient permissions to access this page.','godow'));
			
		if(!file_exists(ABSPATH.$this->upload_dir)) {
			echo "<div id=\"warning\" class=\"error fade\"><p>Automatic dir creation failed! [ <a href='admin.php'>Try again to create dir automatically</a> ]<br><br>Please create dir <strong>" . $this->upload_dir . "</strong> manualy and set permision to <strong>777</strong><br><br>Otherwise you will not be able to upload files.</p></div>";        
		}

		if(isset($_POST['submit'])) {
			update_option('godownload_userlevel',$_POST['userlevel']);
			update_option('godownload_thumbw',$_POST['thumb_width']);
			update_option('godownload_thumbh',$_POST['thumb_height']);
			update_option('godownload_itwitter',$_POST['input_twitter']);
			update_option('godownload_style', $_POST['style']);
		}
		
		/*	Reset Settings	*/
		if(isset($_POST['breset']) && isset($_POST['checkreset']) && $_POST['checkreset']==1) {
			delete_option( 'godownload_userlevel' );
			delete_option( 'godownload_twitter' );
			delete_option( 'godownload_thumbw' );
			delete_option( 'godownload_thumbh' );
			delete_option( 'godownload_style' );
			delete_option('godownload_itwitter');
			
			$this->active();
		}

		$userlevel = get_option('godownload_userlevel');
		$thumb_width = get_option('godownload_thumbw');
		$thumb_height = get_option('godownload_thumbh');
		$input_twitter = get_option('godownload_itwitter');
		
		$style = get_option('godownload_style');
		 
		include_once WP_PLUGIN_DIR.'/social-godownload/templates/godow-settings.php';
	}
	
	/****************************************************
		GET INFO FILE
		This function get info from file, for example:
		url of file, name, description, etc
		@param $godow_id : it's the file's ID
	******************************************************/
	function get_info_by_id($godow_id) {
		$info_file = array();
		global $wpdb;
		$name_table_download = $wpdb->prefix.$this->name_table_download;
	
		if(is_numeric($godow_id))
			$info_file = $wpdb->get_row('SELECT id, name, description, url_file, image FROM '.$name_table_download.' WHERE id="'.$godow_id.'"');
		
		return $info_file;
	}
	
	/******************************************
		GET PATH
		Get the Path for download the file
	********************************************/
	function get_path() {
		return $this->upload_dir;
	}
	
	/*********************************
		DOWNLOAD FILE
	*********************************/
	function process() {
		if(!isset($_GET['goaction'])) return;
		if($_GET['goaction']=='process')
			include("godownload.php");
	}
	
	/*************************************
		FIN : FUNCTION ADMIN
	**************************************/
	
	/*************************************
		INI : FUNCTION FRONTEND
	**************************************/
	function show_godow($atts) {
		extract( shortcode_atts( array(
			'cat' => null
		), $atts ) );
		
		global $wpdb;
		$name_table_download = $wpdb->prefix.$this->name_table_download;
		$thumb_width = get_option('godownload_thumbw');
		$thumb_height = get_option('godownload_thumbh');

		if(isset($godow_cat) && is_numeric($godow_cat))
			$array_data = $wpdb->get_results('SELECT id, name, image FROM '.$name_table_download.' WHERE category_id="'.$cat.'"');
		else
			$array_data = $wpdb->get_results('SELECT id, name, image FROM '.$name_table_download);
		
		if(isset($_GET['godow_id']) && is_numeric($_GET['godow_id'])) {
			$check_twitter = get_option('godownload_twitter');
			$input_twitter = get_option('godownload_itwitter');
			
			$percent='50%';
		
			$array_detail =  $wpdb->get_row('SELECT id, name, description, url_file, image FROM '.$name_table_download.' WHERE id="'.$_GET['godow_id'].'"');
			require_once WP_PLUGIN_DIR.'/social-godownload/templates/godow-detail.php';
		}
		
		require_once WP_PLUGIN_DIR.'/social-godownload/templates/godow-view.php';
	}
	
	function add_header() {
		echo '<style>'.get_option('godownload_style').'</style>';
	}
	/*************************************
		FIN : FUNCTION FRONTEND
	**************************************/
}
?>