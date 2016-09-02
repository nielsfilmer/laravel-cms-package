<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 15/07/16
 * Time: 15:58
 */

namespace NielsFilmer\Forms\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;

class Money extends FormField
{
    /**
     * Returns the template for this field
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'cms-package::forms.fields.money';
    }


    /**
     * @param array $options
     * @param bool $showLabel
     * @param bool $showField
     * @param bool $showError
     *
     * @return string
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $value = number_format($this->getValue() / 100, 2, '.', ',');
        $this->setValue($value);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
