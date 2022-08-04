(function (window, document, $) {
//     'use strict';
    let row, height, cell, this_cell;
    $.fn.block_row = function (opts) {
        row = $(this)
        height = row.height();
        $('td, th', row).each(function () {
            cell = $(this);
            cell.wrapInner('<div class="holderByBlock container" style="width:100%;  overflow: hidden;"></div>');
            cell.addClass('cleanByBlock');
            cell.attr('style', 'border: 0; padding: 0;')
            $('div.holderByBlock', cell).block(opts);
        })
    };

    $.fn.unblock_row = function (optss) {
        row = $(this)
        $('.cleanByBlock', row).each(function () {
            cell = $(this);
            $('div.holderByBlock', cell).unblock({
                onUnblock: function (cell, opts) {
                    this_cell = $(cell).parent('td, th');
                    $('.holderByBlock', this_cell).contents().unwrap();
                    // this_cell.html($('.holderByBlock', this_cell).html());
                    this_cell.removeAttr('style');
                    this_cell.removeClass('cleanByBlock');
                    if (optss.hasOwnProperty("onUnblock")) {
                        optss.onUnblock();
                    }
                }
            });
        })
    };

    $('.add-more-btn').click(function () {
        cloneRow();
    });

    $('table').on("click", "button.save-row", function () {
        console.log("munno");
        let blockElem = $(this).closest("tbody");
        saveRow(blockElem);
    });


    $('body').on("keydown", function (event) {

        console.log(event.which)
        if (event.which == 113) {
            cloneRow();
        }

        if (event.which == 115) {
            let block_ele = $(":focus").closest('tbody');
            saveRow(block_ele);
        }
        if (event.which == 118) {
            let block_ele = $(":focus").closest('tbody');
            saveRow(block_ele, {
                onSuccess: () => {
                    cloneRow();
                }
            });
        }


        // if (event.which == 40 && $(":focus").get(0).tagName == 'SELECT') {
        //     console.log(document.activeElement.size);
        //
        //     document.activeElement.size = document.activeElement.length*2;
        // }
        //
        // if (event.which == 13 && $(":focus").get(0).tagName == 'SELECT') {
        //     document.activeElement.size = document.activeElement.length;
        // }

    });

    // $('body').on("keypress", function (event) {
    //     console.log(event.which)
    // });

    function cloneRow() {
        // $(':focus')
        let clone = $('#ogRow').clone().removeAttr('id');
        clear_form_elements(clone);
        $('table tbody:last').after(clone.show());

        clone.find("input[type='text']")[0].focus();
    }

    function saveRow($rowElem, opts) {
        if ($rowElem.hasClass('table-danger'))
            $rowElem.removeClass('table-danger');

        $rowElem.find('tr.error-row').find("td.errors").html('');

        // Block Element
        $rowElem.block_row({
            message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
            timeout: 2000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#FFF',
                cursor: 'wait',
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        let $url = $('meta[name=enrol_student_url]').attr("content");
        let $token = $('meta[name=csrf_token]').attr("content");
        let $form = $($rowElem).find("select, textarea, input").serializeArray();

        $form.push({name: "_token", value: $token});
        console.log($form);

        $.post($url, $form, function (data, textStatus, jQxhr) {
            console.log(data);
            if (!data.error) {
                let $rec = data.record;
                $rowElem.html(
                    "<tr>" +
                    "<td>" + $rec.student_no + "</td>" +
                    "<td>" + $rec.title + "</td>" +
                    "<td>" + $rec.first_name + "</td>" +
                    "<td>" + $rec.last_name + "</td>" +
                    "<td>" + $rec.gender + "</td>" +
                    "<td>" + $rec.national_id + "</td>" +
                    "<td>" + $rec.date_of_birth + "</td>" +
                    '<td>' +
                    '<a href="' + data.offer_letter_link + '" target="_blank" class="btn btn-block btn-primary">' +
                    '<i class="la la-envelope"></i> View Offer Letter' +
                    '</a>' +
                    '</td>' +
                    "</tr>"
                );

                if (opts.hasOwnProperty("onSuccess")) {
                    opts.onSuccess();
                } else {
                    focusOnNextTBody($rowElem)
                }
            } else {
                $rowElem.addClass('table-danger')

                $.each(data.messages, function (key, values) {
                    let currInput = $rowElem.find(".form-control[name=" + key + "]");
                    currInput.addClass('border-danger');


                    values.forEach(function (item, index) {
                        $rowElem.find('tr.error-row').show().find("td.errors").append(
                            '<div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">\n' +
                            '                          <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>\n' +
                            '                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '                            <span aria-hidden="true">×</span>\n' +
                            '                          </button>\n' +
                            item +
                            '                        </div>')
                    });

                });
            }


        }).fail(function (jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
        }).always(function (data) {
            $rowElem.unblock_row({
                onUnblock: () => {
                    $rowElem.find(".form-control[name=" + Object.keys(data.messages)[0] + "]").focus();
                }
            })

        });


    }

    function focusOnNextTBody($rowElem) {
        let $trs = $($rowElem).closest('table').find('tbody').not("#ogRow");
        $.each($trs, function () {
            let item = $(this);
            let nextIn = item.find("input,select");
            if (nextIn.length > 0) {
                nextIn[0].focus();
                return false;
            }
            return true;
        })
    }

    function clear_form_elements(el) {
        $(el).find(':input').each(function () {
            switch (this.type) {
                case 'select-one':
                    $(this).prop('selectedIndex', 0)
                    break;
                case 'password':
                case 'text':
                case 'textarea':
                case 'file':

                case 'select-multiple':
                case 'date':
                case 'number':
                case 'tel':
                case 'email':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
            }
        });
    }

})(window, document, jQuery);