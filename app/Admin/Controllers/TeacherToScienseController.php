<?php

namespace App\Admin\Controllers;

use App\Models\Sciense;
use App\Models\Teacher;
use App\Models\TeacherToSciense;
use App\Models\Year;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeacherToScienseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'TeacherToSciense';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TeacherToSciense());

        $grid->column('id', __('Id'));
        $grid->column('year.name', __('Year'));
        // $grid->column('teacher.last_name', __('Teacher'));
        $grid->column('FIO')->display(function () {
            return $this->teacher->first_name.' '.$this->teacher->last_name;
        });
        $grid->column('sciense.name', __('Sciense id'));
        $grid->column('limit', __('Limit'));
        // $grid->column('created_by', __('Created by'));
        $grid->column('active', __('Active'))->bool();
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(TeacherToSciense::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('year_id', __('Year id'));
        $show->field('teacher_id', __('Teacher id'));
        $show->field('sciense_id', __('Sciense id'));
        $show->field('limit', __('Limit'));
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
        $form = new Form(new TeacherToSciense());

        $years = Year::orderBy('id', 'DESC')->pluck('name', 'id')->all();
        $scienses = Sciense::orderBy('name', 'ASC')->pluck('name', 'id')->all();
        $tt = Teacher::orderBy('last_name', 'ASC')->select('id', 'first_name', 'last_name', 'middle_name')->get();
        $teachers = [];
        $tt = $tt->map(function ($item) use (&$teachers) {
            return $teachers[$item->id] = $item->last_name . " " . $item->first_name . " " . $item->middle_name;
        });

        // $form->number('year_id', __('Year id'));
        $form->select('year_id', 'Yil')->options($years)->required();
        // $form->number('teacher_id', __('Teacher id'));
        $form->select('teacher_id', 'O\'qituvchi')->options($teachers)->required();
        // $form->number('sciense_id', __('Sciense id'));
        $form->select('sciense_id', 'Fan')->options($scienses)->required();
        $form->number('limit', __('Limit(Guruhlar soni)'));
        // $form->number('created_by', __('Created by'));
        $form->hidden('created_by');
        $form->saving(function (Form $form) {
            $form->created_by = Admin::user()->id;
        });
        $form->switch('active', __('Active'))->default(1);

        return $form;
    }
}
