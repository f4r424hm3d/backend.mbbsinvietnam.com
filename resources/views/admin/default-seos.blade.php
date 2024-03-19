@php
  $seg3 = Request::segment(3)??null;
@endphp
@extends('admin.layouts.main')
@push('title')
<title>{{ $page_title }}</title>
@endpush
@section('main-section')
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0 font-size-18">{{ $page_title }}</h4>

          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="{{ url('/admin/') }}"><i class="mdi mdi-home-outline"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
            </ol>
          </div>

        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12">
        <!-- NOTIFICATION FIELD START -->
        <x-ResultNotificationField></x-ResultNotificationField>
        <!-- NOTIFICATION FIELD END -->
      </div>
    </div>
    @if ($seg3 == 'add' || $ft=='edit')
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">
              {{ $title }} Record
              <span style="float:right;">
                <button class="btn btn-xs btn-info tglBtn">+</button>
                <button class="btn btn-xs btn-info tglBtn hide-this">-</button>
              </span>
            </h4>
          </div>
          <div class="card-body  {{ $ft=='edit'?'':'hide-this' }}" id="tblCDiv">
            <form action="{{ $url }}/" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
              @csrf
              <div class="row">
                <div class="col-md-4 col-sm-12 mb-3">
                  <x-InputField type="text" label="Enter Page Name" name="url" id="url" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-5 col-sm-12 mb-3">
                  <x-InputField type="text" label="Enter Title" name="title" id="title" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-3 col-sm-12 mb-3">
                  <x-InputField type="text" label="Enter Page Content" name="page_content" id="page_content" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                  <x-InputField type="text" label="Enter Keyword" name="keyword" id="keyword" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                  <x-TextareaField label="Enter Description" name="description" id="description" :ft="$ft" :sd="$sd"></x-TextareaField>
                </div>
              </div>
              @if ($ft == 'add')
                <button type="reset" class="btn btn-sm btn-warning  mr-1"><i class="ti-trash"></i> Reset</button>
              @endif
              @if ($ft == 'edit')
                <a href="{{ aurl($page_route) }}" class="btn btn-sm btn-info "><i class="ti-trash"></i> Cancel</a>
              @endif
              <button class="btn btn-sm btn-primary" type="submit">Submit</button>
            </form>
          </div>
        </div>
        <!-- end card -->
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">
              {{ $page_title }} List
            </h4>
          </div>
          <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsiv nowra w-100">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Page</th>
                  <th>Title</th>
                  <th>Keyword</th>
                  <th>Description</th>
                  <th>Page Content</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                $i = 1;
                @endphp
                @foreach ($rows as $row)
                <tr id="row{{ $row->id }}">
                  <td>{{ $i }}</td>
                  <td><?php echo $row->url; ?></td>
                  <td><?php echo $row->title; ?></td>
                  <td><?php echo $row->keyword; ?></td>
                  <td><?php echo $row->description; ?></td>
                  <td><?php echo $row->page_content; ?></td>
                  <td>
                    <a href="{{ url('admin/'.$page_route.'/update/' . $row->id) }}"
                      class="waves-effect waves-light btn btn-xs btn-outline btn-info">
                      <i class="fa fa-edit" aria-hidden="true"></i>
                    </a>
                  </td>
                </tr>
                @php
                $i++;
                @endphp
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#name').change(function() {
      var val = $('#name').val();
      if (val != '') {
        $.ajax({
          url: "{{ url('common/slugify/') }}",
          method: "GET",
          data: {
            val: val,
          },
          success: function(data) {
            $('#slug').val(data);
          }
        });
      }
    });
  });

  function DeleteAjax(id) {
    //alert(id);
    var cd = confirm("Are you sure ?");
    if (cd == true) {
      $.ajax({
        url: "{{ url('admin/'.$page_route.'/delete') }}" + "/" + id,
        success: function(data) {
          if (data == '1') {
            var h = 'Success';
            var msg = 'Record deleted successfully';
            var type = 'success';
            $('#row' + id).remove();
            $('#toastMsg').text(msg);
            $('#liveToast').show();
            showToastr(h, msg, type);
          }
        }
      });
    }
  }

  CKEDITOR.replace("highlights");
  CKEDITOR.replace("experiance");
  CKEDITOR.replace("education");
</script>
@endsection
