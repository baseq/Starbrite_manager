/* Welcome to Agile Toolkit JS framework. This file implements checkboxes / selectable on Grid. */
$.widget("ui.atk4_checkboxes", {
    _init: function(options) {
        var chb = this;
        var ivalue = $(this.options.dst_field).val();

        try {
            if ($.parseJSON) {
                ivalue = $.parseJSON(ivalue);
                if (!ivalue)
                    ivalue = [];
            } else {
                ivalue = eval('(' + ivalue + ')')
            }
        } catch (err) {
            ivalue = [];
        }
        $.each(ivalue, function(k, v) {
            ivalue[k] = String(v);
        });


        this.element.find('tbody').selectable({filter: 'tr', stop: function() {
            chb.stop.apply(chb, [this])
        }}).css({cursor: 'crosshair'});
        this.element.find('input[type=checkbox]')
            .each(function() {
                var o = $(this);
                if ($.inArray(o.val(), ivalue) > -1) {
                    o.attr('checked', true);
                    $(this).closest('tr').addClass('ui-selected');
                }
            })
            .change(function() {
                var tr = $(this).closest('tr');
                var pr = 0;
                if ($(this).attr('checked')) {
                    tr.addClass('ui-selected');
                    pr = 1;
                } else {
                    tr.removeClass('ui-selected');
                    pr = 2;
                }
                chb.recalc(tr.attr('data-id'), pr);
            });
    },
    stop: function(c) {
        $(c).children('.ui-selected').find('input').attr('checked', true);
        $(c).children().not('.ui-selected').find('input').removeAttr('checked', true);
        this.recalc();
    },
    select_all: function() {
        this.element.find('tbody tr').not('.ui-selected')
            .addClass('ui-selected')
            .find('input[type="checkbox"]').attr('checked', true);
        this.recalc();
    },
    unselect_all: function() {
        this.element.find('tbody tr.ui-selected')
            .removeClass('ui-selected')
            .find('input[type="checkbox"]').removeAttr('checked');
        this.recalc();
    },
    recalc: function(valIn, prIn) {
        var t = $(this.options.dst_field).val();
        try {
            t = JSON.parse(t);
            if (!t)
                t = [];

        } catch (err) {
            t = [];
        }
        t = unique(t);
        if (prIn == 2 && t.indexOf(valIn) > -1) {
            t.splice(t.indexOf(valIn), 1);
        }
        var r = unique(t.slice(0));
        this.element.find('input:checked').each(function() {
            r.push($(this).val());
            r = unique(r);
        });
        if (this.options.dst_field) {
            $(this.options.dst_field).val($.univ.toJSON(r)).trigger('autochange_manual');
        }
    }

});
function unique(arr) {
    var obj = {};
    for (var i = 0; i < arr.length; i++) {
        var str = arr[i];
        obj[str] = true;
    }
    return Object.keys(obj);
}
