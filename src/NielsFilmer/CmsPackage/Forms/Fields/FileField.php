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

abstract class FileField extends FormField
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
        $this->parent->setFormOption('files', true);

        if(!isset($options['editable'])) {
            $this->setOption('editable', true);
        }
    }
}
