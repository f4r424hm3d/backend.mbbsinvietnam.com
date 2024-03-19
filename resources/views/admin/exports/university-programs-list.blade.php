<table>
  <thead>
  <tr>
      <th>id</th>
      <th>program_name</th>
      <th>course_category_id</th>
      <th>specialization_id</th>
      <th>level_id</th>
      <th>duration</th>
      <th>study_mode</th>
      <th>course_mode</th>
      <th>tution_fees</th>
  </tr>
  </thead>
  <tbody>
  @foreach($rows as $row)
  @php
  $study_mode = json_decode($row->study_mode);
  $study_mode = implode(',',$study_mode);
  $course_mode = json_decode($row->course_mode);
  $course_mode = implode(',',$course_mode);
  @endphp
      <tr>
          <td>{{ $row->id }}</td>
          <td>{{ $row->program_name }}</td>
          <td>{{ $row->course_category_id }}</td>
          <td>{{ $row->specialization_id }}</td>
          <td>{{ $row->level_id }}</td>
          <td>{{ $row->duration }}</td>
          <td>{{ $study_mode }}</td>
          <td>{{ $course_mode }}</td>
          <td>{{ $row->tution_fees }}</td>
      </tr>
  @endforeach
  </tbody>
</table>
