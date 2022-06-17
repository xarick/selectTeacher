<?php

namespace App\Admin\Controllers;

use App\Models\Faculty;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class FacultyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Kafedralar';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Faculty());

        $grid->column('id', __('Id'));
        $grid->column('admin.name', __('Fakultet'));
        $grid->column('name', __('Nomi'));
        $grid->column('teachers', "O'qituvchilar")->display(function ($teachers) {
            $count = count($teachers);
            return "<span class='label label-warning'>{$count}</span>";
        });
        $grid->column('scienses', 'Fanlar')->display(function ($scienses) {
            $count = count($scienses);
            return "<span class='label label-warning'>{$count}</span>";
        });
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
        $show = new Show(Faculty::findOrFail($id));

        // check
        $auth_id = Admin::user()->id;
        if ($auth_id != 1) {
            $data = Faculty::findOrFail($id);
            if ($data->created_by != $auth_id) {
                return abort(404);
            }
        }
        // 

        $show->field('id', __('Id'));
        $show->field('created_by', __('Created by'));
        $show->field('name', __('Name'));
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
        $form = new Form(new Faculty());
        $id = Admin::user()->id;

        $form->hidden('created_by');
        $form->saving(function (Form $form) use ($id) {
            $form->created_by = $id;
        });
        $form->text('name', __('Name'));
        $form->switch('active', __('Active'))->default(1);

        return $form;
    }
}
