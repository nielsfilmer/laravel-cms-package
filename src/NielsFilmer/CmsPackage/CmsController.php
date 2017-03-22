<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 05/07/16
 * Time: 16:17
 */

namespace NielsFilmer\CmsPackage;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use NielsFilmer\EloquentLister\ListBuilder;
use NielsFilmer\EloquentLister\TableList;

abstract class CmsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var int
     */
    protected $default_rpp = 50;

    /**
     * @var string
     */
    protected $index_heading;

    /**
     * @var string
     */
    protected $list_view = "cms-package::default-resources.list";

    /**
     * @var string
     */
    protected $list_filter;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var TableList
     */
    protected $list_class;

    /**
     * @var Form
     */
    protected $form_class;

    /**
     * @var string
     */
    protected $form_view = 'cms-package::default-resources.form';

    /**
     * @var string
     */
    protected $display_attribute = "name";

    /**
     * @var bool
     */
    protected $show_add = true;

    /**
     * @var string|null
     */
    protected $slug;

    /**
     * @var string
     */
    protected $object_name;

    /**
     * @var string
     */
    protected $default_order = 'created_at';

    /**
     * @var string
     */
    protected $default_order_direction = 'desc';

    /**
     * @var string
     */
    protected $layout = 'layouts.app';

    /**
     * @var string
     */
    protected $section = 'content';

    /**
     * @var int
     */
    protected $args_id_index = null;


    /**
     * Constructor
     */
    public function __construct()
    {
        if(is_null($this->object_name)) {
            $this->object_name = class_basename($this->class);
        }

        if(is_null($this->index_heading)) {
            $this->index_heading = str_plural($this->object_name);
        }
    }


    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getOrder(Request $request)
    {
        return $request->get('order') ? explode('|',$request->get('order')) : [
            $this->default_order,
            $this->default_order_direction
        ];
    }


    /**
     * @param Request $request
     *
     * @return int
     */
    protected function getRpp(Request $request)
    {
        return $request->get('rpp') ?: $this->default_rpp;
    }


    /**
     * @param Request $request
     *
     * @return LengthAwarePaginator
     */
    protected function getListQuery(Request $request, $args = [])
    {
        $order = $this->getOrder($request);
        $rpp = $this->getRpp($request);
        $class = $this->class;

        return $class::orderBy($order[0], $order[1])->paginate($rpp);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = app(Request::class);
        $listbuilder = app(ListBuilder::class);
        $args = $request->route()->parameters();

        $slug = (empty($this->slug)) ? substr($request->getPathInfo(), 1) : $this->slug;
        $listslug = (empty($this->list_slug)) ? $slug : $this->list_slug;

        $collection = $this->getListQuery($request, $args);
        $total = $collection->total();

        if(method_exists($this, 'getListData')) {
            $list_data = $this->getListData($request, $args);
        } else {
            $list_data = [];
        }

        $list = $listbuilder->build(new $this->list_class, $collection, [
            'show_action' => false,
            'slug' => $listslug,
            'data' => $list_data,
        ]);
        $filter = $this->list_filter;
        $show_add = $this->show_add;

        if (method_exists($this, 'getIndexBreadcrumb')) {
            $heading = $this->getIndexBreadcrumb($request, $args, $total);
        } else {
            $heading = $this->index_heading;
        }

        $object_name = $this->object_name;

        if($request->ajax()) {
            return view($this->list_view, compact('list', 'heading', 'filter', 'show_add', 'args', 'object_name', 'total', 'request'));
        } else {
            $layout  = $this->layout;
            $section = $this->section;
            $view    = $this->list_view;
            return view('cms-package::default-resources.layout-extender', compact('list', 'heading', 'filter', 'show_add', 'args', 'object_name', 'layout', 'section', 'view', 'total', 'request'));
        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $request = app(Request::class);
        $formbuilder = app(FormBuilder::class);
        $args = $request->route()->parameters();
        $referer = url()->previous();

        $route = Route::getCurrentRoute()->getName();

        if(method_exists($this, 'getCreateFormData')) {
            $form_data = $this->getCreateFormData($request, $args);
            $form_data = array_merge(['prev_url' => $referer], $form_data);
        } else {
            $form_data = ['prev_url' => $referer];
        }

        $url = (empty($this->route_store)) ? route(str_replace('create', 'store', $route), $args) : $this->route_store;

        $form = $formbuilder->create($this->form_class, [
            'method' => 'POST',
            'url' => $url,
            'data' => $form_data,
        ]);

        if(method_exists($this, 'getCreateBreadcrumb')) {
            $breadcrumb = $this->getCreateBreadcrumb($request, $args);
        } else {
            $breadcrumb = [
                $this->index_heading => route(str_replace('create', 'index', $route), $args),
                "New {$this->object_name}" => null,
            ];
        }

        if($request->ajax()) {
            return view($this->form_view, compact('form', 'breadcrumb', 'args', 'layout', 'section', 'request'));
        } else {
            $layout  = $this->layout;
            $section = $this->section;
            $view    = $this->form_view;
            return view('cms-package::default-resources.layout-extender', compact('form', 'breadcrumb', 'args', 'layout', 'section', 'layout', 'section', 'view', 'request'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        /** @var Request $request */
        $request = app(Request::class);
        $formbuilder = app(FormBuilder::class);
        $args = $request->route()->parameters();

        if(is_null($this->args_id_index)) {
            $id = end($args);
        } else {
            $id = $args[$this->args_id_index];
        }

        $referer = url()->previous();
        $route = Route::getCurrentRoute()->getName();

        if(method_exists($this, 'getEditModel')) {
            $model = $this->getEditModel($request, $id, $args);
        } else {
            $class = $this->class;
            $model = $class::findOrFail($id);
        }

        if(method_exists($this, 'getEditFormData')) {
            $form_data = $this->getEditFormData($model, $request, $args);
            $form_data = array_merge(['prev_url' => $referer], $form_data);
        } else {
            $form_data = ['prev_url' => $referer];
        }

        $url = (empty($this->route_update)) ? route(str_replace('edit', 'update', $route), $args) : $this->route_update;

        $form = $formbuilder->create($this->form_class, [
            'method' => 'PUT',
            'url' => $url,
            'data' => $form_data,
            'model' => $model,
        ]);

        if(method_exists($this, 'getEditBreadcrumb')) {
            $breadcrumb = $this->getEditBreadcrumb($model, $request, $args);
        } else {
            $display_attribute = $this->display_attribute;
            $name = $model->$display_attribute;
            $breadcrumb = [
                $this->index_heading => route(str_replace('edit', 'index', $route), $args),
                "Editting {$this->object_name} '{$name}'" => null,
            ];
        }

        if($request->ajax()) {
            return view($this->form_view, compact('form', 'breadcrumb', 'model', 'args', 'layout', 'section', 'request'));
        } else {
            $layout  = $this->layout;
            $section = $this->section;
            $view    = $this->form_view;
            return view('cms-package::default-resources.layout-extender', compact('form', 'breadcrumb', 'model', 'args', 'layout', 'section', 'layout', 'section', 'view', 'request'));
        }
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        $request = app(Request::class);
        if(is_null($this->args_id_index)) {
            $args = $request->route()->parameters();
            $id = end($args);
        } else {
            $id = $request->route()->parameter($this->args_id_index);
        }

        $class = $this->class;
        $model = $class::findOrFail($id);
        $name = $model->{$this->display_attribute};
        $route = (empty($this->route_index)) ? route(str_replace('destroy', 'index', Route::getCurrentRoute()->getName())) : $this->route_index;
        $model->delete();

        if($request->ajax()) {
            return response()->json([
                "message" => "{$name} was removed"
            ]);
        } else {
            flash()->success("{$name} was removed");
            return redirect()->to($route);
        }
    }


    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function validateOnly(Request $request)
    {
        if($request->get('validate_only') == 'true') {
            return response()->json([
                "message" => "Validation succesful",
            ]);
        }
    }
}
