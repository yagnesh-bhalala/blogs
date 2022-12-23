@extends('admin.adminLayout.admin_design')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $breadcrumb['main_bread'] }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Home</a></li>
              <li class="breadcrumb-item active">{{ $breadcrumb['forward_bread'] }}</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      @if($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form method="POST" @if(empty($articleData->id)) action="{{ $form['form_add_action'] }}" @else action="{{ $form['form_edit_action'] }}" @endif name="{{ $form['form_name'] }}" id="{{ $form['form_id'] }}" enctype="multipart/form-data">
        @csrf
          <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{ $breadcrumb['bread'] }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">

                  <div div class="form-group">
                    <label>Visibility Status</label>
                    <select name="visibility_status" id="visibility_status" class="form-control" style="width: 100%;">
                        @foreach($statusArray as $k=> $status)
                          <option value="{{ $k }}" @if(!empty($articleData->status) && $articleData->status == $k)  selected @endif >{{ $status }}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="requiredStar">Publish Date</label>
                    <input type="date" class="form-control" id="publish_date" name="publish_date" value="<?php echo isset($articleData->publish_date)? date('Y-m-d', strtotime($articleData->publish_date)) :old('publish_date')?>">
                  </div>

                  <div class="form-group">
                      <label for="inputName" class="requiredStar">Author name</label>
                      <input class="form-control" id="author_name" name="author_name" @if(!empty($articleData->author_name)) value="{{ $articleData->author_name }}" @else value="{{ old('author_name') }}" @endif placeholder="Author name, City, State">
                  </div>

                  <div class="form-group">
                      <label for="inputName" class="requiredStar">Title</label>
                      <input class="form-control" onkeyup="convertToSlug(this.value)" id="title" name="title" @if(!empty($articleData->title)) value="{{ $articleData->title }}" @else value="{{ old('title') }}" @endif placeholder="Enter Title">
                  </div>

                  <div div class="form-group">
                    <label>Category</label>
                    <select name="article_categories_id" id="article_categories_id" class="form-control select2_categories" style="width: 100%;">
                        @foreach($articleCategoriesData as $k=> $category)
                          <option value="{{ $category->id }}" @if(!empty($articleData->article_categories_id) && $articleData->article_categories_id == $category->id)  selected @endif >{{ $category->name_english }}</option>
                        @endforeach
                    </select>
                  </div>

                  <div div class="form-group">
                    <label>Languages</label>
                    <select name="languages_id" id="languages_id" class="form-control select2_languages" style="width: 100%;">
                        @foreach($languagesData as $k=> $language)
                          <option value="{{ $language->id }}" @if(!empty($articleData->languages_id) && $articleData->languages_id == $language->id)  selected @endif >{{ $language->name_english }}</option>
                        @endforeach
                    </select>
                  </div>                  
                
                  <div class="form-group">
                    <label for="exampleInputFile">Blog Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                          <input type="file" class="custom-file-input" id="image_path" name="image_path">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                      <?php  if(isset($articleData->thumbImage)) { ?>
                        <div class="form-group">
                            <a href="" target="_blank">
                                <img id="imagePreview" src="<?php echo isset($articleData->thumbImage)?$articleData->thumbImage:"" ?>" style="width:100px; margin-top: 15px"/>
                            </a>
                        </div> 
                        <?php } else {
                        ?>
                            <div class="form-group">
                                    <img class="d-none" id="imagePreview" src="<?php echo isset($articleData->thumbImage)?$articleData->thumbImage:"" ?>" style="width:100px; margin-top: 15px" />
                            </div>
                        <?php
                      } ?>
                  </div>

                </div>

                <div class="col-md-6">

                  <div class="form-group">
                      <label for="inputName" class="requiredStar">Body text</label>
                      <textarea class="form-control" id="id-ckeditor" name="body_text">@if(!empty($articleData->body_text)) {{ $articleData->body_text}} @else {{ old('body_text') }} @endif</textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputName" class="requiredStar">Meta Title</label>
                    <input class="form-control" id="meta_title" name="meta_title" @if(!empty($articleData->meta_title)) value="{{ $articleData->meta_title }}" @else value="{{ old('meta_title') }}" @endif placeholder="Enter Meta Title">
                  </div>
                  <div class="form-group">
                      <label for="inputName" class="requiredStar">Slug</label>
                      <input class="form-control" onkeyup="convertToSlug(this.value)" id="slug" name="slug" @if(!empty($articleData->slug)) value="{{ $articleData->slug }}" @else value="{{ old('slug') }}" @endif placeholder="Enter Slug">
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="requiredStar">Meta Keyword</label>
                    <input class="form-control" id="meta_keyword" name="meta_keyword" @if(!empty($articleData->meta_keyword)) value="{{ $articleData->meta_keyword }}" @else value="{{ old('meta_keyword') }}" @endif placeholder="Enter Meta Keyword">
                  </div>
                  <div class="form-group">
                      <label for="inputName" class="requiredStar">Meta Description</label>
                      <textarea class="form-control" id="meta_description" name="meta_description">@if(!empty($articleData->meta_description)) {{ $articleData->meta_description }} @else {{ old('meta_description') }} @endif</textarea>                      
                  </div>
                  
                </div>
              </div>
              <div class="card-footer">
                  <button type="submit" class="btn btn-primary">{{ $breadcrumb['button_add'] }}</button>
              </div>
            </div>
          </div>
        </form> 
      </div>
    </section>
  </div>

@endsection

@section('scripts')
  <script src="{{ url('public/ckeditor/ckeditor.js') }}"></script>
  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        if (!input.files[0].type.match('image.*')) {return true; }
        else{                            
          reader.onload = function(e) {
            $('#imagePreview').removeClass("d-none");
            $('#imagePreview').attr("src", e.target.result );  
          }
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#image_path").change(function() {  
        readURL(this);
    });
    CKEDITOR.replace('id-ckeditor');

    //Initialize Select2 Elements
    $('.select2_categories').select2();
    $('.select2_languages').select2();
  </script>

<script>
    function convertToSlug( str ) {	  
      //replace all special characters | symbols with a space
      str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
      
      // trim spaces at start and end of string
      str = str.replace(/^\s+|\s+$/gm,'');
      
      // replace space with dash/hyphen
      str = str.replace(/\s+/g, '-');	
      document.getElementById("slug").value= str;
      $("#slug").trigger("blur");
      //return str;
    }
</script>
@endsection

@section('stylesheets')
<style>
    .requiredStar:after{ 
        content:'*'; 
        color:red; 
        padding-left:5px;
    }
</style>
@endsection
