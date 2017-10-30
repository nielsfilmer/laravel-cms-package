<?php
/**
 * Created by PhpStorm.
 * User: filme
 * Date: 10/30/2017
 * Time: 15:47
 */

namespace NielsFilmer\CmsPackage\Lists;


use NielsFilmer\EloquentLister\TableList;

class DefaultList extends TableList
{
    /**
     * @var string
     */
    private $display_attribute;


    /**
     * DefaultList constructor.
     * @param $display_attribute
     */
    public function __construct($display_attribute)
    {
        $this->display_attribute = $display_attribute;
    }


    /**
     * The function that gets called to build the table.
     * All Columns should be added here.
     *
     * @return mixed
     */
    protected function buildTable()
    {
        $this
            ->addColumn($this->display_attribute, ucfirst($this->display_attribute), ['orderable' => true])
            ->addColumn('actions', '', ['type' => 'actions', 'show_action' => false]);
    }
}