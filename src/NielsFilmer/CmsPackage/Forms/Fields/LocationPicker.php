<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 11/07/16
 * Time: 11:32
 */

namespace BenfCasting\Forms\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;

class LocationPicker extends FormField {

    /**
     * Returns the template for this field
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'cms-package::forms.fields.locationpicker';
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
        $options['lat-name'] = $this->getOption('lat');
        $options['lng-name'] = $this->getOption('lng');
        $options['lat-value'] = $this->getParent()->getField($options['lat-name'])->getValue() ?: '52.2306798';
        $options['lng-value'] = $this->getParent()->getField($options['lng-name'])->getValue() ?: '5.186481599999979';

        return parent::render($options, $showLabel, $showField, $showError);
    }

}