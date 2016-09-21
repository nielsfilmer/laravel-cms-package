<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 12/02/16
 * Time: 10:06
 */

namespace NielsFilmer\CmsPackage\Forms\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;
use Kris\LaravelFormBuilder\Form;

class WYSIWYG extends FormField
{
    /**
     * Returns the template for this field
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'cms-package::forms.fields.wysiwyg';
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
        if(!$this->getOption('btns')) {
            $options['btns'] = json_encode([['bold', 'italic'], ['link']]);
        } else {
            $options['btns'] = json_encode($this->getOption('btns'));
        }

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
