/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "../css/app.scss";

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from "jquery";

require("bootstrap");
// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
import "../bootstrap-fileinput/js/fileinput.js";
$(function() {
  $("#exportform").submit(function(e) {
    e.preventDefault();
    // Export du fichier
  });
  $("#importform").submit(function(e) {
    e.preventDefault();
    // importanalyse
  });
  $(".favoriteform").submit(function(e) {
    e.preventDefault();
    $.post("/user/toggleFavorite/" + e.target.propertyid.value).done(function(
      $data
    ) {
      if ($data.startsWith("OK")) {
        var $button = $("#btn-favorite-" + $data.substr(3).trim());
        if ($button.hasClass("text-warning")) {
          $button.removeClass("text-warning");
          $button.addClass("text-dark");
        } else {
          $button.addClass("text-warning");
          $button.removeClass("text-dark");
        }
      }
    });
  });
  $(":file").fileinput({
    uploadAsync: false,
    maxFileCount: 1
  });
  $(":file").change(function(e) {
    if (e.target.baseURI == "http://agence-immo-lievin.fr/user/propose") {
      console.log(e.target);
    }
  });
  $(".custom-file-label").remove();
  $(".carousel-inner")
    .children()
    .first()
    .addClass("active");
  $("#carousel").carousel();
  $(".imagemini").hover(function(e) {
    $("#imagemain").attr("src", e.target.getAttribute("srcview"));
  });
});
