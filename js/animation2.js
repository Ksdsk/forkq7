
$(window).on('scroll', function() {

  var z_scroll_pos = window.pageYOffset;
  console.log(z_scroll_pos);
  var scroll_pos_test = 1200; 


  if(z_scroll_pos > scroll_pos_test) {

  $(".bullet").delay(800).each(function(i) {
    $(this).delay(100 * i).queue(function() {
      $(this).removeClass("bullet");
      $(this).addClass("show");
    })
  })
  
  $(".invis").delay(1200).each(function(i) {
      $(this).delay(100 * i).queue(function() {
        $(this).removeClass("invis");
        $(this).addClass("show");
      })
    })

  }

  });

  var b_list = ["initiation","initiation", "define the requirements", "begin collection of data","configuration","configuration", "design and construct", "verification", "training and deployment", "improvement and evaluation"];

  function changeLine(i) {
    var num = document.getElementById("number");
    num.innerHTML = i;

    var ul = document.getElementById("list2");

    var listItems = ul.getElementsByTagName("a");
    for (var j=0; j<listItems.length; j++) {
      listItems[j].style.color="black";
    }

    var line = document.getElementById(i).innerHTML;
    document.getElementById("inner").innerHTML = line.substring(3, line.length) ;
    document.getElementById("bottom-button").innerHTML = b_list[parseInt(i)-1];

    document.getElementById(i).style.color="#a39161";
    

  }
  
  