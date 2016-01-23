<?php

/* 
 * Shop-Yii - краткое описание на английском
 * Copyright (C) 2012 <keygenqt@google.com>

 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

namespace keygenqt\imageAjax;

use \yii\web\AssetBundle;
use \app\components\JavaScript;

/**
 * @author KeyGen <keygenqt@gmail.com>
 * @since 2.0
 */
class ActiveAssets extends AssetBundle
{
	public $sourcePath = '@keygenqt/imageAjax/assets';

	public $js = [
		'js/dropzone.js',
	];

	public $css = [
		'css/yii2-image-ajax.css'
	];
}
