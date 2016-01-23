yii2-autocomplete-ajax
===================

This is the AutocompleteAjax widget and a Yii 2 enhanced wrapper for the [Autocomplete | jQuery UI](https://jqueryui.com/autocomplete/). A simple way to search model id of the attributes model.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either add

```
"require": {
    "keygenqt/yii2-autocomplete-ajax": "*"
},
"repositories":[
    {
        "type": "git",
        "url": "https://github.com/keygenqt/yii2-autocomplete-ajax.git"
    }
]
```

of your `composer.json` file.

## Latest Release

The latest version of the module is v0.5.0 `BETA`.

## Usage

View:

```php
use keygenqt\autocompleteAjax\AutocompleteAjax;

// Normal select with ActiveForm & model
<?= $form->field($model, 'user_id')->widget(AutocompleteAjax::classname(), [

]) ?>

```

## ScreenShot

![Alt text](https://raw.githubusercontent.com/keygenqt/yii2-autocomplete-ajax/master/screenshot/screen.png?raw=true "")

## License

**yii2-autocomplete-ajax** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.