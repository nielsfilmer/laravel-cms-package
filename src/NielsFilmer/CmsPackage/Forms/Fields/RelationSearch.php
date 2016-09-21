<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 07/07/16
 * Time: 11:05
 */

namespace NielsFilmer\CmsPackage\Forms\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;

class RelationSearch extends FormField
{
    /**
     * Returns the template for this field
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'cms-package::forms.fields.relationsearch';
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
        $value_display = "";

        if($value = $this->getValue()) {
            $class = $this->getOption('class');
            $model = new $class;
            $value_attr = $this->getOption('value-attr');
            $display_attr = $this->getOption('display-attr');
            $object = $model->where($value_attr, $value)->first();
            $value_display = $object->$display_attr;
        }


        $options['value-display'] = $value_display;
        $options['attr'] = (empty($options['attr']))
            ? ['autocomplete' => 'off']
            : array_merge($options['attr'], ['autocomplete' => 'off']);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
