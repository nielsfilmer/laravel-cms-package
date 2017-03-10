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

class AudioFile extends FileField
{
    /**
     * Force enctype multipart/form-data to be set
     *
     * @param $name
     * @param $type
     * @param Form $parent
     * @param array $options
     */
    public function __construct($name, $type, Form $parent, array $options = [])
    {
        parent::__construct($name, $type, $parent, $options);

        if(!isset($options['mime-type'])) {
            $this->setOption('mime-type', 'audio/mp3');
        }

        if(!isset($options['accept'])) {
            $this->setOption('accept', 'audio/*');
        }
    }


    /**
     * Returns the template for this field
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'cms-package::forms.fields.audiofile';
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
        $options['attr']['accept'] = $this->getOption('accept');
        return parent::render($options, $showLabel, $showField, $showError);
    }
}
