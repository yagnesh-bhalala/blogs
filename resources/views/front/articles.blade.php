@extends('front.frontLayout.front_design')

@section('content')

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
    <div class="text_on_img col-xl-12 col-lg-12 col-md-12 d-flex justify-content-end align-items-center flex-wrap pt-5 px-0">
        <div class="col-xl-5 col-lg-6 col-md-6 ">            
            <div class="img_bg_about text-center">
                <img src="{{ url('public/frontend/image/blog_text.png') }}" class="img-fluid">
                <div class="absolute_text">
                    <h4>blog page banner Text goes here</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 pr-0">
            <div class="img_right_side">
                <img src="{{ url('public/frontend/image/blog_main_img.png') }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<!-- /header -->

<section>
    <div class="container">

        <!-- ------------------- filter sectiion goes  ---------------------->
        <div class="row">
            <div class="col-1.5">
                <!-- <div class="form-group col-md-3"> -->
                    <label>Year</label>
                    <select class="form-control" name="groupByYear" id="groupByYear" onchange="loadBlog()">
                        <option value="">Any year</option>
                        <option value="2022">2022</option>
                    </select>
                <!-- </div> -->
                
            </div>
            <div class="col-2">
                <label>Month</label>
                <select class="form-control" name="groupByMonth" id="groupByMonth" onchange="loadBlog()">
                    <option value="">Any month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="11">October</option>
                    <option value="10">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <div class="col-2">
                <label>Language</label>
                <select class="form-control" name="groupByLanguage" id="groupByLanguage" onchange="loadBlog()">
                    <option value="">Any language</option>
                    <?php foreach ($languages as $language) { ?>
                        <option value="{{$language->id}}">{{ $language->name_english }}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-2">
                <label>Category</label>
                <select class="form-control" name="groupByCategory" id="groupByCategory" onchange="loadBlog()">
                    <option value="">Any Category</option>
                    <?php foreach ($articleCategoriesData as $category) { ?>
                        <option value="{{$category->id}}">{{ $category->name_english }}</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- ------------------- end filter sectiion goes  ---------------------->
        
        <div class="row" id="latestBlog">
        </div>
        <div class="col-12 mt-2 d-flex justify-content-center">
            <div class="">
                <div class="loader blogloader mb-5">Loading...</div>
                <div class="event more p-3 loadmore showmoreblog" onclick="loadBlog()">
                    <button class="load_more">Load more</button>        
                </div>
            </div>
        </div> 
    </div>          

   
</section>

@endsection
@section('scripts')
<script>
    console.log('called');
function extractContent(s) {
    var span = document.createElement('span');
    span.innerHTML = s;
    return span.textContent || span.innerText;
};
 var pageLimit = 1;

    loadBlog();
    function loadBlog(){
        var total_page = 0;
    
        
        var data = new FormData();
        data.append('limit', 6);
        data.append('page', pageLimit);
        var groupByYear = $('#groupByYear').val();
        var groupByMonth = $('#groupByMonth').val();
        var groupByLanguage = $('#groupByLanguage').val();
        var groupByCategory = $('#groupByCategory').val();
        var qs = '?limit=6&page='+pageLimit+'&groupByYear='+groupByYear+'&groupByMonth='+groupByMonth+'&groupByLanguage='+groupByLanguage+'&groupByCategory='+groupByCategory; 
        $(".blogloader").removeClass('d-none');
        console.log('called');
        $.ajax({
            url: "{{ url('getBlogListRequestAjax') }}"+qs,
            type: 'get',
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
                data = data;
                // console.log(data);return false;
            
                if (data.status == 1) {      
                    var totalPageLimit = data.total_page;
                    var blogDataResponse = data.data;
                    blogHtml = "";                
                    for(var i = 0; i < blogDataResponse.length; i++) {
                        var obj = blogDataResponse[i];
                        obj.body_text = extractContent(obj.body_text);
                        blogHtml += `<div class="col-xl-4  col-lg-4 col-md-6 col-12  py-2">\
                                        <a href="{{ url("article-details") }}/`+ obj.slug +`">\
                                            <div class="blog_box">\
                                                <div class="img_main">\
                                                    <img src="`+obj.image_path+`" class="img-fluid">\
                                                </div>\
                                                <div class="detail_of_blog">\
                                                    <h4>`+ obj.title +`</h4>\
                                                    <p>`+ (obj.body_text.length >= 50 ? obj.body_text.substr(0,100)+"..." : obj.body_text) +`</p>\

                                                </div>\
                                                <div class="py-3">\
                                                    <button class="read_more_btn pr-3">Read More <i class="fas fa-chevron-right"></i></button>\
                                                </div>\

                                            </div>\
                                        </a>\
                                    </div>`;                
                    }
                
                    $('#latestBlog').append(blogHtml);
                    $('.noblog').html("Articles found");
                    
                    // AOS.init();
                    if(pageLimit==totalPageLimit){
                        $(".showmoreblog").addClass('d-none');
                    } else {
                        $(".showmoreblog").removeClass('d-none');
                    }
                    pageLimit++;          
                }else if(data.status == 0){
                    $(".showmoreblog").addClass('d-none');                        
                    pageLimit=1; 
                    $('#latestBlog').html('<div class="col-12 noblog text-center mt-4"><h5 >No articles found</h5></div>');
                }else{
                    alert("Something went wrong");
                }
                $(".blogloader").addClass('d-none');
            
            }
        });
    }

</script>
@endsection