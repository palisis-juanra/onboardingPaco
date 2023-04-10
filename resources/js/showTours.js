async function getTours(tours) {

    let channelId = $('input[name="channels"]:checked').val();
    let x2js = new X2JS();

    $.ajax({
        url: "http://localhost/mvc_project/api.php/getAllTours?channelId="+channelId, 
        dataType: 'XML',
        async: true,
        success: function(data){
            let xmlText = data; // XML
            let jsonObj = x2js.xml2json(xmlText); // Convert XML to JSON
            toursFromChannel = jsonObj["response"]["tour"];

            console.log(toursFromChannel);

            for(let i = 0; i < toursFromChannel.length; i++) {

                let tour = toursFromChannel[i];
                let tour_id = tour["tour_id"];
                let channel_id = tour["channel_id"];
                let tour_name = tour["tour_name"];
                let shortdesc = tour["shortdesc"];
                let img_url = tour["image_url"];
                
                let card = $(`
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card" id="tour_${tour_id}">
                        <img src="${img_url}" alt="" height="250px" class="card-img-top">
                        <div class="card-body d-inline-flex flex-column pb-3" style="height: 300px;">
                            <div style="flex: 1 0 auto; height: 20%;">
                                <h5 class="card-title" style="overflow: hidden;
                                display: -webkit-box;
                                -webkit-box-orient: vertical;
                                -webkit-line-clamp: 2;">${tour_name}</h5>
                            </div>
                            <div style="flex: 3 0 auto; height: 55%;">
                                <p class="card-text" style="overflow: hidden;
                                display: -webkit-box;
                                -webkit-box-orient: vertical;
                                -webkit-line-clamp: 7;">${shortdesc}</p>
                            </div>
                            <div class="d-inline-flex flex-row align-items-end w-100 pb-1" style="flex: 1 0 auto; height: 25%;">
                                <a href="http://localhost/mvc_project/tour.php?tourId=${tour_id}&channelId=${channel_id}" class="btn btn-outline-success btn-sm">See More</a>
                                <a href="" class="btn btn-outline-danger btn-sm ml-1">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                `);

                tours.append(card);
            }
        }, 
        complete: function(){
            $('#loading-image').remove();
        }
    });
}

$(document).ready(function() {
    $("input[name='channels']").on("change", () => {
        const tours = $("#tours > .container > .row");
        tours.empty();
        tours.append(`
        <div id="loading-image">
            <div class="spinner-border text-dark" role="status">
                <span class="sr-only">Loading Tours. Please wait....</span>
            </div>
            <span>Loading Tours. Please wait...</span>
        </div>
        `);
        getTours(tours);
    });
});