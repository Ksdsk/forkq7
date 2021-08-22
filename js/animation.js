
$(window).on('scroll', function() {

  var y_scroll_pos = window.pageYOffset;
  var scroll_pos_test = 650; 


  if(y_scroll_pos > scroll_pos_test) {

  $(".list_item").delay(500).each(function(i) {
    $(this).delay(75 * i).queue(function() {
      $(this).removeClass("list_item");
      $(this).addClass("show_item");
    })
  })

  $(".invis").delay(1500).each(function(i) {
    $(this).delay(75 * i).queue(function() {
      $(this).removeClass("invis");
      $(this).addClass("show");
    })
  })

  $(".line").delay(1800).each(function(i) {
    $(this).delay(25 * i).queue(function() {
      $(this).removeClass("line");
      $(this).addClass("show");
    })
  })

  $(".dot").delay(2200).each(function(i) {
    $(this).delay(200 * i).queue(function() {
      $(this).removeClass("box");
      $(this).addClass("show");
    })
  })

$(".line-bottom").delay(2200).each(function(i) {
    $(this).delay(200 * i).queue(function() {
      $(this).removeClass("line-bottom");
      $(this).addClass("show");
    })
  })

  $(".pe").delay(2200).each(function(i) {
    $(this).delay(200 * i).queue(function() {
      $(this).removeClass("pe");
      $(this).addClass("show");
    })
  })

  $(".bottom-box").delay(2800).each(function(i) {
    $(this).delay(200 * i).queue(function() {
      $(this).removeClass("box");
      $(this).addClass("show");
    })
  })

}
  
});

