var head_node = document.getElementsByTagName('head')[0];         
var css_node  = document.createElement('link');
css_node.rel = 'stylesheet';
css_node.href = 'plugin/meny/style.css';
head_node.appendChild(css_node);

Meny.create({
	menuElement: document.querySelector('.meny'),
	contentsElement: document.querySelector('.reveal'),
	position: Meny.getQuery().p || 'left'
});