<?php
/**
 * Created by PhpStorm.
 * User: nielsfilmer
 * Date: 03/10/16
 * Time: 10:50
 */

namespace NielsFilmer\CmsPackage;


use Illuminate\Http\Request;
use NielsFilmer\CmsPackage\Forms\CmsUserForm;
use VodafoneStutter\Http\Requests\Cms\CmsUserRequest;
use NielsFilmer\CmsPackage\Lists\CmsUsersList;

class CmsUsersController extends CmsController
{
    protected $list_class = CmsUsersList::class;
    protected $form_class = CmsUserForm::class;


    /**
     * @param CmsUserRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CmsUserRequest $request, $id)
    {
        $class = $this->class;
        $user = $class::findOrFail($id);
        $user = $this->saveUserModel($user, $request);

        flash()->success("User {$user->name} saved");
        return redirect()->to($request->input('prev_url'));
    }


    /**
     * @param CmsUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CmsUserRequest $request)
    {
        $class = $this->class;
        $user = new $class;
        $user = $this->saveUserModel($user, $request);

        flash()->success("User {$user->name} saved");
        return redirect()->to($request->input('prev_url'));
    }


    /**
     * @param CmsUser $user
     * @param Request $request
     *
     * @return CmsUser
     */
    protected function saveUserModel($user, Request $request)
    {
        $password = $request->input('password');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if(!empty($password)) $user->password = bcrypt($password);
        $user->save();

        return $user;
    }
}
