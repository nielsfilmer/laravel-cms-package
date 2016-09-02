<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 15/07/16
 * Time: 15:58
 */

namespace BenfCasting\Forms\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;

class FromTo extends FormField
{
    /**
     * Returns the template for this field
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'cms-package::forms.fields.fromto';
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
        $options['id'] = str_replace(']', '-', str_replace('[', '-', $this->getName()));


        if(!$value = $this->getValue()) {
            $options['value-from'] = $this->getOption('from-default');
            $options['value-to'] = $this->getOption('to-default');
        } else {
            $values = explode('|',$value);
            $options['value-from'] = $values[0];
            $options['value-to'] = $values[1];
        }


        return parent::render($options, $showLabel, $showField, $showError);
    }
}
