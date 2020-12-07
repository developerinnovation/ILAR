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
        scope.idModule = condig.idModule;
        scope.nid = config.nid;
        scope.evaluationNav = 1;
        scope.maxNavValue = config.total_questions;
        scope.minNavValue = 1;
        scope.answers = config.data;
        scope.countAnswer = 0;
        scope.isDisabledNext = true;
        scope.isDisabledSendAnswers = true;
        scope.idEvaluation = null;
        scope.pathAnswers = config.pathAnswers;
        scope.average = config.average;
        scope.idCourse = config.idCourse;
        scope.pathAnswersStart = config.pathAnswersStart;
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
        var params = {
            'answer' : $scope.answers,
            'average' : $scope.average,
            'moduleId' : $scope.moduleId,
            'nid' : $scope.nid,
            'idCourse' : $scope.idCourse,
            'maxNavValue' : scope.maxNavValue,
        };
        $http.get('/rest/session/token').then(function (resp) {
            $http({
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-Token': resp.data
              },
              data: params,
              url: $scope.pathAnswersStart
            }).then(function (resp) {
                if (resp.data.status == '200') {
                    $scope.idEvaluation = resp.data.id;
                }else{
                    var errorMessage = 'Se presentó un error al inciar el examen, por favor recarga la página e e intenta nuevamente, si el error continua por favor repórtalo al equipo de soporte.';
                    $rootScope.showMessageModal(errorMessage);
                }
            });
          }).catch(
            function (resp) {
                $rootScope.showMessageModal('Se presentó una falla de comunicación, por favor intente más tarde.');
            }
        );
    }

    $scope.sendAnswers = function(){
        var params = {
            'answer' : $scope.answers,
            'average' : $scope.average,
            'moduleId' : $scope.moduleId,
            'nid' : $scope.nid,
            'idCourse' : $scope.idCourse,
            'idEvaluation' : $scope.idEvaluation,
        };
        $http.get('/rest/session/token').then(function (resp) {
            $http({
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-Token': resp.data
              },
              data: params,
              url: $scope.pathAnswers
            }).then(function (resp) {
                if (resp.data.status == '200') {
                    if(resp.data.approved){
                        var errorMessage = 'Se presentó un error enviar las respuestas del examen, por favor comunícate con el equipo de soporte.';
                        $rootScope.showMessageModal(errorMessage);
                    }else{
                        var errorMessage = 'Se presentó un error enviar las respuestas del examen, por favor comunícate con el equipo de soporte.';
                        $rootScope.showMessageModal(errorMessage);
                    }
                }else{
                    var errorMessage = 'Se presentó un error enviar las respuestas del examen, por favor comunícate con el equipo de soporte.';
                    $rootScope.showMessageModal(errorMessage);
                }
            });
          }).catch(
            function (resp) {
                $rootScope.showMessageModal('Se presentó una falla de comunicación al tratar de enviar las respuestas, por favor comunícate con el equipo de soporte.');
            }
        );
    }
 
}

