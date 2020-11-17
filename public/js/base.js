document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.material-alert .close-alert').addEventListener('click', function(){
        materializejsExtension.fadeout(this.parentElement, 50);
    });
});
