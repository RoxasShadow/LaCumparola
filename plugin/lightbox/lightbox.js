var head_node = document.getElementsByTagName('head')[0];
var js_node  = document.createElement('script');
js_node.src = 'plugin/lightbox/js/lightbox-2.6.min.js';
head_node.appendChild(js_node);
      
var css_node  = document.createElement('link');
css_node.rel = 'stylesheet';
css_node.href = 'plugin/lightbox/css/lightbox.css';
head_node.appendChild(css_node);