@extends('admin.adminLayout.admin_design')
@section('content')

<div class="content-wrapper" style="min-height: 1200.88px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $breadcrumb['main_bread'] ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $breadcrumb['forward_bread'] ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?= $breadcrumb['bread'] ?></h3>
                        <td class="project-actions text-right">
                            <a class="btn btn-block btn-success" style="max-width: 150px; float:right; inline:block;" href="<?=$breadcrumb['button_add_link'] ?>">
                                <i class="fas fa-plus"></i>
                                <?=$breadcrumb['button_add']?>
                            </a>
                        </td>
                        
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-1">
                            <!-- <div class="form-group col-md-3"> -->
                                <label>Year</label>
                                <select class="form-control" name="groupByYear" id="groupByYear">
                                    <option value="">Any year</option>
                                    <option value="2022">2022</option>
                                </select>
                            <!-- </div> -->
                            
                        </div>
                        <div class="col-1.5">
                            <label>Month</label>
                            <select class="form-control" name="groupByMonth" id="groupByMonth">
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
                            <select class="form-control" name="groupByLanguage" id="groupByLanguage">
                                <option value="">Any language</option>
                                <?php foreach ($languages as $language) { ?>
                                    <option value="{{$language->id}}">{{ $language->name_english }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-2">
                            <label>Category</label>
                            <select class="form-control" name="groupByCategory" id="groupByCategory">
                                <option value="">Any Category</option>
                                <?php foreach ($articleCategoriesData as $category) { ?>
                                    <option value="{{$category->id}}">{{ $category->name_english }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <table id="products" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Publish Date</th>
                                        <th>Visibility status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($articles as $article)
                                    <tr>
                                        <td>{{ $article->id }}</td>
                                        <td>
                                            <img src="{{ $article->image_path  }}" style="width:100px; margin-top: 10px">
                                        </td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->created_at }}</td>
                                        <td class="project-state">
                                            @if($article->visibility_status==1)
                                            <a class="updateBlogStatus" blog_id="{{ $article->id }}" href="javascript:void(0)" data-status="{{$article->visibility_status}}">
                                                <span class="badge badge-success" id="blog-{{ $article->id }}">Visible</span>
                                            </a>
                                            @else
                                            <a class="updateBlogStatus" id="blog-{{ $article->id }}" blog_id="{{ $article->id }}" href="javascript:void(0)"  data-status="{{$article->visibility_status}}">
                                                <span class="badge badge-danger" id="blog-{{ $article->id }}">Not Visible</span>
                                            </a>
                                            @endif
                                        </td>
                                        <td class="project-actions">
                                            <a href="{{ url('admin/add-edit-article/'.$article->id) }}" title="Edit articles" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a title="Delete Articles" href="javascript:void(0)" class="comfirmDelete btn btn-danger btn-sm" record="article" recordid="{{ $article->id }}" <?php /* href="{{ url('admin/delete-blog/'.$article->id) }}" */ ?>>
                                                <i class="fas fa-trash">
                                                </i>
                                                <?/*=$breadcrumb['button_delete']*/ ?>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Publish Date</th>
                                        <th>Visibility status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div> -->

                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4" class="dataTables_wrapper dt-bootstrap4">
                            <table id='empTable' width='100%' border="1" style='border-collapse: collapse;' class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold">ID</th>
                                        <th class="font-weight-bold">Image</th>
                                        <th class="font-weight-bold">Title</th>
                                        <th class="font-weight-bold">Publish Date</th>
                                        <th class="font-weight-bold">Visibility status</th>
                                        <th class="disabled-sorting font-weight-bold">Actions</th>
                                    </tr>
                                </thead>
                                
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Publish Date</th>
                                        <th>Visibility status</th>
                                        <th class="disabled-sorting">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts') 
<script type="text/javascript">
$(document).ready(function() {
    
    // DataTable
    var table =  $('#empTable').DataTable({
        "lengthMenu": [
            [10,50, 100, 150, 5],
            [10,50, 100, 150, 5],
        ],
        "pagingType": "full_numbers",
        responsive: true,
        serverSide: true,
        ordering: true,
        processing: true,
        // ajax: "{{ route('get-articles') }}",
        ajax: {
            url: "{{ route('get-articles') }}",
            type: "POST",
            // data: {
            //     "_token": "{{ csrf_token() }}",
            //     "groupByYear": $('#groupByYear').val(),
            // },
            "data": function (d) {
                d._token = "{{ csrf_token() }}";
                d.groupByYear = $('#groupByYear').val();
                d.groupByMonth = $('#groupByMonth').val();
                d.groupByLanguage = $('#groupByLanguage').val();
                d.groupByCategory = $('#groupByCategory').val();
            },
            error: function () {
                $(".datagrid-error").html("");
                //$("#datagrid").append('<tbody class="datagrid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#datagrid_processing").css("display", "none");
            },
        },
        columns: [
            { data: 'id' },
            { data: 'image_path' },
            { data: 'title' },
            { data: 'publish_date' },
            { data: 'visibility_status' },
            { data: 'action' }
        ]
    });
    
    $("#groupByYear, #groupByMonth, #groupByLanguage, #groupByCategory").change(function() {
        table.ajax.reload();
    });
});
</script>
@endsection