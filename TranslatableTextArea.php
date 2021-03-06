<?php
/**
 * Created by PhpStorm.
 * User: Goran Sarenac <goransarenac91@hotmail.com>
 * Date: 8/12/2016
 * Time: 5:11 PM
 */

namespace goransaki\translatabletextarea;

use common\helpers\ArrayHelper;
use common\helpers\LanguageHelper;
use yii\base\Exception;
use yii\widgets\InputWidget;

class TranslatableTextArea extends InputWidget
{
    public $form;

    public $languages;

    public $options;

    public $showTabs = true;

    public function run()
    {
        if (!$this->showTabs) {
            return $this->form->field($this->model, "{$this->attribute}[" . \Yii::$app->sourceLanguage . "]")->textarea(
                $this->options)->label(false);
        }
		
        $this->registerWidgetScript();

        return $this->render('index', [
            'model' => $this->model,
            'form' => $this->form,
        ]);
    }

    public function getItems()
    {
        if (empty($this->languages)) {
            Throw new Exception("Languages missing");
        }

        $items = [];
        foreach ($this->languages as $code => $language) {
            $items[] = [
                'label' => $language,
                'content' => $this->form->field($this->model, "{$this->attribute}[$code]")->textarea(
                    $this->options
                )->label(false)
            ];
        }

        return $items;
    }

    public function registerWidgetScript()
    {
        $view = $this->getView();
        TranslatableTextAreaAsset::register($view);
    }
}
