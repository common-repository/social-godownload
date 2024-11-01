<?php
	global $wpdb;
	
	/*	If PATH exist	*/
	if(!isset($_GET['godow_id']) || empty($_GET['godow_id']) || !is_numeric($_GET['godow_id']) || !isset($_COOKIE['godowid'])  || $_COOKIE['godowid']!=$_GET['godow_id']) {
		exit();
	}

	/******************************
		FILE DATA
	********************************/
	$info = $this->get_info_by_id($_GET['godow_id']);
	$path = ABSPATH.$this->get_path();
	
	/*	Position of Point	*/
	$pos_point = strrpos($info->url_file, '.');
	/*	Extension	*/
	$ext = strtolower(substr($info->url_file,++$pos_point));

	/*	Get the size in Bites		*/
	$size = filesize($path.$info->url_file);

	/*	Si no tiene extensión	*/
	if($ext===false)
		$ctype='application/force-download';
	else {
		switch($ext) {
			case 'ez': $ctype='application/andrew-inset'; break;
			case 'atom': $ctype='application/atom+xml'; break;
			case 'hqx': $ctype='application/mac-binhex40'; break;
			case 'cpt': $ctype='application/mac-compactpro'; break;
			case 'mathml': $ctype='application/mathml+xml'; break;
			case 'doc': $ctype='application/msword'; break;
			case 'bin':
			case 'class':
			case 'dll':
			case 'dmg':
			case 'dms':
			case 'exe':
			case 'lha':
			case 'lzh':
			case 'rar':
			case 'so': $ctype='application/octet-stream'; break;
			case 'oda': $ctype='application/oda'; break;
			case 'ogg': $ctype='application/ogg'; break;
			case 'pdf': $ctype='application/pdf'; break;
			//case 'pdf':$ctype='application/octet-stream'; break;
			case 'ai':
			case 'eps':
			case 'ps': $ctype='application/postscript'; break;
			case 'rdf': $ctype='application/rdf+xml'; break;
			case 'smi':
			case 'smil': $ctype='application/smil'; break;
			case 'grxml': $ctype='application/srgs+xml'; break;
			case 'gram': $ctype='application/srgs'; break;
			case 'mif': $ctype='application/vnd.mif'; break;
			case 'xul': $ctype='application/vnd.mozilla.xul+xml'; break;
			case 'xls': $ctype='application/vnd.ms-excel'; break;
			case 'ppt': $ctype='application/vnd.ms-powerpoint'; break;
			case 'rm': $ctype='application/vnd.rn-realmedia'; break;
			case 'wbxml': $ctype='application/vnd.wap.wbxml'; break;
			case 'wmlc': $ctype='application/vnd.wap.wmlc'; break;
			case 'wmlsc': $ctype='application/vnd.wap.wmlscriptc'; break;
			case 'vxml': $ctype='application/voicexml+xml'; break;
			case 'bcpio': $ctype='application/x-bcpio'; break;
			case 'vcd': $ctype='application/x-cdlink'; break;
			case 'pgn': $ctype='application/x-chess-pgn'; break;
			case 'cpio': $ctype='application/x-cpio'; break;
			case 'csh': $ctype='application/x-csh'; break;
			case 'dcr':
			case 'dir':
			case 'dxr': $ctype='application/x-director'; break;
			case 'dvi': $ctype='application/x-dvi'; break;
			case 'spl': $ctype='application/x-futuresplash'; break;
			case 'gtar': $ctype='application/x-gtar'; break;
			case 'hdf': $ctype='application/x-hdf'; break;
			case 'phps': $ctype='application/x-httpd-php-source'; break;
			case 'php':
			case 'php3':
			case 'php4':
			case 'phtml': $ctype='application/x-httpd-php'; break;
			case 'js': $ctype='application/x-javascript'; break;
			case 'skd':
			case 'skm':
			case 'skp':
			case 'skt': $ctype='application/x-koan'; break;
			case 'latex': $ctype='application/x-latex'; break;
			case 'cdf':
			case 'nc': $ctype='application/x-netcdf'; break;
			case 'crl': $ctype='application/x-pkcs7-crl'; break;
			case 'shar': $ctype='application/x-shar'; break;
			case 'swf': $ctype='application/x-shockwave-flash'; break;
			case 'sh': $ctype='application/x-sh'; break;
			case 'sit': $ctype='application/x-stuffit'; break;
			case 'sv4cpio': $ctype='application/x-sv4cpio'; break;
			case 'sv4crc': $ctype='application/x-sv4crc'; break;
			case 'tar':
			case 'tgz': $ctype='application/x-tar'; break;
			case 'tcl': $ctype='application/x-tcl'; break;
			case 'texi':
			case 'texinfo': $ctype='application/x-texinfo'; break;
			case 'tex': $ctype='application/x-tex'; break;
			case 'man': $ctype='application/x-troff-man'; break;
			case 'me': $ctype='application/x-troff-me'; break;
			case 'ms': $ctype='application/x-troff-ms'; break;
			case 'roff':
			case 't':
			case 'tr': $ctype='application/x-troff'; break;
			case 'ustar': $ctype='application/x-ustar'; break;
			case 'src': $ctype='application/x-wais-source'; break;
			case 'crt': $ctype='application/x-x509-ca-cert'; break;
			case 'xht':
			case 'xhtml': $ctype='application/xhtml+xml'; break;
			case 'dtd': $ctype='application/xml-dtd'; break;
			case 'xml':
			case 'xsl': $ctype='application/xml'; break;
			case 'xslt': $ctype='application/xslt+xml'; break;
			case 'zip': $ctype='application/zip'; break;
			case 'au':
			case 'snd': $ctype='audio/basic'; break;
			case 'kar':
			case 'mid':
			case 'midi': $ctype='audio/midi'; break;
			case 'mp2':
			case 'mp3':
			case 'mpga': $ctype='audio/mpeg'; break;
			case 'aif':
			case 'aifc':
			case 'aiff': $ctype='audio/x-aiff'; break;
			case 'm3u': $ctype='audio/x-mpegurl'; break;
			case 'ra':
			case 'ram': $ctype='audio/x-pn-realaudio'; break;
			case 'wav': $ctype='audio/x-wav'; break;
			case 'pdb': $ctype='chemical/x-pdb'; break;
			case 'xyz': $ctype='chemical/x-xyz'; break;
			case 'bmp': $ctype='image/bmp'; break;
			case 'cgm': $ctype='image/cgm'; break;
			case 'gif': $ctype='image/gif'; break;
			case 'ief': $ctype='image/ief'; break;
			case 'jpe':
			case 'jpeg':
			case 'jpg': $ctype='image/jpeg'; break;
			case 'png': $ctype='image/png'; break;
			case 'svg': $ctype='image/svg+xml'; break;
			case 'tif':
			case 'tiff': $ctype='image/tiff'; break;
			case 'djv':
			case 'djvu': $ctype='image/vnd.djvu'; break;
			case 'wbmp': $ctype='image/vnd.wap.wbmp'; break;
			case 'ras': $ctype='image/x-cmu-raster'; break;
			case 'ico': $ctype='image/x-icon'; break;
			case 'pnm': $ctype='image/x-portable-anymap'; break;
			case 'pbm': $ctype='image/x-portable-bitmap'; break;
			case 'pgm': $ctype='image/x-portable-graymap'; break;
			case 'ppm': $ctype='image/x-portable-pixmap'; break;
			case 'rgb': $ctype='image/x-rgb'; break;
			case 'xbm': $ctype='image/x-xbitmap'; break;
			case 'xpm': $ctype='image/x-xpixmap'; break;
			case 'xwd': $ctype='image/x-xwindowdump'; break;
			case 'iges':
			case 'igs': $ctype='model/iges'; break;
			case 'mesh':
			case 'msh':
			case 'silo': $ctype='model/mesh'; break;
			case 'vrml':
			case 'wrl': $ctype='model/vrml'; break;
			case 'ics':
			case 'ifb': $ctype='text/calendar'; break;
			case 'css': $ctype='text/css'; break;
			case 'htm':
			case 'html':
			case 'shtml': $ctype='text/html'; break;
			case 'asc':
			case 'log':
			case 'txt': $ctype='text/plain'; break;
			case 'rtx': $ctype='text/richtext'; break;
			case 'rtf': $ctype='text/rtf'; break;
			case 'sgm':
			case 'sgml': $ctype='text/sgml'; break;
			case 'tsv': $ctype='text/tab-separated-values'; break;
			case 'wmls': $ctype='text/vnd.wap.wmlscript'; break;
			case 'wml': $ctype='text/vnd.wap.wml'; break;
			case 'etx': $ctype='text/x-setext'; break;
			case 'mpe':
			case 'mpeg':
			case 'mpg': $ctype='video/mpeg'; break;
			case 'mov':
			case 'qt': $ctype='video/quicktime'; break;
			case 'm4u':
			case 'mxu': $ctype='video/vnd.mpegurl'; break;
			case 'avi': $ctype='video/x-msvideo'; break;
			case 'movie': $ctype='video/x-sgi-movie'; break;
			case 'ice': $ctype='x-conference/x-cooltalk'; break;
			default: $ctype='application/force-download'; break;
		}
	}

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: ".$ctype);
	header("Content-Length: ".$size);
	header("Content-Disposition: attachment; filename=".$info->url_file);
	header("Content-Transfer-Encoding: binary");
  
	//header("Content-Description: File Transfer"); 
	//header("Content-type: application/force-download"); 
	readfile($path.$info->url_file);
?>