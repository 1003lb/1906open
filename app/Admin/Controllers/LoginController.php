<?php

namespace App\Admin\Controllers;

use App\Model\Login;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LoginController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Login';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Login());

        $grid->column('id', __('Id'));
        $grid->column('cname', __('Cname'));
        $grid->column('tel', __('Tel'));
        $grid->column('emali', __('Emali'));
        $grid->column('address', __('Address'));
        $grid->column('password', __('Password'));
        $grid->column('password1', __('Password1'));
        $grid->column('username', __('Username'));

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
        $show = new Show(Login::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cname', __('Cname'));
        $show->field('tel', __('Tel'));
        $show->field('emali', __('Emali'));
        $show->field('address', __('Address'));
        $show->field('password', __('Password'));
        $show->field('password1', __('Password1'));
        $show->field('username', __('Username'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Login());

        $form->text('cname', __('Cname'));
        $form->text('tel', __('Tel'));
        $form->text('emali', __('Emali'));
        $form->text('address', __('Address'));
        $form->password('password', __('Password'));
        $form->text('password1', __('Password1'));
        $form->text('username', __('Username'));

        return $form;
    }
}
