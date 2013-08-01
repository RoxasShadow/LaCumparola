function getURLParameter(name) {
  param = decodeURI((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
  if(param != 'null')
    return param;

  url    = document.URL.split('/');
  length = url.length;
  return url[length - 2] == name ? url[length - 1].split('.html')[0] : 'null';
}

(function(window){
  $('html').dblclick(function() {
    if(getURLParameter('id') != 'null') return;
    
    Reveal.next();
    
    /*if(/webkit/.test(navigator.userAgent.toLowerCase()))
      Reveal.next();
    else
      Reveal.toggleOverview();*/
  });

  $('html').keyup(function(e) {
    switch (e.keyCode) {
      case 8:  // Backspace
        Reveal.prev();
        e.preventDefault();
        break;
      case 13: // Enter
        Reveal.next();
        e.preventDefault();
        break;
    }
  });
})(window);