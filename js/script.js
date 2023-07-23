$("a.delete").on("click", function(e) {
    e.preventDefault()
    if (confirm("Are you sure?")) {
        const frm = $("<form>");
        frm.attr('method','post');
        frm.attr('action', $(this).attr("href"));
        frm.appendTo("body");
        frm.submit();
    }
});

$.validator.addMethod("dateTime", function(value){
    return (value =="") || !isNaN(Date.parse(value));
}, "Must be a valid date and time");

$("#formArticle").validate({
    rules:{
        title:{
            required: true
        },
        content:{
            required: true
        },
        published_at: {
            dateTime: true
        }
    }
});

$("button.publish").on("click", function(e){
    const id = $(this).data('id');
    const button = $(this);
    $.ajax({
        type: "POST",
        url: "/admin/publish-article.php",
        data: {id : id},
    })
    .done(function(data){
        button.parent().html(data);
    })
});
