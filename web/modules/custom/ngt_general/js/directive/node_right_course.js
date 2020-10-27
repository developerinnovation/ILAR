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
        scope.tab = 'contentPresentation';
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
        scope.myTabsType = scope.tabsType[0];
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