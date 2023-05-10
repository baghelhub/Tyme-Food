var FB_Analytics_Overview=function(){function e(){this.wrapperElement=null,this.wrapperClass=".firebox-analytics-overview",this.itemsClass=".overview-items",this.itemClass=".overview-item",this.chartCanvas=".firebox-analytics-overview-chart.chart",this.pieCanvas=".firebox-analytics-overview-chart.pie"}var t=e.prototype;return t.canRun=function(){var e=document.querySelector(this.wrapperClass);return!!e&&(this.wrapperElement=e,!0)},t.init=function(){if(!this.canRun())return!1;this.initDependencies(),this.run()},t.initDependencies=function(){this.filters=new FB_Analytics_Overview_Filters(this)},t.run=function(){this.filters.updateOverviewData(),this.onResize()},t.onResize=function(){window.onresize=function(e){for(var t in Chart.instances)Chart.instances[t].resize()}},t.renderPie=function(e){var t=e.querySelector(this.pieCanvas),i=JSON.parse(t.getAttribute("data-chart-colors"))||!1,r=JSON.parse(t.getAttribute("data-chart-data"))||!1;if(i&&r){var a=[],s=[],n=[],l=[];for(item in r){var o=r[item];a.push(o.total),n.push(o.label),s.push(i[item]),l.push(o.metric)}var c={type:"pie",data:{datasets:[{data:a,backgroundColor:s}],labels:n},options:{maintainAspectRatio:!1,responsive:!0,plugins:{tooltip:{callbacks:{label:function(e){return" "+e.formattedValue+" "+l[e.dataIndex]}}},datalabels:{formatter:function(e){return e.formattedValue},color:"#fff"}}}},v=t.getContext("2d");new Chart(v,c)}},t.renderChart=function(e){var t=e.querySelector(this.chartCanvas),i=t.getContext("2d"),r=t.getAttribute("data-chart-colors")||"#ff0000",a=JSON.parse(t.getAttribute("data-chart-data"))||[],s=Object.keys(a).map(function(e){return a[e].label}),n=Object.keys(a).map(function(e){return a[e].total}),l=t.getAttribute("data-chart-suffix"),o=(t.getAttribute("data-chart-decimal-points"),i.createLinearGradient(0,0,0,400));o.addColorStop(0,this.hexToRGB(r,.6)),o.addColorStop(1,this.hexToRGB(r,.05)),new Chart(i,{type:"line",data:{labels:s,datasets:[{backgroundColor:o,data:n,borderWidth:1,borderColor:r,pointRadius:0}]},options:{responsive:!0,maintainAspectRatio:!1,plugins:{legend:{display:!1},tooltip:{enabled:!0,mode:"nearest",axis:"x",intersect:!1,callbacks:{label:function(e){return e.formattedValue+l}}},datalabels:!1},title:{display:!1},hover:{mode:"index",intersect:!1},layout:{padding:{top:10,left:10,right:10,bottom:10}},scales:{x:{offset:!0,display:!1,grid:{drawBorder:!1,display:!1}},y:{display:!1,grid:{drawBorder:!1,display:!1}}}},plugins:[{afterDraw:function(e){var t,i,r,a,s;e.tooltip._active&&e.tooltip._active.length&&(t=e.tooltip._active[0],i=e.ctx,r=t.element.x,a=e.scales.y.top,s=e.scales.y.bottom,i.save(),i.beginPath(),i.moveTo(r,a),i.lineTo(r,s),i.setLineDash([1,1]),i.lineWidth=2,i.strokeStyle="#a1a1a1",i.stroke(),i.restore())}}]})},t.hexToRGB=function(e,t){var i=parseInt(e.slice(1,3),16),r=parseInt(e.slice(3,5),16),a=parseInt(e.slice(5,7),16);return t?"rgba("+i+", "+r+", "+a+", "+t+")":"rgb("+i+", "+r+", "+a+")"},e}(),FB_Analytics_Overview_Filters=function(){function e(e){this.overview=e,this.filtersStorageKey="firebox_analytics_overview_filters",this.filterItemsWrapperClass=".overview-filters-wrapper",this.filterItemsWrapper=null,this.filterItemClass=".overview-filter-item",this.filterValuesDropdown=".overview-filter-dropdown-values",this.setup()}var t=e.prototype;return t.canRun=function(){var e=document.querySelector(this.filterItemsWrapperClass);return!!e&&(this.filterItemsWrapper=e,!0)},t.setup=function(){if(!this.canRun())return!1;var e=JSON.parse(localStorage.getItem(this.filtersStorageKey));this.selected_filters=e&&Object.keys(e).length?e:this.getDefaultFilters(),this.initializeFiltersValues(),this.handleOverviewFilterClick()},t.initializeFiltersValues=function(){var r=this;this.filterItemsWrapper.querySelectorAll(this.filterItemClass).forEach(function(e){var t,i=e.getAttribute("data-filter")||"";i&&(!r.selected_filters.hasOwnProperty(i)||(t=e.querySelector('li[data-key="'+r.selected_filters[i]+'"]'))&&(t.classList.add("is-selected"),r.updateFilterLabel(e,t.innerHTML)))})},t.updateFilterLabel=function(e,t){e.closest(".overview-filter-item").querySelector(".filter-title-label").innerHTML=t},t.getDefaultFilters=function(){return JSON.parse(this.overview.wrapperElement.getAttribute("data-default-filters"))||[]},t.handleOverviewFilterClick=function(){document.addEventListener("click",function(e){var t=e.target.closest("li");if(t&&t.closest(this.filterItemClass)){var i=t.closest(this.filterItemClass);if(t.classList.contains("is-selected"))return;this.clearFilterValue(i),t.classList.add("is-selected"),this.updateOverviewData(),this.updateFilterLabel(i,t.innerHTML),e.preventDefault()}}.bind(this))},t.updateOverviewData=function(){var t=this,e=this.filterItemsWrapper.querySelector('input[type="hidden"].nonce_hidden').value,i=this.getAllSelectedFiltersData(),r=this.getAllOverviewItemsForUpdate(),a=new FormData;a.append("nonce",e),a.append("action","fb_analytics_overview_items_update"),a.append("selected_filter_data",JSON.stringify(i)),a.append("updating_overview_items",JSON.stringify(r)),this.showOverviewLoader(),fetch(fpf_js_object.ajax_url,{method:"POST",body:a}).then(function(e){return e.json()}).then(function(e){return!!e.data&&(t.updateSelectedFilters(i),void t.populateOverviewItems(e.data))}).finally(function(){t.hideOverviewLoader()})},t.populateOverviewItems=function(e){for(item in e){var t=e[item];null!=this.overview.wrapperElement.querySelector(this.overview.itemClass+'[data-overview-item-name="'+item+'"]')?this.updateOverviewItem(item,t):this.appendOverviewItem(item,t),this.afterUpdate(t)}},t.afterUpdate=function(e){var t=e.overview_type,i=this.overview.wrapperElement.querySelector(this.overview.itemClass+'[data-overview-item-name="'+e.overview_item_name+'"]');"chart"==t?this.overview.renderChart(i):"pie"==t&&this.overview.renderPie(i)},t.updateSelectedFilters=function(e){localStorage.setItem(this.filtersStorageKey,JSON.stringify(e))},t.updateOverviewItem=function(e,t){var i=this.overview.wrapperElement.querySelector(this.overview.itemClass+'[data-overview-item-name="'+e+'"]');this.commonOverviewItemUpdate(i,t)},t.appendOverviewItem=function(e,t){var i=this.overview.wrapperElement.querySelector(this.overview.itemClass+".template").cloneNode(!0);i.classList.remove("template"),i.classList.add(t.layout),this.commonOverviewItemUpdate(i,t),this.overview.wrapperElement.querySelector(this.overview.itemsClass).appendChild(i)},t.commonOverviewItemUpdate=function(e,t){e.setAttribute("data-overview-item-name",t.overview_item_name);var i=e.querySelector(".overview-message");i.classList.remove("is-visible"),(t.hasOwnProperty("current_period")&&t.current_period.hasOwnProperty("data")&&0==Object.keys(t.current_period.data).length||0==t.total)&&(i.innerHTML=i.getAttribute("data-no-data"),i.classList.add("is-visible"));var r=e.querySelector(".top .title a"),a=r.getAttribute("href");t.redirect_base||(a+="&"+t.toolbar_items_url_safe,t.hasOwnProperty("metrics_url_safe")&&(a+="&"+t.metrics_url_safe)),r.setAttribute("href",a);var s=t.overview_title?t.overview_title:t.label;r.innerHTML=s;var n=t.suffix||"";t.total&&t.show_total?(e.querySelector(".top .total").innerHTML=FPF_Helper.number_format(t.total,t.decimal_points)+n,e.querySelector(".top .total").setAttribute("title",s)):e.querySelector(".top .total").innerHTML="";var l,o=e.querySelector(".details .percentage");t.hasOwnProperty("percentage_change")&&0!=t.percentage_change?(o.closest(".details").classList.add("is-visible"),l=0<t.percentage_change?"up":"down",o.classList.remove("up"),o.classList.remove("down"),o.classList.add(l),o.innerHTML=FPF_Helper.number_format(t.percentage_change,t.decimal_points)+"%",o.classList.add("is-visible")):(o.innerHTML="",o.classList.remove("is-visible")),e.querySelector(".overview-content-outer").innerHTML=t.content},t.clearFilterValue=function(e){var t=e.querySelector("li.is-selected");t&&t.classList.remove("is-selected")},t.getAllSelectedFiltersData=function(){if(!this.filterItemsWrapper)return{};var r={};return this.filterItemsWrapper.querySelectorAll(this.filterItemClass).forEach(function(e){var t=e.getAttribute("data-filter"),i=e.querySelector("li.is-selected");i&&(r[t]=i.getAttribute("data-key"))}),r},t.getAllOverviewItemsForUpdate=function(){return JSON.parse(this.overview.wrapperElement.getAttribute("data-overview-items-names"))||[]},t.getOverviewLoaderElement=function(){return this.overview.wrapperElement.querySelector(".overview-items-loader")},t.showOverviewLoader=function(){this.getOverviewLoaderElement().classList.remove("is-hidden")},t.hideOverviewLoader=function(){this.getOverviewLoaderElement().classList.add("is-hidden")},t.showOverviewFiltersLoader=function(){this.filterItemsWrapper.classList.remove("is-visible")},t.hideOverviewFiltersLoader=function(){this.filterItemsWrapper.classList.add("is-visible")},e}();document.addEventListener("DOMContentLoaded",function(){(new FB_Analytics_Overview).init()});

