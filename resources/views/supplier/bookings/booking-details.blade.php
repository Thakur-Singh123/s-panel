@extends('supplier.layouts.master')
@section('content')
@php
    //BOOKING TYPE
    $type = strtolower(
        trim($order->type ?? 'tour')
    );
    if ($type === 'transfer') {
        $typeLabel = 'Transfer';
        $typeIcon = 'fa-car-side';
        $typeClass = 'transfer-tag';
    } elseif ($type === 'package') {
        $typeLabel = 'Package';
        $typeIcon = 'fa-box';
        $typeClass = 'package-tag';
    } elseif ($type === 'hotel') {
        $typeLabel = 'Hotel';
        $typeIcon = 'fa-hotel';
        $typeClass = 'hotel-tag';
    } elseif ($type === 'ferry') {
        $typeLabel = 'Ferry';
        $typeIcon = 'fa-ship';
        $typeClass = 'ferry-tag';
    } elseif ($type === 'wedding') {
        $typeLabel = 'Wedding';
        $typeIcon = 'fa-ring';
        $typeClass = 'wedding-tag';
    } else {
        $typeLabel = ucfirst($type);
        $typeIcon = 'fa-map-location-dot';
        $typeClass = 'tour-tag';
    }

    //BOOKING ID
    $bookingId =
        'SLW' .
        str_pad(
            $order->id,
            7,
            '0',
            STR_PAD_LEFT
        );
    // GUEST
    $guestName = trim(
        ($order->first_name ?? '') . ' ' .
        ($order->last_name ?? '')
    );
    if (empty($guestName)) {
        $guestName = 'Guest';
    }
    //GUEST INITIALS
    $guestInitials = '';
    if (!empty($order->first_name)) {
        $guestInitials .= strtoupper(
            substr(
                $order->first_name,
                0,
                1
            )
        );
    }
    if (!empty($order->last_name)) {
        $guestInitials .= strtoupper(
            substr(
                $order->last_name,
                0,
                1
            )
        );
    }
    if (empty($guestInitials)) {
        $guestInitials = 'NA';
    }
    //PAX
    $adult = (int) ($order->qty_adult ?? 0);
    $child = (int) ($order->qty_child ?? 0);
    $totalMember = $adult + $child;
    //CURRENCY / AMOUNT
    $currency = $order->currency ?: 'THB';
    $amount = number_format(
        (float) ($order->total_amount ?? 0),
        2
    );
    //TRAVEL DATE
    $travelDate = '-';
    if (!empty($order->start_date)) {
        try {
            $travelDate = \Carbon\Carbon::parse(
                $order->start_date
            )->format('d M Y');
        } catch (\Exception $e) {

            $travelDate = $order->start_date;
        }
    }
    //BOOKING DATE
    $bookingDate = '-';
    if (!empty($order->date)) {
        try {
            $bookingDate = \Carbon\Carbon::parse(
                $order->date
            )->format('d M Y, H:i:s');
        } catch (\Exception $e) {
            $bookingDate = $order->date;
        }
    }
    //TIME
    $pickupTime =
        $order->pickup_time
        ?: $order->flight_time
        ?: $order->TransferTime
        ?: '-';
    //STATUS
    $status = $order->status ?: 'Pending';
    $statusText = ucfirst(
        str_replace(
            ['_', '-'],
            ' ',
            strtolower($status)
        )
    );
    //PAYMENT STATUS
    $paymentStatus =
        $order->payment_status
        ?: $order->status
        ?: 'Pending';
    $paymentStatusText = ucfirst(
        str_replace(
            ['_', '-'],
            ' ',
            strtolower($paymentStatus)
        )
    );
    //BOOKING MADE BY
    $bookingMadeBy =
        $order->manually_booking_made_by
        ?: 'Manual';
    //SOURCE
    $source =
        $order->source
        ?: 'N/A';
    //SUPPLIER
    $supplierName =
        $order->supplier_name
        ?: 'N/A';
    //CONTACT
    $contactPhone =
        trim(
            ($order->phone_country_code ?? '') . ' ' .
            ($order->phone ?? '')
        );
    if (empty(trim($contactPhone))) {
        $contactPhone =
            $order->ContactPhone
            ?: '-';
    }
    //HOTEL
    $hotelName =
        $order->HotelName
        ?: '-';
    //PICKUP DETAILS
    $pickupDetails =
        $order->TransferFromAddress
        ?: $order->from
        ?: '-';
    //FLIGHT
    $flightNo =
        $order->flight_no
        ?: $order->departure_flight_no
        ?: '-';
    //FROM
    $transferFrom =
        $order->TransferFrom
        ?: $order->from
        ?: '-';
    //TO
    $transferTo =
        $order->to
        ?: $order->HotelNameTo
        ?: '-';
    //TRANSFER TYPE
    $transferType =
        $order->meal_transfer_type
        ?: 'Private Transfer';
    //VEHICLE
    $vehicle =
        $order->TransferPax
        ?: '-';
    //DROPPED ADDRESS
    $droppedAddress =
        $order->to
        ?: $order->HotelNameTo
        ?: '-';
    //MEETING POINT
    $meetingPoint =
        $order->HotelNameFrom
        ?: 'Hotel Lobby';
    //OTHER INFORMATION
    $otherInfo =
        $order->remark
        ?: $order->supplier_remark
        ?: '-';
    //PAYMENT MODE
    $paymentMode =
        $order->payment_mode
        ?: '-';
    //LAST UPDATED
    $lastUpdated = $bookingDate;
@endphp
<div class="app-layout">
   <main class="main-content">
      <!-- PAGE HEADER -->
      <div class="booking-detail-page-head">
         <div>
            <span class="booking-detail-eyebrow"> BOOKING MANAGEMENT </span>
            <h1>Booking Details</h1>
            <p>View complete booking, guest, service and payment information.</p>
         </div>
         <div class="booking-top-actions">
            <button class="bd-btn bd-btn-light">
               <i class="fa-solid fa-print"></i>
               Print Invoice
            </button>
            <button class="bd-btn bd-btn-danger">
               <i class="fa-solid fa-ban"></i>
               Cancel Booking
            </button>
            <button class="bd-btn bd-btn-light">
               <i class="fa-solid fa-share"></i>
               Forward Booking
            </button>
            <button class="bd-btn bd-btn-primary">
               <i class="fa-solid fa-pen"></i>
               Amend / Edit
            </button>
         </div>
      </div>
      <!--INTERNAL NOTE-->
      {{--
      <div class="booking-internal-note">
         <div class="internal-note-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
         </div>
         <div>
            <strong>Internal Use Only</strong>
            <p>This voucher is for internal use only and should not be shared with the guide or driver.</p>
         </div>
      </div>
      --}}
      <!-- MAIN BOOKING SUMMARY -->
      <section class="booking-summary-card">
         <div class="summary-top">
            <div class="summary-left">
               <span class="summary-label"> BOOKING </span>
               <h2>{{ $order->item_name ?: 'Booking' }}</h2>
               <div class="summary-tags">
                  <span class="summary-tag {{ $typeClass }}">
                     <i class="fa-solid {{ $typeIcon }}"></i>
                     {{ $typeLabel }}
                  </span>
                  <span class="summary-tag confirmed-tag">
                     <i class="fa-solid fa-circle-check"></i>
                     {{ $statusText }}
                  </span>
               </div>
            </div>
            <div class="booking-reference-box">
               <span>BOOKING ID</span>
               <strong> {{ $bookingId }} </strong>

               <small> Order #{{ $order->id }} </small>
            </div>
         </div>
         <!-- SUMMARY STATS -->
         <div class="booking-summary-grid">
            <div class="summary-stat">
               <div class="summary-stat-icon">
                  <i class="fa-regular fa-calendar"></i>
               </div>
               <div>
                  <span>TRAVEL DATE</span>
                  <strong> {{ $travelDate }} </strong>
               </div>
            </div>
            <div class="summary-stat">
               <div class="summary-stat-icon">
                  <i class="fa-regular fa-clock"></i>
               </div>
               <div>
                  <span> {{ $type === 'transfer' ? 'PICKUP TIME' : 'TIME' }} </span>

                  <strong> {{ $pickupTime }} </strong>
               </div>
            </div>

            <div class="summary-stat">
               <div class="summary-stat-icon">
                  <i class="fa-solid fa-users"></i>
               </div>

               <div>
                  <span>PAX</span>

                  <strong> {{ $adult }} Adult / {{ $child }} Child </strong>
               </div>
            </div>

            <div class="summary-stat">
               <div class="summary-stat-icon">
                  <i class="fa-solid fa-wallet"></i>
               </div>

               <div>
                  <span>BOOKING AMOUNT</span>

                  <strong> {{ $currency }} {{ $amount }} </strong>
               </div>
            </div>
         </div>
      </section>

      <!-- TWO COLUMN -->
      <div class="booking-detail-grid">
         <!-- LEFT -->
         <div class="booking-detail-left">
            <!-- GUEST -->
            <section class="booking-section-card">
               <div class="booking-section-head">
                  <div class="section-title-icon">
                     <i class="fa-solid fa-user"></i>
                  </div>

                  <div>
                     <h3>Guest Information</h3>

                     <p>Lead guest and contact information.</p>
                  </div>
               </div>

               <div class="guest-profile-row">
                  <div class="guest-avatar">{{ $guestInitials }}</div>

                  <div class="guest-main-info">
                     <span>LEAD GUEST</span>

                     <h4>{{ $guestName }}</h4>

                     <div class="guest-contact">
                        <span>
                           <i class="fa-solid fa-phone"></i>

                           {{ $contactPhone }}
                        </span>

                        <span>
                           <i class="fa-solid fa-envelope"></i>

                           {{ $order->email ?: '-' }}
                        </span>
                     </div>
                  </div>
               </div>

               <div class="detail-list">
                  <div class="detail-row">
                     <span>Hotel</span>

                     <strong> {{ $hotelName }} </strong>
                  </div>

                  <div class="detail-row">
                     <span>Pickup Details</span>

                     <strong> {{ $pickupDetails }} </strong>
                  </div>

                  <div class="detail-row">
                     <span>Contact Phone</span>

                     <strong> {{ $contactPhone }} </strong>
                  </div>
               </div>
            </section>

            <!-- PICKUP / OPERATION -->
            <section class="booking-section-card">
               <div class="booking-section-head">
                  <div class="section-title-icon orange-icon">
                     <i class="fa-solid fa-location-dot"></i>
                  </div>

                  <div>
                     <h3>Pickup & Operational Details</h3>

                     <p>Driver, pickup and meeting point information.</p>
                  </div>
               </div>

               <div class="detail-list">
                  <div class="detail-row">
                     <span>Booking Made By</span>

                     <strong> {{ $bookingMadeBy }} </strong>
                  </div>

                  <div class="detail-row">
                     <span>Flight No.</span>

                     <strong> {{ $flightNo }} </strong>
                  </div>

                  <div class="detail-row">
                     <span>Pick Up Point</span>

                     <strong> {{ $transferFrom }} </strong>
                  </div>

                  <div class="detail-row">
                     <span>Dropped Address</span>

                     <strong> {{ $droppedAddress }} </strong>
                  </div>

                  <div class="detail-row">
                     <span>Meeting Point</span>

                     <strong> {{ $meetingPoint }} </strong>
                  </div>

                  <div class="detail-row">
                     <span>Other Info</span>

                     <strong> {{ $otherInfo }} </strong>
                  </div>
               </div>
            </section>
         </div>

         <!-- RIGHT -->
         <div class="booking-detail-right">
            <!-- SERVICE -->
            <section class="booking-section-card">
               <div class="booking-section-head">
                  <div class="section-title-icon blue-icon">
                     <i class="fa-solid {{ $typeIcon }}"></i>
                  </div>

                  <div>
                     <h3>{{ $typeLabel }} Details</h3>

                     <p>Service and route information.</p>
                  </div>
               </div>

               <div class="service-title">{{ $order->item_name ?: 'N/A' }}</div>

               <div class="route-box">
                  <div class="route-point">
                     <div class="route-dot start"></div>

                     <div>
                        <span>FROM</span>

                        <strong> {{ $transferFrom }} </strong>
                     </div>
                  </div>

                  <div class="route-line"></div>

                  <div class="route-point">
                     <div class="route-dot end"></div>

                     <div>
                        <span>TO</span>

                        <strong> {{ $transferTo }} </strong>
                     </div>
                  </div>
               </div>

               <div class="detail-list">
                  <div class="detail-row">
                     <span> {{ $type === 'transfer' ? 'Transfer Type' : 'Service Type' }} </span>

                     <strong> {{ $transferType }} </strong>
                  </div>

                  <div class="detail-row">
                     <span> {{ $type === 'transfer' ? 'Vehicle' : 'Details' }} </span>

                     <strong> {{ $vehicle }} </strong>
                  </div>

                  <div class="detail-row">
                     <span>Supplier Name</span>

                     <strong> {{ $supplierName }} </strong>
                  </div>
               </div>
            </section>
            <!-- BOOKING INFO -->
            <section class="booking-section-card">
               <div class="booking-section-head">
                  <div class="section-title-icon green-icon">
                     <i class="fa-solid fa-receipt"></i>
                  </div>
                  <div>
                     <h3>Booking Information</h3>
                     <p>Payment and booking source details.</p>
                  </div>
               </div>
               <div class="detail-list">
                  <div class="detail-row">
                     <span>Booking ID</span>
                     <strong class="green-text"> {{ $bookingId }} </strong>
                  </div>
                  <div class="detail-row">
                     <span>Booking Date</span>
                     <strong> {{ $bookingDate }} </strong>
                  </div>
                  <div class="detail-row">
                     <span>Payment Mode</span>

                     <strong> {{ $paymentMode }} </strong>
                  </div>
                  <div class="detail-row">
                     <span>Payment Status</span>

                     <strong>
                        <span class="payment-status"> {{ $paymentStatusText }} </span>
                     </strong>
                  </div>
                  <div class="detail-row">
                     <span>Source</span>
                     <strong class="blue-text"> {{ $source }} </strong>
                  </div>
               </div>
            </section>
         </div>
      </div>
      <!-- PRICE / PAX TABLE -->
      <section class="booking-section-card booking-price-card">
         <div class="booking-section-head">
            <div class="section-title-icon purple-icon">
               <i class="fa-solid fa-calculator"></i>
            </div>
            <div>
               <h3>Booking Price Summary</h3>
               <p>Vehicle, pax and total booking amount.</p>
            </div>
         </div>
         <div class="booking-price-table-wrap">
            <table class="booking-price-table">
               <thead>
                  <tr>
                     <th>No. of Vehicle</th>
                     <th>Total Member</th>
                     <th>Currency</th>
                     <th>Total Price</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>
                        <strong> 1 </strong>
                     </td>
                     <td>{{ $totalMember }}</td>
                     <td>{{ $currency }}</td>
                     <td>
                        <strong class="price-value"> {{ $currency }} {{ $amount }} </strong>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </section>
      <!-- ACTION BAR -->
      <div class="booking-bottom-actions">
         <div>
            <span> Last updated: {{ $lastUpdated }} </span>
         </div>
         <div>
            <button class="bd-btn bd-btn-light">
               <i class="fa-solid fa-download"></i>
               Download Voucher
            </button>
            <button class="bd-btn bd-btn-primary">
               <i class="fa-solid fa-ticket"></i>
               <a href="{{ route('supplier.bookings.new-voucher', $order->id) }}"
                class="bd-btn bd-btn-primary">
                    <i class="fa-solid fa-ticket"></i>
                    New Voucher
                </a>
            </button>
         </div>
      </div>
   </main>
</div>
@endsection
