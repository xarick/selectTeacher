<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('faculty.name', __('Fakultet'));
        $grid->column('group.name', __('Guruh'));
        $grid->column('name', __('FIO'));
        // $grid->column('email', __('Email'));
        // $grid->column('email_verified_at', __('Email verified at'));
        // $grid->column('password', __('Password'));
        // $grid->column('remember_token', __('Remember token'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        // check
        $auth_id = Admin::user()->id;
        if ($auth_id == 1) {
            $grid->model()->orderBy('name', 'ASC');
        } else {
            $grid->model()->where('faculty_id', $auth_id)->orderBy('name', 'ASC');
        }
        // check

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        // check
        $auth_id = Admin::user()->id;
        if ($auth_id != 1) {
            $data = User::findOrFail($id);
            if ($data->faculty_id != $auth_id) {
                return abort(404);
            }
        }
        // 

        $show->field('id', __('Id'));
        $show->field('faculty_id', __('Faculty id'));
        $show->field('group_id', __('Group id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $groups = Group::orderBy('name', 'ASC')->pluck('name', 'id')->all();

        // $form->number('faculty_id', __('Faculty id'));
        $form->hidden('faculty_id');
        $form->saving(function (Form $form) {
            $form->faculty_id = Admin::user()->id;
        });
        // $form->number('group_id', __('Group id'));
        $form->select('group_id', 'Guruh')->options($groups);
        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->saving(function ($form) {
            $form->password = bcrypt($form->password);
        });
        // $form->password('remember_token', __('Remember token'));

        return $form;
    }
}
