//All booking filter
$(document).ready(function () {
    let supplierBookingRequest = null;
    let bookingFilterTimer = null;

    function showSupplierBookingLoader() {
        $('#supplierBookingAjaxLoader')
            .css('display', 'flex');

    }

    function hideSupplierBookingLoader() {
        $('#supplierBookingAjaxLoader')
            .hide();
    }

    function loadSupplierBookings() {
        if (supplierBookingRequest) {
            supplierBookingRequest.abort();
        }
        showSupplierBookingLoader();
        supplierBookingRequest = $.ajax({
            url: window.location.pathname,
            type: 'GET',
            data: {
                booking_id:
                    $('#bookingId').val(),
                start_date:
                    $('#startDate').val(),
                end_date:
                    $('#endDate').val(),
                booking_type:
                    $('#bookingType').val(),
                booking_status:
                    $('#bookingStatus').val(),
                booking_source: 
                $('#bookingSource').val(),
                search:
                    $('#bookingSearch').val()
            },
            success: function (response) {
                let html =
                    $('<div>').html(response);
                let bookingContent =
                    html.find(
                        '.booking-list-card'
                    ).html();
                if (bookingContent !== undefined) {

                    $('.booking-list-card')
                        .html(bookingContent);
                }
            },
            error: function (xhr, status) {
                if (status !== 'abort') {
                    console.log(
                        xhr.responseText
                    );
                }
            },
            complete: function () {
                supplierBookingRequest = null;
                hideSupplierBookingLoader();
            }
        });
    }
    $(document)
    .off(
        'keyup.supplierBooking',
        '#bookingId'
    )
    .on(
        'keyup.supplierBooking',
        '#bookingId',
        function () {

            clearTimeout(
                bookingFilterTimer
            );
            bookingFilterTimer =
                setTimeout(function () {

                    loadSupplierBookings();

                }, 400);
        }
    );
    $(document)
    .off(
        'keyup.supplierBooking',
        '#bookingSearch'
    )
    .on(
        'keyup.supplierBooking',
        '#bookingSearch',
        function () {

            clearTimeout(
                bookingFilterTimer
            );
            bookingFilterTimer =
                setTimeout(function () {

                    loadSupplierBookings();

                }, 400);

        }
    );
    $(document)
    .off(
        'change.supplierBooking',
        '#startDate, #endDate, #bookingType, #bookingStatus, #bookingSource'
    )
    .on(
        'change.supplierBooking',
        '#startDate, #endDate, #bookingType, #bookingStatus, #bookingSource',
        function () {

            loadSupplierBookings();

        }
    );
    $(document)
    .off(
        'click.supplierBooking',
        '#resetBookingFilter'
    )
    .on(
        'click.supplierBooking',
        '#resetBookingFilter',
        function (e) {
            e.preventDefault();
            $('#bookingId').val('');
            $('#startDate').val('');
            $('#endDate').val('');
            $('#bookingType').val('');
            $('#bookingStatus').val('');
            $('#bookingSource').val('');
            $('#bookingSearch').val('');
            loadSupplierBookings();
        }
    );
});
//Tour list filter
$(document).ready(function () {
    let tourRequest = null;
    let tourFilterTimer = null;

    function loadTours(page = 1, showLoader = false) {
        if (tourRequest) {
            tourRequest.abort();
        }
        const $form = $('#tourFilterForm');
        if (!$form.length) return;
        const filters = {
            location: $('#tourLocation').val(),
            status: $('#tourStatus').val(),
            approval: $('#approvalStatus').val(),
            product_id: $('#tourProductId').val(),
            tour_name: $('#tourName').val()
        };
        const data = $form.serializeArray().filter(
            item => !['page', 'per_page'].includes(item.name)
        );
        data.push(
            { name: 'page', value: page },
            {
                name: 'per_page',
                value: new URLSearchParams(location.search).get('per_page') || 10
            }
        );
        if (showLoader) {
            $('#tourListAjaxLoader').css('display', 'flex');
        }
        const request = $.ajax({
            url: $form.attr('action') || location.pathname,
            type: 'GET',
            data: $.param(data),
            dataType: 'html',
            success: function (response) {
                const $html = $('<div>').append(
                    $.parseHTML(response)
                );
                const $list = $html.find('.tl-list-card').first();
                if (!$list.length) return;
                $('.tl-list-card').first().replaceWith($list);

                const url = new URL(location.href);
                url.search = '';
                if (page > 1) {
                    Object.entries(filters).forEach(([key, value]) => {
                        if (value !== '' && value !== null) {
                            url.searchParams.set(key, value);
                        }
                    });
                    url.searchParams.set('page', page);
                }
                history.pushState(
                    {},
                    '',
                    url.pathname + url.search + url.hash
                );
            },
            error: function (xhr, status) {
                if (status !== 'abort') {
                    console.error(
                        'Tour filter error:',
                        xhr.responseText
                    );
                }
            },
            complete: function () {
                if (tourRequest === request) {
                    tourRequest = null;
                    if (showLoader) {
                        $('#tourListAjaxLoader').hide();
                    }
                }
            }
        });
        tourRequest = request;
    }
    //Dropdown filters
    $(document)
        .off('.tourFilter')

        .on(
            'change.tourFilter',
            '#tourLocation, #tourStatus, #approvalStatus',
            function () {
                loadTours(1, true);
            }
        )
        .on(
            'input.tourFilter',
            '#tourProductId, #tourName',
            function () {
                clearTimeout(tourFilterTimer);

                tourFilterTimer = setTimeout(function () {
                    loadTours(1, true);
                }, 400);
            }
        )
        .on(
            'submit.tourFilter',
            '#tourFilterForm',
            function (e) {
                e.preventDefault();

                clearTimeout(tourFilterTimer);
                loadTours(1, true);
            }
        )
        .on(
            'click.tourFilter',
            '#resetTourFilter',
            function (e) {
                e.preventDefault();

                clearTimeout(tourFilterTimer);

                $('#tourFilterForm')[0]?.reset();

                loadTours(1, false);
            }
        )
        .on(
            'click.tourFilter',
            '.tl-list-card [data-tour-page]',
            function (e) {
                e.preventDefault();

                if (
                    $(this).is(':disabled') ||
                    $(this).hasClass('disabled')
                ) {
                    return;
                }
                const page = parseInt(
                    $(this).attr('data-tour-page'),
                    10
                );

                if (Number.isInteger(page) && page > 0) {
                    loadTours(page, false);
                }
            }
        );
    window.addEventListener('popstate', function () {
        const url = new URL(location.href);
        $('#tourLocation').val(
            url.searchParams.get('location') || ''
        );
        $('#tourStatus').val(
            url.searchParams.get('status') || ''
        );
        $('#approvalStatus').val(
            url.searchParams.get('approval') || ''
        );
        $('#tourProductId').val(
            url.searchParams.get('product_id') || ''
        );
        $('#tourName').val(
            url.searchParams.get('tour_name') || ''
        );
        loadTours(
            parseInt(url.searchParams.get('page') || 1, 10),
            false
        );
    });
});