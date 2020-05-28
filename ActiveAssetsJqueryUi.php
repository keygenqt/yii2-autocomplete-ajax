<?php
/*
 * Copyright 2020 Vitaliy Zarubin
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace keygenqt\autocompleteAjax;

use \yii\web\AssetBundle;

/**
 * @author KeyGen <keygenqt@gmail.com>
 */
class ActiveAssetsJqueryUi extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui';

    public $js = [
        'jquery-ui.js',
    ];

    public $css = [
        'themes/smoothness/jquery-ui.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
