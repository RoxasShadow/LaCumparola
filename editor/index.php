<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
	<title>News editor - Omnivium</title>
</head>
<body>

<?php
$password = 'PASSWORD';

function sitemap() {
  $last = (int)file_get_contents('../news/last.txt', FILE_USE_INCLUDE_PATH);

  $sitemap = '<?xml version="1.0" encoding="UTF-8"?>
  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    for($i = 1; $i <= $last; ++$i) {
      $news = json_decode(file_get_contents('../news/' . $i . '.json', FILE_USE_INCLUDE_PATH));
      $url  = explode('/editor/', "http://{$_SERVER[HTTP_HOST]}{$_SERVER[REQUEST_URI]}");
      list($d, $m, $y) = explode('/', $news->date);
      $sitemap .= "
      <url>
        <loc>{$url[0]}/id/{$i}.html</loc>
        <lastmod>{$y}-{$m}-{$d}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
      </url>";
    }
    $sitemap .= '
  </urlset>';
  
  $f = fopen('../sitemap.xml', 'w');
  fwrite($f, $sitemap);
  fclose($f);
}

if(get_magic_quotes_gpc()) {
  $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
  while(list($key, $val) = each($process))
    foreach($val as $k => $v) {
      unset($process[$key][$k]);
      if(is_array($v)) {
        $process[$key][stripslashes($k)] = $v;
        $process[] = &$process[$key][stripslashes($k)];
      }
      else
        $process[$key][stripslashes($k)] = stripslashes($v);
    }
  unset($process);
}

if(isset($_POST['password'])) {
  if($_POST['password'] != $password)
    die('<div align="center"><h1>Nope</h1><img src="youcannotpass.jpg" /></div>');
    
  // creo i dati
  $news = array(
    'title'  => $_POST['title'],
    'tags'   => $_POST['tags'],
    'author' => $_POST['author'],
    'date'   => date('d/m/Y'),
    'text'   => $_POST['text']
  );

  $id = isset($_GET['id']) ? $_GET['id'] : (string)((int)file_get_contents('../news/last.txt', FILE_USE_INCLUDE_PATH) + 1);
  
  if(!isset($_GET['id'])) {    
    // aggiorno last.txt
    $f = fopen('../news/last.txt', 'w');
    fwrite($f, $id);
    fclose($f);
  }

  // salvo
  $f = fopen('../news/' . $id . '.json', 'w');
  fwrite($f, json_encode($news));
  fclose($f);

  // aggiorno il categories.json
  $categories = json_decode(file_get_contents('../news/categories.json', FILE_USE_INCLUDE_PATH));
  if(isset($_GET['id'])) {
    foreach($categories as $category) {
      if($category->id == $id) {
        $category->tags = $news['tags'];
      }
    }
  }
  else
    array_push($categories, array('id' => $id, 'tags' => $news['tags']));

  $f = fopen('../news/categories.json', 'w');
  fwrite($f, json_encode($categories));
  fclose($f);
  
  // genero la sitemap
  sitemap();
  
  die('<div align="center"><h1>All done</h1><img src="gg.jpg" /></div>');
}
else if(isset($_GET['id']))
  $news = json_decode(file_get_contents('../news/' . $_GET['id'] . '.json', FILE_USE_INCLUDE_PATH));
?>

<script type="text/javascript" src="nicEdit.js"></script>
<script type="text/javascript">
  bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>

<div id="sample" align="center">
  <h1>Omnivium editor</h1>
  <form action="" method="post">
    <input type="text"     placeholder="title"    name="title"    style="width: 47%" value="<?php echo $news->title;  ?>" /><br />
    <input type="tags"     placeholder="tags"     name="tags"     style="width: 47%" value="<?php echo $news->tags;   ?>" /><br />
    <input type="author"   placeholder="author"   name="author"   style="width: 47%" value="<?php echo $news->author; ?>" /><br />
    <input type="password" placeholder="password" name="password" style="width: 47%" /><br />
    <textarea name="text"  style="width: 50%; height: 85%;"><?php echo $news->text; ?></textarea>
    <input type="submit"   value="Send" />
  </form>
</div>

</body>
</html>
