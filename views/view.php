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

/* @var $widget \keygenqt\autocompleteAjax\AutocompleteAjax */

use \yii\helpers\Html;

?>

<style>
    .div-autocompleteajax .image-autocompleteajax<?= $widget->textId ?> {
        width: 20px;
        left: -24px;
        margin: auto;
        position: absolute;
        top: 0;
        bottom: 0;
        display: none;
    }
</style>

<div class="div-autocompleteajax">
    <?= Html::img($widget->assets . '/images/load.gif', ['class' => 'image-autocompleteajax' . $widget->textId]) ?>
    <?= $widget->renderInputHtml() ?>
    <?= $widget->renderInputHtmlHidden() ?>
</div>

<script>

    var <?= $widget->dataName ?> = {};
    var listener<?= $widget->textId ?> = <?= $widget->listener ?>

        $(function () {
            $('#<?= $widget->textId ?>').autocomplete({
                appendTo: ".field-<?= $widget->id ?>",
                minLength: 1,
                source: function (request, response) {
                    var term = request.term;
                    if (term in <?= $widget->dataName ?>) {
                        response(<?= $widget->dataName ?>[term]);
                        return;
                    }
                    $('.image-autocompleteajax<?= $widget->textId ?>').show()
                    $.getJSON('<?= $widget->url ?>', request, function (data, status, xhr) {
                        $('.image-autocompleteajax<?= $widget->textId ?>').hide()
                        <?= $widget->dataName ?>[term] = data;
                        response(data);
                    });
                },
                select: function (event, ui) {
                    $('#<?= $widget->id ?>').val(ui.item['id'])
                    listener<?= $widget->textId ?>(event, ui)
                }
            });

            $('#<?= $widget->textId ?>').keydown(function(event) {
                var input = $('#<?= $widget->textId ?>')
                var hidden = $('#<?= $widget->id ?>')
                if (event.keyCode == 8 && $(hidden).val() != '') {
                    input.val('')
                    hidden.val('')
                }
            });
        })

    <?php if (!empty($widget->getValue())): ?>
    $('.image-autocompleteajax<?= $widget->textId ?>').show()

    $.getJSON('<?= $widget->url ?>?term=<?= $widget->getValue() ?>', function( data ) {
        $('.image-autocompleteajax<?= $widget->textId ?>').hide()
        for (var i = 0; i<data.length; i++) {
            if (data[i].id == '<?= $widget->getValue() ?>') {
                $('#<?= $widget->textId ?>').val(data[i].label)
            }
        }
    });
    <?php endif; ?>
</script>
