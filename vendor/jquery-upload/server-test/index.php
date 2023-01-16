<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

$upload_handler = new UploadHandler(array(
    'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
	'upload_dir' => '/home/admin/domains/57hit.com/public_html/uploads/files/',
	'upload_url' => 'http://57hit.com/uploads/files/',
	'max_width' => null,
	'max_height' => null,
	'min_width' => 400,
	'min_height' => 400,	
	'image_versions' => array(
		'thumbnail' => array(
			'upload_dir' => '/home/admin/domains/57hit.com/public_html/uploads/thumb/',
			'upload_url' => 'http://57hit.com/uploads/thumb/',
			'crop' => true,
			'max_width' => 100,
			'max_height' => 100
		)
	)		
));
