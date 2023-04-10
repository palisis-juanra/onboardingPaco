function updateTour(tourData) {
    console.log(tourData);
    $.ajax({
        url: "http://localhost/mvc_project/api.php/updateTour", 
        method: "POST",
        data: tourData,
        success: function() {
            location.reload();
        }
    });
}

$(document).ready(function() {
    $("#update_tour").submit(function(e) {
        let tourData = $(this).serializeArray();
        updateTour(tourData);
        return false;
    });
});