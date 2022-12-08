"use strict";


window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
    document.body.classList.add('body--scrolled');
  } else {
    document.body.classList.remove('body--scrolled');
  }
}


