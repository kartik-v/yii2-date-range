yii2-date-range
=================

## __Extension is under development__

An advanced date range picker input for Yii Framework 2 based on [dangrossman/bootstrap-daterangepicker plugin](https://github.com/dangrossman/bootstrap-daterangepicker). 
The date range picker widget is styled for Bootstrap 3.x and creates a dropdown menu from which a user can select a range of dates. If the plugin is invoked with no options, 
it will present two calendars to choose a start and end date from. Optionally, you can provide a list of date ranges the user can select from instead of 
choosing dates from the calendars. If attached to a text input, the selected dates will be inserted into the text box. Otherwise, you can provide a custom callback 
function to receive the selection.

> NOTE: This extension depends on the [kartik-v/yii2-widgets](https://github.com/kartik-v/yii2-widgets) extension which in turn depends on the 
[yiisoft/yii2-bootstrap](https://github.com/yiisoft/yii2/tree/master/extensions/bootstrap) extension. Check the 
[composer.json](https://github.com/kartik-v/yii2-date-range/blob/master/composer.json) for this extension's requirements and dependencies. 
Note: Yii 2 framework is still in active development, and until a fully stable Yii2 release, your core yii2-bootstrap packages (and its dependencies) 
may be updated when you install or update this extension. You may need to lock your composer package versions for your specific app, and test 
for extension break if you do not wish to auto update dependencies.

### Demo
You can see detailed [documentation](http://demos.krajee.com/date-range) on usage of the extension.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require kartik-v/yii2-date-range "dev-master"
```

or add

```
"kartik-v/yii2-date-range": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

### DateRangePicker

```php
use kartik\daterange\DateRangePicker;
echo DateRangePicker::widget([
    'daterangeColor' => DateRangePicker::TYPE_DANGER,
    'handleColor' => DateRangePicker::TYPE_DANGER,
    'pluginOptions' => [
        'orientation' => 'horizontal',
        'handle' => 'round',
        'min' => 0,
        'max' => 255,
        'step' => 1
    ],
]); 
```

## License

**yii2-date-range** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.