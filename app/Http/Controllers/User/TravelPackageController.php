<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\TravelPackage; 
use App\Category;

class TravelPackageController extends Controller
{
  	protected object $travel_package,
                     $category;

  	public function __construct(TravelPackage $tp)
  	{
  		  $this->travel_package = $tp;
  	}

    public function index()
    {
      	$travelPackages = $this->travel_package->with('galleries')->paginate(9);
        return request()->isJson() ? view('user.travel-packages.card', compact('travelPackages'))
                                   : view('user.travel-packages.index', compact('travelPackages'));

    }

    /**
     * Perform a search features using ajax
     *
     * @return card view
     */
    public function search()
    {
        $travelPackages = $this->travel_package->getByKeyword(request()->query('keyword'));
        return (request()->isJson()) ? view('user.travel-packages.card', compact('travelPackages'))
                                     : view('user.travel-packages.index', compact('travelPackages'));
    }

    public function category(Category $category)
    {
        $travelPackages = ($category->title == 'All') ? $this->travel_package->with('galleries')->inRandomOrder()->paginate(9)
                                                    : $category->travel_packages()->with('galleries')->paginate(9);

        return request()->isJson() ? view('user.travel-packages.card', compact('travelPackages'))
                                   : view('user.travel-packages.index', compact('travelPackages'));           
    }

    public function show($slug)
    {
        $travelPackage = $this->travel_package
                              ->with(['galleries'])
                              ->where('slug', $slug)
                              ->firstOrFail();

        $transaction = $travelPackage->transactions()
                                     ->where('user_id', auth()->id())
                                     ->where('transaction_status_id', 1)
                                     ->with(['details'])
                                     ->first();

        return view('user.travel-packages.detail', compact('travelPackage', 'transaction'));
    }
}
