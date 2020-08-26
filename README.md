[Autocomplete Ajax](https://keygenqt.com/work/yii2-autocomplete-ajax)
===================

![GitHub](https://img.shields.io/github/license/keygenqt/yii2-autocomplete-ajax)
![Packagist Downloads](https://img.shields.io/packagist/dt/keygenqt/yii2-autocomplete-ajax)

This is the AutocompleteAjax widget and a Yii 2 enhanced wrapper for the [Autocomplete | jQuery UI](https://jqueryui.com/autocomplete/). A simple way to search model id of the attributes model.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either add

```
"require": {
    "keygenqt/yii2-autocomplete-ajax": "1.0.3"
}
```

of your `composer.json` file.

## Usage

View:

```php
<?= $form->field($model, 'complete_id')->widget(keygenqt\autocompleteAjax\AutocompleteAjax::class, [
    'url' => ['ajax/search'],
    'options' => ['placeholder' => 'Find by user email or user id.']
]) ?>
```

Controller:

```php
class AjaxController extends Controller
{
    public function actionSearch($term)
    {
        if (Yii::$app->request->isAjax) {

            sleep(2); // for test

            $results = [];
            if (is_numeric($term)) {
                /** @var User $model */
                $model = User::findOne(['id' => $term]);

                if ($model) {
                    $results[] = [
                        'id' => $model['id'],
                        'label' => $model['email'] . ' (model id: ' . $model['id'] . ')',
                    ];
                }
            } else {
                $q = addslashes($term);
                foreach (User::find()->where("(`email` like '%{$q}%')")->all() as $model) {
                    $results[] = [
                        'id' => $model['id'],
                        'label' => $model['email'] . ' (model id: ' . $model['id'] . ')',
                    ];
                }
            }
            echo Json::encode($results);
        }
    }
}
```