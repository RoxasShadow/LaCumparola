# LaCumparola

*LaCumparola* is a template made with HTML5, CSS3 and Javascript based on a modified versions of [reveal.js](https://github.com/hakimel/reveal.js) sugar, blog engine AJAX based and many many plugins. You can find some changes in `CHANGELOG.md`.

It's originally made for [Omnivium](http://www.omnivium.it), an anime fansub website, but you are free to use it wherever you want. Just respect originary copyrights.

# Usage
Be sure to edit:

- The path in `.htaccess` (#37, #39, #42, #43)
- The password in `editor/index.php` (#10)
- Your IntenseDebat ID in `plugin/blog.js` (#51)

Then, customize LaCumparola as you need.

If you haven't or don't want to use PHP, restore blog.js at #14ff228, because by the next commit, single news are handled by `single.php`.