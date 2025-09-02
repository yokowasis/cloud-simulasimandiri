var gui = require('nw.gui'); //or global.window.nwDispatcher.requireNwGui() (see https://github.com/rogerwang/node-webkit/issues/707)
var win = gui.Window.get();
win.maximize();

$('body').on('click', '#exit', function(event) {
	window.close();
});

