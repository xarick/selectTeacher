<?php

namespace App\Admin\Controllers;

use App\Models\Faculty;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FacultyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Faculty';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Faculty());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
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

        $show->field('id', __('Id'));
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

        $form->text('name', __('Name'));
        $form->switch('active', __('Active'))->default(1);

        return $form;
    }
}
