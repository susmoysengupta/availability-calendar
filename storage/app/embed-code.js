const style = `<style>.acifc {-webkit-overflow-scrolling: touch; overflow-x: auto;} .acifc iframe {width:100%;}</style>`;
const div = `<div id="{$calendarId}" class="acifc"><iframe data-description="javascript-embed" id="{$iframeId}" name="{$iframeId}" src="{$route}" height="{$height}" width="100%" frameborder="0" allowtransparency="true"></iframe></div>`;
document.write(style);
document.write(div);

window.addEventListener(
    "message",
    function (e) {
        var data = e.data.split("___"),
            bodyHeight = parseInt(data[0]),
            iframe_id = data[1];

        var iframeheight = parseInt(
            document.getElementById("{$iframeId}")
                .scrollHeight
        );

        if (iframe_id == "{$iframeId}" && (bodyHeight - iframeheight > 5 || iframeheight - bodyHeight > 5)){
            document.getElementById("{$iframeId}").style.height = bodyHeight + "px";
        }

        if (self != top && document.body.children.length == 1 && document.body.children[0].id == "{$calendarId}") {
            document.body.style.margin = "0px";
        }
    },
    false
);
