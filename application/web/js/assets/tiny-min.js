(function(u){
var ss=/(^|^#|^\.)([^#.\s+~<>\[:=,]+|\[name=([^\]]+)\])$/,cp=/(\s*([>~* +,]|<<?)\s*|\[([^!\^$*~|=]+)([!\^$*~|]?=?)([^\]]*)\]|([#.:]?)([^#.:,\s +~<>\[^\(]+)(\(([^\)]+)\)|))/g,al=/alpha\(opacity=([\d\.]*)\)/gi,co=/rgb\((\d+),\s*(\d+),\s*(\d+)\)/i,rr=/^#([\da-f])([\da-f])([\da-f])/,vf=function(v){return v.replace(/([.+*\[\]\(\)])/g,'\\$1');},cn=(document.getElementsByClassName?function(s,b){return b.getElementsByClassName(s);}:function(s,b){return t.cf['.'](b.getElementsByTagName('*'),s);});
t=function(s,b,z){
if(s===u){return;}
var s=s||[],b=b||document,I,n=[],e=u,E=u,S;
if(s instanceof t){return s;}
if(b.length){t.i(b,function(i,S){t.x(n,t(s,S,1));},1);}
else if(s instanceof Array){n=s;}
else if(s.nodeName){n=[s];}
else if(s==='*'){n=b.getElementsByTagName('*');n=n.length?n:[];}
else if(e=ss.exec(s)){
if(!b){n=[];}
else if(e[1]==='#'){E=document.getElementById(e[2]);n=E&&(b===document||t.w(t.cf['<<']([E]),b)!==-1)?[E]:[];}
else if(e[1]==='.'){n=cn(e[2],b);}
else if(e[3]){n=t.x(n,b.getElementsByName(e[3]));}
else{n=t.x(n,b.getElementsByTagName(e[2]));}}else{
cp.lastIndex=0;cp.exec(s);e=RegExp.$2||'*';E=e=e===' '?'*':e;S=[b];cp.lastIndex=0;
s.replace(cp,function(f,y,j,k,l,m,o,p,z,q){
if(j===','){if(e==='*'){S=t(e,S,1);};n=t.f(t.x([],n,S));e=E;S=[b];return;}
if(!S.length){return;}
if(e==='*'){if(ss.test(f)){S=t(f,S,1);e=f;return;}else{S=t.cf[e](S);}}
var x=(j?(j===' '?'*':[j]):(p?(o===':'?[p,q]:[(o||''),p,q]):(k?[l||'=',k,m]:u)));
if(x!==u&&x!=='*'&&t.cf[x[0]]){S=t.cf[x[0]](S,x[1],x[2]);}
e=x;});
if(e==='*'){S=t(e,S,1);}
n=t.x([],n,S);}
n=t.f(t.f(n),function(_,x){return x&&x.nodeName?x:u;},true);
return(z?n:(function(){z=new t();t.i(n,function(i,x){z[i]=x;},true);z.length=n.length;return z;})());};
t.cf={'':function(n,i){return t.f(n,function(_,x){return x.nodeName.toLowerCase()===i?x:u;},true);},
'.':function(n,i){var r=new RegExp('\\b'+i+'\\b');return t.f(n,function(_,x){return r.test(x.className)?x:u;},true);},
'#':function(n,i){return t.f(n,function(_,x){return x.id===i?x:u;},true);},
odd:function(n){return t.f(n,function(i,x){return i&1===1?u:x;},true);},
even:function(n){return t.f(n,function(i,x){return i&1===1?x:u;},true);},
empty:function(n){return t.f(n,function(i,x){return(!x||x.childNodes||[]).length?u:x;},true);},
'first-child':function(n){return t.f(n,function(_,x){var f=x.parentNode.firstChild;while(f&&f.nodeType!==1){f=f.nextSibling;};return x===f?x:u;},true);},
'last-child':function(n){return t.f(n,function(_,x){var l=x.parentNode.lastChild;while(l&&l.nodeType!==1){l=l.previousSibling;};return x===l?x:u;},true);},
'only-child':function(n){return t.f(n,function(_,x){return x.parentNode.getElementsByTagName('*').length===1?x:u;},true);},
'nth-child':function(n,i){return t.f(n,function(_,x){var I=0;while(x&&(x=x.previousSibling)){if(x.nodeType===1){I++;}};return I===(i*1)?x:u;},true);},
not:function(n,i){return t.f(n,function(_,x){return t.w(x,t.x([],t(i,document,true)))===-1?x:u;},true);},
has:function(n,i){return t.f(n,function(_,x){return t(i,x,true).length?x:u;},true);},
contains:function(n,i){return t.f(n,function(_,x){return x.innerHTML.replace(/<[\>]*>/g,'').indexOf(i)!==-1?x:u;},true);},
lang:function(n,i){return t.f(n,function(_,x){return t('<<[lang|='+i+']',x,true).length?x:u;},true)},
'=':function(n,k,v){return t.f(n,function(_,x){var r=(t(x).a(k));return r!==u&&r!==null&&r===(v||r)?x:u;},true);},
'!=':function(n,k,v){return t.f(n,function(_,x){var r=(t(x).a(k));return(r!==u&&r!==null&&r!==v)?x:u;},true);},
'^=':function(n,k,v){var r=new RegExp('^'+vf(v));return t.f(n,function(_,x){return r.test(t(x).a(k))?x:u;},true);},
'$=':function(n,k,v){var r=new RegExp(vf(v)+'$');return t.f(n,function(_,x){return r.test(t(x).a(k))?x:u;},true);},
'*=':function(n,k,v){return t.f(n,function(_,x){return(t(x).a(k)||'').indexOf(v)!==-1?x:u;},true);},
'~=':function(n,k,v){var r=new RegExp('\\b'+vf(v)+'\\b');return t.f(n,function(_,x){return r.test(t(x).a(k))?x:u;},true);},
'|=':function(n,k,v){var r=new RegExp('^'+vf(v)+'($|\\-)');return t.f(n,function(_,x){return r.test(t(x).a(k))?x:u;},true);},
'>':function(n){var c=[];t.i(n,function(_,x){t.x(c,t.f(x.childNodes,function(_,z){return z.nodeType===1?z:u;},true));},true);return t.f(c);},
'~':function(n){var c=[];t.i(n,function(_,x){while(x=x.nextSibling){if(x.nodeType===1){c.push(x);}}},true);return t.f(c);},
'+':function(n){var c=[];t.i(n,function(_,x){while(x&&(x=x.nextSibling)&&x.nodeType!==1);if(x){c.push(x);}},true);return t.f(c);},
'*':function(n){return t.f(t('*',n,false));},
'<':function(n){return t.f(t.i(true,n,function(i,x){this[i]=x.parentNode||u;},true));},
'<<':function(n){var c=[];t.i(n,function(_,x){var p=x;while((p=p.parentNode)&&p&&c.push(p));},true);return t.f(c);}};
t.version='0.0.1';t.license='(c) 2010 Alex Kloss <alexthkloss@web.de>, LGPL2';
t.prototype=t._={
i:function(c){return t.i(this,c,true);},
f:function(c){return t(t.f(this,c,true));},
a:function(k,v){
if(v===u){
if(typeof k==='object'){var n=this;t.i(k,function(k,v){n.a(k,v);});return this;}
var n=this[0];return this.length?(this.nf[k]?this.nf[k][0](n):n[k]||null):u;}
this.i(function(_,n){this.nf[k]?this.nf[k][1](n,v):n[k]=v;},true);
return this;},
g:function(i){if(i===u||i===null){return this;};if(i.nodeName){return t.w(i,this)};if(typeof(i)==='string'){return t(i,this);};return t(this[i]);},
h:function(h){if(h===u){return this.a('innerHTML');};this.a('innerHTML',h);return this;},
v:function(v){if(v===u){return(this[0]||{}).value||'';};if(typeof v==='function'){var r={},x;this.i(function(i,n){if(!/^(checkbox|radio|option)$/.test(n.type||'')||n.checked||n.selected){x=t(n).v();if(n.name&&x){r[n.name]=(r[n.name]?r[n.name]+',':'')+x;}}});return v(r);};this.a('value',v);return this;},
r:function(){this.i(function(_,v){if(v){v.parentNode.removeChild(v);}});},
c:function(k,v){if(v===u){
if(typeof k==='object'){var n=this;t.i(k,function(k,v){n.c(k,v);});return this;}
var n=this[0];return this.length?this.nf.rgb2hex(this.nf[k]?this.nf[k][0](n):n.style[k]||window.getComputedStyle?(n.ownerDocument.defaultView.getComputedStyle(n,null)||{})[k]:(n.currentStyle||{})[k]||null):u;}
this.i(function(_,n){if(n.style){if(this.nf[k]){this.nf[k][1](n,v);}else{n.style[k]=v;}}},true);
return this;},
nf:(function(){
var f={rgb2hex:function(r){var z;return((z=rr.exec(r))?['#',z[1],z[1],z[2],z[2],z[3],z[3]].join(''):(z=co.exec(r))?'#'+t.i([1,2,3],function(i,v){this[i]=('0'+(z[v]|0).toString(16)).substr(-2);}).join(''):r);},
class:[function(n){return n.className;},function(n,v){n.className=v;}],
value:[function(n){return n.options?n.options[n.selectedIndex]:n.value;},function(n,v){if(/select/i.test(n.nodeName)){n.selectedIndex=t.w(v,t.i(true,n.options,function(i,o){this[i]=o.value||o.innerHTML;},true));};n.value=v;}]
},d=document.createElement('div');d.style.display='none';
d.innerHTML='<span class="color:red;float:left;opacity:0.5">x</span>';
var s=d.getElementsByTagName('span')[0];
if(s.style.opacity!=='0.5'){f.opacity=[function(n){al.exec(t(n).c('filter'));return(parseFloat(RegExp.$1)/100);},function(n,v){n.style.zoom=n.style.zoom||1;n.style.filter=(v>0&&v<1?'alpha(opacity='+(v*100)+')':n.style.filter.replace(al,'')+'');}];}
if(s.style.styleFloat){f['float']=[function(n){return t(n).c('styleFloat');},function(n,v){n.style.styleFloat=v;}]}
return f;})(),
e:function(e,c,r){return t.e(this,e,c,r);}};
t.i=function(o,c,a,z){
if(o===true){return t.i(t.x(z||c instanceof Array?[]:{},c),a,z);}
if(!o||!o.length&&!o.hasOwnProperty){return o;}
var l=o.length||0,a=a||o instanceof Array;
if(a ||!o.hasOwnProperty){for(var i=0;i<l;i++){c.call(o,i,o[i]);}}
else{for(var k in o){if(o.hasOwnProperty(k)){c.call(o,k,o[k]);}}}
return o;};
t.x=function(){
var b=arguments[0],o,i=0,y=b instanceof Array,a=(y?function(k,v){b.push(v);}:function(k,v){b[k]=v;});
if(b.length!==u&&!b.hasOwnProperty){return b;}
while(o=arguments[++i]){t.i(o,a,y);}
return b;};
t.f=function(o,c,y){
if(!o){return o;}
var y=y||o instanceof Array;
if(c===u){y=true;var c=function(i,v){var l=i;while(--l>=0){if(this[l]===v){return u;}};return v;}}
var r=(y ?[]:{});
t.i(o,function(k,v){if((c.call(o,k,v))!==u){
if(y){r.push(v);}else{r[k]=v;}}},y);
return r;}
t.w=function(x,a){
var l=a.length;
while(l>-1&&a[--l]!==x);
return l;}
t.p=function(o,m,c,p,s,f1,f2){
var r=[];
t.i(o,function(k,v){r.push((p===u?'':p)+(f1||escape)(k)+(m===u?'=':m)+(f2||escape)(v)+(s===u?'':s));});
return r.join(c===u?'&':c);};
t.e=function(n,e,c,r){
if(!n.nodeName &&n.length){return t.i(n,function(i,o){t.e(o,e,c,r);},true);}
if(!n.ev){n.ev={};}
if(e===u){return n.ev;}
if(!n.ev[e]){n.ev[e]=[];if(typeof(n['on'+e])==='function'){n.ev[e].push(n['on'+e]);};}
if(n['on'+e]!==t.e.h){n['on'+e]=t.e.h;}
if(c!==u){
if(r){n.ev[e]=t.f(n.ev[e],function(_,x){return c===x?u:x;},true);}
else{n.ev[e].push(c);}}
return n.ev[e];}
t.e.h =function(o){
var e=(o||window.event),D=document.documentElement,n=this;
t.x(e,{key:(e.which||e.keyCode||e.charCode),ts:(new Date())*1,mouseX:(e.clientX||0)+(window.pageXOffset||D.scrollLeft||0),mouseY:(e.clientY||0)+(window.pageYOffset||D.scrollTop||0)});
if(!e.target){e.target=e.srcElement||document;}
t.i((n.ev||{})[e.type],function(i,c){if(typeof c==='function'){c.call(n,e);}});};
if(!document.readyState){
var r=function(){document.readyState='complete';};
if(document.attachEvent){document.attachEvent('onreadystatechange',r);}
if(document.addEventListener){document.addEventListener('DOMContentLoaded',r,false);}
t.e(window,'load',r);}
ready=window.setInterval(function(){
if(document.body &&document.readyState==='complete'){
t.e.h.call(document,{cancelable:false,type:'ready',target:document,view:window });
window.clearInterval(ready);}},45);
t.j=function(u,c,t){
var f=typeof c==='function';
if(f){window[(f='fn'+(Math.random()*1E8|0)+(new Date()*1))]=function(c){return c;}(c);c=f;}
var s=document.createElement('script');
s.type='text/javascript';
s.src=u+(c||'');
document.body.appendChild(s);
if(t){window.setTimeout(function(){document.body.removeChild(s);},t);}
if(f){window.setTimeout(function(){delete window[c];},(t||0)+5000);}};
t.a=function(o){
var x=(window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP"));
if(!x){return false;}
x.open(o.method||'GET',o.url,!!o.async,o.user,o.pass);
x.send(o.data?(typeof o.data==='object'?t.p(o.data):o.data):null);
if(!o.async){return o.type===true?x:x['response'+o.type||'Text'];}
x.onreadystatechange=function(e){if(x.readyState===4){o.async.call(x,x['response'+o.type||'Text']);}}
return x;};})();