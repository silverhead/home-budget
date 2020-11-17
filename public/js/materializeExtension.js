materializejsExtension =  {
    fadeout: function(elt, duration){
        if (typeof(duration) == 'undefined'){
            duration = 200;
        }

        var fadeEffect = setInterval(function () {
            if (!elt.style.opacity) {
                elt.style.opacity = 1;
            }
            if (elt.style.opacity > 0) {
                elt.style.opacity -= 0.1;
            } else {
                clearInterval(fadeEffect);
            }
        }, duration);
    }
}
