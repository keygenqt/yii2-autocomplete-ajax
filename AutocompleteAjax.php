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

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

/**
 * @property Model $model
 * @property string $id
 * @property array $url
 * @property string $options
 * @property boolean $multiple
 * @property string $listener
 * @property string $classname
 * @property string $dataName
 * @property string $textId
 * @property string $assets
 * @property string $attribute
 * @property string $value
 */
class AutocompleteAjax extends InputWidget
{
    public $id;
    public $url = [];
    public $listener = 'function(event, ui) {}';

    public $classname;
    public $dataName;
    public $textId;
    public $assets;

    public function init()
    {
        $this->url = Url::toRoute($this->url);
        $this->classname = strtolower((new \ReflectionClass($this->model))->getShortName());
        $this->id = "{$this->classname}-$this->attribute";
        $this->textId = $this->getId();
        $this->dataName = "data_" . $this->getId();
        parent::init();
    }

    public function registerActiveAssets()
    {
        $this->assets = empty($this->assets) ? ActiveAssets::register($this->getView())->baseUrl : $this->assets;
        ActiveAssetsJqueryUi::register($this->getView())->baseUrl;
    }

    public function run()
    {
        $this->registerActiveAssets();
        return $this->getView()->render('@keygenqt/autocompleteAjax/views/view', ['widget' => $this]);
    }

    public function renderInputHtmlHidden()
    {
        return Html::input('text', $this->name, $this->value, ArrayHelper::merge($this->options, ['id' => $this->textId]));
    }

    public function renderInputHtml($type = 'hidden')
    {
        if ($this->hasModel()) {
            return Html::activeInput($type, $this->model, $this->attribute, $this->options);
        }
        return Html::input($type, $this->name, $this->value, $this->options);
    }

    public function getValue()
    {
        if ($this->hasModel()) {
            return $this->model->{$this->attribute};
        }
        return $this->value;
    }
}
