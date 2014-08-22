//this is the social link calls
(function(w, d, s) {
  function go(){
    var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
	  if (d.getElementById(id)) {return;}
	  js = d.createElement(s); js.src = url; js.id = id;
	  fjs.parentNode.insertBefore(js, fjs);
	};
    load('//apis.google.com/js/plusone.js', 'gplus1js');
    load('//platform.twitter.com/widgets.js', 'tweetjs');
  }
  if (w.addEventListener) { w.addEventListener("load", go, false); }
  else if (w.attachEvent) { w.attachEvent("onload",go); }
}(window, document, 'script'));
/*
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js?onload=onLoadCallback';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
  */
//end the social calls
