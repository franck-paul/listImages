<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of listImages, a plugin for Dotclear 2.
#
# Copyright (c) Kozlika, Franck Paul and contributors
# carnet.franck.paul@gmail.com
#
# Licensed under the GPL version 2.0 license.
# A copy of this license is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------

if (!defined('DC_RC_PATH')) { return; }

$core->addBehavior('initWidgets',array('EntryImagesBehaviors','initWidgets'));

class EntryImagesBehaviors
{

	public static function initWidgets($w)
	{
		global $core;

		$w->create('EntryImages',__('List entry images'),array('widgetEntryImages','EntryImages'));

		// Titre du widget
		$w->EntryImages->setting('title',__('Title:'),__('Last images'));

		// Paramètres de recherche des billets
		$w->EntryImages->setting('limit',__('Limit (empty means no limit):'),'3');
		$w->EntryImages->setting('category',__('Category list:'),'','text');
		$w->EntryImages->setting('selected',__('Selected posts'),0,'check');

		// Paramètres d'affichage
		$w->EntryImages->setting('homeonly',__('Display on:'),0,'combo',
			array(__('All pages') => 0, __('Home page only') => 1, __('Except on home page') => 2));
		$w->EntryImages->setting('size',__('Image size'),1,'combo',
			array('thumbnail' => 't', 'square' => 'sq', 'small' => 's', 'medium' => 'm', 'original' => 'o'));
		$w->EntryImages->setting('def_size',__('Default image size'),1,'combo',
			array('square' => 'sq', 'original' => 'o', 'none' => 'none'));
		$w->EntryImages->setting('html_tag',__('HTML tag'),1,'combo',
			array('span' => 'span', 'list' => 'li', 'div' => 'div', 'none' => 'none'));
		$w->EntryImages->setting('link',__('Image link'),1,'combo',
			array('image' => 'image', 'entry' => 'entry', 'none' => 'none'));
		$w->EntryImages->setting('from',__('Search image in'),1,'combo',
			array('content and excerpt' => 'full', 'excerpt only' => 'excerpt', 'content only' => 'content'));
		$w->EntryImages->setting('legend',__('Legend'),1,'combo',
			array('none' => 'none', 'image' => 'image', 'entry' => 'entry'));
		$w->EntryImages->setting('bubble',__('Image title'),1,'combo',
			array('none' => 'none', 'image' => 'image', 'entry' => 'entry'));

		$w->EntryImages->setting('alt',__('Alt attribute'),1,'combo',
			array('inherit' => 'inherit', 'none' => 'none'));
		$w->EntryImages->setting('img_dim',__('Includes width and height of image'),0,'check');

		$w->EntryImages->setting('start',__('Start from'),'1');
		$w->EntryImages->setting('length',__('Number (empty or 0 = all)'),'0');

		$w->EntryImages->setting('content_only',__('Content only'),0,'check');
		$w->EntryImages->setting('class',__('CSS Class'),'','text');
	}
}
