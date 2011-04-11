<?php

/**
*	Obsedb CMS
*	Copyright 2004-2005 Josh Kimbrel
**/

error_reporting(E_ALL ^ E_NOTICE);
if ($_REQUEST['do'] == 'View Matrix')
{
	$refresh = "rcm_matrix.php?do=viewmatrix&type=previews&id=$_REQUEST[id]";
}

require_once( 'global.php' );
require_once( '../sources/userReviewsClass.php' );

$cp->header();

$links = "<a href=reviews.php?do=add_section>Add Section</a> | "
		."<a href=reviews.php?do=manage_sections>Manage Sections</a> | "
		."<a href=reviews.php?do=add_review>Add Review</a> | "
		."<a href=reviews.php>Manage Reviews</a>";

do_module_header('Review Manager',$links);

$module = new Module;

switch($_REQUEST['do'])
{
	case 'add_news':
		$module->addReview();
		break;
	case 'add_review':
		$module->addReview();
		break;
	case 'add_section':
		$module->addSection();
		break;
	case 'add_section_confirm':
		$module->insertSection();
		break;
	case 'add_news_confirm':
		$module->insertReview();
		break;
	case 'Delete Review':
		$module->deleteReview();
		break;
	case 'Delete Section':
		$module->deleteSection();
		break;
	case 'Edit Review':
		$module->editReview();
		break;
	case 'edit_review_confirm':
		$module->updateReview();
		break;
	case 'Edit Section':
		$module->editSection();
		break;
	case 'edit_section_confirm':
		$module->updateSection();
		break;
	case 'manage_sections':
		$module->manageSections();
		break;
	default:
		$module->manageReviews();
		break;
}

if ($_REQUEST['do'] == 'View Matrix')
{
	SPMessage("Loading content matrix...","rcm_matrix.php?do=viewmatrix&type=previews&id=$_REQUEST[id]");
}

$cp->footer();





?>