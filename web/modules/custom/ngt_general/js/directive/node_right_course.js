myApp.directive('ngNodeRightCourse', ['$http', ngNodeRightCourse]);

function ngNodeRightCourse($http){
    
    var directive = {
        restrict: 'EA',
        controller: NodeRightCourseController,
        link: linkFunc
    };

    return directive;

    function linkFunc(scope, el, attr, ctrl){
        var config = drupalSettings.ngtBlock[scope.uuid_data_ng_course_category];
        scope.tabsType = [
            {
                id: 1,
                name: 'Presentación',
            }, 
            {
                id: 2,
                name: 'Contenido',
            }
        ];
        
        if(location.hash.substring(0,7) == '#module') {
            scope.tab = 'contentMain';
            scope.myTabsType = scope.tabsType[1];

            setTimeout(function(){ 
                var moduleId = location.hash;
                var element = document.querySelector(moduleId);
                element.scrollIntoView();
            }, 1000);
           
        }else{
            scope.tab = 'contentPresentation';
            scope.myTabsType = scope.tabsType[0];
        }
        
    }

}

NodeRightCourseController.$inject = ['$scope', '$http', '$rootScope','$interval', '$window'];
function NodeRightCourseController($scope, $http, $rootScope){
    
    $scope.$watch('myTabsType', function() {
        switch ($scope.myTabsType.id) {
            case 1:
                    $scope.tab = 'contentPresentation'
                break;
            case 2:
                    $scope.tab = 'contentMain'
                 break;
            case 3:
                    $scope.tab = 'contentCommunity'
                break;
        }
    });
}