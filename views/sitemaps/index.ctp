<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo Router::url('/',true); ?></loc>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
	</url>
	<?php foreach ($pages as $page):?>
		<?php $date = $page['Page']['lastUpdate']!="0000-00-00 00:00:00" ? $page['Page']['lastUpdate'] : $page['Page']['dateAdd'];?>
	<url>
		<loc><?php echo Router::url('/'.$page['Page']['link'],true); ?></loc>
		<lastmod><?php echo $time->toAtom($date); ?></lastmod>
		<priority>0.8</priority>
	</url>
	<?php endforeach; ?>
</urlset>