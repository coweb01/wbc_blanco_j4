/* script zum ein und aussliden der linken und rechten sidebar */
/* Vanilla JS                                                  */
/* Author Claudia Oerter                                       */

var ready = (callback) => {
	if (document.readyState != "loading") callback();
	else document.addEventListener("DOMContentLoaded", callback);
  }
  
  ready(() => { 

    var wbcelements = document.querySelectorAll(".wbc-fixed-sidebar-toggle .toggle-btn");
    
    for (var i = 0; i < wbcelements.length; i++) {
      console.log(wbcelements[i]);
      wbcelements[i].addEventListener('click', wbcslideSidebar, false);
    }
    

  });
var wbcslideSidebar = function() {
    console.log(this);
    //let clicked = this;
    let anker;
    let ToggleContainer;
    let containeractive;
    if (this.id.length  ) {
      anker = document.getElementById(this.id);
    } else {
      anker = document.getElementById(this.parentNode.id)
    }
    console.log(anker.parentNode);
    containeractive = anker.parentNode.id;
    ToggleContainer =  document.querySelector('#'+containeractive);
    console.log(ToggleContainer);
    ToggleContainer.classList.toggle('wbc__slide-open');
};