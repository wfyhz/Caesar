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
            var $form = $(this),
                data = $form.data(spaceName),
                needAjaxValidation = false,
                messages = {},
                deferreds = deferredArray(),
                submitting = data.submitting;
            if(submitting)
            {
                var event = $.Event(events.beforeValidate);
                $form.trigger(event, [messages, deferreds]);
                if(event.result === false){
                    data.submitting = false;
                    return;
                }
            }

            $.each(data.attributes, function(){
                this.cancelled = false;
                if(data.submitting || this.status === 2 || this.status === 3){
                    var msg = messages[this.id];
                    if(msg === undefined){
                        msg = [];
                        messages[this.id] = msg;
                    }

                    var event = $.Event(events.beforeValidateAttribute);
                    $form.trigger(event, [this, msg, deferreds]);
                    if(event.result !== false){
                        if(this.validate){
                            console.log(messages);
                            this.validate(this,getValue($form, this), msg, deferreds, $form);
                            console.log(messages);return;
                        }
                        if(this.enableAjaxValidation){
                            needAjaxValidation = true;
                        }
                    }else{
                        this.cancelled = true;
                    }
                }
            });

            $.when.apply(this, deferreds).always(function(){
                //移除空值
                for(var i in messages){
                    if(0 === messages[i].length)
                        delete messages[i];
                }

                if(needAjaxValidation){
                    //需要ajax验证
                    var $button = data.submitObject,
                        extData = '&'+data.settings.ajaxParam + '=' + $form.attr('id');
                    if($button && $button.length && $button.attr('name')){
                        extData += '&' + $button.attr('name') + '=' + $button.attr('value');
                    }
                    $.ajax({
                        url:data.settings.validationUrl,
                        type:$form.attr('method'),
                        data:$form.serialize() + extData,
                        dataType:data.settings.ajaxDataType,
                        complete:function(jqXHR, textStatus){
                            $form.trigger(events.ajaxComplete,[jqXHR, textStatus]);
                        },
                        beforeSend:function(jqXHR, settings){
                            $form.trigger(events.ajaxBeforeSend, [jqXHR, settings]);
                        },
                        success:function(msgs){
                            if(msgs !== null && typeof msgs === 'object'){
                                $.each(data.attributes, function(){
                                    if(!this.enableAjaxValidation || this.canceled){
                                        delete msgs[this.id];
                                    }
                                });
                                updateInputs($form, $.extend(messages, msgs), submitting);
                            }else{
                                updateInputs($form, messages, submitting);
                            }
                        },
                        error:function(){
                            data.submitting = false;
                        }
                    });
                }else if(data.submitting){
                    setTimeout(function(){
                        updateInputs($form, messages, submitting);
                    }, 200);
                }else{
                    updateInputs($form, messages, submitting);
                }

            });
        }
    };

    var watchAttribute = function($form, attribute){
        var $input = findInput($form, attribute);
        if(attribute.validateOnChange){
            $input.on('change.'+ spaceName,function(){
                validateAttribute($form, attribute, false);
            });
        }

        if(attribute.validateOnBlur){
            $input.on('blur.'+spaceName, function(){
                if(attribute.status == 0 || attribute.status == 1){
                    validateAttribute($form, attribute, !attribute.status);
                }
            });
        }

        if(attribute.validateOnType){
            $input.on('keyup.'+spaceName, function(e){
                if($.inArray(e.which, [16,17,18,37,38,39,40]) !== -1){
                    return;
                }

                if(attribute.value !== getValue($form, attribute)){
                    validateAttribute($form, attribute, false, attribute.validationDelay);
                }
            })
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

    var deferredArray = function(){
        var array = [];
        array.add = function(callback){
            this.push(new $.Deferred(callback));
        };

        return array;
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
    };

    var updateInputs = function($form, messages, submitting){
        var data = $form.data(spaceName);
        if(submitting){
            var errorInputs = [];
            $.each(data.attributes, function(){
                if(!this.canceled && updateInput($form, this, messages)){
                    errorInputs.push(this.input);
                }
            });

            $form.trigger(events.afterValidate, [messages]);
            updateSummary($form, messages);
            if(errorInputs.length){
                var top = $form.find(errorInputs.join(',')).first().closest(':visible').offset().top;
                var wtop = $(window).scrollTop();
                if(top < wtop || top > wtop + $(window).height){
                    $(window).scrollTop(top);
                }
                data.submitting = false;
            }else{
                data.validated = true;
                var $button = data.submitObject || $form.find(':submit:first');
                if($button.length && $button.attr('type') == 'submit' && $button.attr('name')){
                    var $hiddenButton = $('input[type="hidden"][name="'+$button.attr('name') + '"]', $form);
                    if(!$hiddenButton.length){
                        $('<input>').attr({
                            type:'hidden',
                            name:$button.attr('name'),
                            value:$button.attr('value')
                        }).appendTo($form);
                    }else{
                        $hiddenButton.attr('value',$button.attr('value'));
                    }
                }
                $form.submit();
            }
        }else{
            $.each(data.attributes, function(){
                if(!this.canceled && (this.status == 2 || this.status === 3) ){
                    updateInput($form, this, messages);
                }
            })
        }
    };

    var updateInput = function($form, attribute, messages){
        var data = $form.data(spaceName),
            $input = findInput($form, attribute),
            hasError = false;
        if(!$.isArray(messages[attribute.id])){
            messages[attribute.id] = [];
        }

        $form.trigger(events.afterValidateAttribute, [attribute, messages[attribute.id]]);

        attribute.status = 1;
        if($input.length){
            hasError = messages[attribute.id].length >0;
            var $container = $form.find(attribute.container);
            var $error = $container.find(attribute.error);
            if(hasError){
                if(attribute.encodeError){
                    $error.text(messages[attribute.id][0]);
                }else{
                    $error.html(messages[attribute.id][0]);
                }

                $container.removeClass(data.settings.validatingCssClass + ' ' + data.settings.successCssClass).addClass(data.settings.errorCssClass);
            }else{
                $error.empty();
                $container.removeClass(data.settings.validatingCssClass + ' ' + data.settings.errorCssClass + ' ').addClass(data.settings.successCssClass);
            }
            attribute.value = getValue($form, attribute);
        }

        return hasError;
    };

    var updateSummary = function($form, messages){
        var data = $form.data(spaceName),
            $summary = $form.find(data.settings.errorSummary),
            $ul = $summary.find('ul').empty();
        if($summary.length && messages){
            $.each(data.attributes, function(){
                if($.isArray(messages[this.id]) && messages[this.id].length){
                    var error = $('<li/>');
                    if(data.settings.encodeErrorSummary){
                        error.text(messages[this.id][0]);
                    }else{
                        error.html(messages[this.id][0]);
                    }
                    $ul.append(error);
                }
            });
            $summary.toggle($ul.find('li').length > 0);
        }
    }
})(window.jQuery);
