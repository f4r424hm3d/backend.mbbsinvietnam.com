<?php
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
  <!-- Sitemap -->
  <?php
  foreach ($rows as $row) {
    $whr = ['u_id' => $row->id];
    $rows2 = $this->mm->getAllData7($whr, 'university_programs');
    //printArray($rows2);
    foreach ($rows2 as $row2) {
  ?>
      <url>
        <loc><?php echo base_url($row->uname . '/' . $row2->slug); ?></loc>
        <priority>0.5</priority>
        <changefreq>always</changefreq>
        <lastmod><?php echo date("Y-m-d", strtotime($row2->updated_on)); ?></lastmod>
      </url>
    <?php } ?>
  <?php } ?>

</urlset>