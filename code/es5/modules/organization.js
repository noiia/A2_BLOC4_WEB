!/**
 * Highcharts JS v11.4.0 (2024-03-04)
 * Organization chart series type
 *
 * (c) 2019-2024 Torstein Honsi
 *
 * License: www.highcharts.com/license
 */function(t){"object"==typeof module&&module.exports?(t.default=t,module.exports=t):"function"==typeof define&&define.amd?define("highcharts/modules/organization",["highcharts","highcharts/modules/sankey"],function(i){return t(i),t.Highcharts=i,t}):t("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(t){"use strict";var i=t?t._modules:{};function e(t,i,e,n){t.hasOwnProperty(i)||(t[i]=n.apply(null,e),"function"==typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:i,module:t[i]}})))}e(i,"Series/Organization/OrganizationPoint.js",[i["Core/Series/SeriesRegistry.js"],i["Core/Utilities.js"]],function(t,i){var e,n=this&&this.__extends||(e=function(t,i){return(e=Object.setPrototypeOf||({__proto__:[]})instanceof Array&&function(t,i){t.__proto__=i}||function(t,i){for(var e in i)Object.prototype.hasOwnProperty.call(i,e)&&(t[e]=i[e])})(t,i)},function(t,i){if("function"!=typeof i&&null!==i)throw TypeError("Class extends value "+String(i)+" is not a constructor or null");function n(){this.constructor=t}e(t,i),t.prototype=null===i?Object.create(i):(n.prototype=i.prototype,new n)}),o=t.seriesTypes.sankey.prototype.pointClass,r=i.defined,s=i.find,a=i.pick;return function(t){function i(i,e,n){var o=t.call(this,i,e,n)||this;return o.isNode||(o.dataLabelOnNull=!0,o.formatPrefix="link"),o}return n(i,t),i.prototype.getSum=function(){return 1},i.prototype.setNodeColumn=function(){t.prototype.setNodeColumn.call(this);var i=this,e=i.getFromNode().fromNode;if(!r(i.options.column)&&0!==i.linksTo.length&&e&&"hanging"===e.options.layout){var n=-1,o=void 0;i.options.layout=a(i.options.layout,"hanging"),i.hangsFrom=e,s(e.linksFrom,function(t,e){var o=t.toNode===i;return o&&(n=e),o});for(var h=0;h<e.linksFrom.length;++h)(o=e.linksFrom[h]).toNode.id===i.id?h=e.linksFrom.length:n+=function t(i){var e=i.linksFrom.length;return i.linksFrom.forEach(function(i){i.id===i.toNode.linksTo[0].id?e+=t(i.toNode):e--}),e}(o.toNode);i.column=(i.column||0)+n}},i}(o)}),e(i,"Series/Organization/OrganizationSeriesDefaults.js",[],function(){return{borderColor:"#666666",borderRadius:3,link:{color:"#666666",lineWidth:1,radius:10,type:"default"},borderWidth:1,dataLabels:{nodeFormatter:function(){var t={width:"100%",height:"100%",display:"flex","flex-direction":"row","align-items":"center","justify-content":"center"},i={"max-height":"100%","border-radius":"50%"},e={width:"100%",padding:0,"text-align":"center","white-space":"normal"};function n(t){return Object.keys(t).reduce(function(i,e){return i+e+":"+t[e]+";"},'style="')+'"'}var o=this.point,r=o.description,s=o.image,a=o.title;s&&(i["max-width"]="30%",e.width="70%"),this.series.chart.renderer.forExport&&(t.display="block",e.position="absolute",e.left=s?"30%":0,e.top=0);var h="<div "+n(t)+">";return s&&(h+='<img src="'+s+'" '+n(i)+">"),h+="<div "+n(e)+">",this.point.name&&(h+="<h4 "+n({margin:0})+">"+this.point.name+"</h4>"),a&&(h+="<p "+n({margin:0})+">"+(a||"")+"</p>"),r&&(h+="<p "+n({opacity:.75,margin:"5px"})+">"+r+"</p>"),h+="</div></div>"},style:{fontWeight:"normal",fontSize:"0.9em"},useHTML:!0,linkTextPath:{attributes:{startOffset:"95%",textAnchor:"end"}}},hangingIndent:20,hangingIndentTranslation:"inherit",hangingSide:"left",minNodeLength:10,nodeWidth:50,tooltip:{nodeFormat:"{point.name}<br>{point.title}<br>{point.description}"}}}),e(i,"Series/PathUtilities.js",[],function(){function t(t,i){for(var e=[],n=0;n<t.length;n++){var o=t[n][1],r=t[n][2];if("number"==typeof o&&"number"==typeof r){if(0===n)e.push(["M",o,r]);else if(n===t.length-1)e.push(["L",o,r]);else if(i){var s=t[n-1],a=t[n+1];if(s&&a){var h=s[1],l=s[2],p=a[1],d=a[2];if("number"==typeof h&&"number"==typeof p&&"number"==typeof l&&"number"==typeof d&&h!==p&&l!==d){var u=h<p?1:-1,g=l<d?1:-1;e.push(["L",o-u*Math.min(Math.abs(o-h),i),r-g*Math.min(Math.abs(r-l),i)],["C",o,r,o,r,o+u*Math.min(Math.abs(o-p),i),r+g*Math.min(Math.abs(r-d),i)])}}}else e.push(["L",o,r])}}return e}return{applyRadius:t,getLinkPath:{default:function(i){var e=i.x1,n=i.y1,o=i.x2,r=i.y2,s=i.width,a=void 0===s?0:s,h=i.inverted,l=void 0!==h&&h,p=i.radius,d=i.parentVisible,u=[["M",e,n],["L",e,n],["C",e,n,e,r,e,r],["L",e,r],["C",e,n,e,r,e,r],["L",e,r]];return d?t([["M",e,n],["L",e+a*(l?-.5:.5),n],["L",e+a*(l?-.5:.5),r],["L",o,r]],p):u},straight:function(t){var i=t.x1,e=t.y1,n=t.x2,o=t.y2,r=t.width,s=t.inverted;return t.parentVisible?[["M",i,e],["L",i+(void 0===r?0:r)*(void 0!==s&&s?-1:1),o],["L",n,o]]:[["M",i,e],["L",i,o],["L",i,o]]},curved:function(t){var i=t.x1,e=t.y1,n=t.x2,o=t.y2,r=t.offset,s=void 0===r?0:r,a=t.width,h=void 0===a?0:a,l=t.inverted,p=void 0!==l&&l;return t.parentVisible?[["M",i,e],["C",i+s,e,i-s+h*(p?-1:1),o,i+h*(p?-1:1),o],["L",n,o]]:[["M",i,e],["C",i,e,i,o,i,o],["L",n,o]]}}}}),e(i,"Series/Organization/OrganizationSeries.js",[i["Series/Organization/OrganizationPoint.js"],i["Series/Organization/OrganizationSeriesDefaults.js"],i["Core/Series/SeriesRegistry.js"],i["Series/PathUtilities.js"],i["Core/Utilities.js"]],function(t,i,e,n,o){var r,s=this&&this.__extends||(r=function(t,i){return(r=Object.setPrototypeOf||({__proto__:[]})instanceof Array&&function(t,i){t.__proto__=i}||function(t,i){for(var e in i)Object.prototype.hasOwnProperty.call(i,e)&&(t[e]=i[e])})(t,i)},function(t,i){if("function"!=typeof i&&null!==i)throw TypeError("Class extends value "+String(i)+" is not a constructor or null");function e(){this.constructor=t}r(t,i),t.prototype=null===i?Object.create(i):(e.prototype=i.prototype,new e)}),a=e.seriesTypes.sankey,h=o.css,l=o.extend,p=o.isNumber,d=o.merge,u=o.pick,g=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return s(e,t),e.prototype.alignDataLabel=function(i,e,n){var o=i.shapeArgs;if(n.useHTML&&o){var r=this.options.borderWidth+2*this.options.dataLabels.padding,s=o.width||0,a=o.height||0;this.chart.inverted&&(s=a,a=o.width||0),a-=r,s-=r;var l=e.text;l&&(h(l.element.parentNode,{width:s+"px",height:a+"px"}),h(l.element,{left:0,top:0,width:"100%",height:"100%",overflow:"hidden"})),e.getBBox=function(){return{width:s,height:a,x:0,y:0}},e.width=s,e.height=a}t.prototype.alignDataLabel.apply(this,arguments)},e.prototype.createNode=function(i){var e=t.prototype.createNode.call(this,i);return e.getSum=function(){return 1},e},e.prototype.pointAttribs=function(t,i){var e=a.prototype.pointAttribs.call(this,t,i),n=t.isNode?t.level:t.fromNode.level,o=this.mapOptionsToLevel[n||0]||{},r=t.options,s=o.states&&o.states[i]||{},h=u(s.borderRadius,r.borderRadius,o.borderRadius,this.options.borderRadius),l=u(s.linkColor,r.linkColor,o.linkColor,this.options.linkColor,s.link&&s.link.color,r.link&&r.link.color,o.link&&o.link.color,this.options.link&&this.options.link.color),d=u(s.linkLineWidth,r.linkLineWidth,o.linkLineWidth,this.options.linkLineWidth,s.link&&s.link.lineWidth,r.link&&r.link.lineWidth,o.link&&o.link.lineWidth,this.options.link&&this.options.link.lineWidth),g=u(s.linkOpacity,r.linkOpacity,o.linkOpacity,this.options.linkOpacity,s.link&&s.link.linkOpacity,r.link&&r.link.linkOpacity,o.link&&o.link.linkOpacity,this.options.link&&this.options.link.linkOpacity);return t.isNode?p(h)&&(e.r=h):(e.stroke=l,e["stroke-width"]=d,e.opacity=g,delete e.fill),e},e.prototype.translateLink=function(t){var i=this.chart,e=this.options,o=t.fromNode,r=t.toNode,s=u(e.linkLineWidth,e.link.lineWidth),a=Math.round(s)%2/2,h=u(e.link.offset,.5),l=u(t.options.link&&t.options.link.type,e.link.type);if(o.shapeArgs&&r.shapeArgs){var p=e.hangingIndent,d="right"===e.hangingSide,g=r.options.offset,f=/%$/.test(g)&&parseInt(g,10),c=i.inverted,y=Math.floor((o.shapeArgs.x||0)+(o.shapeArgs.width||0))+a,k=Math.floor((o.shapeArgs.y||0)+(o.shapeArgs.height||0)/2)+a,m=Math.floor(r.shapeArgs.x||0)+a,v=Math.floor((r.shapeArgs.y||0)+(r.shapeArgs.height||0)/2)+a,b=void 0;if(c&&(y-=o.shapeArgs.width||0,m+=r.shapeArgs.width||0),b=this.colDistance?Math.floor(m+(c?1:-1)*(this.colDistance-this.nodeWidth)/2)+a:Math.floor((m+y)/2)+a,f&&(f>=50||f<=-50)&&(b=m=Math.floor(m+(c?-.5:.5)*(r.shapeArgs.width||0))+a,v=r.shapeArgs.y||0,f>0&&(v+=r.shapeArgs.height||0)),r.hangsFrom===o&&(i.inverted?(k=d?Math.floor((o.shapeArgs.y||0)+p/2)+a:Math.floor((o.shapeArgs.y||0)+(o.shapeArgs.height||0)-p/2)+a,v=d?(r.shapeArgs.y||0)+p/2:(r.shapeArgs.y||0)+(r.shapeArgs.height||0)):k=Math.floor((o.shapeArgs.y||0)+p/2)+a,b=m=Math.floor((r.shapeArgs.x||0)+(r.shapeArgs.width||0)/2)+a),t.plotX=b,t.plotY=(k+v)/2,t.shapeType="path","straight"===l)t.shapeArgs={d:[["M",y,k],["L",m,v]]};else if("curved"===l){var L=Math.abs(m-y)*h*(c?-1:1);t.shapeArgs={d:[["M",y,k],["C",y+L,k,m-L,v,m,v]]}}else t.shapeArgs={d:n.applyRadius([["M",y,k],["L",b,k],["L",b,v],["L",m,v]],u(e.linkRadius,e.link.radius))};t.dlBox={x:(y+m)/2,y:(k+v)/2,height:s,width:0}}},e.prototype.translateNode=function(i,e){t.prototype.translateNode.call(this,i,e);var n=this.chart,o=this.options,r=Math.max(Math.round(i.getSum()*this.translationFactor),o.minLinkWidth||0),s="right"===o.hangingSide,a=o.hangingIndent||0,h=o.hangingIndentTranslation,l=o.minNodeLength||10,p=Math.round(this.nodeWidth),u=i.shapeArgs,g=n.inverted?-1:1,f=i.hangsFrom;if(f){if("cumulative"===h)for(u.height-=a,n.inverted&&!s&&(u.y-=g*a);f;)u.y+=(s?1:g)*a,f=f.hangsFrom;else if("shrink"===h)for(;f&&u.height>a+l;)u.height-=a,(!n.inverted||s)&&(u.y+=a),f=f.hangsFrom;else u.height-=a,(!n.inverted||s)&&(u.y+=a)}i.nodeHeight=n.inverted?u.width:u.height,i.shapeArgs&&!i.hangsFrom&&(i.shapeArgs=d(i.shapeArgs,{x:(i.shapeArgs.x||0)+p/2-(i.shapeArgs.width||0)/2,y:(i.shapeArgs.y||0)+r/2-(i.shapeArgs.height||0)/2}))},e.prototype.drawDataLabels=function(){var i=this.options.dataLabels;if(i.linkTextPath&&i.linkTextPath.enabled)for(var e=0,n=this.points;e<n.length;e++){var o=n[e];o.options.dataLabels=d(o.options.dataLabels,{useHTML:!1})}t.prototype.drawDataLabels.call(this)},e.defaultOptions=d(a.defaultOptions,i),e}(a);return l(g.prototype,{pointClass:t}),e.registerSeriesType("organization",g),g}),e(i,"masters/modules/organization.src.js",[i["Core/Globals.js"]],function(t){return t})});