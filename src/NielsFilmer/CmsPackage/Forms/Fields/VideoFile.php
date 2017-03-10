<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 12/12/16
 * Time: 16:40
 */

namespace NielsFilmer\CmsPackage\Forms\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;

class VideoFile extends FormField {

    /**
     * Returns the template for this field
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'cms-package::forms.fields.videofile';
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
        if(!isset($options['mime-type'])) {
            $options['mime-type'] = 'video/mp4';
        }

        $options['attr']['accept'] = 'video/*';

        return parent::render($options, $showLabel, $showField, $showError);
    }

}
