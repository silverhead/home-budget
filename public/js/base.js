/*document.addEventListener('DOMContentLoaded', function() {
    var alertBoxElements = document.querySelector('.material-alert .close-alert');
    if (alertBoxElements != null){
        alertBoxElements.addEventListener('click', function(){
            materializejsExtension.fadeout(this.parentElement, 50);
        });
    }
});*/
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
