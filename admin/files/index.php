<?php
/**
 * @package Swiftlet
 * @copyright 2009 ElbertF http://elbertf.com
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU Public License
 */

$contrSetup = array(
	'rootPath'  => '../../',
	'pageTitle' => 'Files',
	'inAdmin'   => TRUE
	);

require($contrSetup['rootPath'] . '_model/init.php');

$model->check_dependencies(array('db', 'form', 'node', 'session', 'user'));

$model->form->validate(array(
	'form-submit' => 'bool',
	'title'       => 'string, empty',
	'files'       => 'string'
	));

$id     = isset($model->GET_raw['id']) && ( int ) $model->GET_raw['id'] ? ( int ) $model->GET_raw['id'] : FALSE;
$action = isset($model->GET_raw['action']) ? $model->GET_raw['action'] : FALSE;

if ( $model->session->get('user auth') < user::admin )
{
	header('Location: ' . $contr->rootPath . 'login?ref=' . rawurlencode($_SERVER['PHP_SELF']));

	$model->end();
}

$view->id     = $id;
$view->action = $action;

$view->load('admin/files.html.php');

$model->end();