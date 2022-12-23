$(document).ready(function() {
    var baseUrl = $('input[name="app_url"]').val();

    $("#current_pwd").keyup(function() {
        var current_pwd = $("#current_pwd").val();
        //    alert(current_pwd);
        $.ajax({
            type: "post",
            url: "/admin/check-current-pwd",
            data: { current_pwd: current_pwd },
            success: function(resp) {
                // alert(resp);
                if (resp == "false") {
                    $("#chkCurrentPwd").html(
                        "<font color=red>Current Password is Incorrect</font>"
                    );
                } else if (resp == "true") {
                    $("#chkCurrentPwd").html(
                        "<font color=green>Current Password is Correct</font>"
                    );
                }
            },
            error: function() {
                alert("Error");
            },
        });
    });

    //    Comfirmation of Delete
    $(".comfirmDelete").click(function() {
    // $("a").delegate(".comfirmDelete", "click", function(){

        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        // alert(record);
        // alert(recordid);
        Swal.fire({
            title: "Are you sure ?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.value) {
                window.location.href =
                baseUrl + "admin/delete-" + record + "/" + recordid;
            }
        });
    });

    // Update User Status
    $(".updateUserStatus").click(function() {

        var status = $(this).attr('data-status');
        var user_id = $(this).attr("user_id");
        console.log(status);
        // console.log(user_id);
        // alert(status);
        // alert(user_id);
        $.ajax({
            type: "post",
            url: baseUrl + "admin/update-user-status",
            data: { status: status, user_id: user_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#user-" + user_id)
                        .removeClass("badge badge-success")
                        .addClass("badge badge-danger");
                    $("#user-" + user_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#user-" + user_id)
                        .removeClass("badge badge-danger")
                        .addClass("badge badge-success");
                    $("#user-" + user_id).html("Active");
                }
                location.reload();
            },
            error: function() {
                alert("Error");
            },
        });
    });

    // Update CMS Status
    $(".updateCMSStatus").click(function() {

        var status = $(this).attr('data-status');
        var cms_id = $(this).attr("cms_id");
        // console.log(status);
        // console.log(cms_id);
        // alert(status);
        // alert(cms_id);
        $.ajax({
            type: "post",
            url: baseUrl + "admin/update-cms-status",
            data: { status: status, cms_id: cms_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#cms-" + cms_id)
                        .removeClass("badge badge-success")
                        .addClass("badge badge-danger");
                    $("#cms-" + cms_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#cms-" + cms_id)
                        .removeClass("badge badge-danger")
                        .addClass("badge badge-success");
                    $("#cms-" + cms_id).html("Active");
                }
                location.reload();
            },
            error: function() {
                alert("Error");
            },
        });
    });

    // Update FAQ Status
    $(".updateFaqStatus").click(function() {

        var status = $(this).attr('data-status');
        var faq_id = $(this).attr("faq_id");
        console.log(status);
        // console.log(faq_id);
        // alert(status);
        // alert(faq_id);
        $.ajax({
            type: "post",
            url: baseUrl + "admin/update-faq-status",
            data: { status: status, faq_id: faq_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#faq-" + faq_id)
                        .removeClass("badge badge-success")
                        .addClass("badge badge-danger");
                    $("#faq-" + faq_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#faq-" + faq_id)
                        .removeClass("badge badge-danger")
                        .addClass("badge badge-success");
                    $("#faq-" + faq_id).html("Active");
                }
                location.reload();
            },
            error: function() {
                alert("Error");
            },
        });
    });

    // Update Api Response Status
    $(".updateApiResponseStatus").click(function() {

        var status = $(this).attr('data-status');
        var apiResponse_id = $(this).attr("apiResponse_id");
        console.log(status);
        // console.log(apiResponse_id);
        // alert(status);
        // alert(apiResponse_id);
        $.ajax({
            type: "post",
            url: baseUrl + "admin/update-api-response-status",
            data: { status: status, apiResponse_id: apiResponse_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#apiResponse-" + apiResponse_id)
                        .removeClass("badge badge-success")
                        .addClass("badge badge-danger");
                    $("#apiResponse-" + apiResponse_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#apiResponse-" + apiResponse_id)
                        .removeClass("badge badge-danger")
                        .addClass("badge badge-success");
                    $("#apiResponse-" + apiResponse_id).html("Active");
                }
                location.reload();
            },
            error: function() {
                alert("Error");
            },
        });
    });

    // Update Blog Status
    $(".updateBlogStatus").click(function() {

        var status = $(this).attr('data-status');
        var blog_id = $(this).attr("blog_id");
        console.log(status);
        // console.log(blog_id);
        // alert(status);
        // alert(blog_id);
        $.ajax({
            type: "post",
            url: baseUrl + "admin/update-blog-status",
            data: { status: status, blog_id: blog_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#blog-" + blog_id)
                        .removeClass("badge badge-success")
                        .addClass("badge badge-danger");
                    $("#blog-" + blog_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#blog-" + blog_id)
                        .removeClass("badge badge-danger")
                        .addClass("badge badge-success");
                    $("#blog-" + blog_id).html("Active");
                }
                location.reload();
            },
            error: function() {
                alert("Error");
            },
        });
    });

    // Update App Feedback Status
    $(".updateAppFeedbackStatus").click(function() {

        var status = $(this).attr('data-status');
        var feedback_id = $(this).attr("feedback_id");
        console.log(status);
        // console.log(feedback_id);
        // alert(status);
        // alert(feedback_id);
        $.ajax({
            type: "post",
            url: baseUrl + "admin/update-app-feedback-status",
            data: { status: status, feedback_id: feedback_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#feedback-" + feedback_id)
                        .removeClass("badge badge-success")
                        .addClass("badge badge-danger");
                    $("#feedback-" + feedback_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#feedback-" + feedback_id)
                        .removeClass("badge badge-danger")
                        .addClass("badge badge-success");
                    $("#feedback-" + feedback_id).html("Active");
                }
                location.reload();
            },
            error: function() {
                alert("Error");
            },
        });
    });

    // Update Main Category Status
    $(".updateMainCategoryStatus").click(function() {

        var status = $(this).attr('data-status');
        var mainCategory_id = $(this).attr("mainCategory_id");
        console.log(status);
        // console.log(mainCategory_id);
        // alert(status);
        // alert(mainCategory_id);
        $.ajax({
            type: "post",
            url: baseUrl + "admin/update-main-category-status",
            data: { status: status, mainCategory_id: mainCategory_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#mainCategory-" + mainCategory_id)
                        .removeClass("badge badge-success")
                        .addClass("badge badge-danger");
                    $("#mainCategory-" + mainCategory_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#mainCategory-" + mainCategory_id)
                        .removeClass("badge badge-danger")
                        .addClass("badge badge-success");
                    $("#mainCategory-" + mainCategory_id).html("Active");
                }
                location.reload();
            },
            error: function() {
                alert("Error");
            },
        });
    });

    // Update Ticket Status
    $(".updateTicketStatus").click(function() {

        var status = $(this).attr('data-status');
        var ticket_id = $(this).attr("ticket_id");
        console.log(status);
        // console.log(ticket_id);
        // alert(status);
        // alert(ticket_id);
        $.ajax({
            type: "post",
            url: baseUrl + "admin/update-ticket-status",
            data: { status: status, ticket_id: ticket_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#ticket-" + ticket_id)
                        .removeClass("badge badge-success")
                        .addClass("badge badge-danger");
                    $("#ticket-" + ticket_id).html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#ticket-" + ticket_id)
                        .removeClass("badge badge-danger")
                        .addClass("badge badge-success");
                    $("#ticket-" + ticket_id).html("Active");
                }
                location.reload();
            },
            error: function() {
                alert("Error");
            },
        });
    });
    
});
