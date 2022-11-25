"use strict";


window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
    document.body.classList.add('body--scrolled');
  } else {
    document.body.classList.remove('body--scrolled');
  }
}


var ready = (callback) => {
	if (document.readyState != "loading") callback();
	else document.addEventListener("DOMContentLoaded", callback);
  }
  
  ready(() => { 
    // hessenfinder ajax load
    if (document.getElementById('wbc-content-hzf')) {
        let container = document.getElementById('wbc-content-hzf');
        let wizardId = container.getAttribute('data-hfid');
        let path = window.location.origin;
        let requestUrl = path+'/index.php?option=com_ajax&plugin=hessenfinder&format=raw&wizardid='+wizardId;
        let request = new XMLHttpRequest();    
        request.open('GET', requestUrl, true);

        request.onload = function() {
          if (request.status >= 200 && request.status < 400) {
            var resp = request.responseText;
            container.innerHTML = resp;
            document.getElementById('wbc-loader').classList.add('loaded');
          }
        };
        request.send();
  } 
});

