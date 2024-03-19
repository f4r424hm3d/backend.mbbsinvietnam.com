<?php
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc>
      <?php echo url('/'); ?>/sitemap-home.xml/
    </loc>
  </sitemap>
  <sitemap>
    <loc>
      <?php echo url('/'); ?>/sitemap-blog.xml/
    </loc>
  </sitemap>
  <sitemap>
    <loc>
      <?php echo url('/'); ?>/sitemap-medical-universities.xml/
    </loc>
  </sitemap>
  <sitemap>
    <loc>
      <?php echo url('/'); ?>/sitemap-destinations.xml/
    </loc>
  </sitemap>
  <sitemap>
    <loc>
      <?php echo url('/'); ?>/sitemap-services.xml/
    </loc>
  </sitemap>
  <sitemap>
    <loc>
      <?php echo url('/'); ?>/sitemap-exams.xml/
    </loc>
  </sitemap>
  <sitemap>
    <loc>
      <?php echo url('/'); ?>/sitemap-university.xml/
    </loc>
  </sitemap>
</sitemapindex>