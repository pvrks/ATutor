<?php
/***********************************************************************/
/* ATutor															   */
/***********************************************************************/
/* Copyright (c) 2002-2009											   */
/* Adaptive Technology Resource Centre / Inclusive Design Institution  */
/* http://atutor.ca													   */
/*																	   */
/* This program is free software. You can redistribute it and/or	   */
/* modify it under the terms of the GNU General Public License		   */
/* as published by the Free Software Foundation.					   */
/***********************************************************************/
// $Id$
define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
include (AT_PA_INCLUDE.'classes/PhotoAlbum.class.php');
$_custom_css = $_base_path . AT_PA_BASENAME . 'module.css'; // use a custom stylesheet

//instantiate obj
$pa = new PhotoAlbum();

//handles submit
if(isset($_POST['submit'])){
	//TODO: Check if the user have permission to add a course album
	//		TA and Instructors can
	if (isset($_POST['album_type'])){
		$album_type	= (intval($_POST['album_type'])==AT_PA_TYPE_MY_ALBUM)?AT_PA_TYPE_MY_ALBUM:AT_PA_TYPE_COURSE_ALBUM;
	} else {
		//default is "my album" 'cause normally user can't create course album.
		$album_type	= AT_PA_TYPE_MY_ALBUM;
	}

	if (isset($_POST['album_name']) && $_POST['album_name']!=''){
		//TODO: photo_id = 0, should default to use the first one after multi-file uploader works
		$result = $pa->createAlbum($_POST['album_name'], $_POST['album_location'], $_POST['album_description'], $album_type, $_SESSION['member_id'], 0);

		if (!$result){
			//TODO: sql failure.
			$msg->addError('PA_CREATE_ALBUM_FAILED');
		}
	} else {
		//album name can't be empty
		//TODO: user input failure
		$msg->addError('PA_EMTPY_ALBUM_NAME');
	}
	$msg->addFeedback('ACTION_COMPLETED_SUCCESSFULLY');
	header('Location: index.php');
	exit;
} elseif (isset($_POST['cancel'])){
	$msg->addFeedback('CANCELLED');
	header('Location: '.AT_PA_BASE);
	exit;
}

include (AT_INCLUDE_PATH.'header.inc.php'); 
$savant->display('pa_create_album.tmpl.php');
include (AT_INCLUDE_PATH.'footer.inc.php'); 
?>
