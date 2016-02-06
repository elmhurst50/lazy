$(document).ready(function () {
    //load the images in the most basic way
    $('[data-lazy-image]').each(function () {
        $(this).attr('src', $(this).attr('data-lazy-image'));
    });

    //load custom images based on response from server
    $('[data-lazy-file]').each(function () {
        var ele = $(this);

        var data = {
            document_width:document.documentElement.clientWidth,
            document_height: document.documentElement.clientHeight,
            element_width: ele.width(),
            element_height: ele.height(),
            image_file: ele.attr('data-lazy-file')
        }

        $.ajax({
            method: "GET",
            url: '/ajax-lazy-image',
            data: { data: data},
            dataType: 'json'
        })
            .success(function (response) {
                console.log('Location response success');
                ele.attr('src', response.image);
            })
            .error(function () {
                console.log('error has occurred');
            });
    });

});

