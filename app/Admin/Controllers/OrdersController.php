<?php

namespace App\Admin\Controllers;

use App\Models\Orders;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OrdersController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Orders::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->invoice();
            $grid->customer()->name();
            $grid->total();
            $grid->created_at();
            $grid->expired_at();
            // set the `text`、`color`、and `value`
            $states = [
                0 => ['value' => 0, 'text' => 'Menunggu pembayaran', 'color' => 'default'],
                1 => ['value' => 1, 'text' => 'Barang sedang diproses', 'color' => 'yellow'],
                2 => ['value' => 2, 'text' => 'Barang telah dikirim', 'color' => 'green'],
                3 => ['value' => 3, 'text' => 'Barang telah sampai', 'color' => 'green'],
                4 => ['value' => 4, 'text' => 'Dibatalkan', 'color' => 'default'],
                5 => ['value' => 5, 'text' => 'Kadaluarsa', 'color' => 'red'],
            ];
            $grid->status()->switch($states);
            // $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Orders::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
