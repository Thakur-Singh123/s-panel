<?php

namespace App\Http\Controllers\Supplier\Tour;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddTour;
use App\Models\AddTourImage;
use App\Helpers\ImageHelper;

class TourController extends Controller
{
    //Function for tours
    public function index(Request $request) {
        //LOGGED IN SUPPLIER ID
        $supplierId = session('supplier_id');
        //TOUR QUERY
        $supplierTours = AddTour::query();
        if (!empty($supplierId)) {
            $supplierTours->where('assign_supplier', $supplierId);
        } else {
            $supplierTours->whereRaw('1 = 0');
        }
        //Filtered query for tour listing
        $query = clone $supplierTours;
        //LOCATION FILTER
        if ($request->filled('location')) {
            $query->where(
                'tour_location',
                $request->location
            );
        }
        //STATUS FILTER
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where(
                    'isactive',
                    1
                );
            } elseif ($request->status === 'inactive') {
                $query->where(
                    'isactive',
                    0
                );
            }
        }
        //APPROVAL FILTER
        if ($request->filled('approval')) {
            if ($request->approval === 'approved') {
                $query->where(
                    'approved',
                    1
                );
            } elseif ($request->approval === 'pending') {
                $query->where(function ($q) {
                    $q->whereNull('approved')
                      ->orWhere(
                          'approved',
                          '!=',
                          1
                      );

                });
            }
        }
        //PRODUCT ID
        if ($request->filled('product_id')) {
            $query->where(
                'add_tour_id',
                $request->product_id
            );
        }
        //TOUR NAME
        if ($request->filled('tour_name')) {
            $query->where(
                'title_of_tour',
                'LIKE',
                '%' . $request->tour_name . '%'
            );
        }
        //GET TOURS
        $tours = $query->orderByDesc('add_tour_id')->paginate(10)->withQueryString();
        //GET TOUR IMAGES
        foreach ($tours as $tour) {
            $tour->image = null;
            $tourImage = AddTourImage::where(
                'add_tour_id',
                $tour->add_tour_id
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
                if (!empty($imageName)) {
                    $extension = pathinfo(
                        $imageName,
                        PATHINFO_EXTENSION
                    );
                    if (empty($extension) && !empty($tourImage->img_type)) {
                        $imgType = strtolower(
                            trim($tourImage->img_type)
                        );
                        $imgType = ltrim(
                            $imgType,
                            '.'
                        );
                        if ($imgType === 'jpeg') {
                            $imgType = 'jpg';
                        }
                        $imageName .= '.' . $imgType;
                    }
                    $tour->image = ImageHelper::path(
                        'tour',
                        $imageName
                    );
                }
            }
        }
        //COUNTS
        $totalTours = (clone $supplierTours)->count();
        $activeTours = (clone $supplierTours)->where('isactive', 1)->count();
        $inactiveTours = (clone $supplierTours)->where('isactive', 0)->count();
        $pendingApproval = (clone $supplierTours)->where(function ($q) {
                $q->whereNull('approved')
                ->orWhere('approved', '!=', 1);
            })
        ->count();
        //LOCATIONS
        $locations = (clone $supplierTours)
            ->whereNotNull('tour_location')
            ->where('tour_location', '!=', '')
            ->select('tour_location')
            ->distinct()
            ->orderBy('tour_location')
            ->pluck('tour_location');

        return view('supplier.tours.tour-list', compact('tours','totalTours','activeTours','inactiveTours','pendingApproval','locations'));
    }
}
