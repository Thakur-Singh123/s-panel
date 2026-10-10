<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\AddTour;
use App\Models\AddTransfer;
use App\Models\AddHotel;
use App\Models\AddPackage;
use App\Models\FerryTransfer;
use App\Models\AddSupplier;
use App\Models\AddTourImage;
use App\Models\AddTransferImage;
use App\Models\FerriImage;
use App\Models\HotelImage;
use App\Helpers\ImageHelper;
use Carbon\Carbon;

class BookingController extends Controller
{
    //Function for all supplier bookings
    public function index(Request $request) {
        //Get logged supplier
        $supplierId = session('supplier_id');
        if (empty($supplierId)) {
            return redirect()->route('login')->with('unsuccess','Please login first.');
        }
        //Supplier details
        $supplier = AddSupplier::query()->select(['add_supplier_id','name',])->where('add_supplier_id', $supplierId)->first();
        //Check supplier exits or not
        if (!$supplier) {
            session()->forget([
                'login_type',
                'supplier_id',
                'sub_supplier_id',
            ]);

            return redirect()->route('login')->with('unsuccess', 'Supplier account not found.');
        }

        //Supplier Booking Query
        $query = Order::query()->where('assign_supplier', $supplierId)
            ->select([
                'id',
                'item_id',
                'type',
                'start_date',
                'end_date',
                'qty_adult',
                'qty_child',
                'amount_adult',
                'amount_child',
                'total_amount',
                'date',
                'userID',
                'userRole',
                'item_name',
                'first_name',
                'last_name',
                'email',
                'phone_country_code',
                'phone',
                'assign_supplier',
                'source',
                'booking_reference',
                'status',
                'currency',
                'pickup_time',
                'TransferTime',
                'flight_time',
                'supplier_name',
            ]);

        //Booking id filter
        if ($request->filled('booking_id')) {
            $bookingId = trim($request->booking_id);
            $number = preg_replace('/[^0-9]/', '', $bookingId);
            $query->where(function ($q) use ($bookingId, $number) {
                if ($number !== '') {
                    $q->where('id', $number);
                }
                $q->orWhere('booking_reference', 'LIKE', '%' . $bookingId . '%');
            });
        }
        //Default: show today's bookings
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        } elseif (!$request->hasAny([
            'booking_id', 'end_date', 'booking_type',
            'booking_status', 'booking_source', 'search'
        ])) {
            $query->whereDate('start_date', today()->toDateString());
        }

        if ($request->filled('end_date')) {
            $query->whereDate('start_date', '<=', $request->end_date);
        }
        //Booking Type
        if ($request->filled('booking_type')) {
            $query->whereRaw(
                'LOWER(TRIM(type)) = ?',
                [
                    strtolower(
                        trim(
                            $request->booking_type
                        )
                    )
                ]
            );
        }
        // Booking Source Filter
        if ($request->filled('booking_source')) {
            $query->where('source', $request->booking_source);
        }
        //Booking Status
        if ($request->filled('booking_status')) {
            $bookingStatus = strtolower(
                trim(
                    $request->booking_status
                )
            );
            if ($bookingStatus === 'confirmed') {
                $query->whereRaw(
                    'LOWER(TRIM(status)) = ?',
                    ['confirmed']
                );
            } elseif ($bookingStatus === 'pending') {
                $query->whereRaw(
                    'LOWER(TRIM(status)) = ?',
                    ['pending']
                );
            } elseif ($bookingStatus === 'cancelled') {
                $query->where(function ($q) {
                    $q->whereRaw(
                        'LOWER(TRIM(status)) = ?',
                        ['cancel']
                    )
                    ->orWhereRaw(
                        'LOWER(TRIM(status)) = ?',
                        ['cancelled']
                    )
                    ->orWhereRaw(
                        'LOWER(TRIM(status)) = ?',
                        ['canceled']
                    );
                });
            }
        }
        //Search Booking
        if ($request->filled('search')) {
            $search = trim(
                $request->search
            );
            $query->where(function ($q) use ($search) {
                $q->where(
                    'id',
                    'LIKE',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'item_name',
                    'LIKE',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'first_name',
                    'LIKE',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'last_name',
                    'LIKE',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'booking_reference',
                    'LIKE',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'source',
                    'LIKE',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'supplier_name',
                    'LIKE',
                    '%' . $search . '%'
                );
            });
        }
        //Entries Per Page
        $perPage = (int) (
            $request->get(
                'per_page',
                10
            )
        );
        $allowedPerPage = [
            10,
            25,
            50,
            100,
        ];
        if (
            !in_array(
                $perPage,
                $allowedPerPage,
                true
            )
        ) {

            $perPage = 10;
        }
        //Pagination
        $orders = $query->orderByDesc('id')->paginate($perPage)->withQueryString();
        //Dynamic Booking image data
        $bookings = $orders
            ->getCollection()
            ->map(function ($order) use ($supplier) {
                //Type
                $type = strtolower(
                    trim(
                        $order->type ?? 'tour'
                    )
                );
                if ($type === 'transfer') {
                    $bookingType = 'Transfer';
                    $typeClass = 'transfer';
                    $typeIcon = 'fa-car';
                    $defaultImage = 'assets/images/no-image.png';

                } elseif ($type === 'package') {
                    $bookingType = 'Package';
                    $typeClass = 'package';
                    $typeIcon = 'fa-suitcase';
                    $defaultImage = 'assets/images/no-image.png';
                } elseif ($type === 'hotel') {
                    $bookingType = 'Hotel';
                    $typeClass = 'tour';
                    $typeIcon = 'fa-hotel';
                    $defaultImage ='assets/images/no-image.png';
                } else {
                    $bookingType = 'Tour';
                    $typeClass = 'tour';
                    $typeIcon = 'fa-map-location-dot';
                    $defaultImage ='assets/images/tour-demo.jpg';
                }
                //Status
                $rawStatus = strtolower(
                    trim(
                        $order->status ?? 'pending'
                    )
                );
                if (
                    in_array(
                        $rawStatus,
                        [
                            'confirmed',
                            'confirmation complete',
                        ],
                        true
                    )
                ) {
                    $status = 'Confirmed';
                    $statusClass = 'confirmed';
                    $statusIcon = 'fa-circle-check';

                } elseif (
                    in_array(
                        $rawStatus,
                        [
                            'cancel',
                            'cancelled',
                            'canceled',
                        ],
                        true
                    )
                ) {
                    $status = 'Cancelled';
                    $statusClass = 'cancelled';
                    $statusIcon = 'fa-circle-xmark';

                } else {
                    $status = 'Pending';
                    $statusClass = 'pending';
                    $statusIcon = 'fa-clock';
                }
                $guestName = trim(
                    ($order->first_name ?? '') .
                    ' ' .
                    ($order->last_name ?? '')
                );

                $guestName =
                    $guestName ?: 'N/A';
                $nameParts = preg_split(
                    '/\s+/',
                    trim($guestName)
                );
                $initials = '';
                foreach (
                    array_slice(
                        $nameParts,
                        0,
                        2
                    ) as $part
                ) {

                    if (!empty($part)) {

                        $initials .= strtoupper(
                            Str::substr(
                                $part,
                                0,
                                1
                            )
                        );
                    }
                }

                $initials =
                    $initials ?: 'NA';
                $phone = trim(
                    ($order->phone_country_code ?? '') .
                    ' ' .
                    ($order->phone ?? '')
                );

                $phone =
                    $phone ?: '-';

                $email =
                    $order->email ?: '-';
                $supplierName =
                    $supplier->name
                    ?: (
                        $order->supplier_name
                        ?: 'N/A'
                    );

                $travelDate = '-';
                if (!empty($order->start_date)) {
                    $travelTimestamp =
                        strtotime(
                            $order->start_date
                        );
                    if ($travelTimestamp) {
                        $travelDate =
                            date(
                                'd M Y',
                                $travelTimestamp
                            );
                    }
                }
                $bookingDate = '-';
                if (!empty($order->date)) {
                    $bookingTimestamp =
                        strtotime(
                            $order->date
                        );
                    if ($bookingTimestamp) {
                        $bookingDate =
                            date(
                                'd M Y, H:i',
                                $bookingTimestamp
                            );
                    }
                }
                $adult = (int) (
                    $order->qty_adult ?? 0
                );

                $child = (int) (
                    $order->qty_child ?? 0
                );

                $amount = (float) (
                    $order->total_amount ?? 0
                );

                $currency =
                    $order->currency
                    ?: 'THB';
                if (
                    $type === 'transfer' &&
                    !empty(
                        $order->TransferTime
                    )
                ) {

                    $bookingTime =
                        $order->TransferTime;

                    $timeLabel =
                        'Pickup Time';

                } elseif (
                    $type === 'tour' &&
                    !empty(
                        $order->pickup_time
                    )
                ) {

                    $bookingTime =
                        $order->pickup_time;

                    $timeLabel =
                        'Tour Time';

                } elseif (
                    !empty(
                        $order->flight_time
                    )
                ) {

                    $bookingTime =
                        $order->flight_time;

                    $timeLabel =
                        'Flight Time';

                } else {

                    $bookingTime = '-';

                    $timeLabel =
                        $type === 'transfer'
                        ? 'Pickup Time'
                        : 'Tour Time';
                }
                //Default Image
                $image = null;
                //Tour Image
                if ($type === 'tour') {
                    $tourImage = AddTourImage::where(
                        'add_tour_id',
                        $order->item_id
                    )
                    ->orderByDesc('is_featured')
                    ->get()
                    ->first(function ($item) {

                        return !empty($item->tour_images)
                            || !empty($item->cloudnery_img)
                            || !empty($item->cloudnary_img);
                    });

                    if ($tourImage) {
                        $imageName = null;
                        if (!empty($tourImage->tour_images)) {
                            $imageName = $tourImage->tour_images;
                        } elseif (!empty($tourImage->cloudnery_img)) {
                            $imageName = $tourImage->cloudnery_img;
                        } elseif (!empty($tourImage->cloudnary_img)) {
                            $imageName = $tourImage->cloudnary_img;
                        }

                        if (!empty($imageName) && !empty($tourImage->img_type)) {
                            $extension = strtolower(
                                trim($tourImage->img_type)
                            );

                            $extension = ltrim($extension, '.');
                            if (
                                !str_ends_with(
                                    strtolower($imageName),
                                    '.' . $extension
                                )
                            ) {

                                $imageName .= '.' . $extension;
                            }
                        }
                        if (!empty($imageName)) {

                            $image = ImageHelper::path(
                                'tour',
                                $imageName
                            );
                        }
                    }
                }
                //TRANSFER IMAGE
                elseif ($type === 'transfer') {
                    $transferImage = AddTransferImage::where(
                        'add_transfer_id',
                        $order->item_id
                    )
                    ->orderByDesc('is_featured')
                    ->get()
                    ->first(function ($item) {
                        return !empty($item->cloudnery_img)
                            || !empty($item->cloudnary_img)
                            || !empty($item->transfer_images);
                    });
                    if ($transferImage) {
                        $imageName = null;
                        if (!empty($transferImage->cloudnery_img)) {
                            $imageName = $transferImage->cloudnery_img;
                        } elseif (!empty($transferImage->cloudnary_img)) {
                            $imageName = $transferImage->cloudnary_img;
                        } elseif (!empty($transferImage->transfer_images)) {
                            $imageName = $transferImage->transfer_images;
                        }
                        if (!empty($imageName) && !empty($transferImage->img_type)) {
                            $extension = strtolower(
                                trim($transferImage->img_type)
                            );
                            $extension = ltrim($extension, '.');
                            if (
                                !str_ends_with(
                                    strtolower($imageName),
                                    '.' . $extension
                                )
                            ) {
                                $imageName .= '.' . $extension;
                            }
                        }
                        if (!empty($imageName)) {
                            $image = ImageHelper::path(
                                'transfer',
                                $imageName
                            );
                        }
                    }
                }
                //PACKAGE IMAGE
                elseif ($type === 'package') {
                    $packageImage = AddPackageImage::where(
                        'add_package_id',
                        $order->item_id
                    )
                    ->get()
                    ->first(function ($item) {
                        return !empty($item->cloudnery_img)
                            || !empty($item->cloudnary_img)
                            || !empty($item->package_image)
                            || !empty($item->package_images);
                    });
                    if ($packageImage) {
                        $imageName = null;
                        if (!empty($packageImage->cloudnery_img)) {
                            $imageName = $packageImage->cloudnery_img;
                        } elseif (!empty($packageImage->cloudnary_img)) {
                            $imageName = $packageImage->cloudnary_img;
                        } elseif (!empty($packageImage->package_image)) {
                            $imageName = $packageImage->package_image;
                        } elseif (!empty($packageImage->package_images)) {
                            $imageName = $packageImage->package_images;
                        }
                        if (!empty($imageName) && !empty($packageImage->img_type)) {
                            $extension = strtolower(
                                trim($packageImage->img_type)
                            );
                            $extension = ltrim($extension, '.');
                            if (
                                !str_ends_with(
                                    strtolower($imageName),
                                    '.' . $extension
                                )
                            ) {
                                $imageName .= '.' . $extension;
                            }
                        }
                        if (!empty($imageName)) {
                            $image = ImageHelper::path(
                                'package',
                                $imageName
                            );
                        }
                    }
                }
                //FERRY IMAGE
                elseif ($type === 'ferry') {
                    $ferryImage = FerriImage::where(
                        'ferry_id',
                        $order->item_id
                    )
                    ->get()
                    ->first(function ($item) {

                        return !empty($item->cloudnery_img)
                            || !empty($item->cloudnary_img)
                            || !empty($item->ferry_image)
                            || !empty($item->ferry_images);
                    });
                    if ($ferryImage) {
                        $imageName = null;
                        if (!empty($ferryImage->cloudnery_img)) {
                            $imageName = $ferryImage->cloudnery_img;
                        } elseif (!empty($ferryImage->cloudnary_img)) {
                            $imageName = $ferryImage->cloudnary_img;
                        } elseif (!empty($ferryImage->ferry_image)) {
                            $imageName = $ferryImage->ferry_image;
                        } elseif (!empty($ferryImage->ferry_images)) {
                            $imageName = $ferryImage->ferry_images;
                        }
                        if (!empty($imageName) && !empty($ferryImage->img_type)) {
                            $extension = strtolower(
                                trim($ferryImage->img_type)
                            );
                            $extension = ltrim($extension, '.');
                            if (
                                !str_ends_with(
                                    strtolower($imageName),
                                    '.' . $extension
                                )
                            ) {
                                $imageName .= '.' . $extension;
                            }
                        }
                        if (!empty($imageName)) {
                            $image = ImageHelper::path(
                                'ferry',
                                $imageName
                            );
                        }
                    }
                }
                //HOTEL IMAGE
                elseif ($type === 'hotel') {
                    $hotelImage = HotelImage::where(
                        'hotel_id',
                        $order->item_id
                    )
                    ->orderByDesc('is_featured')
                    ->get()
                    ->first(function ($item) {
                        return !empty($item->cloudnery_img)
                            || !empty($item->cloudnary_img)
                            || !empty($item->hotel_image)
                            || !empty($item->hotel_images);
                    });
                    if ($hotelImage) {
                        $imageName = null;
                        if (!empty($hotelImage->cloudnery_img)) {
                            $imageName = $hotelImage->cloudnery_img;
                        } elseif (!empty($hotelImage->cloudnary_img)) {
                            $imageName = $hotelImage->cloudnary_img;
                        } elseif (!empty($hotelImage->hotel_image)) {
                            $imageName = $hotelImage->hotel_image;
                        } elseif (!empty($hotelImage->hotel_images)) {
                            $imageName = $hotelImage->hotel_images;
                        }
                        if (!empty($imageName) && !empty($hotelImage->img_type)) {
                            $extension = strtolower(
                                trim($hotelImage->img_type)
                            );
                            $extension = ltrim($extension, '.');
                            if (
                                !str_ends_with(
                                    strtolower($imageName),
                                    '.' . $extension
                                )
                            ) {
                                $imageName .= '.' . $extension;
                            }
                        }
                        if (!empty($imageName)) {

                            $image = ImageHelper::path(
                                'hotel',
                                $imageName
                            );
                        }
                    }
                }               
                $bookingMadeBy = $order->userRole ?: 'User';
                return [
                    'id' => $order->id,
                    'booking_id' =>
                        'SLW' .
                        str_pad(
                            $order->id,
                            7,
                            '0',
                            STR_PAD_LEFT
                        ),
                    'item_id' =>
                        $order->item_id,
                    'type' =>
                        $type,
                    'booking_type' =>
                        $bookingType,
                    'type_class' =>
                        $typeClass,
                    'type_icon' =>
                        $typeIcon,
                    'product' =>
                        $order->item_name
                        ?: 'N/A',
                    'status' =>
                        $status,
                    'status_class' =>
                        $statusClass,
                    'status_icon' =>
                        $statusIcon,
                    'travel_date' =>
                        $travelDate,
                    'start_date' =>
                        $order->start_date,
                    'end_date' =>
                        $order->end_date,
                    'booking_time' =>
                        $bookingTime,
                    'time_label' =>
                        $timeLabel,
                    'adult' =>
                        $adult,
                    'child' =>
                        $child,
                    'pax' =>
                        $adult .
                        ' Adult / ' .
                        $child .
                        ' Child',
                    'amount' =>
                        $amount,
                    'currency' =>
                        $currency,
                    'supplier' =>
                        $supplierName,
                    'booking_date' =>
                        $bookingDate,
                    'booking_reference' =>
                        $order->booking_reference
                        ?: 'N/A',
                    'source' =>
                        $order->source
                        ?: 'N/A',
                    'customer' =>
                        $guestName,
                    'customer_initials' =>
                        $initials,
                    'phone' =>
                        $phone,
                    'email' =>
                        $email,
                    'booking_made_by' =>
                        $bookingMadeBy,
                    'image' =>
                        $image,
                ];
            })
            ->values();
            $bookingTypes = Order::whereNotNull('type')
                ->where('type', '!=', '')
                ->select('type')
                ->distinct()
                ->orderBy('type')
                ->pluck('type')
                ->map(function ($type) {
                    return strtolower(trim($type));
                })
                ->filter()
                ->unique()
                ->values();

            $orders->setCollection(
                $bookings
            );
            $bookingSources = Order::where('assign_supplier', $supplierId)
                ->whereNotNull('source')
                ->where('source', '!=', '')
                ->distinct()
                ->orderBy('source')
                ->pluck('source');
        return view('supplier.bookings.all-bookings', compact('orders','bookingTypes','supplier','supplierId','bookingSources'));
    }

    //Function for booking detail
    public function booking_details($id) {
        //Get Booking
        $order = Order::findOrFail($id);
        //Booking Type
        $type = strtolower(trim($order->type ?? 'tour'));
        //Booking ID
        $bookingId = 'SLW' . str_pad($order->id, 7, '0', STR_PAD_LEFT);
        //Guest Name
        $guestName = trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? ''));
        if (empty($guestName)) {
            $guestName = 'Guest';
        }
        //Guest Initials
        $guestInitials = '';
        if (!empty($order->first_name)) {
            $guestInitials .=
                strtoupper(
                    substr($order->first_name, 0, 1)
                );
        }
        if (!empty($order->last_name)) {
            $guestInitials .=
                strtoupper(
                    substr($order->last_name, 0, 1)
                );
        }
        if (empty($guestInitials)) {
            $guestInitials = 'NA';
        }
        //Adult / Child
        $adult = (int) ($order->qty_adult ?? 0);
        $child = (int) ($order->qty_child ?? 0);
        //Currency
        $currency = $order->currency ?: 'THB';
        //Amount
        $amount = number_format(
            (float) ($order->total_amount ?? 0),
            2
        );
        //Travel Date
        $travelDate = '-';
        if (!empty($order->start_date)) {
            try {

                $travelDate = Carbon::parse(
                    $order->start_date
                )->format('d M Y');
            } catch (\Exception $e) {
                $travelDate = $order->start_date;
            }
        }
        //Booking Date
        $bookingDate = '-';
        if (!empty($order->date)) {
            try {
                $bookingDate = Carbon::parse(
                    $order->date
                )->format('d M Y, H:i:s');
            } catch (\Exception $e) {

                $bookingDate = $order->date;
            }
        }
        //Pickup / Flight Time
        $pickupTime =
            $order->pickup_time
            ?: $order->flight_time
            ?: $order->TransferTime
            ?: '-';
        //Payment Status
        $paymentStatus =
            $order->payment_status
            ?: $order->status
            ?: 'Pending';

        //Booking Made By
        $bookingMadeBy =
            $order->manually_booking_made_by
            ?: 'Manual';
        //Source
        $source =
            $order->source
            ?: 'N/A';
        //Supplier
        $supplierName =
            $order->supplier_name
            ?: 'N/A';
        //Hotel
        $hotelName =
            $order->HotelName
            ?: '-';
        //Pickup Details
        $pickupDetails =
            $order->TransferFromAddress
            ?: $order->from
            ?: '-';
        //Contact Phone
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
        $flightNo =
            $order->flight_no
            ?: $order->departure_flight_no
            ?: '-';
        $pickupPoint =
            $order->TransferFrom
            ?: $order->from
            ?: '-';
        $droppedAddress =
            $order->TransferFromAddress
            ?: $order->to
            ?: '-';
        $meetingPoint =
            $order->HotelNameFrom
            ?: 'Hotel Lobby';
        $otherInfo =
            $order->remark
            ?: $order->supplier_remark
            ?: '-';
        $transferFrom =
            $order->TransferFrom
            ?: $order->from
            ?: '-';
        $transferTo =
            $order->to
            ?: $order->HotelNameTo
            ?: '-';
        $transferType =
            $order->meal_transfer_type
            ?: 'Private Transfer';
        $vehicle =
            $order->TransferPax
            ?: 'N/A';
        $paymentMode =
            $order->payment_mode
            ?: '-';
        $vehicleCount = 1;
        if (!empty($order->TransferPax)) {
            $vehicleCount = 1;
        }

        return view('supplier.bookings.booking-details', compact('order','type','bookingId','guestName','guestInitials','adult','child','currency','amount','travelDate','bookingDate','pickupTime','paymentStatus','bookingMadeBy','source','supplierName','hotelName','pickupDetails','contactPhone','flightNo','pickupPoint','droppedAddress','meetingPoint','otherInfo','transferFrom','transferTo','transferType','vehicle','paymentMode','vehicleCount'));
    }

    //Function for new vouchar booking
    public function new_voucher($id) {
        $supplierId = session('supplier_id');
        $booking = Order::where('id', $id)
            ->where('assign_supplier', $supplierId)
            ->firstOrFail();
        $type = strtolower(trim($booking->type ?? ''));
        $models = [
            'tour'     => [AddTour::class, 'add_tour_id'],
            'transfer' => [AddTransfer::class, 'add_transfer_id'],
            'hotel'    => [AddHotel::class, 'add_hotel_id'],
            'package'  => [AddPackage::class, 'add_package_id'],
            'ferry'    => [FerryTransfer::class, 'ferry_id'],
        ];
        $service = null;
        if (isset($models[$type])) {
            [$model, $key] = $models[$type];
            $service = $model::where($key, $booking->item_id)->first();
        }
        $image = null;
        if ($type === 'tour') {
            $img = AddTourImage::where('add_tour_id', $booking->item_id)
                ->orderByDesc('is_featured')
                ->get()
                ->first(fn ($item) =>
                    !empty($item->tour_images) ||
                    !empty($item->cloudnery_img) ||
                    !empty($item->cloudnary_img)
                );
            if ($img) {
                $imageName = $img->tour_images
                    ?: ($img->cloudnery_img ?: $img->cloudnary_img);
                if ($imageName && $img->img_type) {
                    $ext = ltrim(strtolower(trim($img->img_type)), '.');
                    if (!str_ends_with(strtolower($imageName), '.' . $ext)) {
                        $imageName .= '.' . $ext;
                    }
                }
                if ($imageName) {
                    $image = ImageHelper::path('tour', $imageName);
                }
            }
        } elseif ($type === 'transfer') {
            $img = AddTransferImage::where('add_transfer_id', $booking->item_id)
                ->orderByDesc('is_featured')
                ->get()
                ->first(fn ($item) =>
                    !empty($item->cloudnery_img) ||
                    !empty($item->cloudnary_img) ||
                    !empty($item->transfer_images)
                );
            if ($img) {
                $imageName = $img->cloudnery_img
                    ?: ($img->cloudnary_img ?: $img->transfer_images);
                if ($imageName && $img->img_type) {
                    $ext = ltrim(strtolower(trim($img->img_type)), '.');

                    if (!str_ends_with(strtolower($imageName), '.' . $ext)) {
                        $imageName .= '.' . $ext;
                    }
                }
                if ($imageName) {
                    $image = ImageHelper::path('transfer', $imageName);
                }
            }
        } elseif ($type === 'package') {
            $img = AddPackageImage::where('add_package_id', $booking->item_id)
                ->get()
                ->first(fn ($item) =>
                    !empty($item->cloudnery_img) ||
                    !empty($item->cloudnary_img) ||
                    !empty($item->package_image) ||
                    !empty($item->package_images)
                );
            if ($img) {
                $imageName = $img->cloudnery_img
                    ?: ($img->cloudnary_img
                    ?: ($img->package_image ?: $img->package_images));
                if ($imageName && $img->img_type) {
                    $ext = ltrim(strtolower(trim($img->img_type)), '.');
                    if (!str_ends_with(strtolower($imageName), '.' . $ext)) {
                        $imageName .= '.' . $ext;
                    }
                }
                if ($imageName) {
                    $image = ImageHelper::path('package', $imageName);
                }
            }
        } elseif ($type === 'ferry') {
            $img = FerriImage::where('ferry_id', $booking->item_id)
                ->get()
                ->first(fn ($item) =>
                    !empty($item->cloudnery_img) ||
                    !empty($item->cloudnary_img) ||
                    !empty($item->ferry_image) ||
                    !empty($item->ferry_images)
                );
            if ($img) {
                $imageName = $img->cloudnery_img
                    ?: ($img->cloudnary_img
                    ?: ($img->ferry_image ?: $img->ferry_images));
                if ($imageName && $img->img_type) {
                    $ext = ltrim(strtolower(trim($img->img_type)), '.');

                    if (!str_ends_with(strtolower($imageName), '.' . $ext)) {
                        $imageName .= '.' . $ext;
                    }
                }
                if ($imageName) {
                    $image = ImageHelper::path('ferry', $imageName);
                }
            }
        } elseif ($type === 'hotel') {
            $img = HotelImage::where('hotel_id', $booking->item_id)
                ->orderByDesc('is_featured')
                ->get()
                ->first(fn ($item) =>
                    !empty($item->cloudnery_img) ||
                    !empty($item->cloudnary_img) ||
                    !empty($item->hotel_image) ||
                    !empty($item->hotel_images)
                );
            if ($img) {
                $imageName = $img->cloudnery_img
                    ?: ($img->cloudnary_img
                    ?: ($img->hotel_image ?: $img->hotel_images));
                if ($imageName && $img->img_type) {
                    $ext = ltrim(strtolower(trim($img->img_type)), '.');

                    if (!str_ends_with(strtolower($imageName), '.' . $ext)) {
                        $imageName .= '.' . $ext;
                    }
                }
                if ($imageName) {
                    $image = ImageHelper::path('hotel', $imageName);
                }
            }
        }
        return view('supplier.bookings.new-voucher', compact('booking','service','type','image'));
    }
}
