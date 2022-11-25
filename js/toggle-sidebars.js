/* script zum ein und aussliden der linken und rechten sidebar */
/* Vanilla JS                                                  */
/* Author Claudia Oerter                                       */

var ready = (callback) => {
	if (document.readyState != "loading") callback();
	else document.addEventListener("DOMContentLoaded", callback);
  }
  
  ready(() => { 
    document.querySelector("#fixed-sidebar-left-toggle .btn-icon").addEventListener("click", (event) => { 
        event.preventDefault();
        let ToggleContainerLeft =  document.querySelector('#fixed-sidebar-left-toggle .container-fix');
        ToggleContainerLeft.classList.toggle('wbc__toggle');
		document.querySelector( '#fixed-sidebar-left-toggle').classList.toggle('wbc__slide-open');
    });
    document.querySelector("#fixed-sidebar-right-toggle .btn-icon").addEventListener("click", (event) => { 
        event.preventDefault();
        let ToggleContainerLeft =  document.querySelector('#fixed-sidebar-right-toggle .container-fix');
        ToggleContainerLeft.classList.toggle('wbc__toggle');
		document.querySelector( '#fixed-sidebar-right-toggle').classList.toggle('wbc__slide-open');
    });
  });   