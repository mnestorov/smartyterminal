<div id="panel-terminal-shell-{{ $id }}" class="terminal-panel"></div>
<script>
    (function() {
        let preload = function(){
            let createElement=function(tag, attributes) {
                let id="laravel-terminal-" + attributes.id;
                let element = document.getElementById(id);
                if (element) {
                    return element
                }
                element=document.createElement(tag);
                for (key in attributes) {
                    element.setAttribute(key, attributes[key])
                }
                return element
            };
            let appendTo = function(element) {
                let appendTo = document.getElementsByTagName('head');
                appendTo = appendTo.length > 0? appendTo[0]:document.body;
                appendTo.appendChild(element)
            };
            let f = function(filename) {
                return filename.replace(/\?.*/,'') + '?' + (new Date()).getTime()
            };
            return {
                createElement:function(type,id,filename,callback,retry){
                    let attributes = {},source;
                    if (!retry) {
                        retry = 5
                    }
                    if (type === 'script') {
                        source = 'src';
                        attributes.type = 'text/javascript'
                    } else {
                        source = 'href';
                        attributes.type = 'text/css';
                        attributes.rel = 'stylesheet'
                    }
                    attributes[source] = filename;
                    attributes.id = 'laravel-terminal-' + id;
                    let element = createElement(type, attributes);
                    element.onerror = function(){
                        if (retry === 1) {
                            return
                        }
                        setTimeout(function() {
                            preload.createElement(type, id, f(filename), callback, --retry)
                        })
                    };
                    if (callback) {
                        element.onload = callback
                    }
                    appendTo(element)
                }
            }
        }();

        preload.createElement('link', 'css', '{{ action('\SmartyStudio\SmartyTerminal\Http\Controllers\TerminalController@media', ['file' => 'css/app.css']) }}');
        preload.createElement('script', 'js', '{{ action('\SmartyStudio\SmartyTerminal\Http\Controllers\TerminalController@media', ['file' => 'js/app.js']) }}', function () {
            new Terminal('#panel-terminal-shell-{{ $id }}', {!! $options !!});
        });
    })();
</script>
