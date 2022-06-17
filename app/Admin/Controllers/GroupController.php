<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use App\Models\Group;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class GroupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Group';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Group());

        // $grid->column('id', __('Id'));
        $grid->column('course.name', __('Kurs'));
        $grid->column('name', __('Nomi'));
        $grid->column('com_science', __('Majburiy fan'));
        $grid->column('opt_science', __('Ixtiyoriy fan'));
        // $grid->column('created_by', __('Created by'));
        // $grid->column('admin.name', __('Admin'));
        $grid->column('active', __('Active'))->bool();
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        // check
        $auth_id = Admin::user()->id;
        if ($auth_id == 1) {
            $grid->model()->orderBy('name', 'ASC');
        } else {
            $grid->model()->where('created_by', $auth_id)->orderBy('name', 'ASC');
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
        $show = new Show(Group::findOrFail($id));

        // check
        $auth_id = Admin::user()->id;
        if ($auth_id != 1) {
            $data = Group::findOrFail($id);
            if ($data->created_by != $auth_id) {
                return abort(404);
            }
        }
        // 

        $show->field('id', __('Id'));
        $show->field('course_id', __('Kurs'));
        $show->field('name', __('Name'));
        $show->field('com_science', __('Majburiy fan'));
        $show->field('opt_science', __('Ixtiyoriy fan'));
        $show->field('created_by', __('Created by'));
        $show->field('active', __('Active'));
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
        $form = new Form(new Group());

        $couses = Course::orderBy('name', 'ASC')->pluck('name', 'id')->all();

        $form->select('course_id', 'Kurs')->options($couses);
        $form->text('name', __('Name'));
        $form->number('com_science', __('Majburiy fan'))->default(0);
        $form->number('opt_science', __('Ixtiyoriy fan'))->default(0);
        // $form->number('created_by', __('Created by'));
        $form->hidden('created_by');
        $form->saving(function (Form $form) {
            $form->created_by = Admin::user()->id;
        });
        $form->switch('active', __('Active'))->default(1);

        return $form;
    }
}
