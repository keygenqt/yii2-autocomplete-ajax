<?php

namespace keygenqt\imageAjax;

use yii\helpers\Url;
use yii\widgets\InputWidget;

class ImageAjax extends InputWidget
{
    public $url = [];
    public $label = true;
    public $defaultImage;
    public $btnSelect = 'Select';
    public $btnDelete = 'Delete';
    public $subtitle = '';

    private $_baseUrl;
    private $_ajaxUrl;

    public function getModelName()
    {
        return strtolower(preg_replace('/.+\\\(.+)/ui', '$1', get_class($this->model)));
    }

    public function getBaseUrl()
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

    public function getDefaultLogo()
    {
        return $this->defaultImage ? $this->defaultImage : $this->getBaseUrl() . '/images/default_logo.jpg';
    }

    public function init()
    {
        echo $this->getView()->render('@keygenqt/imageAjax/views/view', ['widget' => $this]);

        $this->getView()->registerJs("
//          <script>
            new Dropzone('#{$this->getId()}-select', {
                url: '{$this->getUrl()}',
                clickable: true,
                maxFiles: 1,
                maxFilesize: 100,
                thumbnail: function() {},
                sending: function() {
                    $('#yii2-image-ajax-load').show();
                },
                error: function(file, message) {
                    $('#yii2-image-ajax-load').hide();
                    $('.yii2-image-ajax .error-block').html('Error server response.').show();
                        setTimeout(function() {
                            $('.yii2-image-ajax .error-block').hide();
                        }, 3000);
                },
                success: function(file, response)
                {
                    response = JSON.parse(response);

                    if (response.error === false) {
                        $('#image-{$this->getId()}').attr('src', response.url);
                        $('#{$this->getId()}-delete').show();
                    } else {
                        $('.yii2-image-ajax .error-block').html(response.error).show();
                        setTimeout(function() {
                            $('.yii2-image-ajax .error-block').hide();
                        }, 3000);
                    }
                    $('#{$this->getId()}-select').removeClass('img-loading');
                    $('#{$this->getId()}-hidden-filed').val(response.url);
                    this.removeAllFiles();
                    $('#yii2-image-ajax-load').hide();
                }
            });
        ");

        parent::init();
    }
}