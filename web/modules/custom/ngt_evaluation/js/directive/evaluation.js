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
        scope.maxNavValue = config.total_questions;
        scope.minNavValue = 1;
        scope.answers = config.data;
        scope.countAnswer = 0;
        scope.isDisabledNext = true;
        scope.isDisabledSendAnswers = true;
    }

}

EvaluationController.$inject = ['$scope', '$http', '$rootScope','$interval', '$window'];
function EvaluationController($scope, $http, $rootScope){
    
    $scope.changeTabs = function (tabs){
        if(tabs == 'evaluation') {
            $scope.startEvaluation();
        }
        $scope.tabs = tabs;
        jQuery('li#question_1').addClass('active');
    }

    $scope.changeEvaluationNav = function (type){
        if(type == 'prev') {
            $scope.evaluationNav = $scope.evaluationNav - 1;
            $scope.isDisabledNext = false;
        }else{
            $scope.evaluationNav = $scope.evaluationNav + 1;
            if($scope.answers[$scope.evaluationNav - 1] != ''){
                $scope.isDisabledNext = false;
            }else{
                $scope.isDisabledNext = true;
            }
            
        }
        var nav = $scope.evaluationNav;
        jQuery('li#question_' + nav).addClass('active');
    }

    jQuery('button.bool').click(function( event ) {
        event.preventDefault();
    });

    $scope.checkAnswer = function(questionId, valueId, typeQuestion){
        var arrLastAnswer = [];
        var lastAnswer = '';
        var newValue = '';
        if(typeQuestion == 'multiple'){
            lastAnswer = $scope.answers[questionId];
            arrLastAnswer.push(lastAnswer);
            arrLastAnswer.push(valueId);
            newValue = arrLastAnswer.join();
        }else{
            newValue = valueId.toString();
        }
        $scope.answers[questionId] = newValue;
        $scope.countAnswer = $scope.countAnswer + 1;
        $scope.isDisabledNext = false;
        if($scope.maxNavValue == $scope.countAnswer && $scope.answers[questionId] != ''){
            $scope.isDisabledSendAnswers = false;
        }
    }

    $scope.changeClassBool = function(questionId, response, idElement, classElement){
        jQuery('.' + classElement).removeClass('selected');
        jQuery('#' + idElement).addClass('selected');
    }

    $scope.startEvaluation = function(){
        console.log($scope.answers);
    }

    $scope.sendAnswers = function(){
        console.log($scope.answers);
    }
 
}

