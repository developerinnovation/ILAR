
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
        console.log(url);
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

