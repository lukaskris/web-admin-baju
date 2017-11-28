<?php

namespace App\Admin\Controllers;

use App\Models\Item;
use App\Models\Category;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Google\Cloud\ServiceBuilder;

class ItemController extends Controller
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

            $content->header('Item');
            $content->description('Segala produk');

            $content->body($this->grid());

            // # Your Google Cloud Platform project ID
            // $projectId = 'utility-time-161403';
            // $path = base_path('/houseofdesign-100ea7bbbf63.json');
            // // $key = 'AIzaSyDHWja8f4G2CdHSsfqgPmzIyKxTPR8RolQ';

            // // putenv('GOOGLE_APPLICATION_CREDENTIALS='.$path);

            // $gcloud = new ServiceBuilder([
            //     'keyFilePath' => $path,
            //     'projectId' => $projectId
            // ]);

            // echo $path;
            // # Instantiates a client
            // // $storage = new StorageClient([
            // //     'projectId' => $projectId
            // // ]);
            // $storage = $gcloud->storage();
            // // $storage->useApplicationDefaultCredentials();

            // $bucket = $storage->bucket('houseofdesign');
            // # The name for the new bucket
            // $bucketName = 'houseofdesign1';

            // # Creates the new bucket
            // $bucket = $storage->createBucket($bucketName);

            // echo 'Bucket ' . $bucket->name() . ' created.';
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

            $content->header('Item');
            $content->description('Edit Item');

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
        return Admin::grid(Item::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->thumbnail()->image();
            $grid->name();
            $grid->price();
            $grid->category()->name('Category');
            $grid->description();
            // $grid->created_at();
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
        return Admin::form(Item::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', 'Item name')->rules('required|min:5');
            $form->currency('price', 'Price')->symbol('Rp')->rules('required');
            $form->number('weight','Weight (gram)')->rules('required');
            $category = Category::select('id','name')->get();
            $data = [];
            foreach($category as $c){
                $data[$c->id] = $c->name;
            }

            $form->select('category_id', 'Category')->options($data)->rules('required');
            $form->textarea('description','Description')->rows(10);
            $form->image('thumbnail')->name(function($file){
                return md5(date('ymdhis').$file->getClientOriginalName()) .'_thumbnail'. '.' . $file->getClientOriginalExtension();
            });
            $form->multipleImage('images','Images')->name(function($file){
                return md5(date('ymdhis'). $file->getClientOriginalName()). '.' . $file->getClientOriginalExtension();
            });
            $form->hasMany('subitems',function (Form\NestedForm $form){
                $form->text('color')->rules('required');
                $form->text('size')->rules('required|max:3');
                $form->number('quantity')->rules('required');
            });
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

}
