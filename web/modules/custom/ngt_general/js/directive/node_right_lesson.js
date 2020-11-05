myApp.directive('ngNodeRightLesson', ['$http', ngNodeRightLesson]);

function ngNodeRightLesson($http){
    
    var directive = {
        restrict: 'EA',
        controller: NodeRightLessonController,
        link: linkFunc
    };

    return directive;

    function linkFunc(scope, el, attr, ctrl){
        var config = drupalSettings.ngtBlock[scope.uuid_data_ng_node_right_lesson];
        console.log(config);
        scope.config = config;
        scope.urlCourse = config.urlCourse;
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
        scope.tab = 'contentMain';
        scope.myTabsType = scope.tabsType[1];
    }

}

NodeRightLessonController.$inject = ['$scope', '$http', '$rootScope','$interval', '$window'];
function NodeRightLessonController($scope, $http, $rootScope){
    
    $scope.$watch('myTabsType', function() {
        switch ($scope.myTabsType.id) {
            case 1:
                    window.location.href = $scope.urlCourse;
                    
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