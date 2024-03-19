<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-header">
        <span style="float:left;">
          @foreach ($tabs as $row)
          <a href="{{ url('admin/destination-content/' . $page_id.'/'.$row->id) }}" class="btn btn-xs btn{{ $tab_id==$row->id?'':'-outline' }}-primary">{{ $row->tab }}</a>
          @endforeach
        </span>
      </div>
    </div>
  </div>
</div>
