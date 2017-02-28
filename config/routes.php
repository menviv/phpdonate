<?php
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
 	Router::parseExtensions('rss'); 
 	
	Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'index')); 
	Router::connect('/sitemap.xml', array('controller' => 'sitemaps', 'action' => 'index')); 
	Router::connect('/rss/*', array('controller' => 'rss', 'action' => 'rss'));
	Router::connect('/ajax/:action/*', array('controller' => 'ajax'));
	Router::connect('/admin', array('plugin' => 'admin'));
	Router::connect('/admin/:action/*', array('plugin' => 'admin'));
	Router::connect('/donateresponse/*', array('controller' => 'ajax','action'=>'donateresponse'));
	Router::connect('/:action/*', array('controller' => 'pages'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	uses('Folder');
	$pf = new Folder(APP . 'plugins');
	list($pluginFolders, $pluginFiles) = $pf->read();
	foreach($pluginFolders as $folder) {
		$file = APP . 'plugins' . DS . $folder . DS . 'config' . DS . 'bootstrap.php';
		if(is_file($file)) {
			require_once($file);
		}
	}