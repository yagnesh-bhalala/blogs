<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog as BlogModel;
use Illuminate\Support\Facades\DB;
use App\Models\ArticleCategories_model;
use App\Models\Languages_model;
use App\Models\Articles_model;

class FrontController extends Controller
{
    protected $blogModel;
    protected $articleCategories_model;
    protected $languages_model;
    protected $articles_model;

    function __construct() {
        $this->blogModel = new BlogModel;
        $this->articleCategories_model = new ArticleCategories_model;
        $this->languages_model = new Languages_model;
        $this->articles_model = new Articles_model;
    }
    public function dashboard() {

        $page_title = "Welcome to 5 Dollar Bill Helper | Balance Your Bills and Spending!";
        $meta_description = "Be involved with your finances. 5 Dollar Bill Helper allows you to balance your bills and spending. Download the app and never miss a bill payment.";
        $meta_keywords = "balance billing, bill pay app, bill splitting app, bill tracker app, pay bills with credit card, best bill tracker app, bill organizer app, bill management app, bill reminder app, app to keep track of bills, bill reminder, best bill reminder app, bill pay reminder app, App to keep track of bills due, app to keep track of bills due, free bill tracker app, mobile billing app, top bill tracking apps, best bill tracker app for iphone, best billing app, billing app for android, best app to track bills and spending, free app to keep track of bills due, Monthly bill Organizer app, bill reminder app free, apps to balance your bills, bill balance app";
        $link_rel = "https://5dollarbillhelper.com/";
        $og_title = "Welcome to 5 Dollar Bill Helper | Balance Your Bills and Spending!";
        $og_description = "Be involved with your finances. 5 Dollar Bill Helper allows you to balance your bills and spending. Download the app and never miss a bill payment.";
        $og_image = "https://5dollarbillhelper.com/public/frontend/image/footer_logo.png";

        $twitter_title = "Welcome to 5 Dollar Bill Helper | Balance Your Bills and Spending!";
        $twitter_description = "Be involved with your finances. 5 Dollar Bill Helper allows you to balance your bills and spending. Download the app and never miss a bill payment.";
        $twitter_image = "https://5dollarbillhelper.com/public/frontend/image/footer_logo.png";

        return view ('front.front_dashboard',['page_title' => $page_title, 'meta_description' => $meta_description, 'meta_keywords' => $meta_keywords, 'link_rel' =>$link_rel, 'og_title' => $og_title, 'og_description' => $og_description, 'og_image' => $og_image, 'twitter_title' => $twitter_title, 'twitter_description' => $twitter_description, 'twitter_image' => $twitter_image]);
    }
   
    public function blogs(Request $request) {
        $page_title = "Blogs";
        $meta_description = "Read latest articles & blogs";
        $meta_keywords = "";
        $link_rel = "";
        $og_title = "Blogs";
        $og_description = "Read latest articles & blogs";
        $og_image = "";

        $twitter_title = "Blogs";
        $twitter_description = "Read latest articles & blogs";
        $twitter_image = "";

        $languagesData = $this->languages_model->getData(['deleted_at_null' => true]);
        $articleCategoriesData = $this->articleCategories_model->getData(['deleted_at_null' => true]);

        return view ('front.articles',[
            'page_title' => $page_title, 
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'link_rel' =>$link_rel,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_image' => $og_image,
            'twitter_title' => $twitter_title,
            'twitter_description' => $twitter_description,
            'twitter_image' => $twitter_image,
            'languages' => $languagesData,
            'articleCategoriesData' => $articleCategoriesData,
        ]);
    }

    public function articles(Request $request) {
        $page_title = "Blogs";
        $meta_description = "Read latest articles & blogs";
        $meta_keywords = "";
        $link_rel = "";
        $og_title = "Blogs";
        $og_description = "Read latest articles & blogs";
        $og_image = "";

        $twitter_title = "Blogs";
        $twitter_description = "Read latest articles & blogs";
        $twitter_image = "";

        $languagesData = $this->languages_model->getData(['deleted_at_null' => true]);
        $articleCategoriesData = $this->articleCategories_model->getData(['deleted_at_null' => true]);

        return view ('front.articles',[
            'page_title' => $page_title, 
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'link_rel' =>$link_rel,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_image' => $og_image,
            'twitter_title' => $twitter_title,
            'twitter_description' => $twitter_description,
            'twitter_image' => $twitter_image,
            'languages' => $languagesData,
            'articleCategoriesData' => $articleCategoriesData,
        ]);
    }

    public function articleDetails(Request $request) {
        $slug = $request->segment(2);
        $page_title = "Blogs ";
        $meta_description = "Read latest articles";
        $meta_keywords = "app";
        $link_rel = "";
        $og_title = "Blogs";
        $og_description = "Read latest articles & blogs and download ";
        $og_image = "";

        $twitter_title = "Blogs";
        $twitter_description = "Read latest articles";
        $twitter_image = "";
        $response = $this->articles_model->getData(['visibility_status' => 1,'deleted_at_null' => true,'slug'=>trim($slug)],true);        
        if(empty($response)){
            return redirect('articles')->with('error_message',"Blog detail not found!!!");
        }

        return view ('front.article_details',[
            'page_title' => $response->title,
            'meta_description' => $response->meta_description,
            'meta_keywords' => $response->meta_keyword,
            'link_rel' =>url('blog-details/'.$response->slug),

            'og_title' => $response->title,
            'og_description' => $response->meta_description,
            'og_image' => $response->image_path,
            'twitter_title' => $response->title, 
            'twitter_description' => $response->meta_description, 
            'twitter_image' => $response->image_path,
            'articleDetail' => $response,
        ]);
    }

    public function getBlogListRequest(Request $request) {
        $data = $request->all();
        $page_number = (isset($data['page']) && $data['page'] != '') ? $data['page'] : '1';
        $limit = (isset($data['limit']) && $data['limit'] != '') ? $data['limit'] : 50;
        if (isset($data['page']) && $data['page'] == 1) {
            $offset = 0;
        } else {
            if (isset($data['page']) && $data['page'] != '1') {
                $offset = ($page_number * $limit) - $limit;
            } else {
                $offset = 0;
            }
        }

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

        $query['visibility_status'] = 1;
        $query['deleted_at_null'] = true;
        $blog = $this->articles_model->getData(array_merge($query,array('limit'=> $limit,'offset'=>$offset)));
        $totalData = count($this->articles_model->getData($query));
        
        $response['status'] =  $totalData==0 ? 0 : 1;
        $response['total_page'] =  ceil($totalData / $limit);
        $response['data'] =  $blog;

        echo json_encode($response);
        exit;
    }
    

    public function blogDetails(Request $request) {
        $slug = $request->segment(2);
        $page_title = "Blogs | Balance Your Bills, Balance Your Life! | 5$ Bill Helper";
        $meta_description = "Read latest articles & blogs and download the best bill tracker mobile app available in multiple languages for Android and IOS devices.";
        $meta_keywords = "balance billing, bill pay app, bill splitting app, bill tracker app, pay bills with credit card, best bill tracker app, bill organizer app, bill management app, bill reminder app, app to keep track of bills, bill reminder, best bill reminder app, bill pay reminder app, App to keep track of bills due, app to keep track of bills due, free bill tracker app, mobile billing app, top bill tracking apps, best bill tracker app for iphone, best billing app, billing app for android, best app to track bills and spending, free app to keep track of bills due, Monthly bill Organizer app, bill reminder app free, apps to balance your bills, bill balance app";
        $link_rel = "https://5dollarbillhelper.com/blogs";
        $og_title = "Blogs | Balance Your Bills, Balance Your Life! | 5$ Bill Helper";
        $og_description = "Read latest articles & blogs and download the best bill tracker mobile app available in multiple languages for Android and IOS devices.";
        $og_image = "https://5dollarbillhelper.com/public/frontend/image/side_img.png";

        $twitter_title = "Blogs | Balance Your Bills, Balance Your Life! | 5$ Bill Helper";
        $twitter_description = "Read latest articles & blogs and download the best bill tracker mobile app available in multiple languages for Android and IOS devices.";
        $twitter_image = "https://5dollarbillhelper.com/public/frontend/image/side_img.png";

        $response = $this->blogModel->getData(['status'=>1,'slug'=>trim($slug)],true);
        
        if(empty($response)){
            return redirect('blogs')->with('error_message',"Blog detail not found!!!");
        }

        return view ('front.blog_details',[
                // 'page_title' => $page_title, 
                'page_title' => $response->title,
                // 'meta_description' => $meta_description, 
                'meta_description' => $response->metadescription,
                // 'meta_keywords' => $meta_keywords, 
                'meta_keywords' => $response->metakeyword,
                // 'link_rel' =>$link_rel, 
                'link_rel' =>url('blog-details/'.$response->slug),

                // 'og_title' => $og_title,
                'og_title' => $response->title,
                // 'og_description' => $og_description,
                'og_description' => $response->metadescription,
                // 'og_image' => $og_image,
                'og_image' => $response->image,
                // 'twitter_title' => $twitter_title, 
                'twitter_title' => $response->title, 
                // 'twitter_description' => $twitter_description, 
                'twitter_description' => $response->metadescription, 
                // 'twitter_image' => $twitter_image,
                'twitter_image' => $response->image,
                'blogDetail' => $response
            ]);
    }



}