var getHash = function() {
        return window.location.hash || '';
    };

    var setHash = function(hash) {
        window.location.hash = hash;
    };

    var clearHash = function() {
        var scrollTop, scrollLeft;

        if (typeof history === 'object' && typeof history.pushState === 'function') {
            history.replaceState('', document.title, window.location.pathname + window.location.search);
        } else {
            scrollTop = document.body.scrollTop;
            scrollLeft = document.body.scrollLeft;

            setHash('');

            document.body.scrollTop = scrollTop;
            document.body.scrollLeft = scrollLeft;
        }
    };

    $(window).load(function() {
        var id = getHash().substr(1).replace(/([:\.\[\]\{\}|])/g, "\\$1");
        var elem = $('#' + id);
        if (elem.length) {
            setTimeout(function() {
                $('body,html').scrollTop(elem.position().top);
            });
            elem.find('.toggler').click();
            var section = elem.parents('.section').first();
            if (section) {
                section.addClass('active');
                section.find('.section-list').slideDown('fast');
            }
        }
        loadStoredAuthParams();
    });

    $('.toggler').click(function(event) {
        var contentContainer = $(this).next();

        if (contentContainer.is(':visible')) {
            clearHash();
        } else {
            setHash($(this).data('href'));
        }

        contentContainer.slideToggle('fast');
        return false;
    });

    $('.action-show-hide, .section > h1').on('click', function() {
        var section = $(this).parents('.section').first();
        if (section.hasClass('active')) {
            section.removeClass('active');
            section.find('.section-list').slideUp('fast');
        } else {
            section.addClass('active');
            section.find('.section-list').slideDown('fast');
        }

    });

    $('.action-list').on('click', function() {
        var section = $(this).parents('.section').first();
        if (!section.hasClass('active')) {
            section.addClass('active');
        }
        section.find('.section-list').slideDown('fast');
        section.find('.operation > .content').slideUp('fast');
    });

    $('.action-expand').on('click', function() {
        var section = $(this).parents('.section').first();
        if (!section.hasClass('active')) {
            section.addClass('active');
        }
        $(section).find('ul').slideDown('fast');
        $(section).find('.operation > .content').slideDown('fast');
    });

    var getStoredValue, storeValue, deleteStoredValue;
    var apiAuthKeys = ['api_key', 'api_login', 'api_pass', 'api_endpoint'];

    if ('localStorage' in window) {
        var buildKey = function(key) {
            return 'nelmio_' + key;
        }

        getStoredValue = function(key) {
            return localStorage.getItem(buildKey(key));
        }

        storeValue = function(key, value) {
            localStorage.setItem(buildKey(key), value);
        }

        deleteStoredValue = function(key) {
            localStorage.removeItem(buildKey(key));
        }
    } else {
        getStoredValue = storeValue = deleteStoredValue = function() {};
    }

    var loadStoredAuthParams = function() {
        $.each(apiAuthKeys, function(_, value) {
            var elm = $('#' + value);
            if (elm.length) {
                elm.val(getStoredValue(value));
            }
        });
    }

    var setParameterType = function($context, setType) {
        // no 2nd argument, use default from parameters
        if (typeof setType == "undefined") {
            setType = $context.parent().attr("data-dataType");
            $context.val(setType);
        }

        $context.parent().find('.value').remove();
        var placeholder = "";
        if ($context.parent().attr("data-dataType") != "" && typeof $context.parent().attr("data-dataType") != "undefined") {
            placeholder += "[" + $context.parent().attr("data-dataType") + "] ";
        }
        if ($context.parent().attr("data-format") != "" && typeof $context.parent().attr("data-format") != "undefined") {
            placeholder += $context.parent().attr("data-format");
        }
        if ($context.parent().attr("data-description") != "" && typeof $context.parent().attr("data-description") != "undefined") {
            placeholder += $context.parent().attr("data-description");
        } else {
            placeholder += "Value";
        }

        switch (setType) {
            case "boolean":
                $('<select class="value"><option value=""></option><option value="1">True</option><option value="0">False</option></select>').insertAfter($context);
                break;
            case "file":
                $('<input type="file" class="value" placeholder="' + placeholder + '">').insertAfter($context);
                break;
            case "textarea":
                $('<textarea class="value" placeholder="' + placeholder + '" />').insertAfter($context);
                break;
            default:
                $('<input type="text" class="value" placeholder="' + placeholder + '">').insertAfter($context);
        }
    };

    var toggleButtonText = function($btn) {
        if ($btn.text() === 'Default') {
            $btn.text('Raw');
        } else {
            $btn.text('Default');
        }
    };

    var renderRawBody = function($container) {
        var rawData, $btn;

        rawData = $container.data('raw-response');
        $btn = $container.parents('.pane').find('.to-raw');

        $container.addClass('prettyprinted');
        $container.html($('<div/>').text(rawData).html());

        $btn.removeClass('to-raw');
        $btn.addClass('to-prettify');

        toggleButtonText($btn);
    };

    var renderPrettifiedBody = function($container) {
        var rawData, $btn;

        rawData = $container.data('raw-response');
        $btn = $container.parents('.pane').find('.to-prettify');

        $container.removeClass('prettyprinted');
        $container.html(attachCollapseMarker(prettifyResponse(rawData)));
        prettyPrint && prettyPrint();

        $btn.removeClass('to-prettify');
        $btn.addClass('to-raw');

        toggleButtonText($btn);
    };

    var unflattenDict = function(body) {
        var found = true;
        while (found) {
            found = false;

            for (var key in body) {
                var okey;
                var value = body[key];
                var dictMatch = key.match(/^(.+)\[([^\]]+)\]$/);

                if (dictMatch) {
                    found = true;
                    okey = dictMatch[1];
                    var subkey = dictMatch[2];
                    body[okey] = body[okey] || {};
                    body[okey][subkey] = value;
                    delete body[key];
                } else {
                    body[key] = value;
                }
            }
        }
        return body;
    };

    $('#save_api_auth').click(function(event) {
        $.each(apiAuthKeys, function(_, value) {
            var elm = $('#' + value);
            if (elm.length) {
                storeValue(value, elm.val());
            }
        });
    });

    $('#clear_api_auth').click(function(event) {
        $.each(apiAuthKeys, function(_, value) {
            deleteStoredValue(value);
            var elm = $('#' + value);
            if (elm.length) {
                elm.val('');
            }
        });
    });

    $('.tabs li').click(function() {
        var contentGroup = $(this).parents('.content');

        $('.pane.selected', contentGroup).removeClass('selected');
        $('.pane.' + $(this).data('pane'), contentGroup).addClass('selected');

        $('li', $(this).parent()).removeClass('selected');
        $(this).addClass('selected');
    });

    var getJsonCollapseHtml = function(sectionOpenCharacter) {
        var $toggler = $('<span>').addClass('json-collapse-section').
        attr('data-section-open-character', sectionOpenCharacter).
        append($('<span>').addClass('json-collapse-marker')
            .html('&#9663;')
        ).append(sectionOpenCharacter);
        return $('<div>').append($toggler).html();
    };

    var attachCollapseMarker = function(prettifiedJsonString) {
        prettifiedJsonString = prettifiedJsonString.replace(/(\{|\[)\n/g, function(match, sectionOpenCharacter) {
            return getJsonCollapseHtml(sectionOpenCharacter) + '<span class="json-collapse-content">\n';
        });
        return prettifiedJsonString.replace(/([^\[][\}\]],?)\n/g, '$1</span>\n');
    };

    var prettifyResponse = function(text) {
        try {
            var data = typeof text === 'string' ? JSON.parse(text) : text;
            text = JSON.stringify(data, undefined, '  ');
        } catch (err) {}

        // HTML encode the result
        return $('<div>').text(text).html();
    };

    var displayFinalUrl = function(xhr, method, url, data, container) {
        container.text(method + ' ' + getFinalUrl(method, url, data));
    };

    var displayRequestBody = function(method, data, container, header) {
        if ('GET' != method && !jQuery.isEmptyObject(data) && data !== "" && data !== undefined) {
            if (jQuery.type(data) !== 'string') {
                data = decodeURIComponent(jQuery.param(data));
            }

            container.text(data);
            container.show();
            header.show();
        } else {
            container.hide();
            header.hide();
        }
    };

    var displayProfilerUrl = function(xhr, link, container) {
        var profilerUrl = xhr.getResponseHeader('X-Debug-Token-Link');
        if (profilerUrl) {
            link.attr('href', profilerUrl);
            container.show();
        } else {
            link.attr('href', '');
            container.hide();
        }
    };

    var displayResponseData = function(xhr, container) {
        var data = xhr.responseText;

        container.data('raw-response', data);

        renderPrettifiedBody(container);

        container.parents('.pane').find('.to-prettify').text('Raw');
        container.parents('.pane').find('.to-raw').text('Raw');
    };

    var displayResponseHeaders = function(xhr, container) {
        var text = xhr.status + ' ' + xhr.statusText + "\n\n";
        text += xhr.getAllResponseHeaders();

        container.text(text);
    };

    var displayCurl = function(method, url, headers, data, result_container) {
        var escapeShell = function(param) {
            param = "" + param;
            return '"' + param.replace(/(["\s'$`\\])/g, '\\$1') + '"';
        };

        url = getFinalUrl(method, url, data);

        var command = "curl";
        command += " -X " + escapeShell(method);

        if (method != "GET" && !jQuery.isEmptyObject(data) && data !== "" && data !== undefined) {
            if (jQuery.type(data) !== 'string') {
                data = decodeURIComponent(jQuery.param(data));
            }
            command += " -d " + escapeShell(data);
        }

        for (headerKey in headers) {
            if (headers.hasOwnProperty(headerKey)) {
                command += " -H " + escapeShell(headerKey + ': ' + headers[headerKey]);
            }
        }

        command += " " + url;

        result_container.text(command);
    };

    var getFinalUrl = function(method, url, data) {
        if ('GET' == method && !jQuery.isEmptyObject(data)) {
            var separator = url.indexOf('?') >= 0 ? '&' : '?';
            url = url + separator + decodeURIComponent(jQuery.param(data));
        }

        return url;
    };

    var displayResponse = function(xhr, method, url, headers, data, result_container) {
        displayFinalUrl(xhr, method, url, data, $('.url', result_container));
        displayRequestBody(method, data, $('.request-body', result_container), $('.request-body-header', result_container));
        displayProfilerUrl(xhr, $('.profiler-link', result_container), $('.profiler', result_container));
        displayResponseData(xhr, $('.response', result_container));
        displayResponseHeaders(xhr, $('.headers', result_container));
        displayCurl(method, url, headers, data, $('.curl-command', result_container));

        result_container.show();
    };

    $('.pane.sandbox form').submit(function() {
        var url = $(this).attr('action'),
            method = $('[name="header_method"]', this).val(),
            self = this,
            params = {},
            filters = {},
            formData = new FormData(),
            doubledParams = {},
            doubledFilters = {},
            headers = {},
            content = $(this).find('textarea.content').val(),
            result_container = $('.result', $(this).parent());

        if (method === 'ANY') {
            method = 'POST';
        }

        // set requestFormat
        var requestFormatMethod = 'format_param';
        if (requestFormatMethod == 'format_param') {
            params['_format'] = $('#request_format option:selected').text();
            formData.append('_format', $('#request_format option:selected').text());
        } else if (requestFormatMethod == 'accept_header') {
            headers['Accept'] = $('#request_format').val();
        }

        // set default bodyFormat
        var bodyFormat = $('#body_format').val() || 'form';

        if (!('Content-type' in headers)) {
            if (bodyFormat == 'form') {
                headers['Content-type'] = 'application/x-www-form-urlencoded';
            } else {
                headers['Content-type'] = 'application/json';
            }
        }

        var hasFileTypes = false;
        $('.parameters .tuple_type', $(this)).each(function() {
            if ($(this).val() == 'file') {
                hasFileTypes = true;
            }
        });

        if (hasFileTypes && method != 'POST') {
            alert("Sorry, you can only submit files via POST.");
            return false;
        }

        if (hasFileTypes && bodyFormat != 'form') {
            alert("Body Format must be set to 'Form Data' when utilizing file upload type parameters.\nYour current bodyFormat is '" + bodyFormat +
                "'. Change your BodyFormat or do not use file type\nparameters.");
            return false;
        }

        if (hasFileTypes) {
            // retrieve all the parameters to send for file upload
            $('.parameters .tuple', $(this)).each(function() {
                var key, value;

                key = $('.key', $(this)).val();
                if ($('.value', $(this)).attr('type') === 'file') {
                    value = $('.value', $(this)).prop('files')[0];
                    if (!value) {
                        value = new File([], '');
                    }
                } else {
                    value = $('.value', $(this)).val();
                }

                if (value) {
                    formData.append(key, value);
                }
            });
        }


        // retrieve all the parameters to send
        $('.parameters .tuple', $(this)).each(function() {
            var key, value;

            key = $('.key', $(this)).val();
            value = $('.value', $(this)).val();

            if (value) {
                // convert boolean values to boolean
                if ('json' === bodyFormat && 'boolean' === $('.tuple_type', $(this)).val()) {
                    value = '1' === value;
                }

                // temporary save all additional/doubled parameters
                if (key in params) {
                    doubledParams[key] = value;
                } else {
                    params[key] = value;
                }
            }
        });




        // retrieve all the filters to send
        $('.parameters .tuple.filter', $(this)).each(function() {
            var key, value;

            key = $('.key', $(this)).val();
            value = $('.value', $(this)).val();

            if (value) {
                // temporary save all additional/doubled parameters
                if (key in filters) {
                    doubledFilters[key] = value;
                } else {
                    filters[key] = value;
                }
            }
        });




        // retrieve the additional headers to send
        $('.headers .tuple', $(this)).each(function() {
            var key, value;

            key = $('.key', $(this)).val();
            value = $('.value', $(this)).val();

            if (value) {
                headers[key] = value;
            }

        });

        // fix parameters in URL
        for (var key in $.extend({}, params)) {
            if (url.indexOf('{' + key + '}') !== -1) {
                url = url.replace('{' + key + '}', params[key]);
                delete params[key];
            }
        };

        // merge additional params back to real params object
        if (!$.isEmptyObject(doubledParams)) {
            $.extend(params, doubledParams);
        }

        // disable all the fiels and buttons
        $('input, button', $(this)).attr('disabled', 'disabled');

        // append the query authentication
        var api_key_val = $('#api_key').val();
        if (authentication_delivery == 'query' && api_key_val.length > 0) {
            url += url.indexOf('?') > 0 ? '&' : '?';
            url += api_key_parameter + '=' + api_key_val;
        }

        // prepare the api enpoint
        var endpoint = '';

        //add filters as GET params and remove them from params
        if (method != 'GET') {
            for (var filterKey in $.extend({}, filters)) {
                url += url.indexOf('?') > 0 ? '&' : '?';
                url += filterKey + '=' + filters[filterKey];

                if (params.hasOwnProperty(filterKey)) {
                    delete(params[filterKey]);
                }
            }
        }

        // prepare final parameters
        var body = {};
        if (bodyFormat == 'json' && method != 'GET') {
            body = unflattenDict(params);
            body = JSON.stringify(body);
        } else {
            body = params;
        }
        var data = content.length ? content : body;
        var ajaxOptions = {
            url: (url.indexOf('http') != 0 ? endpoint : '') + url,
            xhrFields: {
                withCredentials: true
            },
            type: method,
            data: data,
            headers: headers,
            crossDomain: true,
            beforeSend: function(xhr) {
                if (authentication_delivery) {
                    var value;

                    if ('http' == authentication_delivery) {
                        if ('basic' == authentication_type) {
                            value = 'Basic ' + btoa($('#api_login').val() + ':' + $('#api_pass').val());
                        } else if ('bearer' == authentication_type) {
                            value = 'Bearer ' + $('#api_key').val();
                        }
                    } else if ('header' == authentication_delivery) {
                        value = $('#api_key').val();
                    }

                    xhr.setRequestHeader(api_key_parameter, value);
                }
            },
            complete: function(xhr) {
                displayResponse(xhr, method, url, headers, data, result_container);

                // and enable them back
                $('input:not(.content-type), button', $(self)).removeAttr('disabled');
            }
        };

        // overrides body format to send data properly
        if (hasFileTypes) {
            ajaxOptions.data = formData;
            ajaxOptions.processData = false;
            ajaxOptions.contentType = false;
            delete(headers['Content-type']);
        }

        // and trigger the API call
        $.ajax(ajaxOptions);

        return false;
    });

    $('.operations').on('click', '.operation > .heading', function(e) {
        if (history.pushState) {
            history.pushState(null, null, $(this).data('href'));
            e.preventDefault();
        }
    });

    $(document).on('click', '.json-collapse-section', function() {
        var openChar = $(this).data('section-open-character'),
            closingChar = (openChar == '{' ? '}' : ']');
        if ($(this).next('.json-collapse-content').is(':visible')) {
            $(this).html('&oplus;' + openChar + '...' + closingChar);
        } else {
            $(this).html('&#9663;' + $(this).data('section-open-character'));
        }
        $(this).next('.json-collapse-content').toggle();
    });

    $(document).on('copy', '.prettyprinted', function() {
        var $toggleMarkers = $(this).find('.json-collapse-marker');
        $toggleMarkers.hide();
        setTimeout(function() {
            $toggleMarkers.show();
        }, 100);
    });

    $('.pane.sandbox').on('click', '.to-raw', function(e) {
        renderRawBody($(this).parents('.pane').find('.response'));

        e.preventDefault();
    });

    $('.pane.sandbox').on('click', '.to-prettify', function(e) {
        renderPrettifiedBody($(this).parents('.pane').find('.response'));

        e.preventDefault();
    });

    $('.pane.sandbox').on('click', '.to-expand, .to-shrink', function(e) {
        var $headers = $(this).parents('.result').find('.headers');
        var $label = $(this).parents('.result').find('a.to-expand');

        if ($headers.hasClass('to-expand')) {
            $headers.removeClass('to-expand');
            $headers.addClass('to-shrink');
            $label.text('Shrink');
        } else {
            $headers.removeClass('to-shrink');
            $headers.addClass('to-expand');
            $label.text('Expand');
        }

        e.preventDefault();
    });


    // sets the correct parameter type on load
    $('.pane.sandbox .tuple_type').each(function() {
        setParameterType($(this));
    });


    // handles parameter type change
    $('.pane.sandbox').on('change', '.tuple_type', function() {
        setParameterType($(this), $(this).val());
    });



    $('.pane.sandbox').on('click', '.add_parameter', function() {
        var html = $(this).parents('.pane').find('.parameters_tuple_template').html();

        $(this).before(html);

        return false;
    });

    $('.pane.sandbox').on('click', '.add_header', function() {
        var html = $(this).parents('.pane').find('.headers_tuple_template').html();

        $(this).before(html);

        return false;
    });

    $('.pane.sandbox').on('click', '.remove', function() {
        $(this).parent().remove();
    });

    $('.pane.sandbox').on('click', '.set-content-type', function(e) {
        var html;
        var $element;
        var $headers = $(this).parents('form').find('.headers');
        var content_type = $(this).prev('input.value').val();

        e.preventDefault();

        if (content_type.length === 0) {
            return;
        }

        $headers.find('input.key').each(function() {
            if ($.trim($(this).val().toLowerCase()) === 'content-type') {
                $element = $(this).parents('p');
                return false;
            }
        });

        if (typeof $element === 'undefined') {
            html = $(this).parents('.pane').find('.tuple_template').html();

            $element = $headers.find('legend').after(html).next('p');
        }

        $element.find('input.key').val('Content-Type');
        $element.find('input.value').val(content_type);

    });

    var authentication_delivery = false;