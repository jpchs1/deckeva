jQuery(function ($) {
    var the7ContactFormReCaptchaDummy = {
        render: function() {},
        getResponse: function() { return true; },
        reset: function() {}
    };

    function the7ContactFormReCaptcha(sitekey, element) {
        this.sitekey = sitekey;
        this.element = element;
        this.captchaObj = null;
    }

    the7ContactFormReCaptcha.prototype.render = function() {
        var self = this;
        grecaptcha.ready(function() {
            self.captchaObj = grecaptcha.render(self.element, {
                "sitekey": self.sitekey
            });
        });
    };

    the7ContactFormReCaptcha.prototype.getResponse = function() {
        return grecaptcha.getResponse(this.captchaObj);
    };

    the7ContactFormReCaptcha.prototype.reset = function() {
        grecaptcha.reset(this.captchaObj);
    };

    function displayFormMessage( $form, message, msgType ) {
        $("input[type=\"hidden\"]", $form).last().validationEngine("showPrompt", message, msgType, "inline");
    }

    // Init form validator
    //function dtInitContactForm () {
    $.fn.dtInitContactForm = function () {
        return this.each(function () {
            var $form = $(this);
            var $term = "";
            if ($form.hasClass("privacy-form")) {
                $term = "<p class=\"dt-privacy-message\">" + dtLocal.contactMessages.terms + "<p>";
            } else {
                $term = "";
            }

            var the7ReCaptcha = the7ContactFormReCaptchaDummy;
            if ( dtLocal.captchaSiteKey ) {
                the7ReCaptcha = new the7ContactFormReCaptcha(dtLocal.captchaSiteKey, $form.find(".the7-g-captcha")[0]);
            }

            the7ReCaptcha.render();

            $form.validationEngine({
                binded: false,
                promptPosition: "inline",
                scroll: false,
                autoHidePrompt: false,
                maxErrorsPerField: 1,
                //showOneMessage: true,
                "custom_error_messages": {
                    "required": {
                        "message": dtLocal.contactMessages.required + $term
                    }
                },
                fadeDuration: 500,
                addPromptClass: "run-animation",
                onAjaxFormComplete: function () {
                },
                addSuccessCssClassToField: "field-success",
                onBeforeAjaxFormValidation: function (form, status) {
                    var $form = $(form);
                    $form.find(".formError").removeClass("first");
                    $form.find("input").removeClass("error-field");
                    $form.find("textarea").removeClass("error-field");
                },
                onFailure: function (form, status) {
                    var $form = $(form);
                    if ($form.find(".formError .close-message").length <= 0) {
                        $form.find(".formError").append("<span class=\"close-message\"></span>");
                    }
                },
                onValidationComplete: function (form, status) {
                    var $form = $(form);
                    if ($form.find(".greenPopup").length > 0) {
                        $form.find(".greenPopup").remove();
                    }
                    $form.find(".formError").removeClass("first");
                    $form.find("input").removeClass("error-field");
                    $form.find("textarea").removeClass("error-field");

                    $form.find(".formError").each(function (i, el) {
                        $(el).eq(i).addClass("first");
                        $(el).prev().addClass("error-field");
                    });
                    $(".formError .close-message").remove();
                    if ($form.find(".formError .close-message").length <= 0) {
                        $form.find(".formError").append("<span class=\"close-message\"></span>");
                    }
                    if ($form.find("input.the7-form-terms").hasClass("field-success")) {
                        $form.find(".dt-privacy-message").addClass("hide-privacy-message");
                    }

                    // If validation success
                    if (status) {
                        var gcaptchaToken = the7ReCaptcha.getResponse();
                        if ( ! gcaptchaToken ) {
                            displayFormMessage($form, dtLocal.contactMessages.fillTheCaptchaError, 'error');
                            return;
                        }

                        var data = {
                            widget_id: $("input[name=\"widget_id\"]", $form).val(),
                            send_message: $("input[name=\"send_message\"]", $form).val(),
                            security_token: $("input[name=\"security_token\"]", $form).val(),
                            gcaptcha_token: gcaptchaToken,
                            fields: {}
                        };

                        $form.find("input[type=\"text\"], textarea").each(function () {
                            var $this = $(this);

                            data.fields[$this.attr("name")] = $this.val();
                        });

                        $.post(
                            dtLocal.REST.baseUrl + dtLocal.REST.endpoints.sendMail,
                            data,
                            function (response) {
                                var _caller = $(form);
                                var msgType = response.success ? "pass" : "error";
                                var messageTimeoutDelete;

                                // Show message
                                displayFormMessage(_caller, response.errors, msgType);

                                $form.find(".formError").addClass("field-success");
                                // set promptPosition again
                                _caller.validationEngine("showPrompt", "", "", "topRight");

                                the7ReCaptcha.reset();

                                // Clear fields if success
                                if (response.success) {
                                    _caller.find("input[type=\"text\"], textarea").val("");
                                    _caller.find("input[type=\"checkbox\"]").removeProp("checked");

                                    if ($form.find(".formError .close-message").length <= 0) {
                                        $form.find(".formError").append("<span class=\"close-message\"></span>");
                                        $form.find(".formError .close-message").on("click", function () {
                                            $form.find(".greenPopup").remove();
                                            clearTimeout(messageTimeoutDelete);
                                        });
                                    }

                                    clearTimeout(messageTimeoutDelete);
                                    messageTimeoutDelete = setTimeout(function () {
                                        $form.find(".greenPopup").remove();
                                    }, 11000);
                                }
                            }
                        );
                    }

                }
            });

            $form.find(".dt-btn.dt-btn-submit").on("click", function (e) {
                e.preventDefault();

                var $form = $(this).parents("form");
                $form.submit();
            });

            $form.find(".clear-form").on("click", function (e) {
                e.preventDefault();

                var $form = $(this).parents("form");

                if ($form.length > 0) {
                    $form.find("input[type=\"text\"], textarea").val("");
                    $form.validationEngine("hide");
                }
            });
        })
    }

    $("form.dt-contact-form.dt-form").dtInitContactForm();
});