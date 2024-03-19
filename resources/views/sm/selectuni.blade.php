<?php 
    header("Content-Type: application/xml; charset=utf-8");
    echo'<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
	<url>
		<loc><?php echo base_url('universities/private-university/'); ?></loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>always</changefreq>
		<priority>1</priority>
	</url>
	<url>
		<loc><?php echo base_url('universities/public-university/'); ?></loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>always</changefreq>
		<priority>1</priority>
	</url>
	<url>
		<loc><?php echo base_url('universities/foreign-university/'); ?></loc>
		<lastmod><?php echo date("Y-m-d"); ?></lastmod>
		<changefreq>always</changefreq>
		<priority>1</priority>
	</url>
	
</urlset>