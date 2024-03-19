<?php
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
  <!-- Sitemap -->
  <?php foreach ($exams as $row) { ?>
    <url>
      <loc>{{ url($row->exam_slug) }}/</loc>
      <priority>1</priority>
      <changefreq>always</changefreq>
      <lastmod><?php echo date("Y-m-d", strtotime($row->updated_at)); ?></lastmod>
    </url>
  <?php } ?>
  <?php foreach ($exampages as $row) { ?>
    <url>
      <loc>{{ url($row->getExam->exam_slug.'/'.$row->slug) }}/</loc>
      <priority>0.80</priority>
      <changefreq>always</changefreq>
      <lastmod><?php echo date("Y-m-d", strtotime($row->updated_at)); ?></lastmod>
    </url>
  <?php } ?>

</urlset>
