<?php
  $news = @json_decode(file_get_contents('news/' . intval($_GET['id']) . '.json', FILE_USE_INCLUDE_PATH));
?>

<!doctype html>
<html>

  <head>
    <meta charset="utf-8" />
    <title><?php echo $news ? $news->title : 'Error' ?> - Omnivium</title>
    <meta name="robots" content="index,follow" />

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    
    <link rel="stylesheet" href="css/reveal.min.css" />
    <link rel="stylesheet" href="css/theme/default.css" id="theme" />

    <script src="lib/js/jquery.min.js"></script>

    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    
    <!--[if lt IE 9]>
      <script src="lib/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="meny">
      <h2>Omnivium</h2>
      <ul>
        <li><a href="index.html">Index</a></li>
        <li><a href="staff.html">Staff</a></li>
        <li><a href="irc.html">IRC</a></li>
        <li><a href="playback.html">Video playback</a></li>
      </ul><br />
      
      <h2>Serie</h2>
      <ul>
        <li><a href="tag/Dareka no Manazashi">Dareka no Manazashi</a></li>
        <li><a href="tag/Miss Monochrome">Miss Monochrome</a></li>
        <li><a href="tag/Outbreak Company">Outbreak Company</a></li>
        <li><a href="tag/Inferno Cop">SbirrInferno</a></li>
        <li><a href="tag/Stella Jogakuin Koutouka C3-bu">Stella Jogakuin Koutouka C3-bu</a></li>
        <li><a href="tag/Strike the Blood">Strike the Blood</a></li>
        <li><a href="tag/Sasami-san@Ganbaranai">Sasami-san@Ganbaranai</a></li>
      </ul><br />
      
      <h2>La Cumpa &copy;</h2>
      <ul>
        <li><a href="http://animezer0.lacumpa.biz/">Animezer0</a></li>
        <li><a href="http://aozora.lacumpa.biz/">Aozora</a></li>
        <li><a href="http://leaf.lacumpa.biz/">LEAF Fansub</a></li>
        <li><a href="http://owarisubs.lacumpa.biz/">Owari Subs</a></li>
        <li><a href="http://pantalonirossi.lacumpa.biz/">Pantaloni Rossi</a></li>
        <li><a href="http://pluschan.lacumpa.biz/">Pluschan Fansub</a></li>
        <li><a href="http://task-force.lacumpa.biz/">Task-Force</a></li>
        <li><a href="http://supremes.lacumpa.biz/">The Supremes Fansub</a></li>
      </ul>
    </div>

    <div class="meny-arrow"></div>

    <div class="reveal">

      <div class="slides">
      
        <section id="news-1">
          <?php
            if($news) {
          ?>
          <header>
            <h2><?php echo $news->title ?></h2>
            <p>News scritta da <em><?php echo $news->author ?></em> il <em><?php echo $news->date ?></em><br /><em>
            <?php
              $tags = explode(',', $news->tags);
              foreach($tags as $tag)
                echo '<a href="tag/' . $tag .'"> '. $tag .'</a>';
            ?>
            </em></p>
          </header>
          <article>
            <?php echo preg_replace('/\.(png|jpg|gif)\"/', '.$1" data-lightbox="roadtrip"', $news->text) ?>
            <div align="center"><script>var idcomments_acct = '87b04b2a52c611244adf65de705ad6f4'; var idcomments_post_id; var idcomments_post_url;</script><span id="IDCommentsPostTitle" style="display:none"></span><script type="text/javascript" src="http://www.intensedebate.com/js/genericCommentWrapperV2.js"></script></div>
          </article>
          <?php
            } else {
          ?>
          <header>
            <h1>Error</h1>
          </header>
          <article>
            <h3>The article you are searching has been eaten by Shinbo.</h3><img src="css/theme/error.gif" alt="Error" /></article>
          </article>
          <?php } ?>
        </section>
        
      </div>

    </div>

    <script src="lib/js/head.min.js"></script>
    <script src="js/reveal.min.js"></script>

    <script>
      Reveal.initialize({
        controls: true,
        progress: true,
        history:  false,
        center:   true,

        theme: Reveal.getQueryHash().theme,
        transition: Reveal.getQueryHash().transition || 'default',

        dependencies: [
          { src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
          
           { src: 'plugin/blog/blog.js' },
          
          { src: 'plugin/lightbox/lightbox.js' },
          
          { src: 'plugin/overview/overview.js' },
          
          { src: 'plugin/meny/meny.min.js' },
          { src: 'plugin/meny/meny.js' },
          
          { src: 'plugin/nicescroll/jquery.nicescroll.min.js' },
          { src: 'plugin/nicescroll/nicescroll.js' }
        ]
      });
    </script>

  </body>
</html>