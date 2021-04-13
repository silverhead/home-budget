document.addEventListener('DOMContentLoaded', function() {
    let targetDropId = "";
    let targetElt = null;
    let modal = new jsExtension.Modal(document.getElementById('addTagModal'));

    document.getElementById('cancelAddEntryTag').addEventListener('click', function(){
        modal.hide();
    });

    jsExtension.dragAndDrop({
        draggable: '.entry',
        handle: '.handle',
        target: document.querySelectorAll('.droppable'),
        onOver: function(e){

            // If over on children of target
            if (e.target.tagName != 'li'){
                targetElt = e.target.closest("li");
            }
            else{
                targetElt = e.target;
            }

            targetElt.style="opacity:0.5";
        },
        onLeave: function(e){
            targetElt.style="opacity:1";
        },
        onEnd: function(e){
            e.preventDefault();

            if (targetElt !== null){
                let label = e.target.getElementsByClassName('label')[0].innerHTML;
                document.getElementById('category_id').value = targetElt.getAttribute('data-id');
                document.getElementById('category_label').innerHTML = targetElt.getElementsByClassName('label')[0].innerHTML;
                document.getElementById('tag_label').value = label;


                modal.show();
            }
        }
    });

    document.getElementById('saveAddEntryTag').addEventListener('click', function(){saveEntryTag(modal)});
});

function saveEntryTag(modal){
    let id = document.getElementById('category_id').value;
    let tagLabel = document.getElementById('tag_label').value;

    minAjax({
        url:document.getElementById('urlAddEntryTag').value,//request URL
        type:"POST",//Request type GET/POST
        //Send Data in form of GET/POST
        data:{
            id: id,
            tagLabel:tagLabel
        },
        //CALLBACK FUNCTION with RESPONSE as argument
        success: function(data){
            modal.hide();
        }
    });
}
