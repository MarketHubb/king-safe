/* jQuery (Footer) */
(function($) {

    function getHeroForModal(heading, description, image)
    {
        $.ajax({
            type:"POST",
            url: "/wp-admin/admin-ajax.php",
            data: {
                action: "get_hero_for_modal",
                heading: heading,
                description: description,
                image: image
            },
            success:function(data){
                $('.modal').find('#modal-hero').html(data);
            },
            complete:function(){

            }
        });
    }

    $('#service-modal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let image = button.data('image') // Extract info from data-* attributes
        let heading = 'Commercial & Residential Locksmiths';
        let description = 'Fully license & bonded with same-day service in Houston & all surrounding communities';
        let hero = getHeroForModal(heading, description, image);

        let modal = $(this)
        modal.find('#modal-hero').html(hero);
    })

})( jQuery );