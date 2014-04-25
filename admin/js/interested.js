$('.parent_info').click(function() {
    $(this).next().slideToggle('slow'); 
    $(this).toggleClass('toggled', 500);
    $(this).children('.fa').toggleClass('fa-chevron-right fa-chevron-down', 500);
});
for ( var i = 1; i < 3; i++) { 
    var largest = 0; 
    $('.parent_info:not(.collapse) p:nth-child(' + i + ')').each(function(idx, e) { largest = largest < $(e).outerWidth() ? $(e).outerWidth() : largest; });
    $('.parent_info:not(.collapse) p:nth-child(' + i + ')').each(function(idx, e) { $(e).css('width', largest); });
}
$('.collapse').css('width', 'auto');