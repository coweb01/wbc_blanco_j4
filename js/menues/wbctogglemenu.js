/* Öffnet ein MODAL Fenster mit dem Inhalt eines Moduls.
/* Author Claudia Oerter
/* das-webconcept.de
/* gehört zum Menu Overrride toggle.php
/* Stand: Oktober 2023
*/

"use strict";

document.addEventListener('DOMContentLoaded', function() {
    const toggleContainers = document.querySelectorAll('.wbc-toggle-container');
    if (toggleContainers.length === 0) {
        return;
    }
    toggleContainers.forEach(container => {
        document.body.appendChild(container);
    });

});

document.addEventListener('click',function(ev){
    // only if it is wbc-toggle-item
    //console.log(event.target);
    let toggleId;
    let container;
    if ( ev.target.classList.contains('wbc-toggle-item-link') || event.target.classList.contains('wbc-toggle-item-icon') ) {

        ev.preventDefault();

            toggleId = ev.target.dataset.toggleContainer;
            if (toggleId.length === 0) { return; }
            container = document.getElementById(toggleId);
            container.classList.toggle('wbcshow');
            return;
    }

    if ( ev.target.classList.contains('wbc-toggle-container-close')){
        toggleId = ev.target.parentNode.id;
        document.getElementById(toggleId).classList.toggle('wbcshow');
        return;
    }
}, false);