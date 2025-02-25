<?php

namespace App\Admin\Controllers;

use App\Models\Faculty;
use App\Models\Teacher;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeacherController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Teacher';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Teacher());

        $grid->column('id', __('Id'));
        // $grid->column('faculty_id', __('Faculty id'));
        $grid->column('faculty.name', __('Kafedra'));
        $grid->column('first_name', __('Ism'));
        $grid->column('last_name', __('Familiya'));
        $grid->column('middle_name', __('Otasi ismi'));
        $grid->column('phone', __('telefon'));
        $grid->column('teacher_degree', __('Ilmiy daraja'));
        // $grid->column('created_by', __('Created by'));
        // $grid->column('active', __('Active'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        // check
        $auth_id = Admin::user()->id;
        if ($auth_id == 1) {
            $grid->model()->orderBy('first_name', 'ASC');
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
        $show = new Show(Teacher::findOrFail($id));

        // check
        $auth_id = Admin::user()->id;
        if ($auth_id != 1) {
            $data = Teacher::findOrFail($id);
            if ($data->created_by != $auth_id) {
                return abort(404);
            }
        }
        //

        $show->field('id', __('Id'));
        $show->field('faculty_id', __('Faculty id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('middle_name', __('Middle name'));
        $show->field('phone', __('Phone'));
        $show->field('teacher_degree', __('Teacher degree'));
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
        $form = new Form(new Teacher());
        $faculties = Faculty::orderBy('name', 'ASC')->pluck('name', 'id')->all();

        // $form->number('faculty_id', __('Faculty id'));
        $form->select('faculty_id', 'Fakultet')->options($faculties);
        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->text('middle_name', __('Middle name'));
        $form->mobile('phone', __('Phone'))->options(['mask' => '99 999 9999']);
        $form->text('teacher_degree', __('Teacher degree'));
        // $form->number('created_by', __('Created by'));
        $form->hidden('created_by');
        $form->saving(function (Form $form) {
            $form->created_by = Admin::user()->id;
        });
        $form->switch('active', __('Active'))->default(1);

        return $form;
    }
}
