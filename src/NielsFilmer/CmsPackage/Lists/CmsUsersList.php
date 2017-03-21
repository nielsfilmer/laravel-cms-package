<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 16/08/16
 * Time: 15:27
 */

namespace NielsFilmer\CmsPackage\Lists;


use NielsFilmer\EloquentLister\TableList;

class CmsUsersList extends TableList {

    /**
     * The function that gets called to build the table.
     * All Columns should be added here.
     *
     * @return mixed
     */
    protected function buildTable()
    {
        $this
             ->addColumn('name', 'Name', ['orderable' => true])
             ->addColumn('email', 'Email', ['orderable' => false])
             ->addColumn('actions', '', ['type' => 'actions', 'show_action' => false]);
    }

}
