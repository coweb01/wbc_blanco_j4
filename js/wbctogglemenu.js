document.addEventListener('click',function(ev){
    // only if it is wbc-toggle-item
    //console.log(event.target);
    if ( ev.target.classList.contains('wbc-toggle-item-link') || event.target.classList.contains('wbc-toggle-item-icon') ) {
        //console.log(event.target);  
        let toggleId;
        if ( ev.target.classList.contains('wbc-toggle-item-link') ) {
            toggleId = document.querySelector(ev.target.hash);
            
        } else {
            //console.log(event.target.parentNode);
            toggleId = document.querySelector(ev.target.parentNode.hash);
        }
        //console.log(toggleContainer);
        if (!toggleId) return;
        toggleId.classList.toggle('wbcshow');
        return;
    }

    if ( ev.target.classList.contains('wbc-toggle-container-close')){
        console.log(ev);
        //console.log(document.querySelector('#'+toggleDiv));
        toggleId = document.getElementById(ev.target.parentNode.id);
        toggleId.classList.toggle('wbcshow');
        return;
    }
}, false);
  