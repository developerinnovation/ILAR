myApp.directive('ngRegisterUser', ['$http', ngRegisterUser]);

function ngRegisterUser($http){
    
    var directive = {
        restrict: 'EA',
        controller: RegisterUserController,
        link: linkFunc
    };

    return directive;

    function linkFunc(scope, el, attr, ctrl){
        var config = drupalSettings.ngtBlock[scope.uuid_data_ng_register_user];
        console.log(config);
        scope.config = config;
        scope.profession = config.profession;
        scope.step = 1;
        scope.message = config.config.message;
        scope.txtBtnNext = config.config.continue;
        scope.txtBtnReturn = config.config.cancell;
        scope.statusCode = true;
        scope.status_pass_label = config.config.new_pass_success_label;
        scope.status_pass = true;
        scope.messageStatusRecovery = config.config.new_pass_success;
        scope.pass_criteriar = config.pass_criteriar;
        scope.btnDisabled = false;
        scope.country = [];
        scope.state = [];
        scope.city = [];

        scope.enableCountry = false;
        scope.enableState = false;
        scope.enableCity = false;

        scope.status_register = true;
        scope.status_register_label = config.config.ready;
        scope.messageStatusRegister = config.config.message_new_user_success;
        scope.labelStatusRegister = config.config.message_new_user_welcome;
        scope.messageStatusLoadPic = config.config.message_picture_load_success;
        scope.txtBtnOmit = config.config.omit;
    }

}

RegisterUserController.$inject = ['$scope', '$http', '$rootScope','$interval', '$window'];
function RegisterUserController($scope, $http, $rootScope){

    $scope.actionNext = function (){
        var emailValid = true; 

        if( $scope.step > 4 ){
            $scope.txtBtnNext = $scope.config.config.login_btn;
        }

        switch ($scope.step) {
            case 1:
                    if($scope().name != '' && $scope().email != '' &&  $scope().date != null && $scope.professionSelect != undefined){
                        if( !$scope.ValidateEmail($scope().email) ) {
                            emailValid = false;
                        }

                        
                    }
                break;

            case 4:
                    $scope.message = $scope.config.config.message_picture;
                break;

            case 5:
                    $scope.txtBtnNext = $scope.config.config.login;
                break;
        }
    }

    $scope.changeStep = function (){
        $scope.step += 1; 
    }

    $scope.actionReturn = function (){
        $scope.step -= 1; 
    }

    $scope.actionCancell = function (){
        // window.location.href = '/';
    }
    
    $scope.actionLogin= function (){
        window.location.href = '/user/login';
    }

    $scope.omitLoadPic = function (){

    }

    $scope.ValidateEmail = function (mail){
        if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail)){
            return (true)
        }
        return (false);
    }

}