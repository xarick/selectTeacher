<?php

namespace App\Admin\Controllers;

use App\Models\Faculty;
use App\Models\Sciense;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ScienseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Sciense';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Sciense());

        $grid->column('id', __('Id'));
        $grid->column('faculty.name', __('Kafedra'));
        $grid->column('name', __('Nomi'));
        // $grid->column('created_by', __('Created by'));
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
        $show = new Show(Sciense::findOrFail($id));

        // check
        $auth_id = Admin::user()->id;
        if ($auth_id != 1) {
            $data = Sciense::findOrFail($id);
            if ($data->created_by != $auth_id) {
                return abort(404);
            }
        }
        // 

        $show->field('id', __('Id'));
        $show->field('faculty_id', __('Faculty id'));
        $show->field('name', __('Name'));
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
        $form = new Form(new Sciense());
        $faculties = Faculty::orderBy('name', 'ASC')->pluck('name', 'id')->all();

        // $form->number('faculty_id', __('Faculty id'));
        $form->select('faculty_id', 'Fakultet')->options($faculties);
        $form->text('name', __('Name'));
        // $form->number('created_by', __('Created by'));
        $form->hidden('created_by');
        $form->saving(function (Form $form) {
            $form->created_by = Admin::user()->id;
        });
        $form->switch('active', __('Active'))->default(1);

        return $form;
    }
}
