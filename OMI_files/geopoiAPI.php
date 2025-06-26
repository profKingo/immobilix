(function () {
    function getScript(src)
    {
        ++geopoi.__toLoad;
        document.write('<' + 'script src="' + src + '"' +
            ' type="text/javascript"><' + '/script>');    }
    function getCss(src)
    {
        var elem = document.createElement('link');
        elem.href = src;
        elem.type="text/css";
        elem.rel="stylesheet";
        (document.getElementsByTagName("head")[0]||document.documentElement).appendChild(elem);
    }

    var geopoi = {};
    window.geopoi=geopoi;

    geopoi.__totalLoaded=0;
    geopoi.__toLoad=0;

    geopoi.__loadedModule = function (module) {
        ++geopoi.__totalLoaded;
        if (geopoi.__totalLoaded===geopoi.__toLoad) {
                        delete geopoi.__lodaded;
            delete geopoi.__totalLoaded;
            delete geopoi.__toLoad;
        }
    }

    getCss('https://www.geopoi.it/geopoiAPI/sdk/css/getCss.php?sdk=true');

    getScript('https://www.geopoi.it/geopoiAPI/php/getLibs.php');

    getScript('https://www.geopoi.it/geopoiAPI/php/getCore.php?key=458fdf9bac83f07ec36bd680b3ecd207&lang=it');

    getScript('https://www.geopoi.it/geopoiAPI/sdk/sdkLoader.php?lang=it');

    geopoi.withSDK = true;

})();
