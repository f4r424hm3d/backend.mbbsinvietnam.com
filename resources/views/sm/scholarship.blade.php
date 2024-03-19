<?php
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">

  <!-- Sitemap -->
  <url>
    <loc><?php echo base_url('scholarship'); ?></loc>
    <priority>1</priority>
    <changefreq>always</changefreq>
    <lastmod><?php echo date("Y-m-d"); ?></lastmod>
  </url>
  <?php
  if ($rows != false) {
    foreach ($rows as $row) {
  ?>
      <url>
        <loc><?php echo base_url($row->slug . '-' . $row->id); ?></loc>
        <priority>0.5</priority>
        <changefreq>always</changefreq>
        <lastmod><?php echo date("Y-m-d", strtotime($row->updated_at)); ?></lastmod>
      </url>
    <?php } ?>
  <?php } ?>

</urlset>