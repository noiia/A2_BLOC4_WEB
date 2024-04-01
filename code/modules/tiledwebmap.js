!/**
 * Highcharts JS v11.4.0 (2024-03-04)
 *
 * (c) 2009-2024
 *
 * License: www.highcharts.com/license
 */function(e){"object"==typeof module&&module.exports?(e.default=e,module.exports=e):"function"==typeof define&&define.amd?define("highcharts/modules/tiledwebmap",["highcharts"],function(t){return e(t),e.Highcharts=t,e}):e("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(e){"use strict";var t=e?e._modules:{};function o(e,t,o,i){e.hasOwnProperty(t)||(e[t]=i.apply(null,o),"function"==typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:t,module:e[t]}})))}o(t,"Maps/TilesProviders/OpenStreetMap.js",[],function(){return class{constructor(){this.defaultCredits='Map data &copy2023 <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',this.initialProjectionName="WebMercator",this.subdomains=["a","b","c"],this.themes={Standard:{url:"https://tile.openstreetmap.org/{zoom}/{x}/{y}.png",minZoom:0,maxZoom:19},Hot:{url:"https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png",minZoom:0,maxZoom:19},OpenTopoMap:{url:"https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",minZoom:0,maxZoom:17,credits:`Map data: &copy; <a href="https://www.openstreetmap.org/copyright">
                        OpenStreetMap</a> contributors, <a href="https://viewfinderpanoramas.org">SRTM</a> 
                        | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> 
                        (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)`}}}}}),o(t,"Maps/TilesProviders/Stamen.js",[],function(){return class{constructor(){this.defaultCredits='&copy; Map tiles by <a href="https://stamen.com">Stamen Design</a>, under <a href="https://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="https://openstreetmap.org">OpenStreetMap</a>, under <a href="https://www.openstreetmap.org/copyright">ODbL</a>',this.initialProjectionName="WebMercator",this.subdomains=["a","b","c","d"],this.themes={Toner:{url:"https://stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}.png",minZoom:0,maxZoom:20},TonerBackground:{url:"https://stamen-tiles-{s}.a.ssl.fastly.net/toner-background/{z}/{x}/{y}.png",minZoom:0,maxZoom:20},TonerLite:{url:"https://stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}.png",minZoom:0,maxZoom:20},Terrain:{url:"https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}.png",minZoom:0,maxZoom:18},TerrainBackground:{url:"https://stamen-tiles-{s}.a.ssl.fastly.net/terrain-background/{z}/{x}/{y}.png",minZoom:0,maxZoom:18},Watercolor:{url:"https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.png",minZoom:1,maxZoom:16,credits:'&copy Map tiles by <a href="https://stamen.com">Stamen Design</a>, under <a href="https://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="https://openstreetmap.org">OpenStreetMap</a>, under <a href="https://creativecommons.org/licenses/by-sa/3.0">CC BY SA</a>'}}}}}),o(t,"Maps/TilesProviders/LimaLabs.js",[],function(){return class{constructor(){this.defaultCredits='Map data &copy;2023 <a href="https://maps.lima-labs.com/">LimaLabs</a>',this.initialProjectionName="WebMercator",this.requiresApiKey=!0,this.themes={Standard:{url:"https://cdn.lima-labs.com/{zoom}/{x}/{y}.png?api={apikey}",minZoom:0,maxZoom:20}}}}}),o(t,"Maps/TilesProviders/Thunderforest.js",[],function(){return class{constructor(){this.defaultCredits='Maps &copy <a href="https://www.thunderforest.com">Thunderforest</a>, Data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>',this.initialProjectionName="WebMercator",this.requiresApiKey=!0,this.subdomains=["a","b","c"],this.themes={OpenCycleMap:{url:"https://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22},Transport:{url:"https://{s}.tile.thunderforest.com/transport/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22},TransportDark:{url:"https://{s}.tile.thunderforest.com/transport-dark/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22},SpinalMap:{url:"https://{s}.tile.thunderforest.com/spinal-map/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22},Landscape:{url:"https://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22},Outdoors:{url:"https://{s}.tile.thunderforest.com/outdoors/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22},Pioneer:{url:"https://{s}.tile.thunderforest.com/pioneer/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22},MobileAtlas:{url:"https://{s}.tile.thunderforest.com/mobile-atlas/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22},Neighbourhood:{url:"https://{s}.tile.thunderforest.com/neighbourhood/{z}/{x}/{y}.png?apikey={apikey}",minZoom:0,maxZoom:22}}}}}),o(t,"Maps/TilesProviders/Esri.js",[],function(){return class{constructor(){this.defaultCredits="Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS,  Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012",this.initialProjectionName="WebMercator",this.themes={WorldStreetMap:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:20},DeLorme:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/Specialty/DeLorme_World_Base_Map/MapServer/tile/{z}/{y}/{x}",minZoom:1,maxZoom:11,credits:"Tiles &copy; Esri &mdash; Copyright: &copy;2012 DeLorme"},WorldTopoMap:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:20,credits:"Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community"},WorldImagery:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:20,credits:"Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community"},WorldTerrain:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Terrain_Base/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:13,credits:"Tiles &copy; Esri &mdash; Source: USGS, Esri, TANA, DeLorme, and NPS"},WorldShadedRelief:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Shaded_Relief/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:13,credits:"Tiles &copy; Esri &mdash; Source: Esri"},WorldPhysical:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Physical_Map/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:8,credits:"Tiles &copy; Esri &mdash; Source: US National Park Service"},NatGeoWorldMap:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:16,credits:"Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC"},WorldGrayCanvas:{url:"https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:16,credits:"Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ"}}}}}),o(t,"Maps/TilesProviders/USGS.js",[],function(){return class{constructor(){this.defaultCredits='Tiles courtesy of the <a href="https://usgs.gov/">U.S. GeologicalSurvey</a>',this.initialProjectionName="WebMercator",this.themes={USTopo:{url:"https://basemap.nationalmap.gov/arcgis/rest/services/USGSTopo/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:20},USImagery:{url:"https://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryOnly/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:20},USImageryTopo:{url:"https://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryTopo/MapServer/tile/{z}/{y}/{x}",minZoom:0,maxZoom:20}}}}}),o(t,"Maps/TilesProviders/TilesProviderRegistry.js",[t["Maps/TilesProviders/OpenStreetMap.js"],t["Maps/TilesProviders/Stamen.js"],t["Maps/TilesProviders/LimaLabs.js"],t["Maps/TilesProviders/Thunderforest.js"],t["Maps/TilesProviders/Esri.js"],t["Maps/TilesProviders/USGS.js"]],function(e,t,o,i,r,s){return{Esri:r,LimaLabs:o,OpenStreetMap:e,Stamen:t,Thunderforest:i,USGS:s}}),o(t,"Series/TiledWebMap/TiledWebMapSeriesDefaults.js",[],function(){return{states:{inactive:{enabled:!1}}}}),o(t,"Series/TiledWebMap/TiledWebMapSeries.js",[t["Core/Globals.js"],t["Core/Series/SeriesRegistry.js"],t["Maps/TilesProviders/TilesProviderRegistry.js"],t["Series/TiledWebMap/TiledWebMapSeriesDefaults.js"],t["Core/Utilities.js"]],function(e,t,o,i,r){let{composed:s}=e,{map:a}=t.seriesTypes,{addEvent:n,defined:l,error:p,merge:m,pick:c,pushUnique:h}=r;function d(e){let{geoBounds:t,chart:i}=e,r=(i.options.series||[]).filter(e=>"tiledwebmap"===e.type)[0];if(r&&r.provider&&r.provider.type&&!r.provider.url){let e=o[r.provider.type];if(l(e)){let{initialProjectionName:o}=new e;if(t){let{x1:e,y1:i,x2:r,y2:s}=t;this.recommendedMapView={projection:{name:o,parallels:[i,s],rotation:[-(e+r)/2]}}}else this.recommendedMapView={projection:{name:o},minZoom:0};return!1}p("Highcharts warning: Tiles Provider not defined in the Provider Registry.",!1)}return!0}class u extends a{constructor(){super(...arguments),this.redrawTiles=!1,this.isAnimating=!1}static compose(e){h(s,"TiledWebMapSeries")&&n(e,"onRecommendMapView",d)}lonLatToTile(e,t){let{lon:o,lat:i}=e;return{x:Math.floor((o+180)/360*Math.pow(2,t)),y:Math.floor((1-Math.log(Math.tan(i*Math.PI/180)+1/Math.cos(i*Math.PI/180))/Math.PI)/2*Math.pow(2,t))}}tileToLonLat(e,t,o){let i=Math.PI-2*Math.PI*t/Math.pow(2,o);return{lon:e/Math.pow(2,o)*360-180,lat:180/Math.PI*Math.atan(.5*(Math.exp(i)-Math.exp(-i)))}}drawPoints(){let e=this.chart,t=e.mapView;if(!t)return;let i=this.tiles=this.tiles||{},r=this.transformGroups=this.transformGroups||[],s=this,a=this.options.provider,{zoom:n}=t,m=c(t.projection.options.rotation&&t.projection.options.rotation[0],0),h=e.renderer.forExport?0:200,d=e=>{for(let o of Object.keys(i))parseFloat(o)===(t.zoom<0?0:Math.floor(t.zoom))||s.minZoom&&(t.zoom<0?0:Math.floor(t.zoom))<s.minZoom&&parseFloat(o)===s.minZoom||s.maxZoom&&(t.zoom<0?0:Math.floor(t.zoom))>s.maxZoom&&parseFloat(o)===s.maxZoom?Object.keys(i[o].tiles).forEach((t,r)=>{i[o].tiles[t].animate({opacity:1},{duration:e},()=>{r===Object.keys(i[o].tiles).length-1&&(i[o].isActive=!0)})}):Object.keys(i[o].tiles).forEach((t,r)=>{i[o].tiles[t].animate({opacity:0},{duration:e,defer:e/2},()=>{i[o].tiles[t].destroy(),delete i[o].tiles[t],r===Object.keys(i[o].tiles).length-1&&(i[o].isActive=!1,i[o].loaded=!1)})})},u=n<0?0:Math.floor(n),y=Math.pow(2,u),f=.638436911716859*Math.pow(2,n)/(.638436911716859*Math.pow(2,u)),g=256*f;if(a&&(a.type||a.url)){if(a.type&&!a.url){let i=o[a.type];if(!l(i)){p("Highcharts warning: Tiles Provider '"+a.type+"' not defined in the ProviderRegistry.",!1);return}let r=new i,s=r.initialProjectionName,n,m="";if(a.theme&&l(r.themes[a.theme]))n=r.themes[a.theme];else{let e=Object.keys(r.themes)[0];n=r.themes[e],p("Highcharts warning: The Tiles Provider's Theme '"+a.theme+"' is not defined in the Provider definition - falling back to '"+e+"'.",!1)}a.subdomain&&r.subdomains&&-1!==r.subdomains.indexOf(a.subdomain)?m=a.subdomain:l(r.subdomains)&&-1!==n.url.indexOf("{s}")&&(m=c(r.subdomains&&r.subdomains[0],""),p("Highcharts warning: The Tiles Provider's Subdomain '"+a.subdomain+"' is not defined in the Provider definition - falling back to '"+m+"'.",!1)),r.requiresApiKey&&(a.apiKey?n.url=n.url.replace("{apikey}",a.apiKey):(p("Highcharts warning: The Tiles Provider requires API Key to use tiles, use provider.apiKey to provide a token.",!1),n.url=n.url.replace("?apikey={apikey}",""))),a.url=n.url.replace("{s}",m),this.minZoom=n.minZoom,this.maxZoom=n.maxZoom;let h=c(e.userOptions.credits&&e.userOptions.credits.text,"Highcharts.com "+c(n.credits,r.defaultCredits));e.credits?e.credits.update({text:h}):e.addCredits({text:h,style:c(e.options.credits?.style,{})}),t.projection.options.name!==s&&p("Highcharts warning: The set projection is different than supported by Tiles Provider.",!1)}else t.projection.options.name||p("Highcharts warning: The set projection is different than supported by Tiles Provider.",!1);if(l(this.minZoom)&&u<this.minZoom?(y=Math.pow(2,u=this.minZoom),g=256*(f=.638436911716859*Math.pow(2,n)/(.638436911716859*Math.pow(2,u)))):l(this.maxZoom)&&u>this.maxZoom&&(y=Math.pow(2,u=this.maxZoom),g=256*(f=.638436911716859*Math.pow(2,n)/(.638436911716859*Math.pow(2,u)))),t.projection&&t.projection.def){t.projection.hasCoordinates=!0,r[u]||(r[u]=e.renderer.g().add(this.group));let o=(e,t,o,i)=>e.replace("{x}",t.toString()).replace("{y}",o.toString()).replace("{zoom}",i.toString()).replace("{z}",i.toString()),n=(n,l,p,m,c)=>{let u=n%y,f=l%y,M=u<0?u+y:u,T=f<0?f+y:f;if(!i[`${p}`].tiles[`${n},${l}`]&&a.url){let u=o(a.url,M,T,p);i[p].loaded=!1,i[`${p}`].tiles[`${n},${l}`]=e.renderer.image(u,n*g-m,l*g-c,g,g).attr({zIndex:2,opacity:0}).on("load",function(){a.onload&&a.onload.apply(this),(p===(t.zoom<0?0:Math.floor(t.zoom))||p===s.minZoom)&&(i[`${p}`].actualTilesCount++,i[`${p}`].howManyTiles===i[`${p}`].actualTilesCount&&(i[p].loaded=!0,s.isAnimating?s.redrawTiles=!0:(s.redrawTiles=!1,d(h)),i[`${p}`].actualTilesCount=0))}).add(r[p]),i[`${p}`].tiles[`${n},${l}`].posX=n,i[`${p}`].tiles[`${n},${l}`].posY=l,i[`${p}`].tiles[`${n},${l}`].originalURL=u}},l=t.pixelsToProjectedUnits({x:0,y:0}),p=t.projection.def.inverse([l.x,l.y]),c={lon:p[0]-m,lat:p[1]},f=t.pixelsToProjectedUnits({x:e.plotWidth,y:e.plotHeight}),M=t.projection.def.inverse([f.x,f.y]),T={lon:M[0]-m,lat:M[1]};(c.lat>t.projection.maxLatitude||T.lat<-1*t.projection.maxLatitude)&&(c.lat=t.projection.maxLatitude,T.lat=-1*t.projection.maxLatitude);let x=this.lonLatToTile(c,u),S=this.lonLatToTile(T,u),v=this.tileToLonLat(x.x,x.y,u),b=t.projection.def.forward([v.lon+m,v.lat]),Z=t.projectedUnitsToPixels({x:b[0],y:b[1]}),w=x.x*g-Z.x,j=x.y*g-Z.y;i[`${u}`]||(i[`${u}`]={tiles:{},isActive:!1,howManyTiles:0,actualTilesCount:0,loaded:!1}),i[`${u}`].howManyTiles=(S.x-x.x+1)*(S.y-x.y+1),i[`${u}`].actualTilesCount=0;for(let e=x.x;e<=S.x;e++)for(let t=x.y;t<=S.y;t++)n(e,t,u,w,j)}for(let o of Object.keys(i))for(let r of Object.keys(i[o].tiles))if(t.projection&&t.projection.def){let a=.638436911716859*Math.pow(2,n)/(.638436911716859*Math.pow(2,parseFloat(o)))*256,p=i[o].tiles[Object.keys(i[o].tiles)[0]],{posX:c,posY:y}=i[o].tiles[r];if(l(c)&&l(y)&&l(p.posX)&&l(p.posY)){let n=this.tileToLonLat(p.posX,p.posY,parseFloat(o)),l=t.projection.def.forward([n.lon+m,n.lat]),f=t.projectedUnitsToPixels({x:l[0],y:l[1]}),g=p.posX*a-f.x,M=p.posY*a-f.y;if(e.renderer.globalAnimation&&e.hasRendered){let e=Number(i[o].tiles[r].attr("x")),t=Number(i[o].tiles[r].attr("y")),n=Number(i[o].tiles[r].attr("width")),l=Number(i[o].tiles[r].attr("height")),p=(s,p)=>{i[o].tiles[r].attr({x:e+(c*a-g-e)*p.pos,y:t+(y*a-M-t)*p.pos,width:n+(Math.ceil(a)+1-n)*p.pos,height:l+(Math.ceil(a)+1-l)*p.pos})};s.isAnimating=!0,i[o].tiles[r].attr({animator:0}).animate({animator:1},{step:p},function(){s.isAnimating=!1,s.redrawTiles&&(s.redrawTiles=!1,d(h))})}else(s.redrawTiles||parseFloat(o)!==u||(i[o].isActive||parseFloat(o)===u)&&Object.keys(i[o].tiles).map(e=>i[o].tiles[e]).some(e=>0===e.opacity))&&(s.redrawTiles=!1,d(h)),i[o].tiles[r].attr({x:c*a-g,y:y*a-M,width:Math.ceil(a)+1,height:Math.ceil(a)+1})}}}else p("Highcharts warning: Tiles Provider not defined in the Provider Registry.",!1)}update(){let{transformGroups:e}=this,t=this.chart,i=t.mapView,r=arguments[0],{provider:s}=r;if(e&&(e.forEach(e=>{0!==Object.keys(e).length&&e.destroy()}),this.transformGroups=[]),i&&!l(t.userOptions.mapView?.projection)&&s&&s.type){let e=o[s.type];if(e){let{initialProjectionName:t}=new e;i.update({projection:{name:t}})}}super.update.apply(this,arguments)}}return u.defaultOptions=m(a.defaultOptions,i),t.registerSeriesType("tiledwebmap",u),u}),o(t,"masters/modules/tiledwebmap.src.js",[t["Core/Globals.js"],t["Maps/TilesProviders/TilesProviderRegistry.js"],t["Series/TiledWebMap/TiledWebMapSeries.js"]],function(e,t,o){return e.TilesProviderRegistry=e.TilesProviderRegistry||t,o.compose(e.MapView),e})});