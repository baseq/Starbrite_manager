$.fn.gridMasterDetails = function(trigger){
    var t = $(this);
    var did = t.attr("data-id"); 

    if(trigger == true && did != null && did!=undefined)
        t.trigger('gridClick', [did]);

    var parent = t.parent();
    var children = parent.children();
    children.each(function(){
        children.removeClass('template-master-details-grid-active');
    })
    
    t.addClass('template-master-details-grid-active');
};
$('button').bind('click', function(event){
    event.stopPropagation();
});