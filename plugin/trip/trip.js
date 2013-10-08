var head_node = document.getElementsByTagName('head')[0];         
var css_node  = document.createElement('link');
css_node.rel = 'stylesheet';
css_node.href = 'plugin/trip/style.css';
head_node.appendChild(css_node);

var trip = new Trip([
 {
   sel: $('.meny-arrow'),
   content: 'Moving the mouse to the left, menu will be open.',
   position: 'e'
 },
 {
   sel: $('.slides'),
   content: 'Below there is the progressbar. It increases or decreases when you look in the website.<br />Click on it to go quickly in other news.To the right there is the arrows to switch the news.',
   position: 's'
 }
], { delay: 3000 } );

$('#tour').click(function() {
  Reveal.slide(1,0,0);
  if(Reveal.getCurrentSlide().id.split('-')[1] == 2)
    trip.start();
  else {
    location.href = 'index.html';
    Reveal.slide(1,0,0);
    trip.start();
    location.href = 'index.html';
  }
});