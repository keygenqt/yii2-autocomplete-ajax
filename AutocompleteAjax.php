<?php

namespace keygenqt\autocompleteAjax;

use yii\helpers\Url;
use yii\widgets\InputWidget;

class AutocompleteAjax extends InputWidget
{
    private $_baseUrl;

    public function getBaseUrl()
    {
        if ($this->_baseUrl === null) {
            $this->_baseUrl = ActiveAssets::register($this->getView())->baseUrl;
        }
        return $this->_baseUrl;
    }

    public function init()
    {
//        echo $this->getView()->render('@keygenqt/imageAjax/views/view', ['widget' => $this]);

        $this->getView()->registerJs("
//          <script>
			var cache_{$this->getId()} = {};
			jQuery('#{$this->getId()}').autocomplete({

			});
        ");

        parent::init();
    }
}