/*
 * Copyright 2013 Small Batch, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
!function(a,b){function g(a){return function(){return this[a]}}function i(a,b){var c=a.split("."),d=h;!(c[0]in d)&&d.execScript&&d.execScript("var "+c[0]);for(var e;c.length&&(e=c.shift());)c.length||void 0===b?d=d[e]?d[e]:d[e]={}:d[e]=b}function j(a){return a.call.apply(a.bind,arguments)}function k(a,b){if(!a)throw Error();if(2<arguments.length){var d=Array.prototype.slice.call(arguments,2);return function(){var c=Array.prototype.slice.call(arguments);return Array.prototype.unshift.apply(c,d),a.apply(b,c)}}return function(){return a.apply(b,arguments)}}function l(){return l=Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?j:k,l.apply(e,arguments)}function n(a,b){this.G=a,this.v=b||a,this.z=this.v.document}function o(a,c,d){a=a.z.getElementsByTagName(c)[0],a||(a=b.documentElement),a&&a.lastChild&&a.insertBefore(d,a.lastChild)}function p(a,b){for(var c=a.className.split(/\s+/),d=0,e=c.length;e>d;d++)if(c[d]==b)return;c.push(b),a.className=c.join(" ").replace(/\s+/g," ").replace(/^\s+|\s+$/,"")}function q(a,b){for(var c=a.className.split(/\s+/),d=[],e=0,f=c.length;f>e;e++)c[e]!=b&&d.push(c[e]);a.className=d.join(" ").replace(/\s+/g," ").replace(/^\s+|\s+$/,"")}function r(a,b){for(var c=a.className.split(/\s+/),e=0,g=c.length;g>e;e++)if(c[e]==b)return d;return f}function s(a){var b=a.v.location.protocol;return"about:"==b&&(b=a.G.location.protocol),"https:"==b?"https:":"http:"}function t(a,b){var c=a.createElement("link",{rel:"stylesheet",href:b}),e=f;c.onload=function(){e||(e=d)},c.onerror=function(){e||(e=d)},o(a,"head",c)}function u(b,c,g,h){var i=b.z.getElementsByTagName("head")[0];if(i){var j=b.createElement("script",{src:c}),k=f;return j.onload=j.onreadystatechange=function(){k||this.readyState&&"loaded"!=this.readyState&&"complete"!=this.readyState||(k=d,g&&g(e),j.onload=j.onreadystatechange=e,"HEAD"==j.parentNode.tagName&&i.removeChild(j))},i.appendChild(j),a.setTimeout(function(){k||(k=d,g&&g(Error("Script load timeout")))},h||5e3),j}return e}function v(a,b,c){this.M=a,this.U=b,this.Aa=c}function w(a,b,c,d){this.d=a!=e?a:e,this.o=b!=e?b:e,this.aa=c!=e?c:e,this.f=d!=e?d:e}function y(a){a=x.exec(a);var b=e,c=e,d=e,f=e;return a&&(a[1]!==e&&a[1]&&(b=parseInt(a[1],10)),a[2]!==e&&a[2]&&(c=parseInt(a[2],10)),a[3]!==e&&a[3]&&(d=parseInt(a[3],10)),a[4]!==e&&a[4]&&(f=/^[0-9]+$/.test(a[4])?parseInt(a[4],10):a[4])),new w(b,c,d,f)}function z(a,b,c,d,e,f,g,h,i,j,k){this.K=a,this.Ga=b,this.za=c,this.fa=d,this.Ea=e,this.ea=f,this.wa=g,this.Fa=h,this.va=i,this.da=j,this.k=k}function A(a,b){this.a=a,this.I=b}function C(a){var b=F(a.a,/(iPod|iPad|iPhone|Android|Windows Phone|BB\d{2}|BlackBerry)/,1);return""!=b?(/BB\d{2}/.test(b)&&(b="BlackBerry"),b):(a=F(a.a,/(Linux|Mac_PowerPC|Macintosh|Windows|CrOS)/,1),""!=a?("Mac_PowerPC"==a&&(a="Macintosh"),a):"Unknown")}function D(a){var b=F(a.a,/(OS X|Windows NT|Android) ([^;)]+)/,2);if(b||(b=F(a.a,/Windows Phone( OS)? ([^;)]+)/,2))||(b=F(a.a,/(iPhone )?OS ([\d_]+)/,2)))return b;if(b=F(a.a,/(?:Linux|CrOS) ([^;)]+)/,1))for(var b=b.split(/\s/),c=0;c<b.length;c+=1)if(/^[\d\._]+$/.test(b[c]))return b[c];return(a=F(a.a,/(BB\d{2}|BlackBerry).*?Version\/([^\s]*)/,2))?a:"Unknown"}function E(a){var b=C(a),c=D(a),d=y(c),e=F(a.a,/AppleWeb(?:K|k)it\/([\d\.\+]+)/,1),g=y(e),h="Unknown",i=new w,j="Unknown",k=f;return/OPR\/[\d.]+/.test(a.a)?h="Opera":-1!=a.a.indexOf("Chrome")||-1!=a.a.indexOf("CrMo")||-1!=a.a.indexOf("CriOS")?h="Chrome":/Silk\/\d/.test(a.a)?h="Silk":"BlackBerry"==b||"Android"==b?h="BuiltinBrowser":-1!=a.a.indexOf("PhantomJS")?h="PhantomJS":-1!=a.a.indexOf("Safari")?h="Safari":-1!=a.a.indexOf("AdobeAIR")&&(h="AdobeAIR"),"BuiltinBrowser"==h?j="Unknown":"Silk"==h?j=F(a.a,/Silk\/([\d\._]+)/,1):"Chrome"==h?j=F(a.a,/(Chrome|CrMo|CriOS)\/([\d\.]+)/,2):-1!=a.a.indexOf("Version/")?j=F(a.a,/Version\/([\d\.\w]+)/,1):"AdobeAIR"==h?j=F(a.a,/AdobeAIR\/([\d\.]+)/,1):"Opera"==h?j=F(a.a,/OPR\/([\d.]+)/,1):"PhantomJS"==h&&(j=F(a.a,/PhantomJS\/([\d.]+)/,1)),i=y(j),k="AdobeAIR"==h?2<i.d||2==i.d&&5<=i.o:"BlackBerry"==b?10<=d.d:"Android"==b?2<d.d||2==d.d&&1<d.o:526<=g.d||525<=g.d&&13<=g.o,new z(h,i,j,"AppleWebKit",g,e,b,d,c,G(a.I),new v(k,536>g.d||536==g.d&&11>g.o,"iPhone"==b||"iPad"==b||"iPod"==b||"Macintosh"==b))}function F(a,b,c){return(a=a.match(b))&&a[c]?a[c]:""}function G(a){return a.documentMode?a.documentMode:void 0}function H(a){this.ua=a||"-"}function I(a,b){this.K=a,this.V=4,this.L="n";var c=(b||"n4").match(/^([nio])([1-9])$/i);c&&(this.L=c[1],this.V=parseInt(c[2],10))}function J(a){return a.L+a.V}function K(a){var b=4,c="n",d=e;return a&&((d=a.match(/(normal|oblique|italic)/i))&&d[1]&&(c=d[1].substr(0,1).toLowerCase()),(d=a.match(/([1-9]00|normal|bold)/i))&&d[1]&&(/bold/i.test(d[1])?b=7:/[1-9]00/.test(d[1])&&(b=parseInt(d[1].substr(0,1),10)))),c+b}function L(a,b,c){this.c=a,this.h=b,this.O=c,this.j="wf",this.g=new H("-")}function M(a){p(a.h,a.g.f(a.j,"loading")),O(a,"loading")}function N(a){q(a.h,a.g.f(a.j,"loading")),r(a.h,a.g.f(a.j,"active"))||p(a.h,a.g.f(a.j,"inactive")),O(a,"inactive")}function O(a,b,c){a.O[b]&&(c?a.O[b](c.getName(),J(c)):a.O[b]())}function P(){this.w={}}function Q(a,b){this.c=a,this.C=b,this.s=this.c.createElement("span",{"aria-hidden":"true"},this.C)}function R(a,b){var c;c=[];for(var d=b.K.split(/,\s*/),e=0;e<d.length;e++){var f=d[e].replace(/['"]/g,"");-1==f.indexOf(" ")?c.push(f):c.push("'"+f+"'")}c=c.join(","),d="normal",e=b.V+"00","o"===b.L?d="oblique":"i"===b.L&&(d="italic"),a.s.style.cssText="position:absolute;top:-999px;left:-999px;font-size:300px;width:auto;height:auto;line-height:normal;margin:0;padding:0;font-variant:normal;white-space:nowrap;font-family:"+c+";"+("font-style:"+d+";font-weight:"+e+";")}function S(a){o(a.c,"body",a.s)}function T(a,b,c,d,f,g,h,i){this.W=a,this.sa=b,this.c=c,this.q=d,this.C=i||"BESbswy",this.k=f,this.F={},this.T=g||5e3,this.Z=h||e,this.B=this.A=e,a=new Q(this.c,this.C),S(a);for(var j in U)U.hasOwnProperty(j)&&(R(a,new I(U[j],J(this.q))),this.F[U[j]]=a.s.offsetWidth);a.remove()}function V(a,b,c){for(var e in U)if(U.hasOwnProperty(e)&&b===a.F[U[e]]&&c===a.F[U[e]])return d;return f}function W(a){var b=a.A.s.offsetWidth,c=a.B.s.offsetWidth;b===a.F.serif&&c===a.F["sans-serif"]||a.k.U&&V(a,b,c)?m()-a.xa>=a.T?a.k.U&&V(a,b,c)&&(a.Z===e||a.Z.hasOwnProperty(a.q.getName()))?X(a,a.W):X(a,a.sa):setTimeout(l(function(){W(this)},a),25):X(a,a.W)}function X(a,b){a.A.remove(),a.B.remove(),b(a.q)}function Y(a,b,c,d){this.c=b,this.t=c,this.P=0,this.ba=this.Y=f,this.T=d,this.k=a.k}function Z(a,b,c,d,e){if(0===b.length&&e)N(a.t);else for(a.P+=b.length,e&&(a.Y=e),e=0;e<b.length;e++){var f=b[e],g=c[f.getName()],h=a.t,i=f;p(h.h,h.g.f(h.j,i.getName(),J(i).toString(),"loading")),O(h,"fontloading",i),new T(l(a.ga,a),l(a.ha,a),a.c,f,a.k,a.T,d,g).start()}}function $(a){0==--a.P&&a.Y&&(a.ba?(a=a.t,q(a.h,a.g.f(a.j,"loading")),q(a.h,a.g.f(a.j,"inactive")),p(a.h,a.g.f(a.j,"active")),O(a,"active")):N(a.t))}function _(a){this.G=a,this.u=new P,this.ya=new A(a.navigator.userAgent,a.document),this.a=this.ya.parse(),this.Q=this.R=0}function ab(a,b){this.c=a,this.e=b,this.m=[]}function bb(a,b){this.c=a,this.e=b,this.m=[]}function cb(a,b,c){this.N=a?a:b+db,this.p=[],this.S=[],this.ca=c||""}function eb(a){this.p=a,this.$=[],this.J={}}function jb(a,c){this.a=new A(navigator.userAgent,b).parse(),this.c=a,this.e=c}function lb(a,b){this.c=a,this.e=b,this.m=[]}function mb(a,b){this.c=a,this.e=b}var d=!0,e=null,f=!1,h=this,m=Date.now||function(){return+new Date};n.prototype.createElement=function(a,b,c){if(a=this.z.createElement(a),b)for(var d in b)b.hasOwnProperty(d)&&("style"==d?a.style.cssText=b[d]:a.setAttribute(d,b[d]));return c&&a.appendChild(this.z.createTextNode(c)),a},i("webfont.BrowserInfo",v),v.prototype.pa=g("M"),v.prototype.hasWebFontSupport=v.prototype.pa,v.prototype.qa=g("U"),v.prototype.hasWebKitFallbackBug=v.prototype.qa,v.prototype.ra=g("Aa"),v.prototype.hasWebKitMetricsBug=v.prototype.ra;var x=/^([0-9]+)(?:[\._-]([0-9]+))?(?:[\._-]([0-9]+))?(?:[\._+-]?(.*))?$/;w.prototype.toString=function(){return[this.d,this.o||"",this.aa||"",this.f||""].join("")},i("webfont.UserAgent",z),z.prototype.getName=g("K"),z.prototype.getName=z.prototype.getName,z.prototype.oa=g("za"),z.prototype.getVersion=z.prototype.oa,z.prototype.ka=g("fa"),z.prototype.getEngine=z.prototype.ka,z.prototype.la=g("ea"),z.prototype.getEngineVersion=z.prototype.la,z.prototype.ma=g("wa"),z.prototype.getPlatform=z.prototype.ma,z.prototype.na=g("va"),z.prototype.getPlatformVersion=z.prototype.na,z.prototype.ja=g("da"),z.prototype.getDocumentMode=z.prototype.ja,z.prototype.ia=g("k"),z.prototype.getBrowserInfo=z.prototype.ia;var B=new z("Unknown",new w,"Unknown","Unknown",new w,"Unknown","Unknown",new w,"Unknown",void 0,new v(f,f,f));A.prototype.parse=function(){var a;if(-1!=this.a.indexOf("MSIE")||-1!=this.a.indexOf("Trident/")){a=C(this);var b=D(this),c=y(b),d=e,g=e,h=e,i=e,j=F(this.a,/Trident\/([\d\w\.]+)/,1),k=G(this.I),d=-1!=this.a.indexOf("MSIE")?F(this.a,/MSIE ([\d\w\.]+)/,1):F(this.a,/rv:([\d\w\.]+)/,1),g=y(d);""!=j?(h="Trident",i=y(j)):(h="Unknown",i=new w,j="Unknown"),a=new z("MSIE",g,d,h,i,j,a,c,b,k,new v("Windows"==a&&6<=g.d||"Windows Phone"==a&&8<=c.d,f,f))}else if(-1!=this.a.indexOf("Opera"))a:if(a="Unknown",b=F(this.a,/Presto\/([\d\w\.]+)/,1),c=y(b),d=D(this),g=y(d),h=G(this.I),c.d!==e?a="Presto":(-1!=this.a.indexOf("Gecko")&&(a="Gecko"),b=F(this.a,/rv:([^\)]+)/,1),c=y(b)),-1!=this.a.indexOf("Opera Mini/"))i=F(this.a,/Opera Mini\/([\d\.]+)/,1),j=y(i),a=new z("OperaMini",j,i,a,c,b,C(this),g,d,h,new v(f,f,f));else{if(-1!=this.a.indexOf("Version/")&&(i=F(this.a,/Version\/([\d\.]+)/,1),j=y(i),j.d!==e)){a=new z("Opera",j,i,a,c,b,C(this),g,d,h,new v(10<=j.d,f,f));break a}i=F(this.a,/Opera[\/ ]([\d\.]+)/,1),j=y(i),a=j.d!==e?new z("Opera",j,i,a,c,b,C(this),g,d,h,new v(10<=j.d,f,f)):new z("Opera",new w,"Unknown",a,c,b,C(this),g,d,h,new v(f,f,f))}else/OPR\/[\d.]+/.test(this.a)?a=E(this):/AppleWeb(K|k)it/.test(this.a)?a=E(this):-1!=this.a.indexOf("Gecko")?(a="Unknown",b=new w,c="Unknown",d=D(this),g=y(d),h=f,-1!=this.a.indexOf("Firefox")?(a="Firefox",c=F(this.a,/Firefox\/([\d\w\.]+)/,1),b=y(c),h=3<=b.d&&5<=b.o):-1!=this.a.indexOf("Mozilla")&&(a="Mozilla"),i=F(this.a,/rv:([^\)]+)/,1),j=y(i),h||(h=1<j.d||1==j.d&&9<j.o||1==j.d&&9==j.o&&2<=j.aa||i.match(/1\.9\.1b[123]/)!=e||i.match(/1\.9\.1\.[\d\.]+/)!=e),a=new z(a,b,c,"Gecko",j,i,C(this),g,d,G(this.I),new v(h,f,f))):a=B;return a},H.prototype.f=function(){for(var b=[],c=0;c<arguments.length;c++)b.push(arguments[c].replace(/[\W_]+/g,"").toLowerCase());return b.join(this.ua)},I.prototype.getName=g("K"),Q.prototype.remove=function(){var a=this.s;a.parentNode&&a.parentNode.removeChild(a)};var U={Da:"serif",Ca:"sans-serif",Ba:"monospace"};T.prototype.start=function(){this.A=new Q(this.c,this.C),S(this.A),this.B=new Q(this.c,this.C),S(this.B),this.xa=m(),R(this.A,new I(this.q.getName()+",serif",J(this.q))),R(this.B,new I(this.q.getName()+",sans-serif",J(this.q))),W(this)},Y.prototype.ga=function(a){var b=this.t;q(b.h,b.g.f(b.j,a.getName(),J(a).toString(),"loading")),q(b.h,b.g.f(b.j,a.getName(),J(a).toString(),"inactive")),p(b.h,b.g.f(b.j,a.getName(),J(a).toString(),"active")),O(b,"fontactive",a),this.ba=d,$(this)},Y.prototype.ha=function(a){var b=this.t;q(b.h,b.g.f(b.j,a.getName(),J(a).toString(),"loading")),r(b.h,b.g.f(b.j,a.getName(),J(a).toString(),"active"))||p(b.h,b.g.f(b.j,a.getName(),J(a).toString(),"inactive")),O(b,"fontinactive",a),$(this)},_.prototype.load=function(a){var b=a.context||this.G;this.c=new n(this.G,b);var f,b=new L(this.c,b.document.documentElement,a),c=this.u,d=this.c,e=[];for(f in a)if(a.hasOwnProperty(f)){var g=c.w[f];g&&e.push(g(a[f],d))}for(a=a.timeout,this.Q=this.R=e.length,a=new Y(this.a,this.c,b,a),f=0,c=e.length;c>f;f++)d=e[f],d.H(this.a,l(this.ta,this,d,b,a))},_.prototype.ta=function(a,b,c,d){var f=this;d?a.load(function(a,d,g){var h=0==--f.R;h&&M(b),setTimeout(function(){Z(c,a,d||{},g||e,h)},0)}):(a=0==--this.R,this.Q--,a&&(0==this.Q?N(b):M(b)),Z(c,[],{},e,a))},ab.prototype.H=function(a,b){var c=this,d=c.e.projectId,e=c.e.version;if(d){var g=c.c.v;u(this.c,c.D(d,e),function(e){if(e)b(f);else{if(g["__mti_fntLst"+d]&&(e=g["__mti_fntLst"+d]()))for(var h=0;h<e.length;h++)c.m.push(new I(e[h].fontfamily));b(a.k.M)}}).id="__MonotypeAPIScript__"+d}else b(f)},ab.prototype.D=function(a,b){var c=s(this.c),d=(this.e.api||"fast.fonts.net/jsapi").replace(/^.*http(s?):(\/\/)?/,"");return c+"//"+d+"/"+a+".js"+(b?"?v="+b:"")},ab.prototype.load=function(a){a(this.m)},bb.prototype.D=function(a){return s(this.c)+(this.e.api||"//f.fontdeck.com/s/css/js/")+(this.c.v.location.hostname||this.c.G.location.hostname)+"/"+a+".js"},bb.prototype.H=function(a,b){var c=this.e.id,d=this.c.v,e=this;c?(d.__webfontfontdeckmodule__||(d.__webfontfontdeckmodule__={}),d.__webfontfontdeckmodule__[c]=function(a,c){for(var d=0,f=c.fonts.length;f>d;++d){var g=c.fonts[d];e.m.push(new I(g.name,K("font-weight:"+g.weight+";font-style:"+g.style)))}b(a)},u(this.c,this.D(c),function(a){a&&b(f)})):b(f)},bb.prototype.load=function(a){a(this.m)};var db="//fonts.googleapis.com/css";cb.prototype.f=function(){if(0==this.p.length)throw Error("No fonts to load !");if(-1!=this.N.indexOf("kit="))return this.N;for(var a=this.p.length,b=[],c=0;a>c;c++)b.push(this.p[c].replace(/ /g,"+"));return a=this.N+"?family="+b.join("%7C"),0<this.S.length&&(a+="&subset="+this.S.join(",")),0<this.ca.length&&(a+="&text="+encodeURIComponent(this.ca)),a};var fb={latin:"BESbswy",cyrillic:"&#1081;&#1103;&#1046;",greek:"&#945;&#946;&#931;",khmer:"&#x1780;&#x1781;&#x1782;",Hanuman:"&#x1780;&#x1781;&#x1782;"},gb={thin:"1",extralight:"2","extra-light":"2",ultralight:"2","ultra-light":"2",light:"3",regular:"4",book:"4",medium:"5","semi-bold":"6",semibold:"6","demi-bold":"6",demibold:"6",bold:"7","extra-bold":"8",extrabold:"8","ultra-bold":"8",ultrabold:"8",black:"9",heavy:"9",l:"3",r:"4",b:"7"},hb={i:"i",italic:"i",n:"n",normal:"n"},ib=RegExp("^(thin|(?:(?:extra|ultra)-?)?light|regular|book|medium|(?:(?:semi|demi|extra|ultra)-?)?bold|black|heavy|l|r|b|[1-9]00)?(n|i|normal|italic)?$");eb.prototype.parse=function(){for(var a=this.p.length,b=0;a>b;b++){var c=this.p[b].split(":"),d=c[0].replace(/\+/g," "),f=["n4"];if(2<=c.length){var g,h=c[1];if(g=[],h)for(var h=h.split(","),i=h.length,j=0;i>j;j++){var k;if(k=h[j],k.match(/^[\w]+$/)){k=ib.exec(k.toLowerCase());var l=void 0;if(k==e)l="";else{if(l=void 0,l=k[1],l==e||""==l)l="4";else var m=gb[l],l=m?m:isNaN(l)?"4":l.substr(0,1);l=[k[2]==e||""==k[2]?"n":hb[k[2]],l].join("")}k=l}else k="";k&&g.push(k)}0<g.length&&(f=g),3==c.length&&(c=c[2],g=[],c=c?c.split(","):g,0<c.length&&(c=fb[c[0]])&&(this.J[d]=c))}for(this.J[d]||(c=fb[d])&&(this.J[d]=c),c=0;c<f.length;c+=1)this.$.push(new I(d,f[c]))}};var kb={Arimo:d,Cousine:d,Tinos:d};jb.prototype.H=function(a,b){b(a.k.M)},jb.prototype.load=function(a){var b=this.c;if("MSIE"==this.a.getName()&&this.e.blocking!=d){var c=l(this.X,this,a),e=function(){b.z.body?c():setTimeout(e,0)};e()}else this.X(a)},jb.prototype.X=function(a){for(var b=this.c,c=new cb(this.e.api,s(b),this.e.text),d=this.e.families,e=d.length,f=0;e>f;f++){var g=d[f].split(":");3==g.length&&c.S.push(g.pop());var h="";2==g.length&&""!=g[1]&&(h=":"),c.p.push(g.join(h))}d=new eb(d),d.parse(),t(b,c.f()),a(d.$,d.J,kb)},lb.prototype.D=function(a){var b=s(this.c);return(this.e.api||b+"//use.typekit.net")+"/"+a+".js"},lb.prototype.H=function(a,b){var c=this.e.id,d=this.e,e=this.c.v,g=this;c?(e.__webfonttypekitmodule__||(e.__webfonttypekitmodule__={}),e.__webfonttypekitmodule__[c]=function(c){c(a,d,function(a,c,d){for(var e=0;e<c.length;e+=1){var f=d[c[e]];if(f)for(var h=0;h<f.length;h+=1)g.m.push(new I(c[e],f[h]));else g.m.push(new I(c[e]))}b(a)})},u(this.c,this.D(c),function(a){a&&b(f)},2e3)):b(f)},lb.prototype.load=function(a){a(this.m)},mb.prototype.load=function(a){var b,c,d=this.e.urls||[],e=this.e.families||[],f=this.e.testStrings||{};for(b=0,c=d.length;c>b;b++)t(this.c,d[b]);for(d=[],b=0,c=e.length;c>b;b++){var g=e[b].split(":");if(g[1])for(var h=g[1].split(","),i=0;i<h.length;i+=1)d.push(new I(g[0],h[i]));else d.push(new I(g[0]))}a(d,f)},mb.prototype.H=function(a,b){return b(a.k.M)};var nb=new _(h);nb.u.w.custom=function(a,b){return new mb(b,a)},nb.u.w.fontdeck=function(a,b){return new bb(b,a)},nb.u.w.monotype=function(a,b){return new ab(b,a)},nb.u.w.typekit=function(a,b){return new lb(b,a)},nb.u.w.google=function(a,b){return new jb(b,a)},h.WebFont||(h.WebFont={},h.WebFont.load=l(nb.load,nb),h.WebFontConfig&&nb.load(h.WebFontConfig))}(this,document);
;/*
 * WordPress Font Customizer front end scripts
 * copyright (c) 2014-2015 Nicolas GUILLAUME (nikeo), Press Customizr.
 * GPL2+ Licensed
 */
( function( $ ) {
	//gets the localized params
  var SavedSettings	= FrontParams.SavedSelectorsSettings,
		DefaultSettings = FrontParams.DefaultSettings,
		Families		= [],
		Subsets		= [];

	function UgetBrowser() {
          var browser = {},
              ua,
              match,
              matched;

          ua = navigator.userAgent.toLowerCase();

          match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
              /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
              /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
              /(msie) ([\w.]+)/.exec( ua ) ||
              ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
              [];

          matched = {
              browser: match[ 1 ] || "",
              version: match[ 2 ] || "0"
          };

          if ( matched.browser ) {
              browser[ matched.browser ] = true;
              browser.version = matched.version;
          }

          // Chrome is Webkit, but Webkit is also Safari.
          if ( browser.chrome ) {
              browser.webkit = true;
          } else if ( browser.webkit ) {
              browser.safari = true;
          }

          return browser;
	}//end of UgetBrowser

	var CurrentBrowser  = UgetBrowser();
	var CurrentBrowserName = '';

	//ADDS BROWSER CLASS TO BODY
	var i = 0;
	for (var browserkey in CurrentBrowser ) {
		if (i > 0)
			continue;
      CurrentBrowserName = browserkey;
     i++;
  }
	$('body').addClass( CurrentBrowserName || '' );


	//Applies effect and icons classes if any
	for ( var key in SavedSettings ){
		//"Not" handling
    var excluded			= SavedSettings[key].not || '';

		if ( SavedSettings[key]['static-effect'] && 'none' != SavedSettings[key]['static-effect'] ) {
			//inset effect can not be applied to Mozilla. @todo Check next versions
			if ( 'inset' == SavedSettings[key]['static-effect'] && true === CurrentBrowser.mozilla )
				continue;

			$( SavedSettings[key].selector ).not(excluded).addClass( 'font-effect-' + SavedSettings[key]['static-effect'] );
		}

		//icons
		if ( SavedSettings[key].icon && 'hide' == SavedSettings[key].icon ) {
			$( DefaultSettings[key].icon ).addClass( 'tc-hide-icon' );
		}
	}

} )( jQuery );


//GOOGLE FONTS STUFFS
//gets the localized params
// var Gfonts      = WebFontsParams.Gfonts,
//   Families    = [],
//   Subsets     = [];

// for ( var key in Gfonts ){
//   //Creates the subsets array
//   //if several subsets are defined for the same fonts > adds them and makes a subset array of unique subset values
//   var FontSubsets = Gfonts[key];
//   for ( var subkey in FontSubsets ) {
//     if ( 'all-subsets' == FontSubsets[subkey] )
//       continue;
//     if ( FontSubsets[subkey] && ! $.inArray( FontSubsets[subkey] , FontSubsets ) ) {
//       Subsets.push(Gfonts[key])
//     }
//   }
//   //fill the families array and add the subsets to the last family (Google Syntax)
//   Families.push( key );
// }

// //are subsets defined?
// if ( Subsets && Subsets.join(',') ) {
//   Families.push('&subset=' +  Subsets.join(',') );
// }

// if ( 0 != Gfonts.length ) {
//   //Loads the fonts
//   WebFont.load({
//       google: {
//         families: Families
//       },
//       // loading: function() {console.log('loading')},
//     // active: function() {},
//     // inactive: function() {},
//     // fontloading: function(familyName, fvd) {},
//     // fontactive: function(familyName, fvd) {},
//     // fontinactive: function(familyName, fvd) {}
//   });
// }