<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sun Leisure World Voucher</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" >
    <link rel="stylesheet" href="{{ asset('public/assets/css/new-voucher.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/supplier-common.css') }}">
</head>
<body>
@php
    $type = strtolower(trim($type ?? $booking->type ?? ''));
    $serviceName = $booking->item_name ?? $service->title_of_tour ?? $service->transfer_name ?? $service->hotel_name ?? $service->package_name ?? $service->title ?? 'N/A';
    $location = $service->tour_location ?? $service->city ?? $service->transfer_from ?? $service->start_city ?? '';
    $country = $service->tour_country ?? $service->country ?? $service->package_country ?? '';
    $item_type = $service->tour_type ?? $service->transfer_type ?? $service->package_type ?? '';
    $item_option = $service->tour_option ?? $service->tour_of_title ?? $service->package_type_select ?? '';
    $start_time = $service->opening_hour ?? $service->transfer_from ?? $service->start_date ?? '';
    $end_time = $service->transfer_to ?? $service->destination ?? '';
    $inclusion = $service->inclusions_description ?? $service->inclusions ?? $service->transfer_information ?? '';
    $exclusions = $service->exclusions_description ?? $service->exclusions ?? '';
    $how_to_use = $service->how_to_use ?? '';
    $meeting_point = $service->meeting_point ?? $service->pick_up_point ?? '';
    $package_itineray = $service->package_itinerary ?? $service->package_itineray ?? '';
@endphp
 <div class="voucher-toolbar no-print"><a href="{{ url('all-bookings') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i>Back to Bookings</a><button type="button" class="print-btn" id="printVoucherBtn"><i class="fa-solid fa-print"></i>Print / Save PDF</button></div>
    <div id="printableArea">
      <div class="voucher-document">
        <header class="voucher-company-header">
          <div class="voucher-brand">
            <img src="https://i.ibb.co/n8t2WZwR/logo-sun.png" alt="Sun Leisure World" class="voucher-logo">
            <div class="voucher-brand-divider"></div>
            <div>
              <span class="official-label">OFFICIAL BOOKING VOUCHER</span>
              <h1>{{ ucfirst($type) }} Voucher</h1>
            </div>
          </div>
          <div class="company-info">
            <h2>SUN LEISURE WORLD</h2>
            <p>Bangkok, Thailand</p>
            <p>Support: support@sunleisureworld.com</p>
            <p>www.sunleisureworld.com</p>
          </div>
        </header>
        <section class="booking-reference-strip">
          <div><span>BOOKING REFERENCE</span><strong>SLW00{{ $booking->id }}</strong></div>
          <div class="confirmed-badge"><i class="fa-solid fa-circle-check"></i>{{ strtoupper($booking->status ?? 'confirmed') }}</div>
        </section>
        <section class="booking-confirmed-box">
          <div class="booking-confirmed-icon"><i class="fa-solid fa-check"></i></div>
          <div>
            <strong>Booking Confirmed</strong>
            <p>Thank you for booking with Sun Leisure World.</p>
          </div>
        </section>
        <section class="booking-quick-grid">
          <div class="quick-info-box"><span>TRAVEL DATE</span><strong>{{ $booking->start_date ?? $booking->date ?? '-' }}</strong></div>
          <div class="quick-info-box"><span>PICKUP TIME</span><strong>{{ $booking->pickup_time ?? '-' }}</strong></div>
          <div class="quick-info-box"><span>PASSENGERS</span><strong>@if($type !== 'transfer') Adult: {{ $booking->qty_adult ?? 0 }}, Child: {{ $booking->qty_child ?? 0 }} @else {{ $booking->TransferPax ?? $booking->qty_adult ?? 0 }} Vehicle @endif</strong></div>
          <div class="quick-info-box"><span>BOOKING TYPE</span><strong>{{ ucfirst($type) }}</strong></div>
        </section>
        <section class="service-card">
          <div class="service-image">
            @if(!empty($image))
            <img src="{{ $image }}" alt="{{ $serviceName }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="no-image-found" style="display:none;"><i class="fa-regular fa-image"></i><span>No Image Found</span></div>
            @else
            <div class="no-image-found"><i class="fa-regular fa-image"></i><span>No Image Found</span></div>
            @endif
          </div>
          <div class="service-content">
            <span class="service-type">{{ strtoupper($type) }}</span>
            <h2>{{ $serviceName }}</h2>
            <p><strong>Destination:</strong>{{ $location ?: '-' }} {{ $country ? ', ' . $country : '' }}</p>
            <p><strong>Booking Date:</strong>{{ $booking->created_at ?? $booking->date ?? '-' }}</p>
            <p><strong>Pickup Time:</strong>{{ $booking->pickup_time ?? '-' }}</p>
          </div>
        </section>
        <section class="two-column-section">
          <div class="info-card">
            <span class="card-label">LEAD PASSENGER</span>
            <h3>{{ trim(($booking->first_name ?? '') . ' ' . ($booking->last_name ?? '')) ?: '-' }}</h3>
            <p><strong>Contact Phone:</strong>{{ $booking->phone ?? '-' }}</p>
            <p><strong>Total Travellers:</strong>@if($type !== 'transfer') {{ ($booking->qty_adult ?? 0) + ($booking->qty_child ?? 0) }} @else {{ $booking->TransferPax ?? $booking->qty_adult ?? 0 }} @endif</p>
          </div>
          <div class="info-card">
            <span class="card-label">BOOKED BY</span>
            <h3>{{ $booking->booked_by ?? '-' }}</h3>
            <span class="agent-badge">Agent ID: {{ $booking->agent_id ?? '-' }}</span>
            <p><strong>Email:</strong>{{ $booking->agent_email ?? '-' }}</p>
            <p><strong>Phone:</strong>{{ $booking->agent_phone ?? '-' }}</p>
          </div>
        </section>
        @if(in_array($type, ['tour', 'package']))
        <section class="two-column-section">
          <div class="info-card">
            <span class="section-orange-title">INCLUSIONS</span>
            <div class="voucher-html-content">{!! $inclusion !!}</div>
          </div>
          <div class="info-card">
            <span class="section-orange-title">EXCLUSIONS</span>
            <div class="voucher-html-content">{!! $exclusions !!}</div>
          </div>
        </section>
        @endif
        @if($type === 'package')
        <section class="full-info-card">
          <span class="section-orange-title">PACKAGE ITINERARY</span>
          <div class="voucher-html-content">{!! $package_itineray !!}</div>
        </section>
        @endif
        @if($type === 'transfer')
        <section class="full-info-card">
          <span class="section-orange-title">TRANSFER DETAILS</span>
          <div class="transfer-detail-grid">
            <div><span>From</span><strong>{{ $start_time ?: '-' }}</strong></div>
            <div><span>To</span><strong>{{ $end_time ?: '-' }}</strong></div>
            <div><span>Flight Number</span><strong>{{ $booking->flight_no ?? '-' }}</strong></div>
            <div><span>Meeting Point</span><strong>{{ $meeting_point ?: '-' }}</strong></div>
          </div>
        </section>
        @endif
        <section class="full-info-card">
          <span class="section-orange-title">HOW TO USE</span>
          <div class="voucher-html-content">{!! $how_to_use !!}</div>
        </section>
        <section class="full-info-card">
          <span class="section-orange-title">IMPORTANT NOTES</span>
          <ul class="notes-list">
            <li>Please arrive at least 10 minutes before the confirmed pickup time.</li>
            <li>Show this voucher to the staff before using the service.</li>
            <li>Pickup time may be reconfirmed by our reservation team.</li>
            <li>Please quote booking reference SLW00{{ $booking->id }} when contacting support.</li>
          </ul>
        </section>
        <section class="emergency-qr-grid">
          <div class="emergency-box">
            <span class="section-orange-title">EMERGENCY CONTACT</span>
            <p><strong>Phone:</strong>+66 81 440 9926</p>
            <p><strong>Email:</strong>support@sunleisureworld.com</p>
            <p><strong>Support:</strong>Available 24/7</p>
            <p><strong>Booking Reference:</strong>SLW00{{ $booking->id }}</p>
          </div>
          <div class="qr-box">
            <div class="fake-qr"><i class="fa-solid fa-qrcode"></i></div>
            <span>Booking Reference</span>
            <strong>SLW00{{ $booking->id }}</strong>
          </div>
        </section>
        <footer class="voucher-footer">
          <div>
            <strong>Thank you for booking with us.</strong>
            <p>For assistance, contact support@sunleisureworld.com</p>
          </div>
          <div class="voucher-authorized"><span>Electronically generated voucher</span><strong>Authorized by Sun Leisure World</strong></div>
        </footer>
        <div class="voucher-computer-note">This is a computer-generated booking voucher and does not require a physical signature.</div>
      </div>
    </div>
    <style>
      /* Print all voucher details */
      @media print {
        @page {
          size: A4;
          margin: 10mm;
        }
        html, body {
          width: 100% !important;
          height: auto !important;
          margin: 0 !important;
          padding: 0 !important;
          overflow: visible !important;
          background: #fff !important;
          -webkit-print-color-adjust: exact !important;
          print-color-adjust: exact !important;
        }
        .no-print, .voucher-toolbar, .back-btn, .print-btn {
          display: none !important;
        }
        #printableArea, .voucher-document {
          display: block !important;
          width: 100% !important;
          max-width: 100% !important;
          height: auto !important;
          max-height: none !important;
          margin: 0 !important;
          padding: 0 !important;
          overflow: visible !important;
          box-shadow: none !important;
          transform: none !important;
        }
        .voucher-document *, .voucher-html-content {
          overflow-wrap: anywhere;
        }
        .voucher-company-header, .booking-reference-strip, .booking-confirmed-box, .booking-quick-grid, .service-card, .two-column-section, .info-card, .full-info-card, .transfer-detail-grid, .emergency-qr-grid, .voucher-footer {
          height: auto !important;
          max-height: none !important;
          overflow: visible !important;
          -webkit-print-color-adjust: exact !important;
          print-color-adjust: exact !important;
        }
        .service-card, .info-card, .full-info-card, .booking-confirmed-box, .quick-info-box, .emergency-box, .qr-box {
          break-inside: avoid;
          page-break-inside: avoid;
        }
        .voucher-html-content img, .service-image img, .voucher-logo {
          max-width: 100% !important;
        }
        .voucher-html-content table {
          width: 100% !important;
          max-width: 100% !important;
          border-collapse: collapse;
        }
        .voucher-html-content pre {
          white-space: pre-wrap !important;
          overflow-wrap: anywhere;
        }
        a {
          color: inherit !important;
          text-decoration: none !important;
        }
      }
      .print-btn {
        position: relative;
        z-index: 9999;
        pointer-events: auto !important;
        cursor: pointer;
      }
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const printBtn = document.getElementById('printVoucherBtn');
      
        if (printBtn) {
          printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
          });
        }
      });
    </script>
  </body>
</html>