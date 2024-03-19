<?php

namespace App\Imports;

use App\Models\University;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UniversityImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
  /**
   * @param Collection $collection
   */
  // public function __construct(array $data)
  // {
  //   $this->group_id = $data['group_id'];
  //   $this->question_type = $data['question_type'];
  // }
  public function startRow(): int
  {
    return 2;
  }
  public function collection(collection $rows)
  {
    $rowsInserted = 0;
    $totalRows = 0;
    foreach ($rows as $row) {
      $where = [
        'name' => $row['name']
      ];
      $data = University::where($where)->count();
      if ($data == 0) {
        University::create([
          'name' => $row['name'],
          'slug' => slugify($row['name']),
          'author_id' => $row['author_id'],
          'views' => $row['views'],
          'established_year' => $row['established_year'],
          'country' => $row['country'],
          'country_slug' => slugify($row['country']),
          'rank' => $row['rank'],
          'institute_type' => $row['institute_type_id'],
          'brochure_path' => $row['brochure_path'],
          'status' => $row['status'] ?? 0,
        ]);
        $rowsInserted++;
      }
      $totalRows++;
    }
    if ($rowsInserted > 0) {
      session()->flash('smsg', $rowsInserted . ' out of ' . $totalRows . ' rows imported succesfully.');
    } else {
      session()->flash('emsg', 'Data not imported. Duplicate rows found.');
    }
  }

  public function chunkSize(): int
  {
    return 1000;
  }
  public function batchSize(): int
  {
    return 1000;
  }
}
