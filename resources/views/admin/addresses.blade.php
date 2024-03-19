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
          <div class="card-body  {{ $ft=='edit'?'':'hide-this' }}" id="tblCDiv">
            <form action="{{ $url }}/" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
              @csrf
              <div class="row">
                <div class="col-md-3 col-sm-12 mb-3">
                  <x-SelectField label="Country" name="country" id="country" savev="nicename" showv="nicename" :list="$countries" :ft="$ft" :sd="$sd"></x-SelectField>
                </div>
                <div class="col-md-3 col-sm-12 mb-3">
                  <x-InputField type="text" label="Enter City" name="city" id="city" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-3 col-sm-12 mb-3">
                  <x-InputField type="text" label="Enter Contact No" name="mobile" id="mobile" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-3 col-sm-12 mb-3">
                  <x-InputField type="text" label="Enter Mail addrs" name="email" id="email" :ft="$ft" :sd="$sd"></x-InputField>
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                  <x-TextareaField label="Enter Address" name="address" id="address" :ft="$ft" :sd="$sd"></x-TextareaField>
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
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsiv nowra w-100">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Country</th>
                  <th>City</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Email</th>
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
                  <td><?php echo $row->country; ?></td>
                  <td><?php echo $row->city; ?></td>
                  <td><?php echo $row->address; ?></td>
                  <td><?php echo $row->mobile; ?></td>
                  <td><?php echo $row->email; ?></td>
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
</script>
@endsection
