<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 16/08/16
 * Time: 15:41
 */

namespace NielsFilmer\CmsPackage\Forms;


use Illuminate\Support\Facades\Cache;
use Kris\LaravelFormBuilder\Form;

class CmsUserForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => 'Name'])
            ->add('email', 'text', ['label' => 'E-mailaddress'])
            ->add('password', 'password', ['label' => 'Password *', 'value' => ''])
            ->add('password_confirmation', 'password', ['label' => 'Repeat Password *'])
            ->add('prev_url', 'hidden', ['default_value' => $this->getData('prev_url')])

            ->add('submit', 'submit', ['label' => 'Save', 'attr' => ['class' => 'btn btn-success btn-block']]);
    }

}
