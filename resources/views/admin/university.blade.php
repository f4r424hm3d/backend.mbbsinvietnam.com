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
            <div class="card-body {{ $ft == 'edit' ? '' : 'hide-this' }}" id="tblCDiv">
              <!-- IMPORT FORM START -->
              <x-ImportForm :pageRoute="$page_route" fileName="university"></x-ImportForm>
              <hr>
              <!-- IMPORT FORM END -->
              <form action="{{ $url }}/" class="needs-validation" method="post" enctype="multipart/form-data"
                novalidate>
                @csrf
                <div class="row">
                  <div class="col-md-6 col-sm-12 mb-3">
                    <x-InputField type="text" label="Name" name="name" id="name" :ft="$ft"
                      :sd="$sd" required="required">
                    </x-InputField>
                  </div>
                  <div class="col-md-6 col-sm-12 mb-3">
                    <x-InputField type="text" label="URL" name="slug" id="slug" :ft="$ft"
                      :sd="$sd">
                    </x-InputField>
                  </div>
                  <div class="col-md-4 col-sm-12 mb-3">
                    <x-InputField type="text" label="Other Name" name="university_name" id="university_name"
                      :ft="$ft" :sd="$sd"></x-InputField>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-3">
                    <x-SelectField label="Author" name="author_id" id="author_id" savev="id" showv="name"
                      :list="$authors" :ft="$ft" :sd="$sd"></x-SelectField>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-3">
                    <x-InputField type="number" label="Views" name="views" id="views" :ft="$ft"
                      :sd="$sd"></x-InputField>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-3">
                    <x-InputField type="number" label="Established Year" name="established_year" id="established_year"
                      :ft="$ft" :sd="$sd"></x-InputField>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-3">
                    <x-SelectField label="Country" name="country" id="country" savev="name" showv="name"
                      :list="$countries" :ft="$ft" :sd="$sd"></x-SelectField>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-3">
                    <x-SelectField label="Destination" name="destination_id" id="destination_id" savev="id"
                      showv="page_name" :list="$destinations" :ft="$ft" :sd="$sd"></x-SelectField>
                  </div>

                  <div class="col-md-2 col-sm-12 mb-3">
                    <x-InputField type="text" label="Rank" name="rank" id="rank" :ft="$ft"
                      :sd="$sd"></x-InputField>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-3">
                    <x-SelectField label="Institute Type" name="institute_type" id="institute_type" savev="id"
                      showv="type" :list="$instType" :ft="$ft" :sd="$sd"></x-SelectField>
                  </div>

                  <div class="col-md-3 col-sm-12 mb-3">
                    <x-InputField type="file" label="Logo" name="logo" id="logo" :ft="$ft"
                      :sd="$sd"></x-InputField>
                  </div>
                  <div class="col-md-3 col-sm-12 mb-3">
                    <x-InputField type="file" label="Banner" name="banner" id="banner" :ft="$ft"
                      :sd="$sd"></x-InputField>
                  </div>
                  <div class="col-md-4 col-sm-12 mb-3" id="uploadBroDiv">
                    <x-InputField type="file" label="Brochure" name="brochure" id="brochure" :ft="$ft"
                      :sd="$sd">
                    </x-InputField>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-3" id="insertLinkBtn">
                    <button onclick="togglebrochureUpload('insertLinkBtn')" type="button"
                      class="btn btn-xs btn-info col-btn"><small>Insert Link</small></button>
                  </div>
                  <div class="col-md-4 col-sm-12 mb-3 hide-this" id="insertLinkDiv">
                    <x-InputField type="text" label="Enter Link" name="brochure_path" id="brochure_path"
                      :ft="$ft" :sd="$sd">
                    </x-InputField>
                  </div>
                  <div class="col-md-2 col-sm-12 mb-3 hide-this" id="uploadBroBtn">
                    <button onclick="togglebrochureUpload('uploadBroBtn')" type="button"
                      class="btn btn-xs btn-info col-btn"><small>Upload File</small></button>
                  </div>
                  <div class="col-md-12 col-sm-12 mb-3">
                    <x-TextareaField type="file" label="Top Description" name="top_description"
                      id="top_description" :ft="$ft" :sd="$sd">
                    </x-TextareaField>
                  </div>
                  <div class="col-md-12 col-sm-12 mb-3">
                    <x-TextareaField type="file" label="Bottom Description" name="bottom_description"
                      id="bottom_description" :ft="$ft" :sd="$sd">
                    </x-TextareaField>
                  </div>
                </div>
                <hr>

                <!--  SEO INPUT FIELD COMPONENT START -->
                <x-SeoField :ft="$ft" :sd="$sd"></x-SeoField>
                <!--  SEO INPUT FIELD COMPONENT END  -->

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
            <div class="card-body">
              <form class="needs-validation" method="get" novalidate>
                <div class="row">
                  <div class="col-md-6 col-sm-12 mb-3">
                    <div class="form-group">
                      <label>Search</label>
                      <input name="search" id="search" type="text" class="form-control"
                        placeholder="search by Name and Country" value="{{ $_GET['search'] ?? '' }}" required>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12 mb-3">
                    <a href="{{ aurl($page_route) }}" class="btn btn-sm btn-info col-btn"><i class="ti-trash"></i>
                      Reset</a>
                    <button class="btn btn-sm btn-primary col-btn" type="submit">Submit</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                {{ $page_title }} List
                {{-- <span style="float:right;">
                <button class="btn btn-xs btn-success">Export</button>
              </span> --}}
              </h4>
            </div>
            <div class="card-body">
              <table id="datatabl" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Info</th>
                    <th>Author</th>
                    <th>Logo/Banner</th>
                    <th>Brochure</th>
                    <th>Permission</th>
                    <th>Description</th>
                    <th>SEO</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($rows as $row)
                    <tr id="row{{ $row->id }}">
                      <td>{{ $i }}</td>
                      <td>
                        <b>Name :</b> {{ $row->name }} <br>
                        <b>URL :</b> {{ $row->slug }} <br>
                        <b>Other Name :</b> {{ $row->university_name }}
                      </td>
                      <td>
                        <b>Country : </b>
                        <?php echo $row->country; ?><br>
                        <b>Destination : </b>
                        <?php echo $row->getDestination->page_name ?? 'N/A'; ?><br>
                        <b>View : </b>
                        <?php echo $row->views; ?><br>
                        <b>Rank : </b>
                        <?php echo $row->rank; ?><br>
                        <b>Established Year : </b>
                        <?php echo $row->established_year; ?><br>
                        <b>Institute Type : </b>
                        <?php echo $row->getInstType->type ?? ''; ?><br>
                      </td>
                      <td>
                        <?php echo $row->author_id != null ? $row->getAuthor->name : ''; ?>
                      </td>
                      <td>
                        @if ($row->image_path != null)
                          <img src="{{ asset($row->image_path) }}" alt="" height="50" width="50">
                        @else
                          N/A
                        @endif
                        <br>
                        @if ($row->banner_path != null)
                          <img src="{{ asset($row->banner_path) }}" alt="" height="50" width="50">
                        @else
                          N/A
                        @endif
                      </td>
                      <td>
                        @if ($row->brochure_path != null)
                          <a target="_blank" href="{{ asset($row->brochure_path) }}"
                            class="btn btn-xs btn-info"><small>View</small></a> | <a target="_blank"
                            href="{{ asset($row->brochure_path) }}" download="{{ $row->name }}"
                            class="btn btn-xs btn-danger"><small>Download</small></a>
                        @else
                          N/A
                        @endif
                      </td>
                      <td id="statustd{{ $row->id }}">
                        <table class="table-sm ">
                          <tbody>
                            <tr>
                              <td>Status</td>
                              <td>
                                <span id="astatus{{ $row->id }}"
                                  class="badge bg-success {{ $row->status == 1 ? '' : 'hide-this' }}"
                                  onclick="changeStatus('{{ $row->id }}','status','0')">Active</span>
                                <span id="istatus{{ $row->id }}"
                                  class="badge bg-danger {{ $row->status == 0 ? '' : 'hide-this' }}"
                                  onclick="changeStatus('{{ $row->id }}','status','1')">Inactive</span>
                              </td>
                            </tr>
                            <tr>
                              <td>Home View</td>
                              <td>
                                <span id="ahomeview{{ $row->id }}"
                                  class="badge bg-success {{ $row->homeview == 1 ? '' : 'hide-this' }}"
                                  onclick="changeStatus('{{ $row->id }}','homeview','0')">Active</span>
                                <span id="ihomeview{{ $row->id }}"
                                  class="badge bg-danger {{ $row->homeview == 0 ? '' : 'hide-this' }}"
                                  onclick="changeStatus('{{ $row->id }}','homeview','1')">Inactive</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td>
                        @if ($row->top_description != null)
                          <button type="button" class="btn btn-xs btn-outline-info waves-effect waves-light"
                            data-bs-toggle="modal"
                            data-bs-target="#SeoModalScrollable{{ $row->id }}">View</button>
                          <div class="modal fade" id="SeoModalScrollable{{ $row->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="SeoModalScrollableTitle{{ $row->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="SeoModalScrollableTitle{{ $row->id }}">
                                    SEO
                                  </h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  {!! $row->top_description !!}
                                  <hr>
                                  {!! $row->bottom_description !!}
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
                        @if ($row->meta_title != null)
                          <button type="button" class="btn btn-xs btn-outline-info waves-effect waves-light"
                            data-bs-toggle="modal"
                            data-bs-target="#SeoModalScrollable{{ $row->id }}">View</button>
                          <div class="modal fade" id="SeoModalScrollable{{ $row->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="SeoModalScrollableTitle{{ $row->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="SeoModalScrollableTitle{{ $row->id }}">
                                    SEO
                                  </h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <b>Title : </b>{!! $row->meta_title !!} <br>
                                  <b>Keyword : </b>{!! $row->meta_keyword !!} <br>
                                  <b>Description : </b>{!! $row->meta_description !!} <br>
                                  <b>Page Content : </b>{!! $row->page_content !!}
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
                        <a title="Profile" href="{{ aurl('university-overview/' . $row->id) }}"
                          class="waves-effect waves-light btn btn-xs btn-outline btn-success">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:void()" onclick="DeleteAjax('{{ $row->id }}')"
                          class="waves-effect waves-light btn btn-xs btn-outline btn-danger">
                          <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                        <a href="{{ url('admin/' . $page_route . '/update/' . $row->id) }}"
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
              {!! $rows->links('pagination::bootstrap-5') !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function togglebrochureUpload() {
      $('#uploadBroBtn').toggle();
      $('#uploadBroDiv').toggle();
      $('#insertLinkDiv').toggle();
      $('#insertLinkBtn').toggle();
      $('#brochure').val('');
    }

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

    function changeStatus(id, col, val) {
      //alert(id);
      var tbl = 'universities';
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
              $('#a' + col + id).toggle();
              $('#i' + col + id).toggle();
            }
            if (val == '0') {
              $('#a' + col + id).toggle();
              $('#i' + col + id).toggle();
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
          url: "{{ url('admin/' . $page_route . '/delete') }}" + "/" + id,
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
    CKEDITOR.replace("bottom_description");
  </script>
@endsection
