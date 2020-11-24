myApp.directive('ngEvaluation', ['$http', ngEvaluation]);

function ngEvaluation($http){
    
    var directive = {
        restrict: 'EA',
        controller: EvaluationController,
        link: linkFunc
    };

    return directive;

    function linkFunc(scope, el, attr, ctrl){
        var config = drupalSettings.ngtBlock[scope.uuid_data_ng_evaluation];
        scope.tabs = 'presentation';
        scope.evaluationNav = 1;
        scope.maxNavValue = 3;
        scope.minNavValue = 1;
    }

}

EvaluationController.$inject = ['$scope', '$http', '$rootScope','$interval', '$window'];
function EvaluationController($scope, $http, $rootScope){
    
    $scope.changeTabs = function (tabs){
        $scope.tabs = tabs;
        jQuery('li#question_1').addClass('active');
    }

    $scope.changeEvaluationNav = function (type){
        if(type == 'prev') {
            $scope.evaluationNav = $scope.evaluationNav - 1;
        }else{
            $scope.evaluationNav = $scope.evaluationNav + 1;
        }
        var nav = $scope.evaluationNav;
        jQuery('li#question_' + nav).addClass('active');
        console.log($scope.evaluationNav);
    }

    jQuery('button.bool').click(function( event ) {
        event.preventDefault();
    });
 
}

