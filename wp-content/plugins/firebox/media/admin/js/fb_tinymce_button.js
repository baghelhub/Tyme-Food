var FBox_TinyMCE_Button=function(){function e(){if(!this.canRun())return!1;this.addButton()}var t=e.prototype;return t.canRun=function(){return!document.body.classList.contains("block-editor-page")},t.addButton=function(){var n=this,t=wp.i18n,a=null;wp.apiFetch({path:"/fireplugins/firebox/boxes"}).then(function(e){a=n.parse_boxes(e)}),tinymce.PluginManager.add("fireplugins_firebox",function(o,e){o.addButton("fireplugins_firebox",{title:t.__("Add a FireBox Button","firebox"),icon:"fpf-mce-icons dashicons dashicons-plus",onclick:function(){o.windowManager.open({title:t.__("Add a FireBox Button","firebox"),body:[{type:"label",label:t.__("Choose the FireBox you'd like to handle.","firebox")},{type:"listbox",name:"box_id",label:t.__("Select a FireBox","firebox"),values:a},{type:"listbox",name:"box_cmd",label:t.__("FireBox Action","firebox"),value:"close",values:[{text:t.__("Open","firebox"),value:"open"},{text:t.__("Close","firebox"),value:"close"},{text:t.__("Toggle","firebox"),value:"toggle"}]},{type:"textbox",name:"button_label",label:t.__("Button Label","firebox"),value:t.__("Close","firebox")},{type:"textbox",name:"button_classes",label:t.__("Button Classes","firebox"),value:"button"}],onsubmit:function(e){var t=n.getBoxButton(e.data);t.error?alert(t.message):o.insertContent(t.message)}})}})})},t.parse_boxes=function(e){var t=[];return e.map(function(e){t.push({text:e.title,value:e.id})}),t},t.getBoxButton=function(e){if(!e.box_id||!e.box_cmd||!e.button_label)return{message:wp.i18n.__("Please select a box ID, Action and set a Link Label","firebox"),error:!0};return{message:'<a href="#" '+(e.box_id?' data-fbox="'+e.box_id+'"':"")+(e.box_cmd?' data-fbox-cmd="'+e.box_cmd+'"':"")+' data-fbox-prevent="1"'+(e.button_classes?' class="'+e.button_classes+'"':"")+">"+e.button_label+"</a>",error:!1}},e}();new FBox_TinyMCE_Button;
