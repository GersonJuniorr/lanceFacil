AjaxSubmitForm.MESSAGETYPE_TOAST = 1;
AjaxSubmitForm.MESSAGETYPE_ALERT = 2;
AjaxSubmitForm.MESSAGETYPE_BOOTBOX = 3;

function AjaxSubmitForm($formToSubmit,$loaderContainer){
    /* Configuração da classe */
    this.$form = $formToSubmit;
    this.$loaderContainer = ($loaderContainer && $loaderContainer.length > 0)?$loaderContainer:$('body');
    this.successCallback = null;
    this.errorCallback = null;
    this.resetForm = false;
    this.clearForm = false;
    this.stateLoading = false;
    this.validator = null;
    this.setFormValidator = function(validator) {
        this.validator = validator;
    };
    //Object.freeze(this.messageType);
    /* Configuração da mensagem de sucesso */
    this.successTitle = 'Sucesso!!';
    this.successMessage = null;
    this.successType = null;
    /* Configuração da mensagem de erro */
    this.errorTitle = 'Erro!!';
    this.errorMessage = null;
    this.errorType = null;
    var INSTANCE = this;
    // já foi setado como um formSubmit antes? então apenas retorno..
    if(this.$form.data()._ajaxFormSubmitInstance) return this;
    this.$form.data('_ajaxFormSubmitInstance', INSTANCE);
    var self = this;

    /* Validando os objetos passados no construtor */
    if (!(this.$form.prop('nodeName') == 'FORM')) throw 'AjaxSubmitForm: No valid form object is defined in constructor';
    /* Setando o metodo de submissão do formulário */
    this.$form.submit(function(e) {
        if (self.validator && !self.validator()) {
            e.preventDefault();
            return false;
        }
        if(self.stateLoading){
            e.preventDefault();
            return false;
        }
        System.beginLoading(self.$loaderContainer,'Aguarde');
        var ajaxFormOptions = {
            dataType: 'json',
            success: self.success,
            error: self.error,
            clearForm: self.clearForm,
            resetForm: self.resetForm
        };
        self.stateLoading = true;
        $(this).ajaxSubmit(ajaxFormOptions);
        self.removeErrorBox();
        e.preventDefault();
        return false;
    });
    /* Ação executada quando não ocorreu erros na requisição */
    this.success = function(response){
        self.stateLoading = false;
        System.stopLoading(self.$loaderContainer);
        /* Exibindo a mensagem de sucesso, caso tenha sido definida */
        switch (self.successType) {
            case AjaxSubmitForm.MESSAGETYPE_ALERT:
                alert(self.successMessage);
                break;
            case AjaxSubmitForm.MESSAGETYPE_TOAST:
                Alert.toast(Alert.TOAST_SUCCESS, self.successMessage, self.successTitle);
                break;
            case AjaxSubmitForm.MESSAGETYPE_BOOTBOX:
                bootbox.alert({
                    message: '<i class="fa fa-check" style="color:#337ab7; font-size:24px"></i>  ' + self.successMessage + '</i>',
                    title: self.successTitle
                });
                break;
        }

        /* Limpando os campos do form quando o ClearForm == true */
        if(self.clearForm === true){
            //funcao que limpa os selects do form
            self.clearSelect();
        }

        /* Verificando e executando o callback do usuário caso exista */
        if (self.successCallback)
            self.successCallback(response);
    }; //fim do success



    // Limpar os campos selects da tela que possuem a class "chosen-select"
    this.clearSelect = function(){
        $('select').each(function(index, value){
            $("#"+value.id).val('').trigger("chosen:updated");
        });
    }

    /* Ação executada quando ocorreram erros na requisição */
    this.error = function(response){
        self.stateLoading = false;
        System.stopLoading(self.$loaderContainer);
        /* Retornando um erro não esperado pela aplicação */
        /*if (!(typeof response == 'object' && response.responseJSON && response.responseJSON.data && Object.prototype.toString.call(response.responseJSON.data) == '[object Array]')){
            var message = (response.responseJSON)?response.responseJSON.message:response.responseText;
            bootbox.dialog({
                message: '<i class="fa fa-times" style="color:red; font-size:24px"></i><b>Error text</b><br><div style="overflow: auto; position: relative;"><br>'+message+'</div>' ,
                title: 'Uncaught Error',
                size: 'large',
                buttons: {
                    main: {
                        label: "Fechar",
                        className: "btn-danger"
                    }
                }
            });
            throw 'AjaxSubmitForm: Uncaught Error ocurred';
        }*/
        /* Retornando a lista de erros */
        //if (typeof response == 'object' && response.responseJSON && response.responseJSON.data && Object.prototype.toString.call(response.responseJSON.data) == '[object Array]')
        var ndata = [];
        if(response.responseJSON.data){
            for(var field in response.responseJSON.data){
                if(['stack', 'exception'].indexOf(field) >= 0) continue;
                console.log('field vale', field);
                ndata.push(response.responseJSON.data[field]);
            }
            //response.responseJSON.data = ndata;
        }
        self.$form.prepend(self.getErrorBox(ndata));
        /* Exibindo a mensagem de erro, caso tenha sido definida */
        switch (self.errorType) {
            case AjaxSubmitForm.MESSAGETYPE_ALERT:
                alert(self.errorMessage);
                break;
            case AjaxSubmitForm.MESSAGETYPE_TOAST:
                Alert.toast(Alert.TOAST_ERROR, self.errorMessage, self.errorTitle);
                break;
            case AjaxSubmitForm.MESSAGETYPE_BOOTBOX:
                bootbox.dialog({
                    message: '<i class="fa fa-times" style="color:red; font-size:24px"></i> ' + self.errorMessage,
                    title: self.errorTitle,
                    buttons: {
                        main: {
                            label: "OK",
                            className: "btn-danger"
                        }
                    }
                });
                break;
        }
        /* Verificando e executando o callback do usuário caso exista */
        if (self.errorCallback)
            self.errorCallback(response);
    }; //fim do onError


    /* Monta o HTML com o retorno dos erros */
    this.getErrorBox = function(errors){
        if (Object.prototype.toString.call(errors) != '[object Array]') throw 'AjaxSubmitForm: Errors passed to getErrorBox function must be an array';
        var errorBox =
            '<div class="alert alert-danger alert-dismissable" id="AjaxSubmitForm-erroBox">'+
            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
            '<i class="fa fa-times"></i> <b>Verifique os erros no formulário</b>'+
            '<div style="border-top: 1px dashed #f2dede; color: #ebccd1; background-color: #ebccd1; height: 1px;  margin: 5px 0;"></div>';
        /* Retornando os erros */
        $.each(errors, function(key, value) {
            errorBox += value + '<br>';
        });

        return errorBox;

    };
    /* Remove os erros da tela */
    this.removeErrorBox = function(){
        $('#AjaxSubmitForm-erroBox', self.$form).remove();
    };
    /* Definindo a mensagem de sucesso */
    this.setSuccessMessage = function(type,message,title,callback){
        if(!title) title = '';
        if ([
                AjaxSubmitForm.MESSAGETYPE_TOAST,
                AjaxSubmitForm.MESSAGETYPE_ALERT,
                AjaxSubmitForm.MESSAGETYPE_BOOTBOX
            ].indexOf(type) < 0) throw "AjaxSubmitForm: Message type undefined or incorrect";
        if (callback && typeof callback != 'function') throw "AjaxSubmitForm: Success callback must be a function";
        self.successType = type;
        self.successMessage = (message && message.replace(/ /g,'').length > 0) ? message : self.successMessage;
        self.successTitle = (title && title.replace(/ /g,'').length > 0) ? title : self.successTitle;
        self.successCallback = callback;
    };
    /* Definindo a mensagem de erro */
    this.setErrorMessage = function(type,message,title,callback){
        if ([
                AjaxSubmitForm.MESSAGETYPE_TOAST,
                AjaxSubmitForm.MESSAGETYPE_ALERT,
                AjaxSubmitForm.MESSAGETYPE_BOOTBOX
            ].indexOf(type) < 0) throw "AjaxSubmitForm: Message type undefined or incorrect";
        if (callback && typeof callback != 'function') throw "AjaxSubmitForm: Error callback must be a function";
        self.errorType = type;
        self.errorMessage = (message && message.replace(/ /g,'').length > 0) ? message : self.errorMessage;
        self.errorTitle = (title && title.replace(/ /g,'').length > 0) ? title : self.errorTitle;
        self.errorCallback = callback;
    };
    /* Definindo o callback de sucesso */
    this.setSuccessCallback = function(callback){
        if (typeof callback != 'function') throw "AjaxSubmitForm: Success callback must be a function";
        self.successCallback = callback;
    };
    /* Definindo o callback de erro */
    this.setErrorCallback = function(callback){
        if (typeof callback != 'function') throw "AjaxSubmitForm: Error callback must be a function";
        self.errorCallback = callback;
    };
    /*Definindo se o fomulário deve ser limpo depois de submitado com sucesso*/
    this.setClearForm = function($value){
        if (typeof $value != 'boolean') throw "AjaxSubmitForm: ClearForm property must be a boolean value";
        self.clearForm = $value;
    };
    /*Definindo se o fomulário deve ser limpo depois de submitado com sucesso*/
    this.setResetForm = function($value){
        if (typeof $value != 'boolean') throw "AjaxSubmitForm: ResetForm property must be a boolean value";
        self.resetForm = $value;
    }
}