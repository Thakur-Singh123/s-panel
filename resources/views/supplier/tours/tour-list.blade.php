@extends('supplier.layouts.master')
@section('content')
<div class="app-layout">
    <main class="main-content tour-list-page">
        <!--PAGE HEADER-->
        <div class="tl-page-header">
            <div>
                <span class="tl-eyebrow">PRODUCT MANAGEMENT</span>
                <h1>Tour Management</h1>
                <p>
                    Manage your tours, pricing, availability and content.
                </p>
            </div>
            <div class="tl-header-actions">
                <a href="#" class="tl-btn tl-btn-outline">
                    <i class="fa-solid fa-calendar-plus"></i>
                    Add Tour Booking
                </a>
                <a href="#" class="tl-btn tl-btn-outline">
                    <i class="fa-solid fa-tags"></i>
                    Manage Tour Price
                </a>
                <a href="#" class="tl-btn tl-btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Add New Tour
                </a>
            </div>
        </div>
        <!-- SUMMARY -->
        <div class="tl-stats-grid">
            <div class="tl-stat-card">
                <div class="tl-stat-icon blue">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <div>
                    <span>Total Tours</span>
                    <h3>{{ $totalTours ?? $tours->total() }}</h3>

                    <small>All registered tours</small>
                </div>
            </div>
            <div class="tl-stat-card">
                <div class="tl-stat-icon green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span>Active Tours</span>
                    <h3>{{ $activeTours ?? 0 }}</h3>

                    <small>Currently active</small>
                </div>
            </div>
            <div class="tl-stat-card">
                <div class="tl-stat-icon red">
                    <i class="fa-solid fa-circle-pause"></i>
                </div>
                <div>
                    <span>Inactive Tours</span>
                    <h3>{{ $inactiveTours ?? 0 }}</h3>
                    <small>Not available for sale</small>
                </div>
            </div>
            <div class="tl-stat-card">
                <div class="tl-stat-icon orange">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <span>Pending Approval</span>
                    <h3>{{ $pendingApproval ?? 0 }}</h3>
                    <small>Content awaiting approval</small>
                </div>
            </div>
        </div>
        <!-- FILTER SECTION -->
        <section class="tl-card tl-filter-card">
            <div class="tl-card-header">
                <div>
                    <h2>Filter Tours</h2>
                    <p>
                        Find tours by location, product ID, status or name.
                    </p>
                </div>
                <button
                    class="tl-icon-button"
                    id="tlFilterToggle"
                    type="button"
                >
                    <i class="fa-solid fa-chevron-up"></i>
                </button>
            </div>
            <div class="tl-filter-body" id="tlFilterBody">
                <form
                    method="GET"
                    action="{{ url()->current() }}"
                    id="tourFilterForm"
                >
                    <div class="tl-filter-grid">
                        <!-- LOCATION -->
                        <div class="tl-form-group">
                            <label for="tourLocation">
                                Location
                            </label>
                            <select
                                id="tourLocation"
                                name="location"
                            >
                                <option value="">
                                    All Locations
                                </option>
                                @foreach(($locations ?? []) as $location)
                                    <option
                                        value="{{ $location }}"
                                        {{ request('location') == $location ? 'selected' : '' }}
                                    >
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!--STATUS-->
                        <div class="tl-form-group">
                            <label for="tourStatus">
                                Tour Status
                            </label>
                            <select
                                id="tourStatus"
                                name="status"
                            >
                                <option value="">
                                    All Status
                                </option>
                                <option
                                    value="active"
                                    {{ request('status') == 'active' ? 'selected' : '' }}
                                >
                                    Active
                                </option>
                                <option
                                    value="inactive"
                                    {{ request('status') == 'inactive' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>
                            </select>
                        </div>
                        <!-- APPROVAL -->
                        <div class="tl-form-group">
                            <label for="approvalStatus">
                                Content Approval
                            </label>
                            <select
                                id="approvalStatus"
                                name="approval"
                            >
                                <option value="">
                                    All Approval Status
                                </option>
                                <option
                                    value="approved"
                                    {{ request('approval') == 'approved' ? 'selected' : '' }}
                                >
                                    Approved
                                </option>
                                <option
                                    value="pending"
                                    {{ request('approval') == 'pending' ? 'selected' : '' }}
                                >
                                    Not Approved
                                </option>
                            </select>
                        </div>
                        <!-- PRODUCT ID -->
                        <div class="tl-form-group">
                            <label for="tourProductId">
                                Product ID
                            </label>
                            <input
                                type="text"
                                id="tourProductId"
                                name="product_id"
                                value="{{ request('product_id') }}"
                                placeholder="Enter Product ID"
                            >
                        </div>
                        <!--TOUR NAME -->
                        <div class="tl-form-group tl-search-field">
                            <label for="tourName">
                                Tour Name
                            </label>
                            <input
                                type="text"
                                id="tourName"
                                name="tour_name"
                                value="{{ request('tour_name') }}"
                                placeholder="Search by tour name..."
                            >
                        </div>
                    </div>
                    <div class="tl-filter-actions">
                        <a
                            href="{{ url()->current() }}"
                            class="tl-btn tl-btn-outline"
                            id="resetTourFilter"
                        >
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset Filter
                        </a>
                    </div>
                </form>
            </div>
        </section>
        <!-- TOUR LIST -->
        <section class="tl-card tl-list-card">
            <div class="tl-card-header tl-list-header">
                <div>
                    <h2>
                        All Tour Listings
                        <span class="tl-count">
                            ({{ $tours->total() }})
                        </span>
                    </h2>
                    <p>
                        Manage your tour products and related services.
                    </p>
                </div>
                {{--<div class="tl-list-tools">
                    <form
                        method="GET"
                        action="{{ url()->current() }}"
                        style="display: contents;"
                    >
                        <input
                            type="search"
                            id="quickTourSearch"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Quick search tours..."
                        >
                    </form>
                    <select id="tourEntries">
                        <option value="10"
                            {{ request('per_page', 10) == 10 ? 'selected' : '' }}>
                            10 Entries
                        </option>
                        <option value="25"
                            {{ request('per_page') == 25 ? 'selected' : '' }}>
                            25 Entries
                        </option>
                        <option value="50"
                            {{ request('per_page') == 50 ? 'selected' : '' }}>
                            50 Entries
                        </option>
                    </select>
                </div> --}}
            </div>
            <div class="tl-list-label">
                <span>TOUR INFORMATION</span>
                <span>PRODUCT MANAGEMENT</span>
            </div>
            @forelse($tours as $tour)
                @php
                    $isActive = (int) $tour->isactive === 1;
                    $isApproved =
                        (string) $tour->approved === '1'
                        ||
                        strtolower((string) $tour->approved) === 'approved';
                    $tourImage = $tour->image ?? null;
                    $tourLocation = $tour->tour_location ?: 'N/A';
                    $duration = $tour->no_of_day ?: 'N/A';
                    $tourOption = $tour->tour_option ?: 'N/A';
                    $openingHour = $tour->opening_hour ?: 'N/A';
                    $updatedDate = null;
                    if (!empty($tour->timestamp)) {
                        try {
                            $updatedDate = \Carbon\Carbon::parse($tour->timestamp)
                                ->format('Y-m-d');
                        } catch (\Exception $e) {
                            $updatedDate = $tour->timestamp;
                        }
                    }
                    if (!$updatedDate) {
                        $updatedDate = 'N/A';
                    }
                @endphp
                <!--TOUR ITEM -->
                <article
                    class="tl-tour-item"
                    data-id="{{ $tour->add_tour_id }}"
                    data-location="{{ $tourLocation }}"
                    data-status="{{ $isActive ? 'active' : 'inactive' }}"
                    data-approval="{{ $isApproved ? 'approved' : 'pending' }}"
                >
                <!-- IMAGE -->
                <div class="tl-tour-image">
                    @if(!empty($tourImage))
                        <img
                            src="{{ $tourImage }}"
                            alt="{{ $tour->title_of_tour ?? 'Tour Image' }}"
                            class="tl-tour-image"
                            onerror="this.onerror=null; this.src='https://placehold.co/320x220/eaf3fa/64748b?text=Tour+Image';"
                        >
                    @else
                        <div class="no-image-found">
                            <i class="fa-regular fa-image"></i>
                            <span>Image Not Found</span>
                        </div>
                    @endif
                </div>
                <!-- TOUR CONTENT -->
                <div class="tl-tour-content">
                    <!-- HEADING -->
                    <div class="tl-tour-heading">
                        <div>
                            <div class="tl-product-meta">
                                Product ID:
                                <strong>
                                    {{ $tour->add_tour_id }}
                                </strong>
                                @if(!empty($tour->tour_type))

                                    <span class="tl-type-badge">
                                        {{ $tour->tour_type }}
                                    </span>
                                @endif
                            </div>
                            <h3>
                                {{ $tour->title_of_tour }}
                            </h3>
                            <p class="tl-location">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $tourLocation }}
                            </p>
                        </div>
                        <!--STATUS-->
                        <div class="tl-status-group">
                            @if($isActive)
                                <span class="tl-badge active">
                                    <i class="fa-solid fa-circle"></i>
                                    Active
                                </span>
                            @else
                                <span class="tl-badge inactive">
                                    <i class="fa-solid fa-circle"></i>
                                    Inactive
                                </span>
                            @endif
                            @if($isApproved)
                                <span class="tl-badge approved">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Approved
                                </span>
                            @else
                                <span class="tl-badge pending">
                                    <i class="fa-solid fa-clock"></i>
                                    Not Approved
                                </span>
                            @endif
                        </div>
                    </div>
                    <!-- TOUR META -->
                    <div class="tl-tour-meta">
                        <div>
                            <span>Tour Option</span>
                            <strong>
                                {{ $tourOption }}
                            </strong>
                        </div>
                        <div>
                            <span>Operating Hours</span>
                            <strong>
                                {{ $openingHour }}
                            </strong>
                        </div>
                        <div>
                            <span>Duration</span>

                            <strong>
                                {{ $duration }} Day(s)
                            </strong>
                        </div>
                        <div>
                            <span>Option Sets</span>
                            <strong>
                                {{ !empty($tour->tour_option) ? 'Available' : 'N/A' }}
                            </strong>
                        </div>
                        <div>
                            <span>Last Updated</span>
                            <strong>
                                {{ $updatedDate }}
                            </strong>
                        </div>
                    </div>
                    @php
                        $missingItems = [];
                        if (empty($tourImage)) {
                            $missingItems[] = 'image';
                        }
                        if (empty($tour->short_description) &&
                            empty($tour->full_description)) {
                            $missingItems[] = 'description';
                        }
                        if (empty($tour->tour_option)) {
                            $missingItems[] = 'option';
                        }
                    @endphp
                    @if(count($missingItems) > 0)
                        <div class="tl-completion-warning">
                            <div class="tl-warning-heading">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>
                                    Complete Your Tour Listing
                                </strong>

                                <span class="tl-warning-count">
                                    {{ count($missingItems) }} Missing
                                </span>
                            </div>
                            <p>
                                Some important information is missing.
                                Please complete the following details.
                            </p>
                            <div class="tl-warning-items">
                                @if(in_array('image', $missingItems))
                                    <div class="tl-warning-item">
                                        <span>
                                            <i class="fas fa-image"></i>
                                            Tour images not uploaded
                                        </span>
                                        <a href="#">
                                            Manage Images
                                        </a>
                                    </div>
                                @endif
                                @if(in_array('option', $missingItems))
                                    <div class="tl-warning-item">
                                        <span>
                                            <i class="fas fa-tag"></i>
                                            Tour option not added
                                        </span>
                                        <a href="#">
                                            Manage Price
                                        </a>
                                    </div>
                                @endif
                                @if(in_array('description', $missingItems))
                                    <div class="tl-warning-item">
                                        <span>
                                            <i class="fas fa-file-alt"></i>
                                            Tour description incomplete
                                        </span>
                                        <a href="#">
                                            Manage Tour
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    <!-- ACTIONS -->
                    <div class="tl-tour-actions">
                        <a
                            href="#"
                            class="tl-action-btn"
                        >
                            <i class="fa-regular fa-image"></i>
                            Manage Images
                        </a>
                        <a
                            href="#"
                            class="tl-action-btn"
                        >
                            <i class="fa-solid fa-pen"></i>
                            Manage Tour
                        </a>
                        <a
                            href="#"
                            class="tl-action-btn"
                        >
                            <i class="fa-regular fa-clock"></i>
                            Tour Timing
                        </a>
                        <a
                            href="#"
                            class="tl-action-btn"
                        >
                            <i class="fa-solid fa-plus"></i>
                            Add Option Set
                        </a>
                        <a
                            href="#"
                            class="tl-action-btn"
                        >
                            <i class="fa-solid fa-list"></i>
                            View Option Set
                        </a>
                        <a
                            href="#"
                            class="tl-action-btn"
                        >
                            <i class="fa-solid fa-chart-line"></i>
                            Price Log
                        </a>
                        <a
                            href="#"
                            class="tl-action-btn"
                        >
                            <i class="fa-regular fa-circle-question"></i>
                            Manage FAQ
                        </a>
                        <a
                            href="#"
                            class="tl-preview-btn"
                        >

                            <i class="fas fa-eye"></i>

                            Preview Tour

                            <i class="fas fa-external-link-alt"></i>

                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div
                class="no-data-found"
                id="tlEmptyState"
            >
                No matching tours found.
            </div>
        @endforelse
        {{-- TOUR PAGINATION - Same design as All Booking --}}
        <div class="booking-pagination">
            <div>
                Showing
                <strong>{{ $tours->firstItem() ?? 0 }}</strong>
                -
                <strong>{{ $tours->lastItem() ?? 0 }}</strong>
                of
                <strong>{{ $tours->total() }}</strong>
                tours
            </div>
            <div class="pagination-buttons">
                {{-- Previous --}}
                @if($tours->onFirstPage())
                    <button type="button" disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                @else
                    <button
                        type="button"
                        data-tour-page="{{ $tours->currentPage() - 1 }}"
                    >
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                @endif
                @php
                    $currentPage = $tours->currentPage();
                    $lastPage = $tours->lastPage();

                    $startPage = max(1, $currentPage - 1);
                    $endPage = min($lastPage, $currentPage + 1);
                @endphp
                {{-- First page --}}
                @if($startPage > 1)
                    <button
                        type="button"
                        data-tour-page="1"
                        class="{{ $currentPage == 1 ? 'active' : '' }}"
                    >1</button>
                    @if($startPage > 2)
                        <span>...</span>
                    @endif
                @endif
                {{-- Page numbers --}}
                @for($page = $startPage; $page <= $endPage; $page++)
                    <button
                        type="button"
                        data-tour-page="{{ $page }}"
                        class="{{ $currentPage == $page ? 'active' : '' }}"
                    >{{ $page }}</button>
                @endfor
                {{-- Last page --}}
                @if($endPage < $lastPage)
                    @if($endPage < $lastPage - 1)
                        <span>...</span>
                    @endif
                    <button
                        type="button"
                        data-tour-page="{{ $lastPage }}"
                    >{{ $lastPage }}</button>
                @endif
                {{-- Next --}}
                @if($tours->hasMorePages())
                    <button
                        type="button"
                        data-tour-page="{{ $currentPage + 1 }}"
                    >
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @else
                    <button type="button" disabled>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif

            </div>
        </div>
        </section>
    </main>
</div>
<div id="tourListAjaxLoader"
     class="sp-loader-overlay"
     aria-live="polite">
    <div class="sp-loader-box">
        <div class="sp-loader-spinner"></div>
        <strong>Loading tours...</strong>
    </div>
</div>
@endsection