@extends('front.frontLayout.front_design')

@section('content')
<style>
    .img_blog img {
        /* max-width: 380px; */
        height: auto;
        border-radius: 7px;
        max-width: 100%;
    }
</style>
<!-- header -->

<!-- <div class="blogBgImage">
    <img src="<?= $articleDetail->image_path; ?>" alt="">
</div> -->
<div class="main_header_Section about_us_main">
    <div class="container">
        <header class="navigation_sec_head">
            <div class="col-xl-12 d-flex justify-content-end pt-3">
                <div class="side_drop_down_top black_drop">
                    
                
                </div>
            </div>
            @include('front.frontLayout.front_header')
        </header>
    </div>
    <div class="text_on_img col-xl-9 col-lg-11 col-md-12 col-12 text-center mx-auto pt-5">
        <div class="title_blog_detail">
            <h4><?= $articleDetail->title; ?></h4>
        </div>
    </div>
</div>
<!-- /header -->

<!-- <div class="bg_round" style="margin-top:35rem"> -->
        <div class="conatainer">
            <div class="">
                <div class="col-xl-12">
                    <div class="col-xl-9 col-lg-11 col-md-12 col-12 d-flex justify-content-center mx-auto flex-wrap pt-3">
                        <div class="col-xl-12 col-lg-8 col-md-8 col-12 pl-0">
                            <div class="img_blog img_blog_detail text-right">
                                <img src="<?= $articleDetail->image_path; ?>" class="img-fluid">
                            </div> 
                            <div class="detail_blog">
                                <h4><?= $articleDetail->title; ?></h4>
                                <p><?= $articleDetail->body_text; ?></p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-12 pr-0 ">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
<!-- </div> -->

@endsection