$(document).ready(function () {
    function clearErrorsAndValues(clone, sectionName) {
        clone.find("input, textarea, select").each(function () {
            $(this).val("");
            $(this).removeClass("outline-red-500");
        });

        // Remove error message elements
        clone.find("p.text-red-600").remove();

        // Update input IDs and labels (optional, for accessibility and avoiding ID duplication)
        clone.find("label").each(function (i) {
            let htmlFor = $(this).attr("for");
            if (htmlFor) {
                $(this).attr("for", htmlFor + "_new");
            }
        });

        clone.find("input, textarea, select").each(function () {
            let id = $(this).attr("id");
            if (id) {
                $(this).attr("id", id + "_new");
            }
        });

        return clone;
    }

    // Education
    $("#addEducationBtn").click(function () {
        let clone = $(".education_entry:first").clone();
        clearErrorsAndValues(clone, "education");
        $("#education_wrapper").append(clone);
    });

    $(document).on("click", ".remove-education", function () {
        if ($(".education_entry").length > 1) {
            $(this).closest(".education_entry").remove();
        }
    });

    // Experience
    $("#addExperienceBtn").click(function () {
        let clone = $(".experience_entry:first").clone();
        clearErrorsAndValues(clone, "experience");
        $("#experience_wrapper").append(clone);
    });

    $(document).on("click", ".remove-experience", function () {
        if ($(".experience_entry").length > 1) {
            $(this).closest(".experience_entry").remove();
        }
    });

    // Skill
    $("#addSkillBtn").click(function () {
        let clone = $(".skill_entry:first").clone();
        clearErrorsAndValues(clone, "skill");
        $("#skill_wrapper").append(clone);
    });

    $(document).on("click", ".remove-skill", function () {
        if ($(".skill_entry").length > 1) {
            $(this).closest(".skill_entry").remove();
        }
    });

    // Certification
    $("#addCertificationBtn").click(function () {
        let clone = $(".certification_entry:first").clone();
        clearErrorsAndValues(clone, "certification");
        $("#certification_wrapper").append(clone);
    });

    $(document).on("click", ".remove-certification", function () {
        if ($(".certification_entry").length > 1) {
            $(this).closest(".certification_entry").remove();
        }
    });
});
