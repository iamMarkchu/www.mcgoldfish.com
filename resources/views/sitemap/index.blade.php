<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ route('sitemap-articles') }}</loc>
        <lastmod><?php echo $article->updated_at->tz('UTC')->toAtomString();?></lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ route('sitemap-categories') }}</loc>
        <lastmod><?php echo $category->updated_at->tz('UTC')->toAtomString();?></lastmod>
    </sitemap>
</sitemapindex>