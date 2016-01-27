<?php

namespace keygenqt\autocompleteAjax;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class AutocompleteAjax extends InputWidget
{
    public $url = [];
    public $options = [];

    private $_baseUrl;
    private $_ajaxUrl;

    public function registerActiveAssets()
    {
        if ($this->_baseUrl === null) {
            $this->_baseUrl = ActiveAssets::register($this->getView())->baseUrl;
        }
        return $this->_baseUrl;
    }

    public function getUrl()
    {
        if ($this->_ajaxUrl === null) {
            $this->_ajaxUrl = Url::toRoute($this->url);
        }
        return $this->_ajaxUrl;
    }

    public function run()
    {
        $value = $this->model->{$this->attribute};
        $this->registerActiveAssets();

        if ($value) {
            $this->getView()->registerJs("
                $(function(){
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '{$this->getUrl()}',
                        data: {term: '$value'},
                        success: function(data) {
                            if (data.length == 0) {
                                $('#{$this->getId()}').attr('placeholder', 'User not found !!!');
                            } else {
                                $('#{$this->getId()}').val(data[0].label);
                            }
                            $('.autocomplete-image-load').hide();
                        }
                    });
                });
            ");
        }

        $this->getView()->registerJs("
			var cache_{$this->getId()} = {};
			jQuery('#{$this->getId()}').autocomplete(
			{
                minLength: 1,
                source: function( request, response )
                {
                    var term = request.term;
                    if ( term in cache_{$this->getId()} ) {
                        response( cache_{$this->getId()} [term] );
                        return;
                    }
                    $.getJSON('{$this->getUrl()}', request, function( data, status, xhr ) {
                        cache_{$this->getId()} [term] = data;
                        response(data);
                    });
                },
                select: function(event, ui)
                {
                    $('#{$this->getId()}-hidden').val(ui.item.id);
                }
			});
        ");

        return Html::activeHiddenInput($this->model, $this->attribute, ['id' => $this->getId() . '-hidden', 'class' => 'form-control'])
            . ($value ? Html::tag('div', "<img src='{$this->registerActiveAssets()}/images/load.gif'/>", ['class' => 'autocomplete-image-load']) : '')
            . Html::textInput($this->attribute, '', array_merge(['id' => $this->getId(), 'class' => 'form-control'], $this->options));
    }
}