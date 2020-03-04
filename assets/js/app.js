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
require("webpack-jquery-ui/datepicker");
// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
import "../bootstrap-fileinput/js/fileinput.js";
// import "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js";

$(function() {
  // console.log('datepicker start');
  // $('#property_export_minDate').datepicker();
  // $('#property_export_maxDate').datepicker();
  // console.log('datepicker end');
  $("#importform").submit(function(e) {
    e.preventDefault();
    // importanalyse
  });
  // Case : Favorite
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
  // Case : Preview File Image
  $("#admin_properties_image1").fileinput({
    uploadAsync: false,
    maxFileCount: 1,
    showUpload: false,
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: "image", // image is the default and can be overridden in config below
    initialPreview: [$("#image1").attr("src")]
  });
  $("#admin_properties_image2").fileinput({
    uploadAsync: false,
    maxFileCount: 1,
    showUpload: false,
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: "image", // image is the default and can be overridden in config below
    initialPreview: [$("#image2").attr("src")]
  });
  $("#admin_properties_image3").fileinput({
    uploadAsync: false,
    maxFileCount: 1,
    showUpload: false,
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: "image", // image is the default and can be overridden in config below
    initialPreview: [$("#image3").attr("src")]
  });
  $("#properties_image1").fileinput({
    uploadAsync: false,
    maxFileCount: 1,
    showUpload: false,
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: "image", // image is the default and can be overridden in config below
    initialPreview: [$("#image1").attr("src")]
  });
  $("#properties_image2").fileinput({
    uploadAsync: false,
    maxFileCount: 1,
    showUpload: false,
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: "image", // image is the default and can be overridden in config below
    initialPreview: [$("#image2").attr("src")]
  });
  $("#properties_image3").fileinput({
    uploadAsync: false,
    maxFileCount: 1,
    showUpload: false,
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: "image", // image is the default and can be overridden in config below
    initialPreview: [$("#image3").attr("src")]
  });
  $(":file").change(function(e) {
    if (e.target.baseURI == "http://agence-immo-lievin.fr/user/propose") {
      console.log(e.target);
    }
  });
  $(".custom-file-label").remove();
  // View : Home
  $(".carousel-inner")
    .children()
    .first()
    .addClass("active");
  $("#carousel").carousel();
  // View : PropertyView
  $(".imagemini").hover(function(e) {
    $("#imagemain").attr("src", e.target.getAttribute("srcview"));
  });
});
