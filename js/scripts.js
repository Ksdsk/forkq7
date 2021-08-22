/*!
* Start Bootstrap - Agency v7.0.5 (https://startbootstrap.com/theme/agency)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-agency/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    window.onscroll = function() {scrollFunction()};


    function scrollFunction() {
        if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
          document.getElementById("gold-bar").style.height = "0.5rem";
          document.getElementById("en").style.display = "none";
          document.getElementById("fr").style.display = "none";
          document.getElementById("search").style.height = "20px";
          document.getElementById("search").style.width = "20px";

          document.getElementById("logo_img").style.width = "180px";

          
        } else {

          document.getElementById("gold-bar").style.height = "2rem";
          document.getElementById("en").style.display = "inline";
          document.getElementById("fr").style.display = "inline";
          document.getElementById("search").style.display = "inline";
          document.getElementById("logo_img").style.width = "240px";
          document.getElementById("search").style.height = "30px";
          document.getElementById("search").style.width = "30px";
        }
      }

    // Translation

    function translateLang(lang)
    {
        $('.lang').each(function(index, item) {
          $(this).text(arrLang[lang][$(this).attr('key')]);
        });
    }

    $(function() {
        //first check for stored language in localStorage i.e. fetch data from localStorage
        let stored_lang = localStorage.getItem("stored_lang");
        //if any then translate page accordingly
        if(stored_lang != null && stored_lang != undefined)
        {
            lang = stored_lang;
            translateLang(lang);
        }


      $('.translate').click(function() {
        var lang = $(this).attr('id');
         //on click store language to localStorage
        localStorage.setItem("stored_lang",lang);
        translateLang(lang);
      });

    });


});
