<?php

namespace App\Admin\Controllers;

use App\Models\Group;
use App\Models\SelectToGroupO;
use App\Models\TeacherToSciense;
use App\Models\Year;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SelectToGroupOController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SelectToGroupO';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SelectToGroupO());

        $grid->column('id', __('Id'));
        $grid->column('year.name', __('Yil'));
        $grid->column('Fan')->display(function () {
            return $this->tts->sciense->name;
        });
        $grid->column("O'qituvchi")->display(function () {
            return $this->tts->teacher->last_name . " " . $this->tts->teacher->first_name . " " . $this->tts->teacher->middle_name;
        });
        $grid->column('group.name', __('Guruh'));
        $grid->column('active', __('Active'))->bool();

        // $grid->column('id', __('Id'));
        // $grid->column('year_id', __('Year id'));
        // $grid->column('teacher_to_sciense_id', __('Teacher to sciense id'));
        // $grid->column('group_id', __('Group id'));
        // $grid->column('created_by', __('Created by'));
        // $grid->column('active', __('Active'));
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
        $show = new Show(SelectToGroupO::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('year_id', __('Year id'));
        $show->field('teacher_to_sciense_id', __('Teacher to sciense id'));
        $show->field('group_id', __('Group id'));
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
        $form = new Form(new SelectToGroupO());

        $id = Admin::user()->id;

        $years = Year::orderBy('id', 'DESC')->pluck('name', 'id')->all();
        $groups = Group::where('created_by', $id)->orderBy('name', 'ASC')->pluck('name', 'id')->all();

        $tts = TeacherToSciense::where('created_by', $id)->orderBy('id', 'ASC')->get();
        $teachers = [];
        $tts = $tts->map(function ($item) use (&$teachers) {
            return $teachers[$item->id] = $item->sciense->name . " - " . $item->teacher->last_name . " " . $item->teacher->first_name . " " . $item->teacher->middle_name;
        });

        $form->select('year_id', 'Yil')->options($years)->required();
        $form->select('teacher_to_sciense_id', 'Fan')->options($teachers)->required();
        $form->select('group_id', 'Guruh')->options($groups)->required();
        $form->hidden('created_by');
        $form->saving(function (Form $form) use ($id) {
            $form->created_by = $id;
        });
        $form->switch('active', __('Active'))->default(1);

        return $form;
    }
}
