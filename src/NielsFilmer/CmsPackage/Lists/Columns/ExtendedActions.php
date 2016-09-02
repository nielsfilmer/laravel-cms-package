<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 23/08/16
 * Time: 14:30
 */

namespace TommyClick\Lists\Columns;


use Illuminate\Database\Eloquent\Model;
use NielsFilmer\EloquentLister\Columns\Actions;

class ExtendedActions extends Actions {

    /**
     * @var string
     */
    protected static $view = 'cms-package::lists.cells.extended-actions';


    /**
     * @param Model $model
     *
     * @return \Illuminate\View\View
     */
    public function makeCell(Model $model)
    {
        $view = parent::makeCell($model);
        $view->with('btn_stats', $this->getOption('stats_action', true));
        $view->with('btn_clone', $this->getOption('clone_action', true));

        return $view;
    }

}