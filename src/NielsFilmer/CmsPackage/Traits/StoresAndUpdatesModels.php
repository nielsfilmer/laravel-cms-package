<?php

namespace NielsFilmer\CmsPackage\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: filme
 * Date: 3/22/2017
 * Time: 17:32
 */
trait StoresAndUpdatesModels
{
    protected $_ignore_input_fields = ['_token', 'prev_url', '_method'];


    /**
     * Default store function
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $request = app()->make(Request::class);
        $class = $this->class;

        $this->checkValidation($request, 'store');

        $model = new $class;
        $model = $this->saveModel($model, $request);
        $display = $this->display_attribute;
        flash()->success("{$model->$display} saved");
        return redirect()->to($request->input('prev_url'));
    }


    /**
     * Default update function
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $request = app()->make(Request::class);
        $args = $request->route()->parameters();
        $class = $this->class;

        if(is_null($this->args_id_index)) {
            $id = end($args);
        } else {
            $id = $args[$this->args_id_index];
        }

        $this->checkValidation($request, 'update', $id);

        $model = $class::findOrFail($id);
        $model = $this->saveModel($model, $request);
        $display = $this->display_attribute;
        flash()->success("{$model->$display} saved");
        return redirect()->to($request->input('prev_url'));
    }


    /**
     * Checks the validation if validation rules are set
     *
     * @param Request $request
     * @param $method
     * @param $key
     */
    protected function checkValidation(Request $request, $method, $key = null)
    {
        if(isset($this->validation_rules)) {
            $validation_rules = $this->validation_rules;
            if(isset($validation_rules[$method]) && is_array($validation_rules[$method])) {
                $validation_rules = $validation_rules[$method];
            }

            if($key) {
                foreach($validation_rules as $attribute=>&$rules) {
                    $rules = str_replace('{key}', $key, $rules);
                }
            }

            $this->validate($request, $validation_rules);
        }
    }


    /**
     * Default save model function
     *
     * @param Model $model
     * @param Request $request
     *
     * @return Model
     */
    protected function saveModel(Model $model, Request $request)
    {
        $input = $request->all();
        $ignore = (isset($this->ignore_input_fields)) ? $this->ignore_input_fields : $this->_ignore_input_fields;

        foreach($input as $key=>$value) {
            if(!in_array($key, $ignore)) {
                $model->$key = $value;
            }
        }

        $model->save();
        return $model;
    }
}