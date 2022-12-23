<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Articles_model;
use App\Models\ArticleCategories_model;
use App\Models\Languages_model;
use Auth;

class ArticlesController extends Controller
{
    protected $articles_model;
    protected $articleCategories_model;
    protected $languages_model;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    function __construct() {
        $this->articles_model = new Articles_model;
        $this->articleCategories_model = new ArticleCategories_model;
        $this->languages_model = new Languages_model;
    }

    //Blog
    public function ___getArticles(Request $request) {
        Session::put('page','article');
        $breadcrumb = array(
            'main_bread' => "Articles",
            'forward_bread' => "Articles",
            'bread' => "View Articles",
            'bread_link' => '/admin/get-articles',
            'button_add' => "Add Articles",
            'button_add_link' => url('admin/add-edit-article'),
            'page' => ['headTitle' => 'Articles']
        );
        $articles = $this->articles_model->getData(['visibility_status' => [0,1],'deleted_at_null' => true]);

        if($request->ajax()){
            echo json_decode($articles); exit;
        }
        return view('admin.articles.get_articles', [
            'breadcrumb' => $breadcrumb, 'articles' => $articles
        ]);

    }

    public function getArticles(Request $request)
    {
        if($request->ajax()){

            $paggination['offset'] = isset($request['start'])?$request['start']:"0";
            if($request['length'] != '-1' && isset($request['length'])) {
                $paggination['limit'] =  isset($request['length']) ? $request['length'] : "10";
            }
            $query['search'] = (isset($request['search']['value']) ? $request['search']['value'] : "");
            $query['visibility_status'] = [0,1];
            $query['deleted_at_null'] = true;
            if (isset($request['groupByYear']) && !empty($request['groupByYear'])) {
                $query['groupByYear'] = $request['groupByYear'];
            }
            if (isset($request['groupByMonth']) && !empty($request['groupByMonth'])) {
                $query['groupByMonth'] = $request['groupByMonth'];
            }
            if (isset($request['groupByLanguage']) && !empty($request['groupByLanguage'])) {
                $query['languages_id'] = $request['groupByLanguage'];
            }
            if (isset($request['groupByCategory']) && !empty($request['groupByCategory'])) {
                $query['article_categories_id'] = $request['groupByCategory'];
            }

            $resultData =  $this->articles_model->getData(array_merge($paggination, $query));
            $totalData =  $this->articles_model->getData($query, false, true);
            $result = [];
            $result['data'] = [];
            $data_arr = [];
            foreach ($resultData as $key => $value) {
                $data_arr[] = [                    
                    "id"            => $value->id,
                    "image_path"   =>  '<img src="'. $value->image_path.'" style="width:100px; margin-top: 10px">',
                    "title"  => $value->title,                    
                    "publish_date"  => $value->publish_date,
                    "visibility_status" => ($value->visibility_status==1) ? "<span class='badge badge-success'>Visible</span>" :"<span class='badge badge-danger'>Not Visible</span>",
                    "action"            => '
                        <a href="' . route('add-edit-article', $value->id) . '" title="Edit articles" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="' . route('delete-article', $value->id) . '" class="btn btn-round btn-icon btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></a> ',                
                ];
            }

            $response = [
                "draw" => intval($request->get('draw')),
                "iTotalRecords" => !empty($totalData) ? $totalData : 0,
                "iTotalDisplayRecords" => !empty($totalData) ? $totalData : 0,
                "aaData" => $data_arr
            ];

            echo json_encode($response); exit;
        } else {
            Session::put('page','article');
            $breadcrumb = array(
                'main_bread' => "Articles",
                'forward_bread' => "Articles",
                'bread' => "View Articles",
                'bread_link' => '/admin/get-articles',
                'button_add' => "Add Articles",
                'button_add_link' => url('admin/add-edit-article'),
                'page' => ['headTitle' => 'Articles']
            );
            $articles = $this->articles_model->getData(['visibility_status' => [0,1],'deleted_at_null' => true]);
            $languagesData = $this->languages_model->getData(['deleted_at_null' => true]);
            $articleCategoriesData = $this->articleCategories_model->getData(['deleted_at_null' => true]);
            return view('admin.articles.get_articles', [
                'breadcrumb' => $breadcrumb, 'articles' => $articles,
                'languages' => $languagesData,
                'articleCategoriesData' => $articleCategoriesData,
            ]);
        }

    }

    public function addEditArticle(Request $request, $id=null) {
        $breadcrumb = [
            'main_bread' => "Article",
            'forward_bread' => "Add Article",
            'bread' => "Add article",
            'bread_link' => '/admin/add-edit-article',
            'button_add' => "Add article",
            'button_view_link' => '/admin/get-articles',
            'button_add_link' => '/admin/add-edit-article',
            'page' => ['headTitle' => 'Add article'],
        ];
        $form = [
            'form_method' => 'post',
            'form_add_action' => url('/admin/add-edit-article'),
            'form_name' => 'articleForm',
            'form_id' => 'articleForm',
        ];
        $statusArray = [ '1' => 'Visible', '0' =>  'Not Visible'];
        if ($id== null) {
            $articleData = [];
            $message = "Article added successfully!!!!";
        } else {
            $breadcrumb['forward_bread'] = "Edit Article";
            $breadcrumb['bread'] =  "Edit Article";
            $breadcrumb['bread_link'] = '/admin/add-edit-article/{id?} ';
            $breadcrumb['button_add'] =  "Edit Article";
            $breadcrumb['button_add_link'] =  "/admin/add-edit-article/{id?}";
            $breadcrumb['page'] = ['headTitle' => 'Edit Article'];
            $articleData = $this->articles_model->getData(['id' =>$id],true);
            $message = "Blog updated successfully!!!!";
            $form = [
                'form_method' => 'post',
                'form_edit_action' => url('/admin/add-edit-article/' .$articleData->id),
                'form_name' => 'articleForm',
                'form_id' => 'articleForm',
            ];
        }
        if($request->isMethod('post')) {
            // echo "<pre>"; print_r($request->all()); die;
            
            $this->validate($request,[
                'publish_date'          => 'required',
                'visibility_status'     => 'required',
                'publish_date'          => 'required|date_format:Y-m-d',
                'author_name'           => 'required|min:3|max:255',
                'meta_title'            => 'required|min:3|max:255',
                'meta_keyword'          => 'required|min:3|max:255',
                'meta_description'      => 'required|min:3|max:255',
                'slug'                  => 'required|min:3|max:255',
                'article_categories_id' => 'required',
                'languages_id'          => 'required',
                'image_path'            => 'mimes:jpeg,jpg,png,gif|max:10000',
                'title'                 => 'required|min:3|max:255',
                'body_text'             => 'required|min:3',                
            ]);

            $data = $request->all();
            if (isset($data['createdDate']) && !empty($data['createdDate'])) {
                $data['createdDate'] = strtotime($data['createdDate']);
            }

            //image upload
            $upload_path = env('UPLOADPATH');
            $allowed_types = array("jpg", "png", "jpeg","webp");          
            if ($request->hasFile('image_path')) {
                $image_path   = $request->image_path;
                $fileExt = $image_path->getClientOriginalExtension();
                if (in_array($fileExt, $allowed_types)) {
                    $fileName = date('ymdhis') . rand(000000,999999) . '.'.$fileExt;
                    $image_path->move(public_path('uploads'),$fileName);
                    $data['image_path'] = $fileName;
                } else {
                    session::flash('error', 'Allowed only image file.');                    
                }
            }
            //image upload
            if($id=="") { 
                $data['created_by_user_id'] = Auth::user()->id;
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->articles_model->setData($data);
            } else {
                $data['updated_by_user_id'] = Auth::user()->id;
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->articles_model->setData($data, $id);
            }
            session::flash('success_message',$message);

            return redirect('admin/get-articles');
        }
        $articleCategoriesData = $this->articleCategories_model->getData(['deleted_at_null' => true]);
        $languagesData = $this->languages_model->getData(['deleted_at_null' => true]);
        

        return view('admin.articles.add_edit_article')->with(compact('breadcrumb','form','articleData','statusArray','articleCategoriesData','languagesData'));
    }

    public function updateBlogStatus(Request $request, $id=null)
    {
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="1"){
                $status = 0;
            }else{
                $status = 1;
            }
            $this->blogModel->setData([
                'status'=> $status,
            ], $data['blog_id']);
            return response()->json(['status'=>$status,'blog_id'=>$data['blog_id']]);
        }
    }

    public function deleteArticle($id = null) {
        if (!empty($id)) {
            Articles_model::destroy($id);
            return redirect()->back()->with('success_message', 'Article deleted Successfully!');
        }
    }

    
}
