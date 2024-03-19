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
          <div class="card-body {{ $ft=='edit'?'':'hide-this' }}" id="tblCDiv">
            <!-- IMPORT FORM START -->
            {{-- <x-ImportForm :pageRoute="$page_route" fileName="course-specializations"></x-ImportForm>
            <hr> --}}
            <!-- IMPORT FORM END -->
            <form action="{{ $url }}/" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
              @csrf
              <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                  <x-InputField type="text" label="Destination Name" name="page_name" id="page_name" :ft="$ft"
                    :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                  <x-InputField type="text" label="Destination URL" name="slug" id="slug" :ft="$ft" :sd="$sd">
                  </x-InputField>
                </div>
                <div class="col-md-2 col-sm-12 mb-3">
                  <x-SelectField label="Country" name="country" id="country" savev="nicename" showv="nicename"
                    :list="$countries" :ft="$ft" :sd="$sd"></x-SelectField>
                </div>
                <div class="col-md-2 col-sm-12 mb-3">
                  <x-SelectField label="Author" name="author_id" id="author_id" savev="id" showv="name" :list="$users"
                    :ft="$ft" :sd="$sd"></x-SelectField>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <x-InputField type="text" label="Course Duration" name="course_duration" id="course_duration"
                    :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <x-InputField type="text" label="Neet" name="neet" id="neet" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                  <x-InputField type="text" label="English Profiency Exam" name="english_profiency_exam"
                    id="english_profiency_exam" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                  <x-InputField type="text" label="Intake" name="intake" id="intake" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                  <x-InputField type="text" label="Eligibility" name="eligibility" id="eligibility" :ft="$ft" :sd="$sd">
                  </x-InputField>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                  <x-InputField type="text" label="Medium Of Teaching" name="medium_of_teaching" id="medium_of_teaching"
                    :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <x-InputField type="file" label="Upload Image" name="image" id="image" :ft="$ft" :sd="$sd">
                  </x-InputField>
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                  <x-InputField type="file" label="Upload Thumbnail" name="thumbnail" id="thumbnail" :ft="$ft"
                    :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-2 col-sm-12 mb-3">
                  <x-InputField type="text" label="SEO Rating" name="seo_rating" id="seo_rating" :ft="$ft" :sd="$sd">
                  </x-InputField>
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                  <x-TextareaField label="Top Description" name="top_description" id="top_description" :ft="$ft"
                    :sd="$sd"></x-TextareaField>
                </div>
              </div>
              <hr>
              <!--  SEO INPUT FILED COMPONENT  -->
              <x-SeoField :ft="$ft" :sd="$sd"></x-SeoField>
              <!--  SEO INPUT FILED COMPONENT END  -->
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
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ $page_title }} List</h4>
          </div>
          <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsiv nowra w-100">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Page Name</th>
                  <th>Info</th>
                  <th>Author</th>
                  <th>Description</th>
                  <th>Thumbnail</th>
                  <th>Image</th>
                  <th>SEO</th>
                  <th>Status</th>
                  <th>More</th>
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
                  <td>{{ $row->page_name }}</td>
                  <td>
                    Duration : <b>
                      <?php echo $row->course_duration; ?>
                    </b><br>
                    Neet : <b>
                      <?php echo $row->neet; ?>
                    </b><br>
                    IELTS/TOEFL : <b>
                      <?php echo $row->english_profiency_exam; ?>
                    </b><br>
                    Intake : <b>
                      <?php echo $row->intake; ?>
                    </b><br>
                    Eligibility : <b>
                      <?php echo $row->eligibility; ?>
                    </b><br>
                    Meduim : <b>
                      <?php echo $row->medium_of_teaching; ?>
                    </b><br>
                  </td>
                  <td>{{ $row->getAuthor->name??'Null' }}</td>
                  <td>
                    @if ($row->top_description != null)
                    <button type="button" class="btn btn-xs btn-outline-info waves-effect waves-light"
                      data-bs-toggle="modal" data-bs-target="#DesModalScrollable{{ $row->id }}">View</button>
                    <div class="modal fade" id="DesModalScrollable{{ $row->id }}" tabindex="-1" role="dialog"
                      aria-labelledby="DesModalScrollableTitle{{ $row->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="DesModalScrollableTitle{{ $row->id }}">
                              SEO
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            {!! $row->top_description !!}
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @else
                    Null
                    @endif
                  </td>
                  <td><img src="<?php echo asset($row->thumbnail); ?>" height="50" width="50"></td>
                  <td><img src="<?php echo asset($row->image_path); ?>" height="50" width="50"></td>
                  <td>
                    @if ($row->meta_title != null)
                    <button type="button" class="btn btn-xs btn-outline-info waves-effect waves-light"
                      data-bs-toggle="modal" data-bs-target="#SeoModalScrollable{{ $row->id }}">View</button>
                    <div class="modal fade" id="SeoModalScrollable{{ $row->id }}" tabindex="-1" role="dialog"
                      aria-labelledby="SeoModalScrollableTitle{{ $row->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="SeoModalScrollableTitle{{ $row->id }}">
                              SEO
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            {!! $row->meta_title !!} <br>
                            {!! $row->meta_keyword !!} <br>
                            {!! $row->meta_description !!} <br>
                            {!! $row->page_content !!} <br>
                            {!! $row->seo_rating !!}
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @else
                    Null
                    @endif
                  </td>
                  <td>
                    <x-StatusField :row="$row"></x-StatusField>
                  </td>
                  <td>
                    <a target="_blank" href="{{ url('admin/destination-content/' . $row->id) }}"
                      class="waves-effect waves-light btn btn-xs btn-outline btn-info">
                      Content
                    </a>
                    <br>
                    <a target="_blank" href="{{ url('admin/destination-gallery/' . $row->id) }}"
                      class="waves-effect waves-light btn btn-xs btn-outline btn-info">
                      Gallery
                    </a>
                    <br>
                    <a target="_blank" href="{{ url('admin/destination-faq/' . $row->id) }}"
                      class="waves-effect waves-light btn btn-xs btn-outline btn-info">
                      Faqs
                    </a>
                  </td>
                  <td>
                    <a href="javascript:void()" onclick="DeleteAjax('{{ $row->id }}')"
                      class="waves-effect waves-light btn btn-xs btn-outline btn-danger">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
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
    $('#page_name').change(function() {
      var val = $('#page_name').val();
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

  function changeStatus(id,col,val) {
    //alert(id);
    var tbl = 'destinations';
    $.ajax({
      url: "{{ url('common/update-field') }}",
      method: "GET",
      data: {
        id: id,
        tbl: tbl,
        col: col,
        val: val
      },
      success: function(data) {
        if (data == '1') {
          //alert('status changed of ' + id + ' to ' + val);
          if (val == '1') {
            $('#a'+col+id).toggle();
            $('#i'+col+id).toggle();
          }
          if (val == '0') {
            $('#a'+col+id).toggle();
            $('#i'+col+id).toggle();
          }
        }
      }
    });
  }

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

  CKEDITOR.replace("top_description");
</script>
@endsection
