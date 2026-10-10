@extends('supplier.layouts.master')
@section('content')
<div class="app-layout">
    <main class="main-content">
        <!-- PAGE HEADER -->
        <div class="page-top">
            <div>
                <span class="page-eyebrow">
                    BOOKINGS
                </span>
                <h1>All Bookings</h1>
                <p>
                    View and manage all tour, transfer and package bookings.
                </p>
            </div>
            <div class="page-top-actions">
                <a href="#" class="top-action-btn secondary-btn">
                    <i class="fa-solid fa-file-invoice"></i>
                    Create Bill
                </a>
                <a href="#" class="top-action-btn secondary-btn">
                    <i class="fa-solid fa-car"></i>
                    Add Transfer Booking
                </a>
                <a href="#" class="top-action-btn primary-btn">
                    <i class="fa-solid fa-plus"></i>
                    Add Tour Booking
                </a>
            </div>
        </div>
        <!--NOTICE-->
        {{--<div class="booking-notice">
            <div class="notice-icon">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div>
                <strong>Cancellation / Amendment Policy</strong>
                <p>
                    Cancellation or amendment is allowed up to
                    <b>24 hours before the booking date.</b>
                </p>
            </div>
        </div>--}}
        <!--FILTER CARD-->
        <section class="content-card booking-filter-card">
            <div class="section-header">
                <div>
                    <h2>Filter Bookings</h2>
                    <p>
                        Search bookings by date range, booking ID, guest or service.
                    </p>
                </div>
                <button
                    type="button"
                    class="filter-toggle-btn"
                    id="filterToggle"
                >
                    <i class="fa-solid fa-sliders"></i>
                    Filters
                </button>
            </div>
            <div
                class="booking-filter-body"
                id="bookingFilterBody"
            >
                <div class="booking-filter-grid">
                    <div class="filter-field">
                        <label>Booking ID</label>
                        <div class="filter-input">
                            <i class="fa-solid fa-ticket"></i>
                            <input
                                type="text"
                                id="bookingId"
                                value="{{ request('booking_id') }}"
                                placeholder="Enter Booking ID e.g. 84539"
                            >
                        </div>
                    </div>
                    <div class="filter-field">
                        <label>Start Date</label>
                        <div class="filter-input">
                            <i class="fa-regular fa-calendar"></i>
                            <input
                                type="date"
                                id="startDate"
                                value="{{ request('start_date') }}"
                            >
                        </div>
                    </div>
                    <div class="filter-field">
                        <label>End Date</label>
                        <div class="filter-input">
                            <i class="fa-regular fa-calendar"></i>
                            <input
                                type="date"
                                id="endDate"
                                value="{{ request('end_date') }}"
                            >
                        </div>
                    </div>
                    <div class="filter-field">
                        <label>Booking Type</label>
                        <div class="filter-input">
                            <i class="fa-solid fa-layer-group"></i>
                            <select id="bookingType" name="booking_type">
                                <option value="">
                                    All Types
                                </option>
                                @foreach($bookingTypes as $bookingType)
                                    @php
                                        $typeValue = strtolower(trim($bookingType));
                                        $typeLabel = ucwords(
                                            str_replace(
                                                ['_', '-'],
                                                ' ',
                                                $typeValue
                                            )
                                        );
                                    @endphp
                                    <option
                                        value="{{ $typeValue }}"
                                        {{ request('booking_type') == $typeValue ? 'selected' : '' }}
                                    >
                                        {{ $typeLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="filter-field">
                        <label>Status</label>
                        <div class="filter-input">
                            <i class="fa-solid fa-circle-check"></i>
                            <select id="bookingStatus">
                                <option value="">
                                    All Status
                                </option>
                                <option
                                    value="confirmed"
                                    {{ request('booking_status') == 'confirmed' ? 'selected' : '' }}
                                >
                                    Confirmed
                                </option>
                                <option
                                    value="pending"
                                    {{ request('booking_status') == 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>
                                <option
                                    value="cancelled"
                                    {{ request('booking_status') == 'cancelled' ? 'selected' : '' }}
                                >
                                    Cancelled
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter-action-row">
                    {{-- <button
                        class="filter-btn apply-filter"
                        type="button"
                    >
                        <i class="fa-solid fa-filter"></i>
                        Filter Booking
                    </button> --}}
                    <button
                        class="filter-btn reset-filter"
                        type="button"
                        id="resetBookingFilter"
                    >
                        <i class="fa-solid fa-rotate-left"></i>
                        Reset Filter
                    </button>
                </div>
            </div>
        </section>
        <!--BOOKING LIST-->
        <section class="content-card booking-list-card">
            {{--<div class="booking-list-header">
                <div>
                    <h2>Booking List</h2>
                    <p>
                        Showing all supplier bookings.
                    </p>
                </div>
                <div class="booking-list-tools">
                    <div class="booking-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input
                            type="text"
                            id="bookingSearch"
                            value="{{ request('search') }}"
                            placeholder="Search booking..."
                        >
                    </div>
                    <select class="entries-select" id="entriesSelect">
                        <option
                            value="10"
                            {{ request('per_page', 10) == 10 ? 'selected' : '' }}
                        >
                            10 Entries
                        </option>
                        <option
                            value="25"
                            {{ request('per_page') == 25 ? 'selected' : '' }}
                        >
                            25 Entries
                        </option>
                        <option
                            value="50"
                            {{ request('per_page') == 50 ? 'selected' : '' }}
                        >
                            50 Entries
                        </option>
                        <option
                            value="100"
                            {{ request('per_page') == 100 ? 'selected' : '' }}
                        >
                            100 Entries
                        </option>
                    </select>
                </div>
            </div> --}}
            @forelse($orders as $booking)
                @php
                    $type = strtolower(
                        trim($booking['type'] ?? 'tour')
                    );
                    if ($type === 'transfer') {
                        $typeClass = 'transfer';
                        $typeLabel = 'Transfer';
                        $typeIcon = 'fa-car';
                        $defaultImage = 'assets/spanel/images/no-image.png';
                    } elseif ($type === 'package') {
                        $typeClass = 'package';
                        $typeLabel = 'Package';
                        $typeIcon = 'fa-suitcase';
                        $defaultImage = 'assets/spanel/images/no-image.png';
                    } elseif ($type === 'hotel') {
                        $typeClass = 'tour';
                        $typeLabel = 'Hotel';
                        $typeIcon = 'fa-hotel';
                        $defaultImage = 'assets/spanel/images/no-image.png';
                    } else {
                        $typeClass = 'tour';
                        $typeLabel = 'Tour';
                        $typeIcon = 'fa-map-location-dot';
                        $defaultImage = 'assets/spanel/images/tour-demo.jpg';
                    }
                    $statusClass = $booking['status_class']
                        ?? 'pending';
                    $statusLabel = $booking['status']
                        ?? 'Pending';
                    $statusIcon = $booking['status_icon']
                        ?? 'fa-clock';
                    $image = !empty($booking['image'])
                        ? $booking['image']
                        : null;
    
                    $searchText = strtolower(
                        ($booking['booking_id'] ?? '') . ' ' .
                        ($booking['product'] ?? '') . ' ' .
                        ($booking['customer'] ?? '') . ' ' .
                        ($booking['supplier'] ?? '') . ' ' .
                        ($booking['source'] ?? '') . ' ' .
                        ($booking['booking_reference'] ?? '') . ' ' .
                        ($typeLabel ?? '')
                    );
                    $customerInitials =
                        $booking['customer_initials'] ?? 'NA';

                @endphp
                <!--BOOKING CARD-->
                <article
                    class="booking-card"
                    data-search="{{ $searchText }}"
                    data-booking-id="{{ $booking['id'] }}"
                    data-booking-type="{{ $type }}"
                    data-status="{{ strtolower($statusLabel) }}"
                >
                   <div class="booking-image">
                    @if(!empty($image))
                        <img
                            src="{{ $image }}"
                            alt="Booking"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <div class="no-image-found" style="display:none;">
                            <i class="fa-regular fa-image"></i>
                            <span>No Image Found</span>
                        </div>
                    @else
                        <div class="no-image-found">
                            <i class="fa-regular fa-image"></i>
                            <span>No Image Found</span>
                        </div>
                    @endif
                    <span class="booking-type {{ $typeClass }}">
                        <i class="fa-solid {{ $typeIcon }}"></i>
                        {{ $typeLabel }}
                    </span>
                </div>
                    <div class="booking-info">
                        <div class="booking-main-head">
                            <div>
                                <div class="booking-id">
                                    BOOKING ID
                                    <strong>
                                        {{ $booking['booking_id'] }}
                                    </strong>
                                </div>
                                <h3>
                                    {{ $booking['product'] }}
                                </h3>
                            </div>
                            <span class="booking-status {{ $statusClass }}">
                                <i class="fa-solid {{ $statusIcon }}"></i>
                                {{ $statusLabel }}
                            </span>
                        </div>
                        <div class="booking-meta-grid">
                            <div class="booking-meta">
                                <span>
                                    <i class="fa-regular fa-calendar"></i>
                                    Travel Date
                                </span>
                                <strong>
                                    {{ $booking['travel_date'] ?? '-' }}
                                </strong>
                            </div>
                            <div class="booking-meta">
                                <span>
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $booking['time_label'] ?? 'Time' }}
                                </span>
                                <strong>
                                    {{ $booking['booking_time'] ?? '-' }}
                                </strong>
                            </div>
                            <div class="booking-meta">
                                <span>
                                    <i class="fa-solid fa-users"></i>
                                    Pax
                                </span>
                                <strong>
                                    {{ $booking['pax'] ?? '0 Adult / 0 Child' }}
                                </strong>
                            </div>
                            <div class="booking-meta">
                                <span>
                                    <i class="fa-solid fa-coins"></i>

                                    Amount
                                </span>
                                <strong>

                                    {{ $booking['currency'] ?? 'THB' }}

                                    {{ number_format((float)($booking['amount'] ?? 0), 2) }}

                                </strong>
                            </div>
                        </div>
                        <!-- DETAILS -->
                        <div class="booking-details-grid">
                            <div>
                                <span>Supplier</span>
                                <strong>
                                    {{ $booking['supplier'] ?? 'N/A' }}
                                </strong>
                            </div>
                            <div>
                                <span>Booking Date</span>
                                <strong>
                                    {{ $booking['booking_date'] ?? '-' }}
                                </strong>
                            </div>
                            <div>
                                <span>Booking Reference</span>
                                <strong>
                                    {{ $booking['booking_reference'] ?? 'N/A' }}
                                </strong>
                            </div>
                            <div>
                                <span>Source</span>
                                <strong>
                                    {{ $booking['source'] ?? 'N/A' }}
                                </strong>
                            </div>
                        </div>
                        <!-- CUSTOMER -->
                        <div class="booking-customer">
                            <div class="customer-avatar">
                                {{ $customerInitials }}
                            </div>
                            <div class="customer-info">
                                <span>LEAD GUEST</span>
                                <strong>
                                    {{ $booking['customer'] ?? 'N/A' }}
                                </strong>
                                <p>
                                    <i class="fa-solid fa-phone"></i>
                                    {{ $booking['phone'] ?? '-' }}
                                    <span></span>
                                    <i class="fa-solid fa-envelope"></i>
                                    {{ $booking['email'] ?? '-' }}
                                </p>
                            </div>
                            <div class="booking-created-by">
                                <span>Booking Made By</span>
                                <strong>
                                    {{ $booking['booking_made_by'] ?? 'User' }}
                                </strong>
                            </div>
                        </div>
                        <!-- ACTIONS -->
                        <div class="booking-actions">
                            <a
                                href="#"
                                class="booking-action-btn"
                            >
                                <i class="fa-regular fa-eye"></i>
                                View Details
                            </a>
                            <a
                                href="#"
                                class="booking-action-btn"
                            >
                                <i class="fa-solid fa-download"></i>
                                Download Voucher
                            </a>
                            <a
                                href="#"
                                class="booking-action-btn new-voucher-btn"
                            >
                                <span class="new-booking-badge">
                                    NEW
                                </span>
                                <i class="fa-solid fa-ticket"></i>
                                New Voucher
                            </a>
                            <a
                                href="#"
                                class="booking-action-btn message-btn"
                            >
                                <i class="fa-regular fa-message"></i>
                                Message
                                <span class="message-count">
                                    0
                                </span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="booking-card">
                    <div class="booking-info">
                        <div class="booking-main-head">
                            <div>
                                <div class="booking-id">
                                    BOOKING LIST
                                </div>
                                <h3>
                                    No bookings found
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
           <!-- PAGINATION -->
            <div class="booking-pagination">
                <div>
                    Showing
                    <strong>
                        {{ $orders->firstItem() ?? 0 }}
                        -
                        {{ $orders->lastItem() ?? 0 }}
                    </strong>
                    of
                    <strong>
                        {{ $orders->total() }}
                    </strong>
                    bookings
                </div>
                <div class="pagination-buttons">
                    @if($orders->onFirstPage())
                        <button disabled>
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                    @else
                        <button
                            type="button"
                            onclick="window.location='{{ $orders->previousPageUrl() }}'"
                        >
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                    @endif
                    @php
                        $currentPage = $orders->currentPage();
                        $lastPage = $orders->lastPage();
                        $startPage = max(
                            1,
                            $currentPage - 1
                        );
                        $endPage = min(
                            $lastPage,
                            $currentPage + 1
                        );
                    @endphp
                    @if($startPage > 1)
                        <button
                            type="button"
                            onclick="window.location='{{ url()->current() }}'"
                            class="{{ $currentPage == 1 ? 'active' : '' }}"
                        >
                            1
                        </button>
                        @if($startPage > 2)
                            <span>...</span>
                        @endif
                    @endif
                    @for($page = $startPage; $page <= $endPage; $page++)
                        <button
                            type="button"
                            class="{{ $currentPage == $page ? 'active' : '' }}"
                            onclick="window.location='{{ $page == 1 ? url()->current() : $orders->url($page) }}'"
                        >
                            {{ $page }}
                        </button>
                    @endfor
                    @if($endPage < $lastPage)
                        @if($endPage < $lastPage - 1)
                            <span>...</span>
                        @endif
                        <button
                            type="button"
                            onclick="window.location='{{ $orders->url($lastPage) }}'"
                        >
                            {{ $lastPage }}
                        </button>
                    @endif
                    @if($orders->hasMorePages())
                        <button
                            type="button"
                            onclick="window.location='{{ $orders->nextPageUrl() }}'"
                        >
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    @else
                        <button disabled>
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    @endif
                </div>
            </div>
        </section>
    </main>
</div>
<div
    id="supplierBookingAjaxLoader"
    style="
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.35);
        display:none;
        align-items:center;
        justify-content:center;
        z-index:999999;
    "
>
    <div
        style="
            background:#fff;
            padding:22px 28px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 10px 35px rgba(0,0,0,.20);
        "
    >
        <div class="supplier-booking-loader-spinner"></div>
        <strong>
            Loading supplier bookings...
        </strong>
    </div>
</div>
<style>
.supplier-booking-loader-spinner {
    width:42px;
    height:42px;
    margin:0 auto 10px;
    border:4px solid #eeeeee;
    border-top:4px solid #ff654f;
    border-radius:50%;
    animation:supplierBookingSpin .8s linear infinite;
}
.no-image-found {
    width: 100%;
    height: 220px;
    border: none;
    border-radius: 10px;
    background: #ffffff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    box-sizing: border-box;
}
.no-image-found i {
    font-size: 25px;
    margin-bottom: 12px;
    color: #ff3b30;
}
.no-image-found span {
    font-size: 10px;
    font-weight: 700;
    color: #ff3b30;
}
@keyframes supplierBookingSpin {
    to {
        transform:rotate(360deg);
    }
}
</style>
@endsection