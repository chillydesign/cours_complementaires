(function ($, root, undefined) {
  $(function () {
    "use strict";

    // SCHOOLIO STUFF

    var $course_form = $("#course_form");
    var $submit_course_form = $("#submit_course_form");
    var $course_id = $("#course_id");
    var $teacher_id = $("#teacher_id");
    var $agree_terms = $("#agree_terms");
    var $teacher_id_cont = $("#teacher_id_cont").hide();

    $("#student_of_cpmdt_check input").on("change", function () {
      var $this = $(this);
      if ($this.val() == "oui") {
        $(".student_group").addClass("group_visible");
        $(".group_not_for_student_of_cpmdt").removeClass("group_visible");
        $(".respondent_group").removeClass("group_visible");
        $(".student_address_group").removeClass("group_visible");
        $(".group_for_otherschools").removeClass("group_visible");
        $(".group_for_ondine").removeClass("group_visible");
      } else {
        $(".group_not_for_student_of_cpmdt").addClass("group_visible");
        $(".student_group").removeClass("group_visible");
      }
    });

    $("#student_of_other_check input").on("change", function () {
      var $this = $(this);
      if ($this.val() == "CMG" || $this.val() == "IJD") {
        $(".group_for_otherschools").addClass("group_visible");
      } else {
        $(".group_for_otherschools").removeClass("group_visible");
      }
    });

    $("#ondine_genevoise_check input").on("change", function () {
      var $this = $(this);
      if ($this.val() == "oui") {
        $(".group_for_ondine").addClass("group_visible");
      } else {
        $(".group_for_ondine").removeClass("group_visible");
      }
    });

    $("#proper_respondent_check input").on("change", function () {
      var $this = $(this);
      if ($this.val() == "oui") {
        $(".student_group").addClass("group_visible");
        $(".student_address_group").addClass("group_visible");
        $(".respondent_group").removeClass("group_visible");
      } else {
        $(".student_group").addClass("group_visible");
        $(".student_address_group").addClass("group_visible");
        $(".respondent_group").addClass("group_visible");
      }
    });

    $submit_course_form.addClass("inactive"); //.prop("disabled", true  );

    $course_id.on("change", function () {
      var $this = $(this);

      $.ajax({
        url: ajax_object.ajax_url,
        type: "post",
        data: {
          action: "my_action",
          course_id: $this.val(),
        },
        beforeSend: function () {
          $teacher_id_cont.html("");
        },
        success: function (data) {
          // disables form if no times are returned
          //	$submit_course_form.prop("disabled", data == ''  );
          var parsed_data = JSON.parse(data);
          var school = parsed_data.school;
          var horaires = parsed_data.horaires;

          $teacher_id_cont.html("").append(horaires).show();

          showSchoolSpecificFields(school);

          makeNiceSelectBoxes();
        },
      });
    });

    // if course id in url, automatically select that course
    setTimeout(function () {
      prefilCourse();
    }, 250);

    function prefilCourse() {
      var se = document.location.search;
      if (se != "") {
        var course_id_split = se.split("course_id=");

        if (course_id_split.length > 1) {
          var course_id = course_id_split[1].split("&")[0];

          if (course_id != "") {
            $(".nicer_option[data-val=" + course_id + "]").click();
          }
        }
      }
    }

    function showSchoolSpecificFields(school) {
      if (school === null) {
        $(".group_for_non_cpmdt_courses").hide();
        $(".group_for_cpmdt_courses").hide();
      } else if (school == "CPMDT") {
        $(".group_for_cpmdt_courses").show();
        $(".group_for_non_cpmdt_courses").hide();
      } else {
        $(".group_for_cpmdt_courses").hide();

        if (school == "CMG") {
          var shtml =
            '<p ><a target="_blank" href="http://www.cmg.ch/sites/default/files/cmusge/public/formulaire_inscription_musique_2017_2018.pdf" class="button">S’inscrire sur le site du CMG</a></p>';
          $(".group_for_non_cpmdt_courses").show().html(shtml);
        } else {
          var shtml =
            '<p ><a target="_blank" href="http://www.dalcroze.ch/inscription/" class="button">S’inscrire sur le site de l’IJD</a></p>';
          $(".group_for_non_cpmdt_courses").show().html(shtml);
        }
      }
    }

    function getBadFields() {
      $badfields = [];

      $(".group_visible").each(function () {
        var $group = $(this);

        var $radiolength = $("input[type='radio']", $group).length;
        if ($radiolength > 0) {
          // console.log( $radiolength , $("input:checked", $group ).length  );

          if ($("input:checked", $group).length == 0) {
            $badfields.push($(this));
          } else {
            $(this).removeClass("badfield");
          }
        } else {
          var $textfields = $(
            "input[type='text'], input[type='email']",
            $group
          );
          $textfields.each(function () {
            var $field = $(this);
            if ($field.val() == "") {
              $badfields.push($field);
            } else {
              $field.removeClass("badfield");
            }
          });

          // console.log( $agree_terms.is(':checked') == false   );

          if ($agree_terms.is(":checked") == false) {
            $badfields.push($agree_terms.parent()); // add the label
          } else {
            $agree_terms.parent().removeClass("badfield");
          }
        }
      });

      return $badfields;
    }

    var $badfields = getBadFields();

    $("input, select").on("change", function () {
      var $error = false;

      $badfields = getBadFields();

      if ($badfields.length > 0) {
        $error = true;
      }

      if ($course_id.val() == "0") {
        $error = true;
      }

      if (typeof $teacher_id.val() != "undefined") {
        if ($teacher_id.val().length < 1) {
          $error = true;
        }
      }

      if ($error == false) {
        $submit_course_form.removeClass("inactive").addClass("green_button"); //.prop("disabled", false  );;
        $("#stopsubmit").hide();
        $("p.fillitall").hide();
      } else {
        $submit_course_form.addClass("inactive").removeClass("green_button"); //.prop("disabled", true  );;
        $("p.fillitall").show();
        $("#stopsubmit").show();
      }
    });

    $("input#submit_course_form.inactive ").on("click", function (event) {
      $badfields = getBadFields();

      $("label, input, div, select, option").removeClass("badfield");

      for (var i = 0; i < $badfields.length; i++) {
        $badfields[i].addClass("badfield");
      }
    });

    makeNiceSelectBoxes();

    function makeNiceSelectBoxes() {
      var $field_for_select = $(".field_for_select");
      // NICER SELECT BOXES
      $("select", $field_for_select).each(function () {
        var $this = $(this);

        if ($this.hasClass("dont_show")) {
        } else {
          $this.addClass("dont_show");

          var $parent = $this.parent(); // .field

          $parent.append(
            '<div class="nicer_sel_container"><ul class="nicer_select_options"></ul><div class="nicer_currently_selected">...</div></div>'
          );
          var $nso = $(".nicer_select_options", $parent);

          var $options = $("option", $this);
          for (var i = 0; i < $options.length; i++) {
            var $option = $options[i];

            if ($option.selected) {
              $(".nicer_currently_selected", $parent).html($option.text);
            }

            // if ($option.value != '') {	}
            $nso.append(
              '<li class="nicer_option" data-val="' +
                $option.value +
                '">' +
                $option.text +
                "</li>"
            );
          }

          $("label, .nicer_currently_selected", $parent).on(
            "click",
            function (e) {
              $(".nicer_select_options").hide();
              $(".nicer_select_options", $parent).show();
            }
          );

          $(".nicer_option", $parent).on("click", function (e) {
            var $that = $(this);
            $this.val($that.data("val")).change();

            $(".nicer_select_options", $parent).hide();
            $(".nicer_currently_selected", $parent).html($that.html());
          });

          $this
            .on("focus", function (e) {
              $(".nicer_currently_selected", $parent).addClass("focussed");
            })
            .on("blur", function () {
              $(".nicer_currently_selected", $parent).removeClass("focussed");
            })
            .on("change", function (e) {
              $(".nicer_select_options", $parent).hide();
              $(".nicer_currently_selected", $parent).html(
                $this.find("option:selected").text()
              );
            });

          $(document).on("keydown", function (e) {
            if (e.keyCode == 27) {
              $(".nicer_select_options", $parent).hide();
            }
          });
        }
      });
    }
  });
})(jQuery, this);
