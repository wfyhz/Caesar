(function($){
    $.fn.iActiveForm = function(method){
        if(methods[method]){
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }else if(typeof method === 'object' || !method){
            return methods.init.apply(this,arguments);
        }else{
            $.error('Method' + method + 'does not exist on jQuery.iActiveForm');
        }
    };
    var spaceName='iActiveForm';
    var events = {
        beforeValidate: 'beforeValidate',
        afterValidate: 'afterValidate',
        beforeValidateAttribute: 'beforeValidateAttribute',
        afterValidateAttribute: 'afterValidateAttribute',
        beforeSubmit: 'beforeSubmit',
        ajaxBeforeSend: 'ajaxBeforeSend',
        ajaxComplete: 'ajaxComplete'
    };

    var defaults = {
        encodeErrorSummary: true,
        errorSummary: '.error-summary',
        validateOnSubmit: true,
        errorCssClass: 'has-error',
        successCssClass: 'has-success',
        validatingCssClass: 'validating',
        ajaxParam: 'ajax',
        ajaxDataType: 'json',
        validationUrl: undefined,
        ajaxSubmitUrl: undefined,
        enableAjaxSubmit: false
    };

    var attributeDefaults = {
        id: undefined,
        name: undefined,
        container: undefined,
        input: undefined,
        error: '.help-block',
        encodeError: true,
        validateOnChange: true,
        validateOnBlur: true,
        validateOnType:false,
        validationDelay: 500,
        enableAjaxValidation: false,
        validate: undefined,
        status: 0,
        cancelled:false,
        value:undefined
    };

    var methods ={
        init:function(attributes, options){
            return this.each(function(){
                var $form = $(this);
                if($form.data(spaceName)){
                    return;
                }

                var settings = $.extend({},defaults, options||{});
                if(settings.validationUrl === undefined){
                    settings.validationUrl = $form.attr('action');
                }

                $.each(attributes, function(i){
                    attributes[i] = $.extend({value:getValue($form, this)}, attributeDefaults, this);
                    watchAttribute($form, attributes[i]);
                });
                $form.data(spaceName, {
                    settings: settings,
                    attributes: attributes,
                    submitting: false,
                    validated: false
                });
                $form.bind('reset.'+ spaceName, methods.resetForm);

                if(settings.validateOnSubmit){
                    $form.on('mouseup.'+spaceName+' keyup.'+spaceName, ':submit',function(){
                        $form.data(spaceName).submitObject = $(this);
                    });
                    $form.on('submit.'+spaceName, methods.submitForm);
                }
            });
        },
        add:function(){

        },
        submitForm:function(){
            alert('submitForm');
            return false;
        },
        resetForm:function(){
            alert('resetForm');
        },
        validate:function(){

        }
    };

    var watchAttribute = function($form, attribute){
        var $input = findInput($form, attribute);
        if(attribute.validateOnChange){
            $input.on('change.'+ spaceName,function(){
                validateAttribute($form, attribute, false);
            });
        }
    };

    var validateAttribute = function($form, attribute, forceValidate, validationDelay){
        var data = $form.data(spaceName);
        if(forceValidate){
            attribute.status = 2;
        }
        $.each(data.attributes, function(){
            if(this.value !== getValue($form,this)){
                this.status = 2;
                forceValidate = true;
            }
        });
        if(!forceValidate){
            return;
        }

        if(data.settings.timer != undefined){
            clearTimeout(data.settings.timer);
        }

        data.settings.timer = setTimeout(function(){
            if(data.submitting || $form.is(':hidden')){
                return;
            }

            $.each(data.attributes, function(){
                if(this.status === 2){
                    this.status = 3;
                    $form.find(this.container).addClass(data.settings.validatingCssClass);
                }
            });
            methods.validate.call($form);
        },validationDelay ? validationDelay : 200);
    };

    var getValue=function($form, attribute){
        var $input = findInput($form, attribute);
        var type = $input.attr('type');
        if(type === 'checkbox' || type === 'radio'){
            var $realInput = $input.filter(':checked');
            if(!$realInput.length){
                $realInput = $form.find('input[type=hidden][name="' + $input.attr("name") + '"]');
            }
            return $realInput.val();
        }

        return $input.val();
    };

    var findInput=function($form, attribute){
        var $input = $form.find(attribute.input);
        if($input.length && $input[0].tagName.toLowerCase() === 'div'){
            return $input.find('input');
        }else{
            return $input;
        }
    }
})(window.jQuery);