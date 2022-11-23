"use strict"; 
/**
 *	Script to make all Tables Responsive
 *
 *	@author: Claudia Oerter
 *	@version: v2.0. 08.2022
 *  vanilla JavaScript
 *	
 */

// Define a convenience method and use it
var ready = (callback) => {
	if (document.readyState != "loading") callback();
	else document.addEventListener("DOMContentLoaded", callback);
  }
  
  ready(() => { 
	let Etables = document.getElementsByTagName("table");
	if(Etables.length) {
		console.log(Etables);
		for(let i = 0; i < Etables.length; i++ ){
			console.log(Etables[i]);
			Etables[i].className = "table table-condensed table-striped wbc__table";
			let wrapDiv = document.createElement('div');
			wrapDiv.classList.add("table-responsive", "wbc__table-responsive");
			console.log(wrapDiv);
			Etables[i].parentNode.insertBefore(wrapDiv, Etables[i]);
			wrapDiv.appendChild(Etables[i]);
		}	
	}
  });