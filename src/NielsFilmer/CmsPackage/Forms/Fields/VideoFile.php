<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 12/12/16
 * Time: 16:40
 */

namespace NielsFilmer\CmsPackage\Forms\Fields;


use Kris\LaravelFormBuilder\Form;

class VideoFile extends FileField {

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
            $this->setOption('mime-type', 'video/mp4');
        }

        if(!isset($options['accept'])) {
            $this->setOption('accept', 'video/*');
        }
    }


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
        $options['attr']['accept'] = $this->getOption('accept');
        return parent::render($options, $showLabel, $showField, $showError);
    }

}
