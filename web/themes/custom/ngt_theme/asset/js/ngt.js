
var app = angular.module("App", ['ngRoute','ngTouch']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

// app.controller.$inject = ['$scope', '$http', '$rootScope','$interval', '$window'];

app.controller("AppCtrl", ['$scope', '$http', function($scope,$http){
    var ngt = this;
    ngt.showMore = true;
    ngt.loading = true;
    ngt.CourseCategory = [];
    ngt.ratingLoad = {
        cat : 'all',
        start : 0,
        stop : 4,
    };

    ngt.loadMoreCourse = function (tid,rangeInitial,rangeStop) {
        var tid = ngt.ratingLoad.cat;
        var rangeInitial = ngt.ratingLoad.start;
        var rangeStop = ngt.ratingLoad.stop;
        ngt.loadCourseCategory(tid,rangeInitial,rangeStop);
        ngt.loading = true;
    }

    ngt.loadCourseCategory  = function (tid,rangeInitial,rangeStop) {
        
        var config_data = {};
        var url = `/ngt/api/v1/course/${tid}/${rangeInitial}/${rangeStop}`;
        $http.get(url, config_data).then(function (resp) {
            if (resp.data !== undefined && resp.data !== '' && resp.data.length > 0) {
                ngt.loading = false;
                ngt.updaRating();
                ngt.CourseCategory = ngt.CourseCategory.concat(resp.data);
            }else{
                ngt.showMore = false;
                console.log("nada");
            }
            ngt.loading = false;
        }, function (error) {
            console.log("error")
        });
    }

    ngt.updaRating = function () {
        ngt.ratingLoad.start = ngt.ratingLoad.stop
        ngt.ratingLoad.stop = ngt.ratingLoad.stop + 4;
    }


}]);

(function($) {
    $(document).ready(function() {
        
        // owl menu home
        $("#main.page-front .top .slider").owlCarousel({
            nav: true,
            loop: false,
            navRewind: false,
            center: true,
            items: 1,
        });
        $("#main.page-front .top .slider").addClass('owl-carousel');
    
        // scroll show menu
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 197) {
                $("nav#menu-fixed").addClass("scroll");
            } else {
                $("nav#menu-fixed").removeClass("scroll");
            }
        });
    
    });
})(jQuery);
