function getURLParameter(name) {
  param = decodeURI((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
  if(param != 'null')
    return param;

  url    = decodeURIComponent(document.URL).split('/');
  length = url.length;
  return url[length - 2] == name ? url[length - 1].split('.html')[0] : 'null';
}

$(document).ready(function() {
  Reveal.addEventListener('ready', function(event) {
    id = parseInt(event.currentSlide.id.split('-')[1]);
    
    if(getURLParameter('id') != 'null') {
      $('#news-1').niceScroll();
      window.setInterval("$('#news-' + id).niceScroll().resize();", 1150);
      $('.nicescroll-rails').css('padding-left', '2%');
    }
    else {
      $('#news-' + id).niceScroll();
      window.setInterval("$('#news-' + id).niceScroll().resize();", 1150);
      $('.nicescroll-rails').css('padding-left', '2%');
    }
  });
  
  Reveal.addEventListener('slidechanged', function(event) {
    id = parseInt(event.currentSlide.id.split('-')[1]);
    
    $('div[id^="ascrail"]').each(function() {
      if(parseInt(this.id.split('20')[1].split('-hr')[0]) != id)
        $(this).hide();
      else
        if(this.id.split('-hr').length == 1) // no -hr
          $(this).show();
    });
    
    $('#news-' + id).niceScroll().show();
    $('#news-' + id).css('padding-left', '2%');
    window.setInterval("$('#news-' + id).niceScroll().resize();", 1150);
  });
});