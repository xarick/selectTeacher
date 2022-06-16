<?php

namespace App\Admin\Controllers;

use App\Models\SelectToStudentM;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SelectToStudentMController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SelectToStudentM';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SelectToStudentM());

        $grid->column('id', __('Id'));
        $grid->column('year.name', __('Yil'));
        // $grid->column('student.group.name', __('Guruh'));
        $grid->column('Guruh')->display(function () {
            return $this->student->group->name;
        });
        $grid->column('student.name', __('Student'));
        // $grid->column('stgo', __('Tanlangan Fan'));
        $grid->column('Tanlangan Fan')->display(function () {
            return $this->stgo->tts->sciense->name;
        });
        $grid->column("O'qituvchi")->display(function () {
            return $this->stgo->tts->teacher->last_name . " " . $this->stgo->tts->teacher->first_name . " " . $this->stgo->tts->teacher->middle_name;
        });
        $grid->column('active', __('Active'))->bool();
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));


        $grid->model()->latest();

        // $grid->disableRowSelector();
        // $grid->disableColumnSelector();
        $grid->disableCreateButton();

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
        $show = new Show(SelectToStudentM::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('year_id', __('Year id'));
        $show->field('student_id', __('Student id'));
        $show->field('select_to_group_m_id', __('Select to group m id'));
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
        $form = new Form(new SelectToStudentM());

        $form->number('year_id', __('Year id'));
        $form->number('student_id', __('Student id'));
        $form->number('select_to_group_m_id', __('Select to group m id'));
        $form->switch('active', __('Active'))->default(1);

        return $form;
    }
}
