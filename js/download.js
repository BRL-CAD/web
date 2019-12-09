var versions = undefined;
/*
These are the links to the icons
These have to be like they would be in the src field of <img>
 */
let icons = {
    win64: "/img/download/windows64.png",
    win32: "/img/download/windows32.png",
    macos: "/img/download/macos.png",
    linux64: "/img/download/linux64.png",
    linux32: "/img/download/linux32.png",
    bsd64: "/img/download/bsd64.png",
    bsd32: "/img/download/bsd32.png",
    source: "/img/download/sourcecode.png"
};
function Get(yourUrl){
    var Httpreq = new XMLHttpRequest(); // a new request
    Httpreq.open("GET",yourUrl,false);
    Httpreq.send(null);
    return Httpreq.responseText;
}
window.addEventListener('load', function() {
    /*
    This is the url to the json file containing the downloads
     */
    versions = JSON.parse(Get('/downloads.json'));
    let win64 = document.getElementById('list-win64');
    let win32 = document.getElementById('list-win32');
    let macos = document.getElementById('list-macos');
    let linux32 = document.getElementById('list-linux32');
    let linux64 = document.getElementById('list-linux64');
    let bsd32 = document.getElementById('list-bsd32');
    let bsd64 = document.getElementById('list-bsd64');
    let source = document.getElementById('list-source');
    Object.keys(versions["windows"]["64bit"]).forEach((id, idx) => {
        if (id.toLowerCase() !== 'latest') {
            var it = versions["windows"]["64bit"][id];
            var itm = buildListItem('win64', it);
            win64.appendChild(itm);
        }
    });
    Object.keys(versions["windows"]["32bit"]).forEach((id, idx) => {
        if (id.toLowerCase() !== 'latest') {
            var it = versions["windows"]["32bit"][id];
            var itm = buildListItem('win32', it);
            win32.appendChild(itm);
        }
    });
    Object.keys(versions["macos"]).forEach((id, idx) => {
        if (id.toLowerCase() !== 'latest') {
            var it = versions["macos"][id];
            var itm = buildListItem('macos', it);
            macos.appendChild(itm);
        }
    });
    Object.keys(versions["linux"]["64bit"]).forEach((id, idx) => {
        if (id.toLowerCase() !== 'latest') {
            var it = versions["linux"]["64bit"][id];
            var itm = buildListItem('linux64', it);
            linux64.appendChild(itm);
        }
    });
    Object.keys(versions["linux"]["32bit"]).forEach((id, idx) => {
        if (id.toLowerCase() !== 'latest') {
            var it = versions["linux"]["32bit"][id];
            var itm = buildListItem('linux32', it);
            linux32.appendChild(itm);
        }
    });
    Object.keys(versions["bsd"]["64bit"]).forEach((id, idx) => {
        if (id.toLowerCase() !== 'latest') {
            var it = versions["bsd"]["64bit"][id];
            var itm = buildListItem('bsd64', it);
            bsd64.appendChild(itm);
        }
    });
    Object.keys(versions["bsd"]["32bit"]).forEach((id, idx) => {
        if (id.toLowerCase() !== 'latest') {
            var it = versions["bsd"]["32bit"][id];
            var itm = buildListItem('bsd32', it);
            bsd32.appendChild(itm);
        }
    });
    Object.keys(versions["source"]).forEach((id, idx) => {
        if (id.toLowerCase() !== 'latest') {
            var it = versions["source"][id];
            var itm = buildListItem('source', it);
            source.appendChild(itm);
        }
    });
    var curOS="undefined";
    if (navigator.appVersion.indexOf("Win")!==-1) curOS="Windows";
    if (navigator.appVersion.indexOf("Mac")!==-1) curOS="MacOS";
    if (navigator.appVersion.indexOf("X11")!==-1) curOS="UNIX";
    if (navigator.appVersion.indexOf("Linux")!==-1) curOS="Linux";
    var bit64 = false;
    if (navigator.userAgent.indexOf("WOW64")!==-1||
        navigator.userAgent.indexOf("Win64")!==-1||
        navigator.userAgent.indexOf("x86_64")!==-1||
        navigator.userAgent.indexOf("x86-64")!==-1||
        navigator.userAgent.indexOf("x64;")!==-1||
        navigator.userAgent.indexOf("amd64")!==-1||
        navigator.userAgent.indexOf("AMD64")!==-1||
        navigator.userAgent.indexOf("x64_64")!==-1){bit64=true;}
    setOS(curOS, '10', bit64);
});
function changeList(i) {
    let win64 = document.getElementById('list-win64');
    let s_win64 = document.getElementById('list-switch-win64');
    let win32 = document.getElementById('list-win32');
    let s_win32 = document.getElementById('list-switch-win32');
    let macos = document.getElementById('list-macos');
    let s_macos = document.getElementById('list-switch-macos');
    let linux64 = document.getElementById('list-linux64');
    let s_linux64 = document.getElementById('list-switch-linux64');
    let linux32 = document.getElementById('list-linux32');
    let s_linux32 = document.getElementById('list-switch-linux32');
    let bsd64 = document.getElementById('list-bsd64');
    let s_bsd64 = document.getElementById('list-switch-bsd64');
    let bsd32 = document.getElementById('list-bsd32');
    let s_bsd32 = document.getElementById('list-switch-bsd32');
    let source = document.getElementById('list-source');
    let s_source = document.getElementById('list-switch-source');
    if (i.toLowerCase()==='win64')win64.classList.add('active');else win64.classList.remove('active');
    if (i.toLowerCase()==='win64')s_win64.classList.add('active');else s_win64.classList.remove('active');
    if (i.toLowerCase()==='win32')win32.classList.add('active');else win32.classList.remove('active');
    if (i.toLowerCase()==='win32')s_win32.classList.add('active');else s_win32.classList.remove('active');
    if (i.toLowerCase()==='macos')macos.classList.add('active');else macos.classList.remove('active');
    if (i.toLowerCase()==='macos')s_macos.classList.add('active');else s_macos.classList.remove('active');
    if (i.toLowerCase()==='linux64')linux64.classList.add('active');else linux64.classList.remove('active');
    if (i.toLowerCase()==='linux64')s_linux64.classList.add('active');else s_linux64.classList.remove('active');
    if (i.toLowerCase()==='linux32')linux32.classList.add('active');else linux32.classList.remove('active');
    if (i.toLowerCase()==='linux32')s_linux32.classList.add('active');else s_linux32.classList.remove('active');
    if (i.toLowerCase()==='bsd64')bsd64.classList.add('active');else bsd64.classList.remove('active');
    if (i.toLowerCase()==='bsd64')s_bsd64.classList.add('active');else s_bsd64.classList.remove('active');
    if (i.toLowerCase()==='bsd32')bsd32.classList.add('active');else bsd32.classList.remove('active');
    if (i.toLowerCase()==='bsd32')s_bsd32.classList.add('active');else s_bsd32.classList.remove('active');
    if (i.toLowerCase()==='source')source.classList.add('active');else source.classList.remove('active');
    if (i.toLowerCase()==='source')s_source.classList.add('active');else s_source.classList.remove('active');
}
function buildListItem(os, data) {
    var _i = document.createElement('div');
    _i.setAttribute('class', 'list-i-i');
    var _ia = document.createElement('a');
    _ia.href = data["url"]?data["url"]:'';
    _ia.target = "_blank";
    _ia.rel = "noreferrer";
    var _iimg = document.createElement('img');
    _iimg.src = icons[os];
    _ia.appendChild(_iimg);
    var _itbl = document.createElement('table');
    var _itbody = document.createElement('tbody');
    var _itr = document.createElement('tr');
    var _itype = document.createElement('td');
    _itype.setAttribute('class', 'list-i-i-i type');
    /*
    These are the values you can insert in the type field of a download object.
    r (default) = release
    p = pre-release
    n = nightly
    b = beta
    d = dev
    u = unstable
     */
    _itype.classList.add(data["type"]==='r'?'release':data["type"]==='p'?'pre':data["type"]==='n'?'nightly':data["type"]==='b'?'beta':data["type"]==='d'?'dev':data["type"]==='u'?'unstable':'release');
    _itype.innerHTML = data["type"]==='r'?'Release':data["type"]==='p'?'Pre':data["type"]==='n'?'Nightly':data["type"]==='b'?'Beta':data["type"]==='d'?'Dev':data["type"]==='u'?'Unstable':'Release';
    _itr.appendChild(_itype);
    var _ivers = document.createElement('td');
    _ivers.setAttribute('class', 'list-i-i-i');
    var _iversd = document.createElement('div');
    _iversd.innerHTML = data["version"];
    _ivers.appendChild(_iversd);
    _itr.appendChild(_ivers);
    var _idate = document.createElement('td');
    _idate.setAttribute('class', 'list-i-i-i');
    var _idated = document.createElement('div');
    _idated.innerHTML = data["date"];
    _idate.appendChild(_idated);
    _itr.appendChild(_idate);
    _itbody.appendChild(_itr);
    _itbl.appendChild(_itbody);
    _ia.appendChild(_itbl);
    _i.appendChild(_ia);
    return _i;
}
function setOS(n, v, bit64) {
    let _el = document.getElementById('os-cell');
    _el.innerHTML = '';
    var _td = document.createElement('td');
    _td.classList.add('dl-os-lm');
    var _a = document.createElement('a');
    _a.target = '_blank';
    _a.classList.add('os-a');
    var _img = document.createElement('img');
    _img.classList.add('os-ico');
    var _os = document.createElement('div');
    _os.classList.add('os-os');
    var _os_d = document.createElement('div');
    _os_d.classList.add('os-d');
    var _os_n = document.createElement('div');
    _os_n.classList.add('os-n');
    _os.appendChild(_os_d);
    _os.appendChild(_os_n);
    _a.appendChild(_img);
    _a.appendChild(_os);
    _td.appendChild(_a);
    _el.appendChild(_td);
    var _otd = document.createElement('td');
    _otd.classList.add('dl-os-lm');
    var _oa = document.createElement('a');
    _oa.target = '_blank';
    _oa.classList.add('os-a');
    var _oimg = document.createElement('img');
    _oimg.classList.add('os-ico');
    var _oos = document.createElement('div');
    _oos.classList.add('os-os');
    var _oos_d = document.createElement('div');
    _oos_d.classList.add('os-d');
    var _oos_n = document.createElement('div');
    _oos_n.classList.add('os-n');
    _oos.appendChild(_oos_d);
    _oos.appendChild(_oos_n);
    _oa.appendChild(_oimg);
    _oa.appendChild(_oos);
    _otd.appendChild(_oa);
    _oa.href = versions["source"][versions["source"]["latest"]]["url"];
    _oimg.src = icons['source'];
    _oimg.alt = 'SOURCE';
    _oos_d.innerHTML = '';
    _oos_n.innerHTML = 'Source';
    _el.appendChild(_otd);
    if (n.toLowerCase()==='windows') {
        if (bit64) {
            _a.href = versions["windows"]["64bit"][versions["windows"]["64bit"]["latest"]]["url"];
            _img.src = icons['win64'];
            _img.alt = 'WIN';
            _os_d.innerHTML = 'Download latest • ' + versions["windows"]["64bit"][versions["windows"]["64bit"]["latest"]]["version"];
            _os_n.innerHTML = 'Windows';
            changeList('win64');
        } else {
            _a.href = versions["windows"]["32bit"][versions["windows"]["32bit"]["latest"]]["url"];
            _img.src = icons['win32'];
            _img.alt = 'WIN';
            _os_d.innerHTML = 'Download latest • ' + versions["windows"]["32bit"][versions["windows"]["32bit"]["latest"]]["version"];
            _os_n.innerHTML = 'Windows';
            changeList('win32');
        }
    } else if (n.toLowerCase()==='macos') {
        _a.href = versions["macos"][versions["macos"]["latest"]]["url"];
        _img.src = icons['macos'];
        _img.alt = 'MAC';
        _os_d.innerHTML = 'Download latest • ' + versions["macos"][versions["macos"]["latest"]]["version"];
        _os_n.innerHTML = 'MacOS';
        changeList('macos');
    } else if (n.toLowerCase()==='linux') {
        if (bit64) {
            _a.href = versions["linux"]["64bit"][versions["linux"]["64bit"]["latest"]]["url"];
            _img.src = icons['linux64'];
            _img.alt = 'LINUX';
            _os_d.innerHTML = 'Download latest • ' + versions["linux"]["64bit"][versions["linux"]["64bit"]["latest"]]["version"];
            _os_n.innerHTML = 'Linux';
            changeList('linux64');
        } else {
            _a.href = versions["linux"]["32bit"][versions["linux"]["32bit"]["latest"]]["url"];
            _img.src = icons['linux32'];
            _img.alt = 'LINUX';
            _os_d.innerHTML = 'Download latest • ' + versions["linux"]["32bit"][versions["linux"]["32bit"]["latest"]]["version"];
            _os_n.innerHTML = 'Linux';
            changeList('linux32');
        }
    }
}