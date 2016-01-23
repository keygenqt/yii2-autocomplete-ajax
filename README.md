yii2-widget-select2
===================

This is the ImageAjax widget and a Yii 2 enhanced wrapper for the [Dropzone jQuery plugin](http://www.dropzonejs.com). A simple way to do ajax loading image on the site.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/kartik-v/yii2-widget-select2/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

Add

```
"require": {
    "keygenqt/yii2-image-ajax": "*"
},
"repositories":[
    {
        "type": "git",
        "url": "https://github.com/keygenqt/yii2-image-ajax.git"
    }
]
```

to the ```require``` section of your `composer.json` file.

## Latest Release

The latest version of the module is v0.5.0 `BETA`.

## Usage

View:

```php
use keygenqt\imageAjax\ImageAjax;

// Normal select with ActiveForm & model
<?= $form->field($model, 'icon')->widget(ImageAjax::classname(), [
    'label' => false,
    'defaultImage' => '/images/user-icon-default.png',
    'btnSelect' => 'Choose',
    'btnDelete' => 'Delete',
    'url' => ['ajax/upload-image'],
    'subtitle' => 'This video will change its size to 360х360, so keep that in mind.'
]) ?>

```

Controller:

```php
// AjaxController
class AjaxController extends Controller
{
    public function actionUploadImage()
    {
        if (Yii::$app->request->isAjax) {
            $url = Helper::uploadImage('file');
            if ($url) {
                echo Json::encode([
                    'url' => $url,
                    'error' => false,
                ]);
            } else {
                echo Json::encode([
                    'error' => 'Error upload file.',
                ]);
            }
            exit;
        }
    }
}
```

## ScreenShot

![Alt text](https://raw.githubusercontent.com/keygenqt/yii2-image-ajax/master/screenshot/empty.png?raw=true "Empty")
![Alt text](https://raw.githubusercontent.com/keygenqt/yii2-image-ajax/master/screenshot/load.png?raw=true "Load")
![Alt text](https://raw.githubusercontent.com/keygenqt/yii2-image-ajax/master/screenshot/select.png?raw=true "Select")

## License

**yii2-widget-select2** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.