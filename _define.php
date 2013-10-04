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

$this->registerModule(
	/* Name */				"listImages",
	/* Description*/		"List images from entries",
	/* Author */			"Kozlika, Franck Paul",
	/* Version */			'1.9',
	array(
		/* Permissions */	'permissions' =>	'contentadmin',
		/* Type */			'type' =>			'plugin'
	)
);
