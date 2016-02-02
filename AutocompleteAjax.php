<?php

namespace keygenqt\autocompleteAjax;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class AutocompleteAjax extends InputWidget
{
    public $multiple = false;
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

        if ($this->multiple) {
            
            $this->getView()->registerJs("
                
                $('#{$this->getId()}').keyup(function(event) {
                    if (event.keyCode == 8 && !$('#{$this->getId()}').val().length) {
                        
                        $('#{$this->getId()}-hidden').val('');
                            
                    } else if ($('.ui-autocomplete').css('display') == 'none' && 
                        $('#{$this->getId()}-hidden').val().split(', ').length > $(this).val().split(', ').length) {
                            
                        var val = $('#{$this->getId()}').val().split(', ');
                        var ids = [];
                        for (var i = 0; i<val.length; i++) {
                            val[i] = val[i].replace(',', '').trim();
                            ids[i] = cache_{$this->getId()}_1[val[i]];
                        }
                        $('#{$this->getId()}-hidden').val(ids.join(', '));
                    }
                });
                
                $('#{$this->getId()}').keydown(function(event) {
                    
                    if (event.keyCode == 13 && $('.ui-autocomplete').css('display') == 'none') {
                        submit_{$this->getId()} = $('#{$this->getId()}').closest('.grid-view');
                        $('#{$this->getId()}').closest('.grid-view').yiiGridView('applyFilter');
                    }
                    
                    if (event.keyCode == 13) {
                        $('.ui-autocomplete').hide();
                    }
                    
                });
                
                $('body').on('beforeFilter', '#' + $('#{$this->getId()}').closest('.grid-view').attr('id') , function(event) {
                    return submit_{$this->getId()};
                });

                var submit_{$this->getId()} = false;
                var cache_{$this->getId()} = {};
                var cache_{$this->getId()}_1 = {};
                var cache_{$this->getId()}_2 = {};
                jQuery('#{$this->getId()}').autocomplete(
                {
                    minLength: 1,
                    source: function( request, response )
                    {
                        var term = request.term;

                        if (term in cache_{$this->getId()}) {
                            response( cache_{$this->getId()}[term]);
                            return;
                        }
                        $.getJSON('{$this->getUrl()}', request, function( data, status, xhr ) {
                            cache_{$this->getId()} [term] = data;
                                
                            for (var i = 0; i<data.length; i++) {
                                if (!(data[i].id in cache_{$this->getId()}_2)) {
                                    cache_{$this->getId()}_1[data[i].label] = data[i].id;
                                    cache_{$this->getId()}_2[data[i].id] = data[i].label;
                                }
                            }

                            response(data);
                        });
                    },
                    select: function(event, ui)
                    {
                        var val = $('#{$this->getId()}-hidden').val().split(', ');

                        if (val[0] == '') {
                            val[0] = ui.item.id;
                        } else {
                            val[val.length] = ui.item.id;
                        }

                        $('#{$this->getId()}-hidden').val(val.join(', '));

                        var names = [];
                        for (var i = 0; i<val.length; i++) {
                            names[i] = cache_{$this->getId()}_2[val[i]];
                        }

                        setTimeout(function() {
                            $('#{$this->getId()}').val(names.join(', '));
                        }, 0);
                    }
                });
            ");
        } else {
            $this->getView()->registerJs("
                var cache_{$this->getId()} = {};
                var cache_{$this->getId()}_1 = {};
                var cache_{$this->getId()}_2 = {};
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
        }
        
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
                                var arr = [];
                                for (var i = 0; i<data.length; i++) {
                                    arr[i] = data[i].label;
                                    if (!(data[i].id in cache_{$this->getId()}_2)) {
                                        cache_{$this->getId()}_1[data[i].label] = data[i].id;
                                        cache_{$this->getId()}_2[data[i].id] = data[i].label;
                                    }
                                }
                                $('#{$this->getId()}').val(arr.join(', '));
                            }
                            $('.autocomplete-image-load').hide();
                        }
                    });
                });
            ");
        }
        
        return Html::tag('div', 
                
            Html::activeHiddenInput($this->model, $this->attribute, ['id' => $this->getId() . '-hidden', 'class' => 'form-control'])
            . ($value ? Html::tag('div', "<img src='{$this->registerActiveAssets()}/images/load.gif'/>", ['class' => 'autocomplete-image-load']) : '')
            . Html::textInput('', '', array_merge($this->options, ['id' => $this->getId(), 'class' => 'form-control']))
              
            , [
                'style' => 'position: relative;'
            ]
        );
    }
}