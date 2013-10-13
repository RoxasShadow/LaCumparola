<?php
function makeFeed() {
  $news = (int)file_get_contents('../news/last.txt', FILE_USE_INCLUDE_PATH);
    
  $feed_content  = '<?xml version="1.0" encoding="UTF-8" ?>';
  $feed_content .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
  $feed_content .= '<channel>';
  $feed_content .= '<title>Omnivium</title>';
  $feed_content .= '<link>http://www.omnivium.it</link>';

  while($news > 0) {
    $json = json_decode(file_get_contents('../news/'.$news.'.json', FILE_USE_INCLUDE_PATH));

    $feed_content .= '<item>';
    $feed_content .= '<title>'.htmlspecialchars($json->{'title'}, ENT_QUOTES).'</title>';
    $feed_content .= '<description>'.htmlspecialchars($json->{'text'}, ENT_QUOTES).'</description>';
    $feed_content .= '<author>'.htmlspecialchars($json->{'author'}, ENT_QUOTES).'</author>';
    $feed_content .= '<category>'.htmlspecialchars($json->{'tags'}, ENT_QUOTES).'</category>';
    $feed_content .= '<link>'.htmlspecialchars('http://www.omnivium.it/id/'.$news.'.html', ENT_QUOTES).'</link>';
    $feed_content .= '<comments>'.htmlspecialchars('http://www.omnivium.it/id/'.$news.'.html', ENT_QUOTES).'</comments>';
    $feed_content .= '<guid>'.htmlspecialchars('http://www.omnivium.it/id/'.$news.'.html', ENT_QUOTES).'</guid>';
    $feed_content .= '</item>';

    --$news;
  }
   
  $feed_content .= '</channel></rss>';

  $f = fopen('../feed.rss', 'w+');
  fwrite($f, $feed_content);
  fclose($f);
}

function makeSitemap() {
  $numero_news = (int)file_get_contents('../news/last.txt', FILE_USE_INCLUDE_PATH);
    
  $sitemap_content  = '<?xml version="1.0" encoding="UTF-8"?>';
  $sitemap_content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

  while($numero_news > 0) {
    $json = json_decode(file_get_contents('../news/'.$numero_news.'.json', FILE_USE_INCLUDE_PATH));

    $sitemap_content .= '<url>';
    $sitemap_content .= '<loc>'.htmlspecialchars('http://www.omnivium.it/id/'.$numero_news.'.html', ENT_QUOTES).'</loc>';
    $sitemap_content .= '<lastmod>'.date('Y-m-d', strtotime($json->{'date'})).'</lastmod>';
    $sitemap_content .= '<changefreq>weekly</changefreq>';
    $sitemap_content .= '<priority>0.8</priority>';
    $sitemap_content .= '</url>';

    --$numero_news;
  }
   
  $sitemap_content .= '</urlset>';

  $f = fopen('../sitemap.xml', 'w+');
  fwrite($f, $sitemap_content);
  fclose($f);
}