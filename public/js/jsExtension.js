class Fadeout {
    constructor(elt, duration){
        if (typeof(duration) == 'undefined'){
            duration = 200;
        }

        let fadeEffect = setInterval(function () {
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
};

jsExtension =  {
    fadeout: function(elt, duration){
        return new fadeout(lt, duration);
    },
    dragAndDrop: function(options){
        let defaults = {
            draggable: '',
            target: 'target',
            handle: null,
            onStart: function(e){},
            onEnd: function(e){},
            onOver: function(e){},
            onDrop: function(e){},
            onLeave: function(e){},
            onEnter: function(e){}
        };
        let settings = {};
        for(let setting in defaults){
            if (options.hasOwnProperty(setting)){
                settings[setting] = options[setting];
            }
            else{
                settings[setting] = defaults[setting];
            }
        }

        let draggable = settings.draggable;
        let dragableElts = document.querySelectorAll(draggable);

        if (settings.handle !== null){
            let handleElts = document.querySelectorAll(settings.handle);
            for (handleElt of handleElts){
                handleElt.style.cursor = "grabbing";
                handleElt.addEventListener('mousedown', function(e){
                    e.target.closest(draggable).draggable = true;
                });
            }
        }

        for(let i = 0; i < dragableElts.length; i++) {
            if (settings.handle === null) {
                dragableElts[i].draggable = true;
            }
            dragableElts[i].addEventListener("dragstart", settings.onStart);
            dragableElts[i].addEventListener("dragend", function(e){
                e.target.draggable = false;
                settings.onEnd(e);
            });
        }


        for(let i = 0; i < settings.target.length; i++) {
            settings.target[i].addEventListener("dragover", settings.onOver, false);
            settings.target[i].addEventListener("dragenter", settings.onEnter, false);
            settings.target[i].addEventListener("dragleave", settings.onLeave, false);
        }
    },
    tagsInput: function() {
        // Default state
        var defaults = {
            selector : '',
            max : null,
            duplicate: false,
            wrapperClass : 'tags-input-wrapper',
            tagClass : 'tag'
        }

        // Initialize elements
        this.arr = [];
        this.input = document.createElement('input');
        this.wrapper = document.createElement('div');
        if(arguments[0] && typeof arguments[0]  === "object") {
            this.options = Object.assign(defaults, arguments[0]);
        }
        this.original_input = document.getElementById(this.options.selector);

        buildUI.call(this);
        addEvents.call(this);

        // Building UI Elements
        function buildUI() {
            this.wrapper.append(this.input);
            this.wrapper.classList.add(this.options.wrapperClass);
            this.original_input.setAttribute('hidden', 'true');
            this.original_input.parentNode.insertBefore(this.wrapper, this.original_input);
        }

        // Initialize Events
        function addEvents() {
            var _ = this;
            this.wrapper.addEventListener('click', function() {
                _.input.focus();
            });

            this.input.addEventListener('keydown', function(event) {
                var str = _.input.value.trim();
                if (!!(~[9, 13, 188].indexOf(event.keyCode))) {
                    _.input.value = "";
                    if(str != "") {
                        _.addTag(str);
                    }
                }
            });
        }

        // Add Tag
        tagsInput.prototype.addTag = function(string) {
            if(this.anyErrors(string)) return;

            this.arr.push(string);
            var tagInput = this;

            var tag = document.createElement('span');
            tag.className = this.options.tagClass;
            tag.textContent = string;

            var closeIcon = document.createElement('a');
            closeIcon.innerHTML = '&times;';
            closeIcon.addEventListener('click', function(event) {
                event.preventDefault();
                var tag = this.parentNode;

                for(var i =0 ;i < tagInput.wrapper.childNodes.length ; i++){
                    if(tagInput.wrapper.childNodes[i] == tag)
                        tagInput.deleteTag(tag , i);
                }
            });

            tag.appendChild(closeIcon);
            this.wrapper.insertBefore(tag, this.input);

            this.original_input.value = this.arr.join(',');
            return this;
        }

        // Delete Tag
        tagsInput.prototype.deleteTag = function(tag, i) {
            tag.remove();
            this.arr.splice(i, 1);
            this.original_input.value = this.arr.join(',');
            return this;
        }

        // Errors
        tagsInput.prototype.anyErrors = function(string) {
            if( this.options.max != null && this.arr.length >= this.options.max) {
                console.log('Max tags limit reached');
                return true;
            }

            if(!this.options.duplicate && this.arr.indexOf(string) != -1 ){
                console.log('duplicate found " '+string+' " ')
                return true;
            }

            return false;
        }

        tagsInput.prototype.addData = function(array){
            var plugin = this;

            array.forEach(function(string){
                plugin.addTag(string);
            })
            return this;
        }
    },
    ajax: function(options){
        let defaults = {
            url: '',
            contentType: 'application/x-www-form-urlencoded',
            addingHeaders: [],
            method: 'POST',
            data: '',
            onSuccess: function(responseText){},
            onError: function(status, responseText){}
        };
        let settings = {};
        for(let setting in defaults){
            if (options.hasOwnProperty(setting)){
                settings[setting] = options[setting];
            }
            else{
                settings[setting] = defaults[setting];
            }
        }

        console.log(settings);

        let xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function()
        {
            if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
            {
                settings.onSuccess(xmlHttp.responseText);
            }
            else{
                settings.onError(xmlHttp.status, xmlHttp.responseText);
            }
        }
        // xmlHttp.setRequestHeader('contentType', settings.contentType);
        // for(let header in settings.addingHeaders){
        //     xmlHttp.setRequestHeader(header, settings.addingHeaders[header]);
        // }
        xmlHttp.open(settings.method, settings.url);
        xmlHttp.send(settings.data);
    },
    Modal: class {
        constructor(element) {
            this.element = element;

            // for get height and width
            this.element.style.display = 'block';

            this.element.style.top = '50%';
            this.element.style.left = '50%';
            this.element.style.marginTop = (-1*this.element.offsetHeight/2) + 'px';
            this.element.style.marginLeft = (-1*this.element.offsetWidth/2) + 'px';
            this.element.style.display = '';
        }
        hide() {
            this.element.style.display = 'none';
        }
        show() {
            this.element.style.display = 'block';
        }
    }
}
