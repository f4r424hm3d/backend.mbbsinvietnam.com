<?php
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
  <url>
    <loc>{{ url('/medical-universities/') }}/</loc>
    <lastmod><?php echo date("Y-m-d"); ?></lastmod>
    <changefreq>always</changefreq>
    <priority>1</priority>
  </url>

  <!-- Sitemap -->
  <?php foreach ($universities as $row) { ?>
    <url>
      <loc>{{ url('/medical-universities-in-'.$row->country_slug) }}/</loc>
      <priority>0.80</priority>
      <changefreq>always</changefreq>
      <lastmod><?php echo date("Y-m-d", strtotime($row->updated_at)); ?></lastmod>
    </url>
  <?php } ?>

</urlset>
