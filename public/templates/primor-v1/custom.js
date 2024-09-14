// Livewire: https://laravel-livewire.com/docs/2.x/reference#global-livewire-js

(function($) {
    const BOOTSTRAP_BREAKPOINT_LG = 992;
    const BOOTSTRAP_BREAKPOINT_MD = 768;
    const BOOTSTRAP_BREAKPOINT_SM = 576;

    const MOBILE_MENU = $("#header-mobile-menu");
    const CAROUSEL_SINGLE = $('.carousel-single');
    const CAROUSEL_RECIPES = $('.carousel-recipes');

    $(document).ready(function() {
        MOBILE_MENU.hide();
        $("#header-menu-mobile a").click(function() {
            MOBILE_MENU.slideToggle("slow");
        });

        CAROUSEL_SINGLE.slick({
            'adaptiveHeight': true,
            'dots': true,
            'draggable': false,
            'zIndex': 998,
            'autoplay': true,
            'autoplaySpeed': 4000,
        });
        CAROUSEL_SINGLE.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
            // hide all text-box
            $(this).find('div.text-box').hide();

            // display the one for the next slide
            $(this).find(`[data-slick-index='${nextSlide}']`).find('div.text-box').show();
        });

        CAROUSEL_RECIPES.slick({
            'adaptiveHeight': true,
            'dots': false,
            'draggable': false,
            'zIndex': 998,
            'slidesToShow': 5,
            'slidesToScroll': 1,
            'autoplay': true,
            'autoplaySpeed': 4000,
            responsive: [
                {
                    breakpoint: BOOTSTRAP_BREAKPOINT_LG,
                    settings: {
                      slidesToShow: 4,
                    }
                },
                {
                  breakpoint: BOOTSTRAP_BREAKPOINT_MD,
                  settings: {
                    slidesToShow: 3,
                  }
                },
                {
                    breakpoint: BOOTSTRAP_BREAKPOINT_SM,
                    settings: {
                      slidesToShow: 2,
                    }
                  },
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
              ]
        });
    });

    $('#recipes #f-search').on('keypress', function(e) {
        if(e.which == 13) {
            const search = $(this).val();
            const div_recipes_holder = $('#recipes-list .recipes-holder')
            
            $.post(`/api/v1/recipes/filter`, { 'search': search }, function (retData) {

              if (retData?.data?.html !== null) {
                div_recipes_holder.html(retData?.data?.html);
              }
            });
        }
    });

    $(window).on('resize', function(){
        var win = $(this); //this = window
        if (win.width() >= BOOTSTRAP_BREAKPOINT_MD) {
            MOBILE_MENU.hide();
        }
    });

    $(document).on('submit', 'form#recipeIngredient-add', function(e) {
        e.preventDefault();
        let FORM = $(this);
        const SPAN_QUOTE_CARD = $('form#job-register span#job-partials-quoteCard');
    
        submitModalForm(FORM, function(retorno) {
            FORM.find('.btn-modal-close').click();
            showSuccessAlert({
                'title': 'Sucesso!',
                'text': retorno.message
            });
    
            loadJqueryComponents();
            setTimeout(function() {
                refreshAllLivewireTables();
            }, 250);
        }, null, {
            'disabled': SPAN_QUOTE_CARD.data('disabled')
        });
    });

    function showLoader()
    {
        $.LoadingOverlay("show");
        setTimeout(function(){
            $.LoadingOverlay("hide");
        }, 10000);
    }

    function closeLoader()
    {
        $.LoadingOverlay("hide");
    }

    function showBootstrapModal(html)
    {
        $('div[id^="bootstrap-modal-"]').remove();
        const eventDivId = 'bootstrap-modal-' + uuidv4();
        $('body').append(`<div id="${eventDivId}">${html}</div>`);
        const jqObj = $('#' + eventDivId).find('div.modal');

        var myModal = new bootstrap.Modal(document.getElementById(jqObj[0].id));
        myModal.show();

        return myModal;
    }

    function ajaxSetup(csrf)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf ?? $('meta[name="csrf-token"]').attr('content'),
                // 'Authorization': `Bearer ${USER_API_TOKEN_ID}`,
                // 'domain': DOMAIN_CODED
            }
        });
    }

    function showJsonAjaxModal(type, url, data, csrf=null)
    {
        ajaxSetup(csrf);
        
        $.ajax({
            type,
            url,
            data,
            dataType: 'json',
            beforeSend: function(){showLoader()},
            success: function (retorno) {
                if (retorno.error) {
                    showErrorAlert({
                        title: 'Erro',
                        text: retorno.message
                    });
                    return;
                }

                showBootstrapModal(retorno.data.html);
                loadJqueryComponents();
            },
            complete: function(){closeLoader()},
            error: function (data) {
                showErrorAlert({
                    title: 'Erro',
                    text: getAjaxErrorMsg(data)
                });
            }
        });
    }

    function submitModalForm(oForm, successFnc, actionUrl=null, customData={}, skipDisableForm=false)
    {
        let FORM = oForm;
        let CSRF = FORM.find('input[name="_token"]').val();

        ajaxSetup(CSRF);
        let formData = new FormData(FORM[0]);
        for (const [key, value] of Object.entries(customData)) {
            formData.append(key, value);
        }

        $.ajax({
            type: 'POST',
            url: actionUrl ?? FORM.attr('action'),
            data: formData,
            dataType: 'json',
            processData: false, // required for FormData with jQuery
            contentType: false, // required for FormData with jQuery
            beforeSend: function() {
                showLoader();
                if (!skipDisableForm) {
                    disableFormWhileSaving(FORM);
                }
            },
            success: function (retorno) {
                if (retorno.error) {
                    showErrorAlert({
                        'title': 'Erro!',
                        'text': retorno.message
                    });
                    return;
                }

                successFnc(retorno);
            },
            complete: function() {
                closeLoader();
                if (!skipDisableForm) {
                    enableFormWhileSaving(FORM);
                }
            },
            error: function (data) {
                showErrorAlert({
                    'title': 'Erro!',
                    'text': 'Ocorreu um erro inesperado! Tente novamente.'
                });
                if (!skipDisableForm) {
                    enableFormWhileSaving(FORM);
                }
            }
        });
    }

    function uuidv4() {
        return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
          (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }
    
    function getAjaxErrorMsg(data)
    {
        if (typeof data.responseJSON == 'undefined' || typeof data.responseJSON.message == 'undefined') {
            return 'Erro ao processar essa requisição!';
        }
    
        return data.responseJSON.message;
    }

    function enableFormWhileSaving(formObj)
    {
        formObj.find(":input").prop("disabled", false);
    }

    function disableFormWhileSaving(formObj)
    {
        formObj.find(":input").prop("disabled", true);
    }

    function loadJqueryComponents()
    {
        setTimeout(function() {
          
        }, 250);
    }

    // sweet alert
    /**
     * 
     * @param {*} objVar [title|text]
     */
    function showAlert(typeStr, objVar)
    {
        Swal.fire({
            icon: typeStr,
            title: objVar.title,
            html: objVar.text,
            // footer: '<a href="">Why do I have this issue?</a>'
        });
    }

    function showErrorAlert(objVar)
    {
        showAlert('error', objVar);
    }

    function showSuccessAlert(objVar)
    {
        showAlert('success', objVar);
    }

    function showWarningAlert(objVar)
    {
        showAlert('warning', objVar);
    }

    function showInfoAlert(objVar)
    {
        showAlert('info', objVar);
    }

    function getConfirm(objVar)
    {
        return Swal.mixin({
            title: objVar.title,
            html: objVar.text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim!',
            cancelButtonText: "Fechar",
        });
    }
    // ===========

    // Livewire
    function initLivewireTable()
    {
        Livewire.start();
    }

    function refreshLivewireTable(parentSelector)
    {
        var id = $(`${parentSelector} div[wire\\:id]`).attr('wire:id');
        var Liv = Livewire.find(id);
        Liv.refresh();
    }

    function refreshAllLivewireTables()
    {
        $(`div[wire\\:id]`).each(function() {
            var id = $(this).attr('wire:id');
            var Liv = Livewire.find(id);
            Liv.refresh();

            delete Liv;
        });
    }

    Livewire.on('laraveltable:link:open:newtab', (url) => {
        window.open(url, '_blank').focus();
    });

    Livewire.on('laraveltable:action:feedback', (feedbackMessage) => {
        // Replace this native JS alert by your favorite modal/alert/toast library implementation. Or keep it this way!
        // window.alert(feedbackMessage);

        showInfoAlert({
            icon: null,
            title: 'Informação',
            text: feedbackMessage,
        });
    });

    Livewire.on('laraveltable:action:confirm', (actionType, actionIdentifier, modelPrimary, confirmationQuestion) => {
        // You can replace this native JS confirm dialog by your favorite modal/alert/toast library implementation. Or keep it this way!
        /*
        if (window.confirm(confirmationQuestion)) {
            // As explained above, just send back the 3 first argument from the `table:action:confirm` event when the action is confirmed
            Livewire.emit('laraveltable:action:confirmed', actionType, actionIdentifier, modelPrimary);
        }
        */
        
        var confirm = getConfirm({
            title: 'Confirmação',
            text: confirmationQuestion
        });
        confirm.fire().then((result) => {
            if (!result.isConfirmed) {
                return false;
            }
            
            Livewire.emit('laraveltable:action:confirmed', actionType, actionIdentifier, modelPrimary);
        });
    });

    Livewire.on('laraveltable:link:open:modal', (url, urlParam) => {
        // window.open(url, '_blank').focus();

        const emptyParam = (JSON.stringify(urlParam) === '{}') || (JSON.stringify(urlParam) === '"[]"' || (JSON.stringify(urlParam) === '[]'));
        showJsonAjaxModal('GET', url, emptyParam ? null: urlParam);
    });
}(jQuery));