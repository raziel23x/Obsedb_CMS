<?php

/**
*	Obsedb CMS
*	Copyright 2004-2005 Josh Kimbrel
**/

error_reporting(E_ALL ^ E_NOTICE);

switch ($_REQUEST['do']) {
	case 'add_quick_confirm':
		$refresh = "Mods.php";
		break;
	case 'add_Mod_confirm':
		$refresh = "Mods.php?";
		break;
	case 'edit_Mod_confirm':
		$refresh = "Mods.php?";
		break;
	case 'Delete Mod':
		$refresh = "Mods.php";
		break;
	case 'Delete Section';
		$refresh = "Mods.php";
		break;
	case 'add_section_confirm':
		$refresh = "Mods.php";
		break;
	case 'edit_section_confirm':
		$refresh = "Mods.php";
		break;
	case 'View Matrix':
		$refresh = "rcm_matrix.php?do=viewmatrix&type=Mods&id=$_REQUEST[id]";
		break;
	}

require_once( 'global.php' );
require_once( '../sources/userModsClass.php' );
require_once( '../language/default/user_Mods.php' );

$cp->header();

/*** ModS MODULE LINKS ***/
$links = '<a href=Mods.php?do=add_section>Add Section</a> | '
		.'<a href=Mods.php?do=manage_sections>Manage Sections</a> | '
		.'<a href=Mods.php?do=add_Mod>Add Mod</a> | '
		.'<a href=Mods.php?do=add_quick>Quick Add Mod</a> | '
		.'<a href=Mods.php>Manage Mods</a>';

do_module_header('Mods Manager',$links,'doc_Mods','Mods.php?do=settings','Mods.php?do=search');
$module = new Module;

switch($_REQUEST['do'])
{
	case 'add_quick':
		$module->add_quick();
		break;
	case 'add_quick_confirm':
		$module->add_quick_confirm();
		break;
	case 'Delete Mod':
		$module->delete_Mod();
		break;
	case 'Delete Section':
		$module->delete_section();
		break;
	case 'View Matrix':
		$module->view_matrix();
		break;
	case 'publish':
		$module->publish();
		break;
	case 'search':
		$module->search_Mods();
		break;
	case 'settings':
		$module->edit_settings();
		break;
	case 'save_settings':
		$module->save_settings();
		break;
	case 'unpublish':
		$module->unpublish();
		break;
	default:
		manage_Mods();
		break;
	case 'Edit Mod':
		$module->edit_Mod();
		break;
	case 'edit_Mod_confirm':
		$module->save_Mod();
		break;
	case 'add_section':
		$module->add_section();
		break;
	case 'Edit Section':
		$module->edit_section();
		break;
	case 'add_Mod':
		add_Mod();
		break;
	case 'add_Mod_confirm':
		add_Mod_confirm();
		break;
	case 'edit_section_confirm':
		edit_section_confirm();
		break;
	case 'add_section_confirm':
		add_section_confirm();
		break;
	case 'manage_sections':
		manage_sections();
		break;
}

$cp->footer();

?>