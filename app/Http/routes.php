<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::get('socket', 'socketController@index');
Route::post('sendmessage', 'socketController@sendMessage');
Route::get('writemessage', 'socketController@writemessage');

/** Support Routes */
Route::group(['middleware' => 'web'], function () {
    Route::auth();
    
    Route::get('/social/redirect/{provider}', [
        'as' => 'social.redirect',
        'uses' => 'Auth\AuthController@getSocialRedirect'
    ]);

    Route::get('/social/handle/{provider}', [
        'as' => 'social.handle',
        'uses' => 'Auth\AuthController@getSocialHandle'
    ]);

    /** Users */
    Route::post('/user/create/', 'UsersController@register');

    /** Access to States and Cities from different places of code */
    Route::post('/get/states/', 'StatesController@statesByCountry');
    Route::post('/get/cities/', 'CityController@getCityByState');

});


Route::group([  'prefix'        => LaravelLocalization::setLocale(),
                'middleware'    => ['web', 'auth', 'roles'/*, 'localeSessionRedirect', 'localizationRedirect'*/],
                'roles'         => ['Alien', 'Male', 'Female']
], function(){
    Route::get('chat', 'ChatController@index');

    Route::post('chat/ajax', 'ChatController@ajax');
    /** Users profile */
    Route::get('profile/{id}', 'UsersController@edit');
    Route::get('profile/{id}/photo', 'UsersController@profilePhoto');
    Route::get('profile/{id}/albums', 'AlbumController@profileAlbum');
    Route::get('profile/{id}/video', 'UsersController@profileVideo');
    Route::get('profile/{id}/mail', 'MessagesController@index'); // Списки сообщений: исходящие, входящие и т.д.
    Route::get('profile/{id}/correspond/{cor_id}', 'MessagesController@show'); // Переписка с конкретным пользователем
    Route::get('profile/{id}/smiles', 'UsersController@profileSmiles');
    Route::get('profile/{id}/gifts', 'GiftsController@getGifts');
    Route::get('profile/{id}/presents/{girl_id}', 'GiftsController@getPresents');
    Route::get('profile/{id}/presents/{girl_id}/gift/{gift_id}', 'GiftsController@getOrderForm');

    Route::get('profile/{id}/horoscope/{cor_id}', 'HoroscopeController@show'); // Страница с кнопкой "Проверить совместимость"
    Route::get('profile/{id}/horoscope/{cor_id}/check', 'HoroscopeController@check'); // Страница с текстом совместимости по гороскопу
    Route::get('profile/{id}/contacts/{girl_id}', 'ContactsRequestController@showGirlContacts'); // Страница с кнопками "Запрос на имя, фамилию, телефон/емейл"
    Route::get('profile/{id}/contacts/{girl_id}/request_phone', 'ContactsRequestController@getGirlPhone'); // Функция получения имени, фамилии и телефона
    Route::get('profile/{id}/contacts/{girl_id}/request_email', 'ContactsRequestController@getGirlEmail'); // Функция получения имени, фамилии и e-mail
    Route::get('profile/{id}/finance', 'ClientFinanceController@show');

    Route::get('profile/{id}/add/{cor_id}/to_list/{list}', 'ListsController@addToList');// Добавить пользователя в определенный список: к фаворитам или черный список
    Route::get('profile/{id}/remove/{cor_id}/from_list/{list}', 'ListsController@removeFromList');// Удалить пользователя из списка

    Route::get('profile/activate/{id}', 'UsersController@activate'); // Активировать аккаунт
    Route::get('profile/deactivate/{id}', 'UsersController@deactivate'); // Деактивировать аккаунт
    Route::get('profile/drop/{id}', 'UsersController@delete'); // Удалить аккаунт

    Route::post('profile/correspond', 'MessagesController@sendMessage');
    Route::post('profile/{id}/photo', 'UsersController@profilePhotoAdd');
    Route::post('profile/dropProfilePhoto/{photo_id}', 'UsersController@profilePhotoDelete'); // Delete photo from Girl

    Route::post('profile/update/{id}', 'UsersController@update');
    Route::post('profile/{id}/gift/order', 'GiftsController@order');


    /* Albums */
    Route::get('profile/{id}/add_album', 'AlbumController@createAlbum'); // Create album form
    Route::get('profile/{id}/edit_album/{aid}', 'AlbumController@editAlbum'); // Edit album form

    Route::post('profile/{id}/add_album', 'AlbumController@addAlbum'); // Create and save albums and inner photos
    Route::post('profile/{id}/edit_album/{aid}', 'AlbumController@saveAlbum'); // Save editing albums
    Route::post('profile/dropImageAlbum/{aid}', 'AlbumController@dropImageAlbum'); // Delete photo from albums
    Route::post('profile/deleteAlbum/{albumID}', 'AlbumController@deleteAlbum'); // Delete album with inner photo

    /** Videos */

    Route::get('profile/{id}/video/show/{vid}', 'VideoController@show');// Show one choosen video

    Route::post('profile/{id}/video/add', 'VideoController@addVideo');// Add video to profile
    Route::post('profile/deleteVideo/{videoID}', 'VideoController@deleteVideo');// Delete video from profile

    /* Winks */

    Route::post('wink', 'SmilesController@sendSmile');
    Route::get('wink', 'SmilesController@getSmileFromUser');
});


/** Admin route group */
Route::group([  'prefix' => LaravelLocalization::setLocale().'/admin',
                'middleware' => ['web', 'auth', 'roles'/*,'localeSessionRedirect', 'localizationRedirect'*/],
                'roles' => ['Owner', 'Moder', 'Partner']
], function(){

    Route::get('/', function(){
        return redirect('admin/dashboard');
    });

    Route::get('dashboard', 'Admin\AdminController@dashboard');
    Route::get('profile', 'Admin\AdminController@profile'); //end

    Route::post('profile', 'Admin\AdminController@profile_update');

    /** Start Blog Routing */
    Route::get('blog', 'Admin\BlogController@index');
    Route::get('blog/new', 'Admin\BlogController@create');

    Route::get('blog/edit/{id}','Admin\BlogController@edit');
    Route::get('blog/drop/{id}', 'Admin\BlogController@destroy');

    Route::post('blog/new', 'Admin\BlogController@store');
    Route::post('blog/update', 'Admin\BlogController@update');
    /** Stop Blog Routing */

    /** Start Mailer sender delivery */
    Route::get('sender', 'Admin\MessageSenderController@index');
    Route::get('sender/new/{girl_id}', 'Admin\MessageSenderController@create');
    Route::get('sender/edit/{id}','Admin\MessageSenderController@edit');
    Route::get('sender/drop/{id}', 'Admin\MessageSenderController@destroy');
    Route::get('sender/send/{id}', 'Admin\MessageSenderController@send');

    Route::post('sender', 'Admin\MessageSenderController@index');
    Route::post('sender/store', 'Admin\MessageSenderController@store');
    Route::post('sender/update', 'Admin\MessageSenderController@update');
    Route::post('sender/ajax', 'Admin\MessageSenderController@ajax');
    /** End Mailer sender delivery */

    /** Start Partners Profile routing */
    Route::get('partners', 'Admin\PartnerController@index');
    Route::get('partner/new', 'Admin\PartnerController@create');
    Route::get('partner/show/{id}', 'Admin\PartnerController@show');
    Route::get('partner/edit/{id}', 'Admin\PartnerController@edit');
    Route::get('partner/drop/{id}', 'Admin\PartnerController@destroy');
    Route::get('partner/activate/{id}', 'Admin\PartnerController@activate');//Активация анкеты девушки
    Route::get('partner/deactivate/{id}', 'Admin\PartnerController@deactivate'); //Деактивация анкеты девушки

    Route::post('partner/store', 'Admin\PartnerController@store');
    Route::post('partner/edit/{id}', 'Admin\PartnerController@update');

    /** End partners profile routing */

    /** Start Moderator Profile routing */
    Route::get('moderators', 'Admin\ModeratorController@index');
    Route::get('moderator/new', 'Admin\ModeratorController@create');
    Route::get('moderator/show/{id}', 'Admin\ModeratorController@show');
    Route::get('moderator/edit/{id}', 'Admin\ModeratorController@edit');
    Route::get('moderator/drop/{id}', 'Admin\ModeratorController@destroy');

    Route::post('moderator/store', 'Admin\ModeratorController@store');
    Route::post('moderator/edit/{id}', 'Admin\ModeratorController@update');
    /** End Moderator Profile routing */

    /** Start Girls Profile routing */
    Route::get('girls', 'Admin\GirlsController@index'); //All
    Route::get('girl/new', 'Admin\GirlsController@create'); //Add new

    Route::get('girl/edit/{id}', 'Admin\GirlsController@edit'); // Edit Girl profile
    Route::get('girl/edit/{id}/add_album', 'Admin\GirlsController@createAlbum'); // Create Girl albums
    Route::get('girl/edit/{id}/edit_album/{aid}', 'Admin\GirlsController@editAlbum'); // Edit Girl albums

    Route::get('girl/activate/{id}', 'Admin\GirlsController@activate'); // Активировать аккаунт девушки
    Route::get('girl/deactivate/{id}', 'Admin\GirlsController@deactivate'); // Деактивировать аккаунт девушки
    Route::get('girl/drop/{id}', 'Admin\GirlsController@destroy');//
    Route::get('girl/restore/{id}', 'Admin\GirlsController@restore');
    Route::post('girl/edit/{id}/add_album', 'Admin\GirlsController@addAlbum'); // Create Girl save albums
    Route::post('girl/edit/{id}/edit_album/{aid}', 'Admin\GirlsController@saveAlbum'); // Save editing Girl albums
    Route::post('girl/dropImageAlbum/{aid}', 'Admin\GirlsController@dropImageAlbum'); // Delete photo from Girl albums
    Route::post('girl/dropProfileFoto/{fid}', 'Admin\GirlsController@dropProfileFoto'); // Delete photo from Girl albums
    Route::post('girl/deleteAlbum/{albumID}', 'Admin\GirlsController@deleteAlbum'); // Edit Girl save albums

    Route::post('girl/{id}/video/add', 'Admin\GirlsController@addVideo');// Add video to profile
    Route::post('girl/deleteVideo/{videoID}', 'Admin\GirlsController@deleteVideo');// Delete video from profile

    Route::post('girl/check', ['as' => 'check_pass', 'uses' => 'Admin\GirlsController@check']); // Check passport at DB
    Route::post('girl/store', 'Admin\GirlsController@store'); //Store new to db
    Route::post('girl/edit/{id}','Admin\GirlsController@update');// Update db
    Route::post('girl/changepartner', 'Admin\GirlsController@changePartner'); //change girlStatus from edit profile page

    Route::get('girls/{status}', 'Admin\GirlsController@getByStatus'); //Return all by status
    /** End Girls Profile routing */

    /** Start Men Profile routing **/
    Route::get('men', 'Admin\ManController@index'); //All
    Route::get('man/edit/{id}', 'Admin\ManController@edit'); // Edit man profile

    Route::get('man/activate/{id}', 'Admin\ManController@activate'); // Активировать аккаунт мужчины
    Route::get('man/deactivate/{id}', 'Admin\ManController@deactivate'); // Деактивировать аккаунт мужчины
    Route::get('man/drop/{id}', 'Admin\ManController@destroy');
    Route::get('man/restore/{id}', 'Admin\ManController@restore');

    Route::post('man/dropProfileFoto/{fid}', 'Admin\ManController@dropProfileFoto'); // Delete photo from man profile
    Route::post('man/edit/{id}','Admin\ManController@update');// Update db

    Route::post('man/{id}/video/add', 'Admin\ManController@addVideo');// Add video to profile
    Route::post('man/deleteVideo/{videoID}', 'Admin\ManController@deleteVideo');// Delete video from profile


    Route::get('man/{status}', 'Admin\ManController@getByStatus'); //Return all by status
    /** End Men Profile routing **/


    /** Start Presents  */ /* Подарки */
    Route::get('presents/', 'Admin\PresentsController@index');
    Route::get('presents/new', 'Admin\PresentsController@create');
    Route::get('presents/edit/{id}', 'Admin\PresentsController@edit');
    Route::get('presents/drop/{id}', 'Admin\PresentsController@drop');

    Route::post('presents/store', 'Admin\PresentsController@store');
    Route::post('presents/update/{id}', 'Admin\PresentsController@update');

    Route::post('presents/check_lang', ['as' => 'check_lang', 'uses' => 'Admin\PresentsController@check_language']);
    Route::post('presents/save_present_translation', ['as' => 'save_present_translation', 'uses' => 'Admin\PresentsController@save_present_translation']);
    /** End Presents */

    /** Gifts **/ /* Подарки, заказанные мужчинами */

    Route::get('gifts/status/{status}', 'Admin\GiftsController@getGiftsByStatus');
    Route::get('gifts/edit/{id}', 'Admin\GiftsController@edit');
    Route::get('gifts/drop/{id}', 'Admin\GiftsController@drop');

    Route::post('gifts/update/{id}', 'Admin\GiftsController@update');

    /** End gifts **/

    /** Messages from man **/

    Route::get('messages-from-man', 'Admin\MessagesFromManController@index'); // Список сообщений от мужчин
    Route::get('messages-from-man/{man_id}/correspond/{girl_id}', 'Admin\MessagesFromManController@show'); // Переписка с мужчиной
    Route::post('messages-from-man/correspond', 'Admin\MessagesFromManController@sendMessage');
    /** End Messages From Man **/

    /** Ticket System Routes */
    Route::get('support', 'Admin\TicketController@index');
    Route::get('support/new', 'Admin\TicketController@newTicket');
    Route::get('support/show/{ticket_id}', 'Admin\TicketController@show'); // show one ticket

    Route::get('support/answered', 'Admin\TicketController@answered');
    Route::get('support/closed', 'Admin\TicketController@closed');

    Route::post('support', 'Admin\TicketController@create'); //create new ticket
    Route::post('support/show/{ticket_id}', 'Admin\TicketController@answer');
    Route::post('support/close/{ticket_id}', 'Admin\TicketController@close');
    Route::post('support/{ticket_id}', 'Admin\TicketController@answer'); //add new answer to ticket
    /** End ticket System Routes */

    /** Finance */
    Route::get('finance/prices', 'Admin\PriceController@getPrices');
    Route::get('finance/rates', 'Admin\PriceController@getRates');

    Route::post('finance/prices', 'Admin\PriceController@setPrice');
    Route::post('finance/rates', 'Admin\PriceController@setRate');

    Route::get('finance/clients/general-stat', 'Admin\ClientFinanceController@getGeneralStat');
    Route::match(['get', 'post'], 'finance/clients/deposits', 'Admin\ClientFinanceController@getDeposits');
    Route::match(['get', 'post'], 'finance/clients/expenses', 'Admin\ClientFinanceController@getExpenses');
    Route::match(['get', 'post'], 'finance/clients/refunds', 'Admin\ClientFinanceController@getRefunds');
    Route::match(['get', 'post'], 'finance/clients/detail-stat/{user_id}', 'Admin\ClientFinanceController@getDetailStat');

    Route::get('finance/clients/debit/{user_id}', 'Admin\ClientFinanceController@getDebitForm');
    Route::get('finance/clients/refund/{user_id}', 'Admin\ClientFinanceController@getRefundForm');
    Route::post('finance/clients/debit/{user_id}', 'Admin\ClientFinanceController@saveDebit');
    Route::post('finance/clients/refund/{user_id}', 'Admin\ClientFinanceController@saveRefund');

    Route::get('finance/partners/general-stat', 'Admin\PartnerFinanceController@getGeneralStat');
    Route::match(['get', 'post'], 'finance/partners/detail-stat/{partner_id}', 'Admin\PartnerFinanceController@getDetailStat');
    Route::match(['get', 'post'], 'finance/partners/fines', 'Admin\PartnerFinanceController@getFines');

    Route::get('finance/partners/payment/{partner_id}', 'Admin\PartnerFinanceController@getPartnerPaymentForm');
    Route::get('finance/partners/fine/{partner_id}', 'Admin\PartnerFinanceController@getPartnerFineForm');
    Route::post('finance/partners/payment/{partner_id}', 'Admin\PartnerFinanceController@savePartnerPayment');
    Route::post('finance/partners/fine/{partner_id}', 'Admin\PartnerFinanceController@savePartnerFine');

    /* End finance */

    /** Pages */
    Route::get('pages', 'Admin\PagesController@index');
    Route::get('pages/add', 'Admin\PagesController@create');
    Route::get('pages/edit/{id}', 'Admin\PagesController@edit');
    Route::get('pages/drop/{id}', 'Admin\PagesController@destroy');

    Route::post('pages/add', 'Admin\PagesController@store');
    Route::post('pages/edit/{id}', 'Admin\PagesController@update');
    Route::post('pages/dropFile', 'Admin\PagesController@dropFile');
    /** End pages */

    /** Horoscope */
    Route::get('horoscope', 'Admin\HoroscopeController@index');
    Route::get('horoscope/add', 'Admin\HoroscopeController@create');
    Route::get('horoscope/edit/{id}', 'Admin\HoroscopeController@edit');

    Route::post('horoscope/add', 'Admin\HoroscopeController@store');
    Route::post('horoscope/edit/{id}', 'Admin\HoroscopeController@update');
    /** End horoscope */

});


/**
 *  Free Routes
 */

Route::group([ 'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect'],
], function(){
    Route::get('/','HomeController@index');
    Route::get('contacts', 'ContactsController@show');
    Route::get('contacts/tickets', 'TicketController@index');
    Route::get('contacts/tickets/close/{id}', 'TicketController@closeTicket');
    Route::post('contacts/tickets/create', 'TicketController@createTicket');
    Route::post('contacts/tickets/reply/{id}', 'TicketController@createReply');
    Route::post('contacts/message', 'ContactsController@sendMessage');


    Route::get('blog', 'BlogController@all');
    Route::get('blog/{id}', 'BlogController@post');
    Route::get('pricing', 'PriceController@index');
    Route::get('search', 'SearchController@index');
    Route::post('search', 'SearchController@search');

    Route::get('users/online', 'UsersController@online');

    Route::get('profile/show/{id}', 'UsersController@show');
    Route::get('profile/{id}/show_album/{aid}', 'AlbumController@showAlbum'); // Edit album

    /** Pages */
    Route::get('{slug}', 'PagesController@show');
});

Route::post('sendmessage', 'ChatController@sendMessage');
