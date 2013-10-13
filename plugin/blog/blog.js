function getURLParameter(name) {
  param = decodeURI((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
  if(param != 'null')
    return param;

  url    = decodeURIComponent(document.URL).split('/');
  length = url.length;
  return url[length - 2] == name ? url[length - 1].split('.html')[0] : 'null';
}

function fill(last) {
  for(var i = 2; i <= last; ++i) {
    content  = '<section id="news-' + i + '">';
      content += '<header>Caricando il titolo...</h2>';
      content += '<article><p>Caricando la news...</p></article>';
    content += '</section>';
    $('.slides').append(content);
  }
}

function get(id, n) {
  $.ajax({
    type:     'GET',
    dataType: 'json',
    url:      'news/' + id + '.json',
    async:    false,
    success:  function(data) {
      $('title')                     .html(data['title'] + ' - ' + pagetitle);
      $('#news-' + n + ' > header')  .html('<h2>' + data['title'] + '</h2>');
      $('#news-' + n + ' > header').append('<p>News scritta da <em>' + data['author'] + '</em> il <em>' + data['date'] + '</em>. <a class="roll" href="id/' + id + '.html"><span data-title="Commenti">Commenti</span></a><br /><em>' + $.map(data['tags'].split(', '), function(tag) { return '<a class="roll" href="tag/' + tag + '"><span data-title="' + tag + '">' + tag + '</span></a>' }) +'</em></p>');
      $('#news-' + n)              .append('<article>' + data['text'].replace(/\.(png|jpg|gif)\"/g, '.$1" data-lightbox="roadtrip"') + '</article>');
      
      if(screen.height < 1080 && screen.height >= 1024) {
        $('#news-' + n).prepend('<div class="spacing"></div>');
        $('#news-' + n).append('<div class="spacing"></div>');
      }

      if(screen.height < 1024 ) {
        $('#news-' + n).prepend('<div class="spacing"></div>');
        $('#news-' + n).append('<div class="spacing"></div>');
      }
    },
    error: function(data) {
      $('title')                     .html('Error - ' + pagetitle);
      $('#news-' + n + ' > header')  .html('<h1>Error</h1>');
      $('#news-' + n)              .append('<article><h3>The article you are searching has been eaten by Shinbo.</h3><img src="css/theme/error.gif" alt="Error" /></article>');
      
      if(screen.height < 1080 && screen.height >= 1024) {
        $('#news-' + n).prepend('<div class="spacing"></div>');
        $('#news-' + n).append('<div class="spacing"></div>');
      }

      if(screen.height < 1024 ) {
        $('#news-' + n).prepend('<div class="spacing"></div>');
        $('#news-' + n).append('<div class="spacing"></div>');
      }
    }
  });
}

function get_by_id(id) {
  if(screen.height < 1080 && screen.height >= 1024) {
    $('#news-1').prepend('<div class="spacing"></div>');
    $('#news-1').append('<div class="spacing"></div>');
  }

  if(screen.height < 1024 ) {
    $('#news-1').prepend('<div class="spacing"></div>');
    $('#news-1').append('<div class="spacing"></div>');
  }
}

$(document).ready(function() {
  var counter  = [];
  var last     = 0;
  var next     = false;
  var n        = 1;
  var params   = getURLParameter('id');
  var tag      = getURLParameter('tag');
  pagetitle    = $('title').html();
  
  Reveal.addEventListener('ready', function(event) {
    if(params != 'null') {
      get_by_id(params);
      Reveal.configure({ controls: false });
    }
  });

  if(tag != 'null')
    $.ajax({
      type:     'GET',
      dataType: 'json',
      url:      'news/categories.json',
      async:    false,
      success:  function(data) {
        var tags = [];
        $.each(data, function(key, val) {
          $.each(val['tags'].split(', '), function(k, v) {
            if(tag == v)
              tags.push(val['id']);
          });
        });
        if(tags.length == 0) {
          $('title')           .html('Error - ' + pagetitle);
          $('#news-1 > header').html('<h1>Error</h1>');
          $('#news-1')       .append('<article><h3>The article you are searching has been eaten by Shinbo.</h3><img src="css/theme/error.gif" alt="Error" /></article>');
          return;
        }
        counter = tags;
        last    = tags.length;
        fill(last);
        get(counter.pop(), n++);
      }
    });
  else if(params == 'null')
    $.ajax({
      type:     'GET',
      dataType: 'text',
      url:      'news/last.txt',
      async:    false,
      success:  function(data) {
        last = parseInt(data);
        for(var i = 1; i <= last; ++i)
          counter.push(i);
        fill(last);
        get(counter.pop(), n++);
      }
    });
  
  Reveal.addEventListener('slidechanged', function(event) {    
    if(params != 'null') {
      Reveal.slide(0, 0, 0);
      return;
    }
    
    if(event.currentSlide.id == 'news-' + n)
      get(counter.pop(), n++);

    $('title').html($('#' + event.currentSlide.id + ' > header > h2').html() + ' - ' + pagetitle);
  });
  
  $('div').on('click', '.progress', function() {
    if(tag == 'null') {
      var id = Reveal.getCurrentSlide().id.split('-')[1];
      get(id, id);
    }
  });
  
});