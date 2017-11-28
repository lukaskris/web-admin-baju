<?php

namespace App\Admin\Controllers;

use App\Models\Restock;
use App\Models\SubItem;
use App\Models\Item;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Response;
use DB;

class RestockController extends Controller
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
        return Admin::grid(Restock::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->item()->name();
            $grid->subitems()->color();
            $grid->subitems()->size();
            $grid->quantity();
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Restock::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('item_id')->options(
                Item::all()->pluck('name','id')
            )->load('sub_item','/admin/api/subitem');

            $form->select('sub_item')->options(function ($id) {
                return SubItem::options($id);
            })->rules('required');
            $form->number('quantity');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    public function item(Request $request)
    {
        $q = $request->get('q');

        return Item::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    public function subitem(Request $request)
    {
        $q = $request->get('q');
        // return Response::json(SubItem::select('id','size as text' )->where('item_id', $q)->get()->toArray(),200);
        return Response::json(SubItem::select('id', DB::raw("CONCAT(size,' ', color) as text"))->where('item_id', $q)->get()->toArray(),200);
    }
}
