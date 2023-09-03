<?php

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartPlaceController;
use App\Http\Controllers\Api\CartProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryProductController;
use App\Http\Controllers\Api\CategoryFasilitasController;
use App\Http\Controllers\Api\FasilitasController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\LokasiController;
use App\Http\Controllers\Api\PrductPlaceController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TempatController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\PengunjungController;
use App\Http\Controllers\Api\HistorySearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::put('update-profil/{id}', [AuthController::class, 'update']);
Route::post('upload-imguser/{id}', [AuthController::class, 'upload']);

Route::get('find/{cari}', [HomeController::class, 'finding']);

Route::get('home', [HomeController::class, 'getHome']);
Route::get('homekategori', [HomeController::class, 'getHomeCategory']);
Route::get('homeslider', [HomeController::class, 'getHomeSlider']);
Route::get('newplace', [HomeController::class, 'newPlace']);
Route::get('new-place-all', [HomeController::class, 'newPlaceAll']);

Route::get('tempat-detail/{id}', [TempatController::class, 'detailTempat']);
Route::get('findRelated/{cari}', [TempatController::class, 'findRelated']);
Route::get('product-placedetail/{id}', [PrductPlaceController::class,'menuproduct']);
Route::get('fasilitas-placedetail/{id}', [FasilitasController::class,'menufasilitas']);
Route::get('showreview/{tempatId}', [RatingController::class,'showReview']);

Route::resource('tempat', TempatController::class);
Route::get('tempat-user/{id}', [TempatController::class, 'cekTempat']);
Route::post('upload-imageTe', [TempatController::class, 'uploadImgTempat']);
Route::post('upload-imagePe', [TempatController::class, 'uploadImgPemilik']);
Route::put('totalReview', [TempatController::class,'updateTotalByUlasan']);

Route::post('upload/{path}', [BaseController::class, 'upload']);

Route::get('category-show', [CategoryController::class,'tampil']);
Route::get('categoryproduct-show', [CategoryProductController::class,'tampil']);
Route::get('categoryfasilitas-show', [CategoryFasilitasController::class,'tampil']);

Route::get('get-place-by-fasilitas/{id}', [FasilitasController::class,'getPlace']);
Route::get('show-place-age/{userId?}', [PengunjungController::class,'showPlace']);

Route::resource('category-product', CategoryProductController::class);
Route::resource('category-fasilitas', CategoryFasilitasController::class);
Route::resource('category', CategoryController::class);

Route::resource('history-search', HistorySearchController::class);
Route::get('show-search-by-userId/{userId}', [HistorySearchController::class,'showByUserId']);

Route::middleware('user')->group(function (){

    Route::resource('rating', RatingController::class);
    Route::get('rating-place/{id}', [RatingController::class, 'ulasan']);
    Route::get('rating-placeAll/{id}', [RatingController::class, 'ulasanAll']);
    Route::get('review-ulasan-tempat/{tempatId}', [RatingController::class,'Review']);
    Route::get('review-ulasan-pribadi/{userId}', [RatingController::class,'ReviewMySelf']);
    Route::get('review-ulasan-potensi/{tempatId}', [RatingController::class,'showReviewsMax']);
    Route::get('review-ulasan-nopotensi/{tempatId}', [RatingController::class,'showReviewsMin']);
    Route::post('chek-review', [RatingController::class,'cekUlasan']);
    Route::put('review', [RatingController::class,'updateJumlah']);

    Route::resource('lokasi-tempat', LokasiController::class);

    Route::resource('product-place', PrductPlaceController::class);
    Route::post('upload-image', [PrductPlaceController::class, 'upload']);

    Route::resource('fasilitas-place', FasilitasController::class);
    Route::post('upload-imageFa', [FasilitasController::class, 'upload']);

    Route::resource('cart-Store', CartController::class);
    Route::put('cart-Update-Store', [CartController::class, 'updateCartStore']);
    Route::put('cart-Update-Product', [CartController::class, 'updateCartProduct']);

    Route::resource('keranjang-product', CartProductController::class);
    Route::get('view-order-by-place/{tempatId}', [CartProductController::class,'viewOrderByPlace']);
    Route::get('view-by-userId/{userId}', [CartProductController::class,'viewByUserID']);
    Route::get('view-by-order/{userId}', [CartProductController::class,'viewByOrder']);
    Route::put('order/{userId}', [CartProductController::class,'Order']);
    Route::put('finish-Konfir/{userId}', [CartProductController::class,'finishKonfir']);
    Route::get('view-history-transaksi/{cartPlace}', [CartProductController::class,'viewHistoryProductUser']);
    Route::put('addId-CartPlace', [CartProductController::class,'addIdCartPlace']);

    Route::resource('keranjang-place', CartPlaceController::class);
    Route::get('view-bayar/{userId}', [CartPlaceController::class,'viewUserId']);
    Route::get('view-konfir-bayar/{tempatId}', [CartPlaceController::class,'viewTempatId']);
    Route::get('view-history-user/{userId}', [CartPlaceController::class,'viewisActiveOff']);
    Route::get('view-histroy-place/{tempatId}', [CartPlaceController::class,'viewHistoryOrder']);
    Route::put('konfir-status/{id}', [CartPlaceController::class,'konfirmation']); 

    Route::resource('cart-Favorite', FavoriteController::class);
    Route::post('cek-favorit', [FavoriteController::class,'cekFavorite']);

    Route::resource('pengunjung-place', PengunjungController::class);
    
});

Route::middleware('admin')->group(function (){

    Route::get('view-confirmation-place', [TempatController::class, 'viewConfirmation']);
    Route::get('view-detail-place/{id}', [TempatController::class, 'detailTempatConfir']);
    Route::put('confirmation-place/{Tempat}', [TempatController::class, 'updateConfimation']);
    Route::delete('delete-place/{id}', [TempatController::class, 'deletePlace']);

    Route::resource('slider', SliderController::class);

});







