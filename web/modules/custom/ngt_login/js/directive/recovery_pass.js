myApp.directive('ngRecoveryPass', ['$http', ngRecoveryPass]);

function ngRecoveryPass($http){
    
    var directive = {
        restrict: 'EA',
        controller: RecoveryPassController,
        link: linkFunc
    };

    return directive;

    function linkFunc(scope, el, attr, ctrl){
        var config = drupalSettings.ngtBlock[scope.uuid_data_ng_recovery_pass];
        console.log(config);
        scope.config = config;
        scope.step = 1;
        scope.message = config.config.msj_mail;
        scope.txtBtnNext = config.config.continue;
        scope.txtBtnReturn = config.config.cancell;
        scope.statusCode = true;
        scope.status_pass_label = config.config.new_pass_success_label;
        scope.status_pass = true;
        scope.messageStatusRecovery = config.config.new_pass_success;
        scope.pass_criteriar = config.pass_criteriar;
    }

}

RecoveryPassController.$inject = ['$scope', '$http', '$rootScope','$interval', '$window'];
function RecoveryPassController($scope, $http, $rootScope){

    $scope.actionNext = function (){
        $scope.step += 1; 
        if( $scope.step > 3 ){
            $scope.txtBtnNext = $scope.config.config.login_btn;
        }
    }

    $scope.actionReturn = function (){
        $scope.step -= 1; 
    }

    $scope.actionCancell= function (){
        // window.location.href = '/';
    }
    
    $scope.actionLogin= function (){
        window.location.href = '/user/login';
    }
    

    $scope.getPing  = function (tid,rangeInitial,rangeStop) {

        var url = `/ngt/api/v1/course/${tid}/${rangeInitial}/${rangeStop}`;
        var config_data = {};

        // var params = {};
        // $http.get('/rest/session/token').then(function (resp) {
        //     $http({
        //       method: 'POST',
        //       headers: {
        //         'Content-Type': 'application/json',
        //         'Accept': 'application/json',
        //         'X-CSRF-Token': resp.data
        //       },
        //       data: params,
        //       url: `/ngt/api/v1/course/${tid}/${rangeInitial}/${rangeStop}`
        //     }).then(function (resp) {
        //         if (resp.data !== undefined && resp.data !== '' && resp.data.length > 0) {
        //             loading = false;
        //             $scope.updaRating();
        //             $scope.RecoveryPass = RecoveryPass.concat(resp.data);
        //         }else{
        //             $scope.showMore = false;
        //         }
        //         $scope.loading = false;
        //     });
        //   }).catch(
        //     function (resp) {
        //         console.log("error");
        //         console.log(resp);
        //     }
        // );

    }


}