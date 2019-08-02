<?php

use Illuminate\Http\Request;
//master backend 
route::get('test','SuperAdminController@test');

Route::get('master_backend_26',function (){
    if(!Auth::check()){
        return view('master_backend.login');
    }else{
        return redirect()->back();
    }
   
});
Route::post('master-admin-login','MasterBackendController@login');
Route::any( 'admin_confirm','MasterBackendController@confirm');
Route::get('master_redirect/{id}','MasterBackendController@redirect')->middleware('Master_access');

Route::group(['middleware' => 'Master_access'], function () {
    Route::get('see_permission', 'SuperAdminController@see_permission');
    Route::get('all_permission', 'SuperAdminController@all_permission');
    Route::get('manage_permission', 'SuperAdminController@manage_permission');

});


//end of master backend

Route::get('errors',function(){
 return view('errors.503');
})->name('errors');

//switching a/c
Route::get('switch_to/{type}/{slag}', 'UserController@swithcing');
//pin
Route::post('verification_user','CustomVerificationController@pin');
Route::get('verification_user_ajax','CustomVerificationController@pin_check');
Route::get('reset_pin','CustomVerificationController@reset');
Route::get('resetpin_conf/{str}','CustomVerificationController@reset_conf');
Route::get('reset_form',function (){
    return view('reset_form');
});
Route::post('reset_form','CustomVerificationController@reset_form_conf');
Route::get('get_email','SuperAdminController@get_email');
Route::post('set_permission','SuperAdminController@set_permission');

Auth::routes();
// Cache clear route
Route::group(['middleware' => 'Permission_check:server_module'], function () {
    Route::get(
        'cache-clear',
        function () {
            $exitCode = \Artisan::call('cache:clear');
            $exitCode = \Artisan::call('route:clear');
            $exitCode = \Artisan::call('config:clear');
            $exitCode = \Artisan::call('view:clear');
            return redirect()->back();
        }
    );   
});

// Home
Route::get(
    '/freelancer-dashboard',
    function () {
        if (Schema::hasTable('users')) {
            return view('front-end.index');
        } else {
            if (!empty(env('DB_DATABASE'))) {
                return Redirect::to('/install');
            } else {
                return trans('lang.configure_database');
            }
        }
    }
)->name('home');
Route::get(
    '/home',
    function () {
        return Redirect::to('/');
    }
);
Route::get('/',function(){
    $open=Session::get('open');
    if(isset($open) && $open!=null){
        return redirect('/site_landing');
    }else{
        return view('commingsoon');
    }
});
Route::post('/open',function(Request $request){
    if($request->open == 'MATUL123'){
        Session::put('open','open');
        return redirect('site_landing');
    }else{
        return redirect()->back();
    }
});
Route::get('/site_landing','LandingController@index');
Route::get('job/{slug}', 'JobController@show')->name('jobDetail');
Route::get('profile/{slug}', 'PublicController@showUserProfile')->name('showUserProfile');
Route::get('categories', 'CategoryController@categoriesList')->name('categoriesList');
Route::get('page/{slug}', 'PageController@show')->name('showPage');
Route::post('store/project-offer', 'UserController@storeProjectOffers');
Route::get('jobs', 'JobController@listjobs')->name('jobs');
Route::get('user/password/reset/{verify_code}', 'PublicController@resetPasswordView')->name('getResetPassView');
Route::post('user/update/password', 'PublicController@resetUserPassword')->name('resetUserPassword');
// Authentication|Guest Routes
Route::post('register/login-register-user', 'PublicController@loginUser')->name('loginUser');
Route::post('register/verify-user-code', 'PublicController@verifyUserCode');
Route::post('register/form-step1-custom-errors', 'PublicController@RegisterStep1Validation');
Route::post('register/form-step2-custom-errors', 'PublicController@RegisterStep2Validation');
Route::get('search-results', 'PublicController@getSearchResult')->name('searchResults');
Route::post('user/add-wishlist', 'UserController@addWishlist');
// Admin Routes
Route::group(['middleware' => ['role:admin', 'Permission_check:server_module']], function () {
    Route::post('admin/clear-cache', 'SiteManagementController@clearCache');
    Route::get('admin/clear-allcache', 'SiteManagementController@clearAllCache');
    Route::get('admin/import-demo', 'SiteManagementController@importDemo');
    Route::get('admin/remove-demo', 'SiteManagementController@removeDemoContent');
});
Route::group(['middleware' => ['role:admin', 'Permission_check:settings_module']], function () {
    Route::get('admin/home-page-settings', 'SiteManagementController@homePageSettings')->name('homePageSettings');
    Route::get('admin/settings/a', 'SiteManagementController@Settings')->name('settings');
    Route::get('admin/languages', 'LanguageController@index')->name('languages');
    Route::get('admin/languages/edit-langs/{id}', 'LanguageController@edit')->name('editLanguages');
    Route::get('admin/review-options', 'ReviewController@index')->name('reviewOptions');
    Route::get('admin/review-options/edit-review-options/{id}', 'ReviewController@edit')->name('editReviewOptions');
    Route::post('admin/store-review-options', 'ReviewController@store');
    Route::post('admin/review-options/delete-review-options', 'ReviewController@destroy');
    Route::post('admin/review-options/update-review-options/{id}', 'ReviewController@update');
    Route::post('admin/delete-checked-rev-options', 'ReviewController@deleteSelected');
});
Route::group(['middleware' => ['role:admin', 'Permission_check:payout_module']], function () {
    Route::get('admin/payouts', 'UserController@getPayouts')->name('adminPayouts');
    Route::get('admin/payouts/download/{year}', 'UserController@generatePDF');
});
Route::group(['middleware' => ['role:admin', 'Permission_check:user_management_module']], function () {
    Route::get('users', 'UserController@userListing')->name('userListing');
});
Route::group(
    ['middleware' => ['role:admin', 'Permission_check:freelancer_module']],
    function () {
             
        Route::post('admin/get-page-option', 'SiteManagementController@getPageOption');
        // Skill Routes
        Route::get('admin/skills', 'SkillController@index')->name('skills');
        Route::get('admin/skills/edit-skills/{id}', 'SkillController@edit')->name('editSkill');
        Route::post('admin/store-skill', 'SkillController@store');
        Route::post('admin/skills/update-skills/{id}', 'SkillController@update');
        Route::get('admin/skills/search', 'SkillController@index');
        Route::post('admin/skills/delete-skills', 'SkillController@destroy');
        Route::post('admin/delete-checked-skills', 'SkillController@deleteSelected');
        // Department Routes
        Route::get('admin/departments', 'DepartmentController@index')->name('departments');
        Route::get('admin/departments/edit-dpts/{id}', 'DepartmentController@edit')->name('editDepartment');
        Route::post('admin/store-department', 'DepartmentController@store');
        Route::get('admin/departments/search', 'DepartmentController@index');
        Route::post('admin/departments/delete-dpts', 'DepartmentController@destroy');
        Route::post('admin/departments/update-dpts/{id}', 'DepartmentController@update');
        Route::post('admin/delete-checked-dpts', 'DepartmentController@deleteSelected');
        // Language Routes
       
        Route::post('admin/store-language', 'LanguageController@store');
        Route::get('admin/languages/search', 'LanguageController@index');
        Route::post('admin/languages/delete-langs', 'LanguageController@destroy');
        Route::post('admin/languages/update-langs/{id}', 'LanguageController@update');
        Route::post('admin/delete-checked-langs', 'LanguageController@deleteSelected');
        // Category Routes
        Route::get('admin/categories', 'CategoryController@index')->name('categories');
        Route::get('admin/categories/edit-cats/{id}', 'CategoryController@edit')->name('editCategories');
        Route::post('admin/store-category', 'CategoryController@store');
        Route::get('admin/categories/search', 'CategoryController@index');
        Route::post('admin/categories/delete-cats', 'CategoryController@destroy');
        Route::post('admin/categories/update-cats/{id}', 'CategoryController@update');
        Route::post('admin/categories/upload-temp-image', 'CategoryController@uploadTempImage');
        Route::post('admin/delete-checked-cats', 'CategoryController@deleteSelected');
        // Badges Routes
        Route::get('admin/badges', 'BadgeController@index')->name('badges');
        Route::get('admin/badges/edit-badges/{id}', 'BadgeController@edit')->name('editbadges');
        Route::post('admin/store-badge', 'BadgeController@store');
        Route::get('admin/badges/search', 'BadgeController@index');
        Route::post('admin/badges/delete-badges', 'BadgeController@destroy');
        Route::post('admin/badges/update-badges/{id}', 'BadgeController@update');
        Route::post('admin/badges/upload-temp-image', 'BadgeController@uploadTempImage');
        Route::post('admin/delete-checked-badges', 'BadgeController@deleteSelected');
        // Location Routes
        Route::get('admin/locations', 'LocationController@index')->name('locations');
        Route::get('admin/locations/edit-locations/{id}', 'LocationController@edit')->name('editLocations');
        Route::post('admin/store-location', 'LocationController@store');
        Route::post('admin/locations/delete-locations', 'LocationController@destroy');
        Route::post('/admin/locations/update-location/{id}', 'LocationController@update');
        Route::post('admin/get-location-flag', 'LocationController@getFlag');
        Route::post('admin/locations/upload-temp-image', 'LocationController@uploadTempImage');
        Route::post('admin/delete-checked-locs', 'LocationController@deleteSelected');
        // Review Options Routes
       
        // Site Management Routes
       
        Route::post('admin/store/email-settings', 'SiteManagementController@storeEmailSettings');
        Route::post('admin/store/home-settings', 'SiteManagementController@storeHomeSettings');
        Route::get('admin/get-section-display-setting', 'SiteManagementController@getSectionDisplaySetting');
        Route::get('admin/get-chat-display-setting', 'SiteManagementController@getchatDisplaySetting');
        Route::post('admin/store/section-settings', 'SiteManagementController@storeSectionSettings');
        Route::post('admin/store/settings', 'SiteManagementController@storeGeneralSettings');
        // Route::get('admin/theme-style-settings', 'SiteManagementController@ThemeStyleSettings');
        Route::post('admin/store/theme-styling-settings', 'SiteManagementController@storeThemeStylingSettings');
        Route::get('admin/get-theme-color-display-setting', 'SiteManagementController@getThemeColorDisplaySetting');
        Route::post('admin/store/registration-settings', 'SiteManagementController@storeRegistrationSettings');
        Route::post('admin/upload-temp-image/{file_name}', 'SiteManagementController@uploadTempImage');
        Route::post('admin/store/upload-icons', 'SiteManagementController@storeDashboardIcons');
        Route::post('admin/store/footer-settings', 'SiteManagementController@storeFooterSettings');
        Route::post('admin/store/social-settings', 'SiteManagementController@storeSocialSettings');
        Route::post('admin/store/search-menu', 'SiteManagementController@storeSearchMenu');
        Route::post('admin/store/commision-settings', 'SiteManagementController@storeCommisionSettings');
        Route::post('admin/store/payment-settings', 'SiteManagementController@storePaymentSettings');
        Route::post('admin/store/stripe-payment-settings', 'SiteManagementController@storeStripeSettings');
        Route::get('admin/email-templates', 'EmailTemplateController@index')->name('emailTemplates');
        Route::get('admin/email-templates/{id}', 'EmailTemplateController@edit')->name('editEmailTemplates');
        Route::post('admin/email-templates/update-content', 'EmailTemplateController@updateTemplateContent');
        Route::post('admin/email-templates/update-templates/{id}', 'EmailTemplateController@update');
        // Pages Routes
        Route::get('admin/pages', 'PageController@index')->name('admin_pages');
        Route::get('admin/create/pages', 'PageController@create')->name('createPage');
        Route::get('admin/pages/edit-page/{id}', 'PageController@edit')->name('editPage');
        Route::post('admin/store-page', 'PageController@store');
        Route::get('admin/pages/search', 'PageController@index');
        Route::post('admin/pages/delete-page', 'PageController@destroy');
        Route::post('admin/pages/update-page/{id}', 'PageController@update');
        Route::post('admin/delete-checked-pages', 'PageController@deleteSelected');
        //All Jobs
        Route::get('admin/jobs', 'JobController@jobsAdmin')->name('allJobs');
        //All packages
        Route::get('admin/packages', 'PackageController@create')->name('createPackage');
        Route::get('admin/packages/search', 'PackageController@create');
        Route::get('admin/packages/edit/{slug}', 'PackageController@edit')->name('editPackage');
        Route::post('admin/packages/update/{slug}', 'PackageController@update');
        Route::post('admin/store/package', 'PackageController@store');
        Route::post('admin/packages/delete-package', 'PackageController@destroy');
        Route::post('package/get-package-options', 'PackageController@getPackageOptions');

        Route::get('admin/profile/a', 'UserController@adminProfileSettings')->name('adminProfile');
        Route::post('admin/store-profile-settings', 'UserController@storeProfileSettings');
        Route::post('admin/upload-temp-image', 'UserController@uploadTempImage');
    }
);

Route::group(
    ['middleware' => ['role:employer|admin']],
    function () {
        Route::get('job/edit-job/{job_slug}', 'JobController@edit')->name('editJob');
        Route::post('job/get-stored-job-skills', 'JobController@getJobSkills');
        Route::post('job/get-job-settings', 'JobController@getAttachmentSettings');
        Route::post('job/update-job', 'JobController@update');
        Route::post('skills/get-job-skills', 'SkillController@getJobSkills');
        Route::post('job/delete-job', 'JobController@destroy');
    }
);
//Employer Routes
Route::group(
    ['middleware' => ['role:employer']],
    function () {
        Route::post('skills/get-job-skills', 'SkillController@getJobSkills');
        Route::get('employer/dashboard/post-job', 'JobController@postJob')->name('employerPostJob');
        Route::get('employer/dashboard/manage-jobs', 'JobController@index')->name('employerManageJobs');
        Route::get('employer/jobs/{status}', 'EmployerController@showEmployerJobs');
        Route::get('employer/dashboard/job/{slug}/proposals', 'ProposalController@getJobProposals')->name('getProposals');
        Route::get('employer/dashboard', 'EmployerController@employerDashboard')->name('employerDashboard');
        Route::get('employer/profile', 'EmployerController@index')->name('employerPersonalDetail');
        Route::post('employer/upload-temp-image', 'EmployerController@uploadTempImage');
        Route::post('employer/store-profile-settings', 'EmployerController@storeProfileSettings');
        Route::post('job/post-job', 'JobController@store');
        Route::post('job/upload-temp-image', 'JobController@uploadTempImage');
        Route::post('user/submit-review', 'UserController@submitReview');
        //job controller
        Route::post('proposal/hire-freelancer', 'ProposalController@hiredFreelencer');
    }
);
// Freelancer Routes
Route::group(
    ['middleware' => ['role:freelancer']],
    function () {
        Route::get('/get-freelancer-skills', 'SkillController@getFreelancerSkills');
        Route::get('/get-skills', 'SkillController@getSkills');
        Route::get('payouts', 'FreelancerController@getPayouts')->name('getFreelancerPayouts');
        Route::get('freelancer/dispute/{slug}', 'UserController@raiseDispute');
        Route::post('freelancer/store-dispute', 'UserController@storeDispute');
        Route::get('freelancer/dashboard/experience-education', 'FreelancerController@experienceEducationSettings')->name('experienceEducation');
        Route::get('freelancer/dashboard/project-awards', 'FreelancerController@projectAwardsSettings')->name('projectAwards');
        Route::get('freelancer/dashboard/payment-settings', 'FreelancerController@paymentSettings')->name('paymentSettings');
        Route::post('freelancer/store-profile-settings', 'FreelancerController@storeProfileSettings')->name('freelancerProfileSetting');
        Route::post('freelancer/store-experience-settings', 'FreelancerController@storeExperienceEducationSettings');
        Route::post('freelancer/store-payment-settings', 'FreelancerController@storePaymentSettings');
        Route::post('freelancer/store-project-award-settings', 'FreelancerController@storeProjectAwardSettings');
        Route::get('freelancer/get-freelancer-skills', 'FreelancerController@getFreelancerSkills');
        Route::get('freelancer/get-freelancer-experiences', 'FreelancerController@getFreelancerExperiences');
        Route::get('freelancer/get-freelancer-projects', 'FreelancerController@getFreelancerProjects');
        Route::get('freelancer/get-freelancer-educations', 'FreelancerController@getFreelancerEducations');
        Route::get('freelancer/get-freelancer-awards', 'FreelancerController@getFreelancerAwards');
        Route::get('freelancer/jobs/{status}', 'FreelancerController@showFreelancerJobs');
        Route::get('freelancer/job/{slug}', 'FreelancerController@showOnGoingJobDetail')->name('showOnGoingJobDetail');
        Route::get('freelancer/proposals', 'FreelancerController@showFreelancerProposals')->name('showFreelancerProposals');
        Route::get('freelancer/dashboard', 'FreelancerController@freelancerDashboard')->name('freelancerDashboard');
        Route::get('freelancer/profile', 'FreelancerController@index')->name('personalDetail');
        Route::post('freelancer/upload-temp-image', 'FreelancerController@uploadTempImage');
    }
);
// Employer|Freelancer Routes
Route::group(
    ['middleware' => ['role:employer|freelancer|admin']],
    function () {
        Route::post('proposal/upload-temp-image', 'ProposalController@uploadTempImage');
        Route::get('job/proposal/{job_slug}', 'ProposalController@createProposal')->name('createProposal');
        Route::get('profile/settings/manage-account', 'UserController@accountSettings')->name('manageAccount');
        Route::get('profile/settings/reset-password', 'UserController@resetPassword')->name('resetPassword');
        Route::post('profile/settings/request-password', 'UserController@requestPassword');
        Route::get('profile/settings/email-notification-settings', 'UserController@emailNotificationSettings')->name('emailNotificationSettings');
        Route::post('profile/settings/save-email-settings', 'UserController@saveEmailNotificationSettings');
        Route::post('profile/settings/save-account-settings', 'UserController@saveAccountSettings');
        Route::get('profile/settings/delete-account', 'UserController@deleteAccount')->name('deleteAccount');
        Route::post('profile/settings/delete-user', 'UserController@destroy');
        Route::post('admin/delete-user', 'UserController@deleteUser');
        Route::get('profile/settings/get-manage-account', 'UserController@getManageAccountData');
        Route::get('profile/settings/get-user-notification-settings', 'UserController@getUserEmailNotificationSettings');
        Route::get('{role}/saved-items', 'UserController@getSavedItems')->name('getSavedItems');
        Route::post('profile/get-wishlist', 'UserController@getUserWishlist');
        Route::post('job/add-wishlist', 'JobController@addWishlist');
        Route::get('proposal/{slug}/{status}', 'ProposalController@show');
        Route::post('proposal/download-attachments', 'UserController@downloadAttachments');
        Route::post('proposal/send-message', 'UserController@sendPrivateMessage');
        Route::post('proposal/get-private-messages', 'UserController@getPrivateMessage');
        Route::get('proposal/download/message-attachments/{id}', 'UserController@downloadMessageAttachments');
        Route::get('user/package/checkout/{id}', 'UserController@checkout');
        Route::get('employer/{type}/invoice', 'UserController@getEmployerInvoices')->name('employerInvoice');
        Route::get('freelancer/{type}/invoice', 'UserController@getFreelancerInvoices')->name('freelancerInvoice');
        Route::get('show/invoice/{id}', 'UserController@showInvoice');
        // Route::get('user/verify/email', 'UserController@verifyUser');
        // Route::post('user/verify/emailcode', 'UserController@verifyUserEmailCode');
    }
);
Route::post('job/get-wishlist', 'JobController@getWishlist');
Route::get('dashboard/packages/{role}', 'PackageController@index');
Route::get('package/get-purchase-package', 'PackageController@getPurchasePackage');
Route::get('paypal/redirect-url', 'PaypalController@getIndex');
Route::get('paypal/ec-checkout', 'PaypalController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'PaypalController@getExpressCheckoutSuccess');
Route::get('user/products/thankyou', 'UserController@thankyou');
Route::get('payment-process/{id}', 'EmployerController@employerPaymentProcess');
Route::get('search/get-search-filters', 'PublicController@getFilterlist');
Route::post('search/get-searchable-data', 'PublicController@getSearchableData');
Route::get('channels/{channel}/messages', 'MessageController@index')->name('message');
Route::post('channels/{channel}/messages', 'MessageController@store');
Route::post('message/send-private-message', 'MessageController@store');
Route::get('message-center', 'MessageController@index')->name('message');
Route::get('message-center/get-users', 'MessageController@getUsers');
Route::post('message-center/get-messages', 'MessageController@getUserMessages');
Route::post('message', 'MessageController@store')->name('message.store');
Route::get('get/{type}/{filename}/{id}', 'PublicController@getFile')->name('getfile');
Route::post('submit-report', 'UserController@storeReport');
Route::post('badge/get-color', 'BadgeController@getBadgeColor');
Route::get('check-proposal-auth-user', 'PublicController@checkProposalAuth');
Route::post('proposal/submit-proposal', 'ProposalController@store');
Route::post('get-freelancer-experiences', 'PublicController@getFreelancerExperience');
Route::post('get-freelancer-education', 'PublicController@getFreelancerEducation');

Route::get('addmoney/stripe', array('as' => 'addmoney.paywithstripe', 'uses' => 'StripeController@payWithStripe',));
Route::post('addmoney/stripe', array('as' => 'addmoney.stripe', 'uses' => 'StripeController@postPaymentWithStripe',));










//pro........................................................................................



Route::get('/Pro/Activating/{id}', 'Pro\ProUserController@activate_pro');
Route::post('Pro/job/post-job', 'Pro\ProJobController@store');
Route::get(
    '/pro',
    function () {
        if (Schema::hasTable('users')) {
            return view('pro.front-end.index');
        } else {
            if (!empty(env('DB_DATABASE'))) {
                return Redirect::to('/install');
            } else {
                return trans('lang.configure_database');
            }
        }
    }
)->name('pro_home');
Route::get(
    '/pro-home',
    function () {
        return Redirect::to('/pro');
    }
);
Route::group(['prefix' => 'Pro/'], function () {
    

Route::get('job/{slug}', 'Pro\ProJobController@show')->name('pro_jobDetail');
Route::get('profile/{slug}', 'Pro\ProPublicController@showUserProfile')->name('pro_showUserProfile');
Route::get('categories', 'Pro\ProCategoryController@categoriesList')->name('pro_categoriesList');
Route::get('page/{slug}', 'Pro\ProPageController@show')->name('pro_showPage');
Route::post('store/project-offer', 'Pro\ProUserController@storeProjectOffers');
Route::get('jobs', 'Pro\ProJobController@listjobs')->name('pro_jobs');
// Route::get('user/password/reset/{verify_code}', 'Pro\ProPublicController@resetPasswordView')->name('pro_getResetPassView');
// Route::post('user/update/password', 'Pro\ProPublicController@resetUserPassword')->name('pro_resetUserPassword');
// Authentication|Guest Routes
// Route::post('register/login-register-user', 'Pro\ProPublicController@loginUser')->name('pro_loginUser');
// Route::post('register/verify-user-code', 'Pro\ProPublicController@verifyUserCode');
// Route::post('register/form-step1-custom-errors', 'Pro\ProPublicController@RegisterStep1Validation');
// Route::post('register/form-step2-custom-errors', 'Pro\ProPublicController@RegisterStep2Validation');

Route::get('search-results', 'Pro\ProPublicController@getSearchResult')->name('pro_searchResults');
Route::post('user/add-wishlist', 'Pro\ProUserController@addWishlist');
// Admin Routes
Route::group(
    ['middleware' => ['role:admin', 'Permission_check:pro_module']],
    function () {
        // Route::post('admin/clear-cache', 'Pro\ProSiteManagementController@clearCache');
        // Route::get('admin/clear-allcache', 'Pro\ProSiteManagementController@clearAllCache');
        // Route::get('admin/import-demo', 'Pro\ProSiteManagementController@importDemo');
        // Route::get('admin/remove-demo', 'Pro\ProSiteManagementController@removeDemoContent');
        Route::get('admin/payouts', 'Pro\ProUserController@getPayouts')->name('pro_adminPayouts');
        Route::get('admin/payouts/download/{year}', 'Pro\ProUserController@generatePDF');
        // Route::get('users', 'Pro\ProUserController@userListing')->name('pro_userListing');
        Route::get('admin/home-page-settings', 'Pro\ProSiteManagementController@homePageSettings')->name('pro_homePageSettings');
        Route::post('admin/get-page-option', 'Pro\ProSiteManagementController@getPageOption');
        // Skill Routes
        Route::get('admin/skills', 'Pro\ProSkillController@index')->name('pro_skills');
        Route::get('admin/skills/edit-skills/{id}', 'Pro\ProSkillController@edit')->name('pro_editSkill');
        Route::post('admin/store-skill', 'Pro\ProSkillController@store');
        Route::post('admin/skills/update-skills/{id}', 'Pro\ProSkillController@update');
        Route::get('admin/skills/search', 'Pro\ProSkillController@index');
        Route::post('admin/skills/delete-skills', 'Pro\ProSkillController@destroy');
        Route::post('admin/delete-checked-skills', 'Pro\ProSkillController@deleteSelected');
        // Department Routes
        Route::get('admin/departments', 'Pro\ProDepartmentController@index')->name('pro_departments');
        Route::get('admin/departments/edit-dpts/{id}', 'Pro\ProDepartmentController@edit')->name('pro_editDepartment');
        Route::post('admin/store-department', 'Pro\ProDepartmentController@store');
        Route::get('admin/departments/search', 'Pro\ProDepartmentController@index');
        Route::post('admin/departments/delete-dpts', 'Pro\ProDepartmentController@destroy');
        Route::post('admin/departments/update-dpts/{id}', 'Pro\ProDepartmentController@update');
        Route::post('admin/delete-checked-dpts', 'Pro\ProDepartmentController@deleteSelected');
        // Language Routes
        Route::get('admin/languages', 'Pro\ProLanguageController@index')->name('pro_languages');
        Route::get('admin/languages/edit-langs/{id}', 'Pro\ProLanguageController@edit')->name('pro_editLanguages');
        Route::post('admin/store-language', 'Pro\ProLanguageController@store');
        Route::get('admin/languages/search', 'Pro\ProLanguageController@index');
        Route::post('admin/languages/delete-langs', 'Pro\ProLanguageController@destroy');
        Route::post('admin/languages/update-langs/{id}', 'Pro\ProLanguageController@update');
        Route::post('admin/delete-checked-langs', 'Pro\ProLanguageController@deleteSelected');
        // Category Routes
        Route::get('admin/categories', 'Pro\ProCategoryController@index')->name('pro_categories');
        Route::get('admin/categories/edit-cats/{id}', 'Pro\ProCategoryController@edit')->name('pro_editCategories');
        Route::post('admin/store-category', 'Pro\ProCategoryController@store');
        Route::get('admin/categories/search', 'Pro\ProCategoryController@index');
        Route::post('admin/categories/delete-cats', 'Pro\ProCategoryController@destroy');
        Route::post('admin/categories/update-cats/{id}', 'Pro\ProCategoryController@update');
        Route::post('admin/categories/upload-temp-image', 'Pro\ProCategoryController@uploadTempImage');
        Route::post('admin/delete-checked-cats', 'Pro\ProCategoryController@deleteSelected');
        // Badges Routes
        Route::get('admin/badges', 'Pro\ProBadgeController@index')->name('pro_badges');
        Route::get('admin/badges/edit-badges/{id}', 'Pro\ProBadgeController@edit')->name('pro_editbadges');
        Route::post('admin/store-badge', 'Pro\ProBadgeController@store');
        Route::get('admin/badges/search', 'Pro\ProBadgeController@index');
        Route::post('admin/badges/delete-badges', 'Pro\ProBadgeController@destroy');
        Route::post('admin/badges/update-badges/{id}', 'Pro\ProBadgeController@update');
        Route::post('admin/badges/upload-temp-image', 'Pro\ProBadgeController@uploadTempImage');
        Route::post('admin/delete-checked-badges', 'Pro\ProBadgeController@deleteSelected');
        // Location Routes
        Route::get('admin/locations', 'Pro\ProLocationController@index')->name('pro_locations');
        Route::get('admin/locations/edit-locations/{id}', 'Pro\ProLocationController@edit')->name('pro_editLocations');
        Route::post('admin/store-location', 'Pro\ProLocationController@store');
        Route::post('admin/locations/delete-locations', 'Pro\ProLocationController@destroy');
        Route::post('/admin/locations/update-location/{id}', 'Pro\ProLocationController@update');
        Route::post('admin/get-location-flag', 'Pro\ProLocationController@getFlag');
        Route::post('admin/locations/upload-temp-image', 'Pro\ProLocationController@uploadTempImage');
        Route::post('admin/delete-checked-locs', 'Pro\ProLocationController@deleteSelected');
        // Review Options Routes
        Route::get('admin/review-options', 'Pro\ProReviewController@index')->name('pro_reviewOptions');
        Route::get('admin/review-options/edit-review-options/{id}', 'Pro\ProReviewController@edit')->name('pro_editReviewOptions');
        Route::post('admin/store-review-options', 'Pro\ProReviewController@store');
        Route::post('admin/review-options/delete-review-options', 'Pro\ProReviewController@destroy');
        Route::post('admin/review-options/update-review-options/{id}', 'Pro\ProReviewController@update');
        Route::post('admin/delete-checked-rev-options', 'Pro\ProReviewController@deleteSelected');
        // Site Management Routes
        Route::get('admin/settings', 'Pro\ProSiteManagementController@Settings')->name('pro_settings');
        Route::post('admin/store/email-settings', 'Pro\ProSiteManagementController@storeEmailSettings');
        Route::post('admin/store/home-settings', 'Pro\ProSiteManagementController@storeHomeSettings');
        Route::get('admin/get-section-display-setting', 'Pro\ProSiteManagementController@getSectionDisplaySetting');
        Route::get('admin/get-chat-display-setting', 'Pro\ProSiteManagementController@getchatDisplaySetting');
        Route::post('admin/store/section-settings', 'Pro\ProSiteManagementController@storeSectionSettings');
        Route::post('admin/store/settings', 'Pro\ProSiteManagementController@storeGeneralSettings');
        // Route::get('admin/theme-style-settings', 'Pro\ProSiteManagementController@ThemeStyleSettings');
        Route::post('admin/store/theme-styling-settings', 'Pro\ProSiteManagementController@storeThemeStylingSettings');
        Route::get('admin/get-theme-color-display-setting', 'Pro\ProSiteManagementController@getThemeColorDisplaySetting');
        Route::post('admin/store/registration-settings', 'Pro\ProSiteManagementController@storeRegistrationSettings');
        Route::post('admin/upload-temp-image/{file_name}', 'Pro\ProSiteManagementController@uploadTempImage');
        Route::post('admin/store/upload-icons', 'Pro\ProSiteManagementController@storeDashboardIcons');
        Route::post('admin/store/footer-settings', 'Pro\ProSiteManagementController@storeFooterSettings');
        Route::post('admin/store/social-settings', 'Pro\ProSiteManagementController@storeSocialSettings');
        Route::post('admin/store/search-menu', 'Pro\ProSiteManagementController@storeSearchMenu');
        Route::post('admin/store/commision-settings', 'Pro\ProSiteManagementController@storeCommisionSettings');
        Route::post('admin/store/payment-settings', 'Pro\ProSiteManagementController@storePaymentSettings');
        Route::post('admin/store/stripe-payment-settings', 'Pro\ProSiteManagementController@storeStripeSettings');
        Route::get('admin/email-templates', 'Pro\ProEmailTemplateController@index')->name('pro_emailTemplates');
        Route::get('admin/email-templates/{id}', 'Pro\ProEmailTemplateController@edit')->name('pro_editEmailTemplates');
        Route::post('admin/email-templates/update-content', 'Pro\ProEmailTemplateController@updateTemplateContent');
        Route::post('admin/email-templates/update-templates/{id}', 'Pro\ProEmailTemplateController@update');
        // Pages Routes
        Route::get('admin/pages', 'Pro\ProPageController@index')->name('pro_pages');
        Route::get('admin/create/pages', 'Pro\ProPageController@create')->name('pro_createPage');
        Route::get('admin/pages/edit-page/{id}', 'Pro\ProPageController@edit')->name('pro_editPage');
        Route::post('admin/store-page', 'Pro\ProPageController@store');
        Route::get('admin/pages/search', 'Pro\ProPageController@index');
        Route::post('admin/pages/delete-page', 'Pro\ProPageController@destroy');
        Route::post('admin/pages/update-page/{id}', 'Pro\ProPageController@update');
        Route::post('admin/delete-checked-pages', 'Pro\ProPageController@deleteSelected');
        //All Jobs
        Route::get('admin/jobs', 'Pro\ProJobController@jobsAdmin')->name('pro_allJobs');
        //All packages
        Route::get('admin/packages', 'Pro\ProPackageController@create')->name('pro_createPackage');
        Route::get('admin/packages/search', 'Pro\ProPackageController@create');
        Route::get('admin/packages/edit/{slug}', 'Pro\ProPackageController@edit')->name('pro_editPackage');
        Route::post('admin/packages/update/{slug}', 'Pro\ProPackageController@update');
        Route::post('admin/store/package', 'Pro\ProPackageController@store');
        Route::post('admin/packages/delete-package', 'Pro\ProPackageController@destroy');
        Route::post('package/get-package-options', 'Pro\ProPackageController@getPackageOptions');

        // Route::get('admin/profile', 'Pro\ProUserController@adminProfileSettings')->name('pro_adminProfile');
        Route::post('admin/store-profile-settings', 'Pro\ProUserController@storeProfileSettings');
        Route::post('admin/upload-temp-image', 'Pro\ProUserController@uploadTempImage');
    }
);

Route::group(
    ['middleware' => ['role:employer|admin']],
    function () {
        Route::get('job/edit-job/{job_slug}', 'Pro\ProJobController@edit')->name('pro_editJob');
        Route::post('job/get-stored-job-skills', 'Pro\ProJobController@getJobSkills');
        Route::post('job/get-job-settings', 'Pro\ProJobController@getAttachmentSettings');
        Route::post('job/update-job', 'Pro\ProJobController@update');
        Route::post('skills/get-job-skills', 'Pro\ProSkillController@getJobSkills');
        Route::post('job/delete-job', 'Pro\ProJobController@destroy');
    }
);
//Employer Routes
Route::group(
    ['middleware' => ['role:employer']],
    function () {
        Route::post('skills/get-job-skills', 'Pro\ProSkillController@getJobSkills');
        Route::get('employer/dashboard/post-job', 'Pro\ProJobController@postJob')->name('pro_employerPostJob');
        Route::get('employer/dashboard/manage-jobs', 'Pro\ProJobController@index')->name('pro_employerManageJobs');
        Route::get('employer/jobs/{status}', 'Pro\ProEmployerController@showEmployerJobs');
        Route::get('employer/dashboard/job/{slug}/proposals', 'Pro\ProProposalController@getJobProposals')->name('pro_getProposals');
        Route::get('employer/dashboard', 'Pro\ProEmployerController@employerDashboard')->name('pro_employerDashboard');
        Route::get('employer/profile', 'Pro\ProEmployerController@index')->name('pro_employerPersonalDetail');
        Route::post('employer/upload-temp-image', 'Pro\ProEmployerController@uploadTempImage');
        Route::post('employer/store-profile-settings', 'Pro\ProEmployerController@storeProfileSettings');
      
        Route::post('job/upload-temp-image', 'Pro\ProJobController@uploadTempImage');
        Route::post('user/submit-review', 'Pro\ProUserController@submitReview');
        //job controller
        Route::post('proposal/hire-freelancer', 'Pro\ProProposalController@hiredFreelencer');
    }
);
// Freelancer Routes
Route::group(
    ['middleware' => ['role:pro']],
    function () {
        Route::get('/get-freelancer-skills', 'Pro\ProSkillController@getFreelancerSkills');
        Route::get('/get-skills', 'Pro\ProSkillController@getSkills');
        Route::get('payouts', 'Pro\ProFreelancerController@getPayouts')->name('pro_getFreelancerPayouts');
        Route::get('freelancer/dispute/{slug}', 'Pro\ProUserController@raiseDispute');
        Route::post('freelancer/store-dispute', 'Pro\ProUserController@storeDispute');
        Route::get('freelancer/dashboard/experience-education', 'Pro\ProFreelancerController@experienceEducationSettings')->name('pro_experienceEducation');
        Route::get('freelancer/dashboard/project-awards', 'Pro\ProFreelancerController@projectAwardsSettings')->name('pro_projectAwards');
        Route::get('freelancer/dashboard/payment-settings', 'Pro\ProFreelancerController@paymentSettings')->name('pro_paymentSettings');
        Route::post('freelancer/store-profile-settings', 'Pro\ProFreelancerController@storeProfileSettings')->name('pro_freelancerProfileSetting');
        Route::post('freelancer/store-experience-settings', 'Pro\ProFreelancerController@storeExperienceEducationSettings');
        Route::post('freelancer/store-payment-settings', 'Pro\ProFreelancerController@storePaymentSettings');
        Route::post('freelancer/store-project-award-settings', 'Pro\ProFreelancerController@storeProjectAwardSettings');
        Route::get('freelancer/get-freelancer-skills', 'Pro\ProFreelancerController@getFreelancerSkills');
        Route::get('freelancer/get-freelancer-experiences', 'Pro\ProFreelancerController@getFreelancerExperiences');
        Route::get('freelancer/get-freelancer-projects', 'Pro\ProFreelancerController@getFreelancerProjects');
        Route::get('freelancer/get-freelancer-educations', 'Pro\ProFreelancerController@getFreelancerEducations');
        Route::get('freelancer/get-freelancer-awards', 'Pro\ProFreelancerController@getFreelancerAwards');
        Route::get('freelancer/jobs/{status}', 'Pro\ProFreelancerController@showFreelancerJobs');
        Route::get('freelancer/job/{slug}', 'Pro\ProFreelancerController@showOnGoingJobDetail')->name('pro_showOnGoingJobDetail');
        Route::get('freelancer/proposals', 'Pro\ProFreelancerController@showFreelancerProposals')->name('pro_showFreelancerProposals');
        Route::get('pro/dashboard', 'Pro\ProFreelancerController@freelancerDashboard')->name('pro_freelancerDashboard');
        Route::get('freelancer/profile', 'Pro\ProFreelancerController@index')->name('pro_personalDetail');
        Route::post('freelancer/upload-temp-image', 'Pro\ProFreelancerController@uploadTempImage');
    }
);
// Employer|Freelancer Routes
Route::group(
    ['middleware' => ['role:employer|pro|admin']],
    function () {
        Route::post('proposal/upload-temp-image', 'Pro\ProProposalController@uploadTempImage');
        Route::get('job/proposal/{job_slug}', 'Pro\ProProposalController@createProposal')->name('pro_createProposal');
        Route::get('profile/settings/manage-account', 'Pro\ProUserController@accountSettings')->name('pro_manageAccount');
        Route::get('profile/settings/reset-password', 'Pro\ProUserController@resetPassword')->name('pro_resetPassword');
        Route::post('profile/settings/request-password', 'Pro\ProUserController@requestPassword');
        Route::get('profile/settings/email-notification-settings', 'Pro\ProUserController@emailNotificationSettings')->name('pro_emailNotificationSettings');
        Route::post('profile/settings/save-email-settings', 'Pro\ProUserController@saveEmailNotificationSettings');
        Route::post('profile/settings/save-account-settings', 'Pro\ProUserController@saveAccountSettings');
        Route::get('profile/settings/delete-account', 'Pro\ProUserController@deleteAccount')->name('pro_deleteAccount');
        Route::post('profile/settings/delete-user', 'Pro\ProUserController@destroy');
        Route::post('admin/delete-user', 'Pro\ProUserController@deleteUser');
        Route::get('profile/settings/get-manage-account', 'Pro\ProUserController@getManageAccountData');
        Route::get('profile/settings/get-user-notification-settings', 'Pro\ProUserController@getUserEmailNotificationSettings');
        Route::get('{role}/saved-items', 'Pro\ProUserController@getSavedItems')->name('pro_getSavedItems');
        Route::post('profile/get-wishlist', 'Pro\ProUserController@getUserWishlist');
        Route::post('job/add-wishlist', 'Pro\ProJobController@addWishlist');
        Route::get('proposal/{slug}/{status}', 'Pro\ProProposalController@show');
        Route::post('proposal/download-attachments', 'Pro\ProUserController@downloadAttachments');
        Route::post('proposal/send-message', 'Pro\ProUserController@sendPrivateMessage');
        Route::post('proposal/get-private-messages', 'Pro\ProUserController@getPrivateMessage');
        Route::get('proposal/download/message-attachments/{id}', 'Pro\ProUserController@downloadMessageAttachments');
        Route::get('user/package/checkout/{id}', 'Pro\ProUserController@checkout');
        Route::get('employer/{type}/invoice', 'Pro\ProUserController@getEmployerInvoices')->name('pro_employerInvoice');
        Route::get('freelancer/{type}/invoice', 'Pro\ProUserController@getFreelancerInvoices')->name('pro_freelancerInvoice');
        Route::get('show/invoice/{id}', 'Pro\ProUserController@showInvoice');
        // Route::get('user/verify/email', 'Pro\ProUserController@verifyUser');
        // Route::post('user/verify/emailcode', 'Pro\ProUserController@verifyUserEmailCode');
    }
);
Route::post('job/get-wishlist', 'Pro\ProJobController@getWishlist');
Route::get('dashboard/packages/{role}', 'Pro\ProPackageController@index');
Route::get('package/get-purchase-package', 'Pro\ProPackageController@getPurchasePackage');
// Route::get('paypal/redirect-url', 'Pro\ProPaypalController@getIndex');
// Route::get('paypal/ec-checkout', 'Pro\ProPaypalController@getExpressCheckout');
// Route::get('paypal/ec-checkout-success', 'Pro\ProPaypalController@getExpressCheckoutSuccess');
Route::get('user/products/thankyou', 'Pro\ProUserController@thankyou');
Route::get('payment-process/{id}', 'Pro\ProEmployerController@employerPaymentProcess');
Route::get('search/get-search-filters', 'Pro\ProPublicController@getFilterlist');
Route::post('search/get-searchable-data', 'Pro\ProPublicController@getSearchableData');
Route::get('channels/{channel}/messages', 'Pro\ProMessageController@index')->name('pro_message');
Route::post('channels/{channel}/messages', 'Pro\ProMessageController@store');
Route::post('message/send-private-message', 'Pro\ProMessageController@store');
Route::get('message-center', 'Pro\ProMessageController@index')->name('pro_message');
Route::get('message-center/get-users', 'Pro\ProMessageController@getUsers');
Route::post('message-center/get-messages', 'Pro\ProMessageController@getUserMessages');
Route::post('message', 'Pro\ProMessageController@store')->name('pro_message.store');
Route::get('get/{type}/{filename}/{id}', 'Pro\ProPublicController@getFile')->name('pro_getfile');
Route::post('submit-report', 'Pro\ProUserController@storeReport');
Route::post('badge/get-color', 'Pro\ProBadgeController@getBadgeColor');
Route::get('check-proposal-auth-user', 'Pro\ProPublicController@checkProposalAuth');
Route::post('proposal/submit-proposal', 'Pro\ProProposalController@store');
Route::post('get-freelancer-experiences', 'Pro\ProPublicController@getFreelancerExperience');
Route::post('get-freelancer-education', 'Pro\ProPublicController@getFreelancerEducation');

// Route::get('addmoney/stripe', array('as' => 'addmoney.paywithstripe', 'uses' => 'Pro\ProStripeController@payWithStripe',));
// Route::post('addmoney/stripe', array('as' => 'addmoney.stripe', 'uses' => 'Pro\ProStripeController@postPaymentWithStripe',));
});














//job.....................................



Route::get('/Job/Activating/{id}', 'Job\JobUserController@activate_pro');
Route::post('Job/job/post-job', 'Job\JobJobController@store');
Route::get(
    '/job',
    function () {
        if (Schema::hasTable('users')) {
            return view('job.front-end.index');
        } else {
            if (!empty(env('DB_DATABASE'))) {
                return Redirect::to('/install');
            } else {
                return trans('lang.configure_database');
            }
        }
    }
)->name('pro_home');
Route::get(
    '/job-home',
    function () {
        return Redirect::to('/job');
    }
);
Route::group(['prefix' => 'Job/'], function () {


    Route::get('job/{slug}', 'Job\JobJobController@show')->name('job_jobDetail');
    Route::get('profile/{slug}', 'Job\JobPublicController@showUserProfile')->name('job_showUserProfile');
    Route::get('categories', 'Job\JobCategoryController@categoriesList')->name('job_categoriesList');
    Route::get('page/{slug}', 'Job\JobPageController@show')->name('job_showPage');
    Route::post('store/project-offer', 'Job\JobUserController@storeProjectOffers');
    Route::get('jobs', 'Job\JobJobController@listjobs')->name('job_jobs');
    Route::get('user/password/reset/{verify_code}', 'Job\JobPublicController@resetPasswordView')->name('job_getResetPassView');
    Route::post('user/update/password', 'Job\JobPublicController@resetUserPassword')->name('job_resetUserPassword');
    // Authentication|Guest Routes
    // Route::post('register/login-register-user', 'Job\JobPublicController@loginUser')->name('job_loginUser');
    // Route::post('register/verify-user-code', 'Job\JobPublicController@verifyUserCode');
    // Route::post('register/form-step1-custom-errors', 'Job\JobPublicController@RegisterStep1Validation');
    // Route::post('register/form-step2-custom-errors', 'Job\JobPublicController@RegisterStep2Validation');

    Route::get('search-results', 'Job\JobPublicController@getSearchResult')->name('job_searchResults');
    Route::post('user/add-wishlist', 'Job\JobUserController@addWishlist');
    // Admin Routes
    Route::group(
        ['middleware' => ['role:admin', 'Permission_check:job_module']],
        function () {
            // Route::post('admin/clear-cache', 'Job\JobSiteManagementController@clearCache');
            // Route::get('admin/clear-allcache', 'Job\JobSiteManagementController@clearAllCache');
            // Route::get('admin/import-demo', 'Job\JobSiteManagementController@importDemo');
            // Route::get('admin/remove-demo', 'Job\JobSiteManagementController@removeDemoContent');
            Route::get('admin/payouts', 'Job\JobUserController@getPayouts')->name('job_adminPayouts');
            Route::get('admin/payouts/download/{year}', 'Job\JobUserController@generatePDF');
            // Route::get('users', 'Job\JobUserController@userListing')->name('job_userListing');
            Route::get('admin/home-page-settings', 'Job\JobSiteManagementController@homePageSettings')->name('job_homePageSettings');
            Route::post('admin/get-page-option', 'Job\JobSiteManagementController@getPageOption');
            // Skill Routes
            Route::get('admin/skills', 'Job\JobSkillController@index')->name('job_skills');
            Route::get('admin/skills/edit-skills/{id}', 'Job\JobSkillController@edit')->name('job_editSkill');
            Route::post('admin/store-skill', 'Job\JobSkillController@store');
            Route::post('admin/skills/update-skills/{id}', 'Job\JobSkillController@update');
            Route::get('admin/skills/search', 'Job\JobSkillController@index');
            Route::post('admin/skills/delete-skills', 'Job\JobSkillController@destroy');
            Route::post('admin/delete-checked-skills', 'Job\JobSkillController@deleteSelected');
            // Department Routes
            Route::get('admin/departments', 'Job\JobDepartmentController@index')->name('job_departments');
            Route::get('admin/departments/edit-dpts/{id}', 'Job\JobDepartmentController@edit')->name('job_editDepartment');
            Route::post('admin/store-department', 'Job\JobDepartmentController@store');
            Route::get('admin/departments/search', 'Job\JobDepartmentController@index');
            Route::post('admin/departments/delete-dpts', 'Job\JobDepartmentController@destroy');
            Route::post('admin/departments/update-dpts/{id}', 'Job\JobDepartmentController@update');
            Route::post('admin/delete-checked-dpts', 'Job\JobDepartmentController@deleteSelected');
            // Language Routes
            Route::get('admin/languages', 'Job\JobLanguageController@index')->name('job_languages');
            Route::get('admin/languages/edit-langs/{id}', 'Job\JobLanguageController@edit')->name('job_editLanguages');
            Route::post('admin/store-language', 'Job\JobLanguageController@store');
            Route::get('admin/languages/search', 'Job\JobLanguageController@index');
            Route::post('admin/languages/delete-langs', 'Job\JobLanguageController@destroy');
            Route::post('admin/languages/update-langs/{id}', 'Job\JobLanguageController@update');
            Route::post('admin/delete-checked-langs', 'Job\JobLanguageController@deleteSelected');
            // Category Routes
            Route::get('admin/categories', 'Job\JobCategoryController@index')->name('job_categories');
            Route::get('admin/categories/edit-cats/{id}', 'Job\JobCategoryController@edit')->name('job_editCategories');
            Route::post('admin/store-category', 'Job\JobCategoryController@store');
            Route::get('admin/categories/search', 'Job\JobCategoryController@index');
            Route::post('admin/categories/delete-cats', 'Job\JobCategoryController@destroy');
            Route::post('admin/categories/update-cats/{id}', 'Job\JobCategoryController@update');
            Route::post('admin/categories/upload-temp-image', 'Job\JobCategoryController@uploadTempImage');
            Route::post('admin/delete-checked-cats', 'Job\JobCategoryController@deleteSelected');
            // Badges Routes
            Route::get('admin/badges', 'Job\JobBadgeController@index')->name('job_badges');
            Route::get('admin/badges/edit-badges/{id}', 'Job\JobBadgeController@edit')->name('job_editbadges');
            Route::post('admin/store-badge', 'Job\JobBadgeController@store');
            Route::get('admin/badges/search', 'Job\JobBadgeController@index');
            Route::post('admin/badges/delete-badges', 'Job\JobBadgeController@destroy');
            Route::post('admin/badges/update-badges/{id}', 'Job\JobBadgeController@update');
            Route::post('admin/badges/upload-temp-image', 'Job\JobBadgeController@uploadTempImage');
            Route::post('admin/delete-checked-badges', 'Job\JobBadgeController@deleteSelected');
            // Location Routes
            Route::get('admin/locations', 'Job\JobLocationController@index')->name('job_locations');
            Route::get('admin/locations/edit-locations/{id}', 'Job\JobLocationController@edit')->name('job_editLocations');
            Route::post('admin/store-location', 'Job\JobLocationController@store');
            Route::post('admin/locations/delete-locations', 'Job\JobLocationController@destroy');
            Route::post('/admin/locations/update-location/{id}', 'Job\JobLocationController@update');
            Route::post('admin/get-location-flag', 'Job\JobLocationController@getFlag');
            Route::post('admin/locations/upload-temp-image', 'Job\JobLocationController@uploadTempImage');
            Route::post('admin/delete-checked-locs', 'Job\JobLocationController@deleteSelected');
            // Review Options Routes
            Route::get('admin/review-options', 'Job\JobReviewController@index')->name('job_reviewOptions');
            Route::get('admin/review-options/edit-review-options/{id}', 'Job\JobReviewController@edit')->name('job_editReviewOptions');
            Route::post('admin/store-review-options', 'Job\JobReviewController@store');
            Route::post('admin/review-options/delete-review-options', 'Job\JobReviewController@destroy');
            Route::post('admin/review-options/update-review-options/{id}', 'Job\JobReviewController@update');
            Route::post('admin/delete-checked-rev-options', 'Job\JobReviewController@deleteSelected');
            // Site Management Routes
            Route::get('admin/settings', 'Job\JobSiteManagementController@Settings')->name('job_settings');
            Route::post('admin/store/email-settings', 'Job\JobSiteManagementController@storeEmailSettings');
            Route::post('admin/store/home-settings', 'Job\JobSiteManagementController@storeHomeSettings');
            Route::get('admin/get-section-display-setting', 'Job\JobSiteManagementController@getSectionDisplaySetting');
            Route::get('admin/get-chat-display-setting', 'Job\JobSiteManagementController@getchatDisplaySetting');
            Route::post('admin/store/section-settings', 'Job\JobSiteManagementController@storeSectionSettings');
            Route::post('admin/store/settings', 'Job\JobSiteManagementController@storeGeneralSettings');
            // Route::get('admin/theme-style-settings', 'Job\JobSiteManagementController@ThemeStyleSettings');
            Route::post('admin/store/theme-styling-settings', 'Job\JobSiteManagementController@storeThemeStylingSettings');
            Route::get('admin/get-theme-color-display-setting', 'Job\JobSiteManagementController@getThemeColorDisplaySetting');
            Route::post('admin/store/registration-settings', 'Job\JobSiteManagementController@storeRegistrationSettings');
            Route::post('admin/upload-temp-image/{file_name}', 'Job\JobSiteManagementController@uploadTempImage');
            Route::post('admin/store/upload-icons', 'Job\JobSiteManagementController@storeDashboardIcons');
            Route::post('admin/store/footer-settings', 'Job\JobSiteManagementController@storeFooterSettings');
            Route::post('admin/store/social-settings', 'Job\JobSiteManagementController@storeSocialSettings');
            Route::post('admin/store/search-menu', 'Job\JobSiteManagementController@storeSearchMenu');
            Route::post('admin/store/commision-settings', 'Job\JobSiteManagementController@storeCommisionSettings');
            Route::post('admin/store/payment-settings', 'Job\JobSiteManagementController@storePaymentSettings');
            Route::post('admin/store/stripe-payment-settings', 'Job\JobSiteManagementController@storeStripeSettings');
            Route::get('admin/email-templates', 'Job\JobEmailTemplateController@index')->name('job_emailTemplates');
            Route::get('admin/email-templates/{id}', 'Job\JobEmailTemplateController@edit')->name('job_editEmailTemplates');
            Route::post('admin/email-templates/update-content', 'Job\JobEmailTemplateController@updateTemplateContent');
            Route::post('admin/email-templates/update-templates/{id}', 'Job\JobEmailTemplateController@update');
            // Pages Routes
            Route::get('admin/pages', 'Job\JobPageController@index')->name('job_job_pages');
            Route::get('admin/create/pages', 'Job\JobPageController@create')->name('job_createPage');
            Route::get('admin/pages/edit-page/{id}', 'Job\JobPageController@edit')->name('job_editPage');
            Route::post('admin/store-page', 'Job\JobPageController@store');
            Route::get('admin/pages/search', 'Job\JobPageController@index');
            Route::post('admin/pages/delete-page', 'Job\JobPageController@destroy');
            Route::post('admin/pages/update-page/{id}', 'Job\JobPageController@update');
            Route::post('admin/delete-checked-pages', 'Job\JobPageController@deleteSelected');
            //All Jobs
            Route::get('admin/jobs', 'Job\JobJobController@jobsAdmin')->name('job_allJobs');
            //All packages
            Route::get('admin/packages', 'Job\JobPackageController@create')->name('job_createPackage');
            Route::get('admin/packages/search', 'Job\JobPackageController@create');
            Route::get('admin/packages/edit/{slug}', 'Job\JobPackageController@edit')->name('job_editPackage');
            Route::post('admin/packages/update/{slug}', 'Job\JobPackageController@update');
            Route::post('admin/store/package', 'Job\JobPackageController@store');
            Route::post('admin/packages/delete-package', 'Job\JobPackageController@destroy');
            Route::post('package/get-package-options', 'Job\JobPackageController@getPackageOptions');

            // Route::get('admin/profile', 'Job\JobUserController@adminProfileSettings')->name('job_adminProfile');
            Route::post('admin/store-profile-settings', 'Job\JobUserController@storeProfileSettings');
            Route::post('admin/upload-temp-image', 'Job\JobUserController@uploadTempImage');
        }
    );

    Route::group(
        ['middleware' => ['role:job_employer|admin']],
        function () {
            Route::get('job/edit-job/{job_slug}', 'Job\JobJobController@edit')->name('job_editJob');
            Route::post('job/get-stored-job-skills', 'Job\JobJobController@getJobSkills');
            Route::post('job/get-job-settings', 'Job\JobJobController@getAttachmentSettings');
            Route::post('job/update-job', 'Job\JobJobController@update');
            Route::post('skills/get-job-skills', 'Job\JobSkillController@getJobSkills');
            Route::post('job/delete-job', 'Job\JobJobController@destroy');
        }
    );
    //Employer Routes
    Route::group(
        ['middleware' => ['role:job_employer']],
        function () {
            Route::post('skills/get-job-skills', 'Job\JobSkillController@getJobSkills');
            Route::get('employer/dashboard/post-job', 'Job\JobJobController@postJob')->name('job_employerPostJob');
            Route::get('employer/dashboard/manage-jobs', 'Job\JobJobController@index')->name('job_employerManageJobs');
            Route::get('employer/jobs/{status}', 'Job\JobEmployerController@showEmployerJobs');
            Route::get('employer/dashboard/job/{slug}/proposals', 'Job\JobProposalController@getJobProposals')->name('job_getProposals');
            Route::get('employer/dashboard', 'Job\JobEmployerController@employerDashboard')->name('job_employerDashboard');
            Route::get('employer/profile', 'Job\JobEmployerController@index')->name('pro_employerPersonalDetail');
            Route::post('employer/upload-temp-image', 'Job\JobEmployerController@uploadTempImage');
            Route::post('employer/store-profile-settings', 'Job\JobEmployerController@storeProfileSettings');

            Route::post('job/upload-temp-image', 'Job\JobJobController@uploadTempImage');
            Route::post('user/submit-review', 'Job\JobUserController@submitReview');
            //job controller
            Route::post('proposal/hire-freelancer', 'Job\JobProposalController@hiredFreelencer');
        }
    );
    // Freelancer Routes
    Route::group(
        ['middleware' => ['role:candidate']],
        function () {
            Route::get('/get-freelancer-skills', 'Job\JobSkillController@getFreelancerSkills');
            Route::get('/get-skills', 'Job\JobSkillController@getSkills');
            Route::get('payouts', 'Job\JobFreelancerController@getPayouts')->name('job_getFreelancerPayouts');
            Route::get('freelancer/dispute/{slug}', 'Job\JobUserController@raiseDispute');
            Route::post('freelancer/store-dispute', 'Job\JobUserController@storeDispute');
            Route::get('freelancer/dashboard/experience-education', 'Job\JobFreelancerController@experienceEducationSettings')->name('job_experienceEducation');
            Route::get('freelancer/dashboard/project-awards', 'Job\JobFreelancerController@projectAwardsSettings')->name('job_projectAwards');
            Route::get('freelancer/dashboard/payment-settings', 'Job\JobFreelancerController@paymentSettings')->name('job_paymentSettings');
            Route::post('freelancer/store-profile-settings', 'Job\JobFreelancerController@storeProfileSettings')->name('job_freelancerProfileSetting');
            Route::post('freelancer/store-experience-settings', 'Job\JobFreelancerController@storeExperienceEducationSettings');
            Route::post('freelancer/store-payment-settings', 'Job\JobFreelancerController@storePaymentSettings');
            Route::post('freelancer/store-project-award-settings', 'Job\JobFreelancerController@storeProjectAwardSettings');
            Route::get('freelancer/get-freelancer-skills', 'Job\JobFreelancerController@getFreelancerSkills');
            Route::get('freelancer/get-freelancer-experiences', 'Job\JobFreelancerController@getFreelancerExperiences');
            Route::get('freelancer/get-freelancer-projects', 'Job\JobFreelancerController@getFreelancerProjects');
            Route::get('freelancer/get-freelancer-educations', 'Job\JobFreelancerController@getFreelancerEducations');
            Route::get('freelancer/get-freelancer-awards', 'Job\JobFreelancerController@getFreelancerAwards');
            Route::get('freelancer/jobs/{status}', 'Job\JobFreelancerController@showFreelancerJobs');
            Route::get('freelancer/job/{slug}', 'Job\JobFreelancerController@showOnGoingJobDetail')->name('job_showOnGoingJobDetail');
            Route::get('freelancer/proposals', 'Job\JobFreelancerController@showFreelancerProposals')->name('job_showFreelancerProposals');
            Route::get('candidate/dashboard', 'Job\JobFreelancerController@freelancerDashboard')->name('job_freelancerDashboard');
            Route::get('candidate/profile', 'Job\JobFreelancerController@index')->name('job_personalDetail');
            Route::post('freelancer/upload-temp-image', 'Job\JobFreelancerController@uploadTempImage');
        }
    );
    // Employer|Freelancer Routes
    Route::group(
        ['middleware' => ['role:job_employer|candidate|admin']],
        function () {
            Route::post('proposal/upload-temp-image', 'Job\JobProposalController@uploadTempImage');
            Route::get('job/proposal/{job_slug}', 'Job\JobProposalController@createProposal')->name('job_createProposal');
            Route::get('profile/settings/manage-account', 'Job\JobUserController@accountSettings')->name('job_manageAccount');
            Route::get('profile/settings/reset-password', 'Job\JobUserController@resetPassword')->name('job_resetPassword');
            Route::post('profile/settings/request-password', 'Job\JobUserController@requestPassword');
            Route::get('profile/settings/email-notification-settings', 'Job\JobUserController@emailNotificationSettings')->name('job_emailNotificationSettings');
            Route::post('profile/settings/save-email-settings', 'Job\JobUserController@saveEmailNotificationSettings');
            Route::post('profile/settings/save-account-settings', 'Job\JobUserController@saveAccountSettings');
            Route::get('profile/settings/delete-account', 'Job\JobUserController@deleteAccount')->name('job_deleteAccount');
            Route::post('profile/settings/delete-user', 'Job\JobUserController@destroy');
            Route::post('admin/delete-user', 'Job\JobUserController@deleteUser');
            Route::get('profile/settings/get-manage-account', 'Job\JobUserController@getManageAccountData');
            Route::get('profile/settings/get-user-notification-settings', 'Job\JobUserController@getUserEmailNotificationSettings');
            Route::get('{role}/saved-items', 'Job\JobUserController@getSavedItems')->name('job_getSavedItems');
            Route::post('profile/get-wishlist', 'Job\JobUserController@getUserWishlist');
            Route::post('job/add-wishlist', 'Job\JobJobController@addWishlist');
            Route::get('proposal/{slug}/{status}', 'Job\JobProposalController@show');
            Route::post('proposal/download-attachments', 'Job\JobUserController@downloadAttachments');
            Route::post('proposal/send-message', 'Job\JobUserController@sendPrivateMessage');
            Route::post('proposal/get-private-messages', 'Job\JobUserController@getPrivateMessage');
            Route::get('proposal/download/message-attachments/{id}', 'Job\JobUserController@downloadMessageAttachments');
            Route::get('user/package/checkout/{id}', 'Job\JobUserController@checkout');
            Route::get('employer/{type}/invoice', 'Job\JobUserController@getEmployerInvoices')->name('job_employerInvoice');
            Route::get('freelancer/{type}/invoice', 'Job\JobUserController@getFreelancerInvoices')->name('job_freelancerInvoice');
            Route::get('show/invoice/{id}', 'Job\JobUserController@showInvoice');
            // Route::get('user/verify/email', 'Job\JobUserController@verifyUser');
            // Route::post('user/verify/emailcode', 'Job\JobUserController@verifyUserEmailCode');
        }
    );
    Route::post('job/get-wishlist', 'Job\JobJobController@getWishlist');
    Route::get('dashboard/packages/{role}', 'Job\JobPackageController@index');
    Route::get('package/get-purchase-package', 'Job\JobPackageController@getPurchasePackage');
    // Route::get('paypal/redirect-url', 'Job\JobPaypalController@getIndex');
    // Route::get('paypal/ec-checkout', 'Job\JobPaypalController@getExpressCheckout');
    // Route::get('paypal/ec-checkout-success', 'Job\JobPaypalController@getExpressCheckoutSuccess');
    Route::get('user/products/thankyou', 'Job\JobUserController@thankyou');
    Route::get('payment-process/{id}', 'Job\JobEmployerController@employerPaymentProcess');
    Route::get('search/get-search-filters', 'Job\JobPublicController@getFilterlist');
    Route::post('search/get-searchable-data', 'Job\JobPublicController@getSearchableData');
    Route::get('channels/{channel}/messages', 'Job\JobMessageController@index')->name('job_message');
    Route::post('channels/{channel}/messages', 'Job\JobMessageController@store');
    Route::post('message/send-private-message', 'Job\JobMessageController@store');
    Route::get('message-center', 'Job\JobMessageController@index')->name('pro_message');
    Route::get('message-center/get-users', 'Job\JobMessageController@getUsers');
    Route::post('message-center/get-messages', 'Job\JobMessageController@getUserMessages');
    Route::post('message', 'Job\JobMessageController@store')->name('pro_message.store');
    Route::get('get/{type}/{filename}/{id}', 'Job\JobPublicController@getFile')->name('job_getfile');
    Route::post('submit-report', 'Job\JobUserController@storeReport');
    Route::post('badge/get-color', 'Job\JobBadgeController@getBadgeColor');
    Route::get('check-proposal-auth-user', 'Job\JobPublicController@checkProposalAuth');
    Route::post('proposal/submit-proposal', 'Job\JobProposalController@store');
    Route::post('get-freelancer-experiences', 'Job\JobPublicController@getFreelancerExperience');
    Route::post('get-freelancer-education', 'Job\JobPublicController@getFreelancerEducation');

    // Route::get('addmoney/stripe', array('as' => 'addmoney.paywithstripe', 'uses' => 'Job\JobStripeController@payWithStripe',));
    // Route::post('addmoney/stripe', array('as' => 'addmoney.stripe', 'uses' => 'Job\JobStripeController@postPaymentWithStripe',));
});
















//learn ............................................................................... 

Route::get('/learn-and-grow', 'FrontendController@index')->name('learn.homepage');;


Route::get('/menu/{slug}', 'FrontendController@menu')->name('menu');;
Route::get('/about-us', 'FrontendController@about')->name('about');
Route::get('/faqs', 'FrontendController@faqs')->name('faqs');
Route::get('/click-add/{id}', 'FrontendController@clickadd');
Route::get('/contact-us', 'FrontendController@contactUs')->name('contact');
Route::post('/contact-us', ['uses' => 'FrontendController@contactSubmit', 'as' => 'contact-submit']);
Route::post('/subscribe', 'FrontendController@subscribe')->name('subscribe');


Route::get('/details-blog/{id}/{slug}', 'FrontendController@detailsBlog')->name('details.blog');
Route::get('/blog-category/{id}/{slug}', 'FrontendController@blogCategory')->name('blog.category');



Route::get('/categories/{id}/{slug}', 'FrontendController@categories')->name('article.categories');
Route::get('/topics/{id}/{slug}', 'FrontendController@topics')->name('topics');
Route::get('/live-class', 'FrontendController@liveClass')->name('live.class');



Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminLoginController@index')->name('admin.loginForm');
    Route::post('/', 'AdminLoginController@authenticate')->name('admin.login');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'Permission_check:learn_module']], function () {

    /*demo start*/
    //    Route::middleware(['demo'])->group(function () {

    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/subscribers', 'DashboardController@manageSubscribers')->name('manage.subscribers');
    Route::post('/update-subscribers', 'DashboardController@updateSubscriber')->name('update.subscriber');
    Route::get('/send-email', 'DashboardController@sendMail')->name('send.mail.subscriber');
    Route::post('/send-email', 'DashboardController@sendMailsubscriber')->name('send.email.subscriber');

    Route::get('/live', 'DashboardController@live')->name('admin.live');
    Route::post('/live', 'DashboardController@UpdateLive')->name('update.live');

    Route::get('/learn_category', 'DashboardController@category')->name('learnadmincategory');
    Route::post('/search-category', 'DashboardController@searchCategory')->name('admin.searchCategory');
    Route::post('/search-category', 'DashboardController@UpdateCategory')->name('update.category');

    Route::get('/sub-category', 'DashboardController@unit')->name('admin.unit');
    Route::post('/search-sub-category', 'DashboardController@searchSubCategory')->name('admin.searchSubCategory');
    Route::post('/sub-category', 'DashboardController@UpdateUnit')->name('update.unit');

    Route::get('/articles', 'DashboardController@plans')->name('plan.all');
    Route::post('/search-article', 'DashboardController@searchPost')->name('search.post');
    Route::get('/article-create', 'DashboardController@createPlan')->name('plan.create');
    Route::post('/article-create', 'DashboardController@storePlan')->name('plan.store');
    Route::get('/article-edit/{id}', 'DashboardController@editPlan')->name('plan.edit');
    Route::post('/article-update', 'DashboardController@updatePlan')->name('plan.update');

    //    Testimonial Controller
    Route::get('testimonial', 'TestimonialController@index')->name('admin.testimonial');
    Route::get('testimonial/create', 'TestimonialController@create')->name('testimonial.create');
    Route::post('testimonial/create', 'TestimonialController@store')->name('testimonial.store');
    Route::delete('testimonial/delete', 'TestimonialController@destroy')->name('testimonial.delete');
    Route::get('testimonial/edit/{id}', 'TestimonialController@edit')->name('testimonial.edit');
    Route::post('testimonial-update', 'TestimonialController@updatePost')->name('testimonial.update');


    //Email Template
    Route::get('/template', 'EtemplateController@index')->name('email.template');
    Route::post('/template-update', 'EtemplateController@update')->name('template.update');


    // General Settings
    Route::get('/general-settings', 'GeneralSettingController@GenSetting')->name('admin.GenSetting');
    Route::post('/general-settings', 'GeneralSettingController@UpdateGenSetting')->name('admin.UpdateGenSetting');
    Route::get('/change-password', 'GeneralSettingController@changePassword')->name('admin.changePass');
    Route::post('/change-password', 'GeneralSettingController@updatePassword')->name('admin.changePass');
    Route::get('/profile', 'GeneralSettingController@profile')->name('admin.profile');
    Route::post('/profile', 'GeneralSettingController@updateProfile')->name('admin.profile');


    //    Blog Controller
    Route::get('/blog-category', 'PostController@category')->name('admin.cat');
    Route::post('/blog-category', 'PostController@UpdateCategory')->name('update.cat');
    Route::get('blog', 'PostController@index')->name('admin.blog');
    Route::get('blog/create', 'PostController@create')->name('blog.create');
    Route::post('blog/create', 'PostController@store')->name('blog.store');
    Route::delete('blog/delete', 'PostController@destroy')->name('blog.delete');
    Route::get('blog/edit/{id}', 'PostController@edit')->name('blog.edit');
    Route::post('blog-update', 'PostController@updatePost')->name('blog.update');

    //Contact Setting
    Route::get('contact-setting', ['as' => 'contact-setting', 'uses' => 'WebSettingController@getContact']);
    Route::put('contact-setting/{id}', ['as' => 'contact-setting-update', 'uses' => 'WebSettingController@putContactSetting']);

    Route::get('manage-logo', ['as' => 'manage-logo', 'uses' => 'WebSettingController@manageLogo']);
    Route::post('manage-logo', ['as' => 'manage-logo', 'uses' => 'WebSettingController@updateLogo']);

    Route::get('manage-footer', ['as' => 'manage-footer', 'uses' => 'WebSettingController@manageFooter']);
    Route::put('manage-footer', ['as' => 'manage-footer-update', 'uses' => 'WebSettingController@updateFooter']);

    Route::get('manage-social', ['as' => 'manage-social', 'uses' => 'WebSettingController@manageSocial']);
    Route::post('manage-social', ['as' => 'manage-social', 'uses' => 'WebSettingController@storeSocial']);
    Route::get('manage-social/{product_id?}', ['as' => 'social-edit', 'uses' => 'WebSettingController@editSocial']);
    Route::put('manage-social/{product_id?}', ['as' => 'social-edit', 'uses' => 'WebSettingController@updateSocial']);
    Route::post('delete-social', ['as' => 'del.social', 'uses' => 'WebSettingController@destroySocial']);

    Route::get('menu-create', ['as' => 'menu-create', 'uses' => 'WebSettingController@createMenu']);
    Route::post('menu-create', ['as' => 'menu-create', 'uses' => 'WebSettingController@storeMenu']);
    Route::get('menu-control', ['as' => 'menu-control', 'uses' => 'WebSettingController@manageMenu']);
    Route::get('menu-edit/{id}', ['as' => 'menu-edit', 'uses' => 'WebSettingController@editMenu']);
    Route::post('menu-update/{id}', ['as' => 'menu-update', 'uses' => 'WebSettingController@updateMenu']);
    Route::delete('menu-delete', ['as' => 'menu-delete', 'uses' => 'WebSettingController@deleteMenu']);

    Route::get('manage-breadcrumb', ['as' => 'manage-breadcrumb', 'uses' => 'WebSettingController@mangeBreadcrumb']);
    Route::post('manage-breadcrumb', ['as' => 'manage-breadcrumb', 'uses' => 'WebSettingController@updateBreadcrumb']);

    Route::get('manage-about', ['as' => 'manage-about', 'uses' => 'WebSettingController@manageAbout']);
    Route::post('manage-about', ['as' => 'manage-about', 'uses' => 'WebSettingController@updateAbout']);

    Route::get('manage-privacy', ['as' => 'manage-privacy', 'uses' => 'WebSettingController@managePrivacy']);
    Route::post('manage-privacy', ['as' => 'manage-privacy', 'uses' => 'WebSettingController@updatePrivacy']);

    Route::get('manage-terms', ['as' => 'manage-terms', 'uses' => 'WebSettingController@manageTerms']);
    Route::post('manage-terms', ['as' => 'manage-terms', 'uses' => 'WebSettingController@updateTerms']);

    Route::get('faqs-create', ['as' => 'faqs-create', 'uses' => 'WebSettingController@createFaqs']);
    Route::post('faqs-create', ['as' => 'faqs-create', 'uses' => 'WebSettingController@storeFaqs']);
    Route::get('faqs-all', ['as' => 'faqs-all', 'uses' => 'WebSettingController@allFaqs']);
    Route::get('faqs-edit/{id}', ['as' => 'faqs-edit', 'uses' => 'WebSettingController@editFaqs']);
    Route::put('faqs-edit/{id}', ['as' => 'faqs-update', 'uses' => 'WebSettingController@updateFaqs']);
    Route::delete('faqs-delete', ['as' => 'faqs-delete', 'uses' => 'WebSettingController@deleteFaqs']);

    Route::get('our-goals', ['as' => 'service-control', 'uses' => 'WebSettingController@manageService']);
    Route::get('our-goals/{id}', ['as' => 'service-edit', 'uses' => 'WebSettingController@editService']);
    Route::post('our-goals/{id}', ['as' => 'service-update', 'uses' => 'WebSettingController@updateService']);

    //    });
    /*demo End*/

    // Route::get('/logout', 'AdminController@logout')->name('admin.logout');
});


Route::get('/category-get-subcategory', function () {
    $category_id = \Illuminate\Support\Facades\Input::get('category_id');
    $subcategory = \App\Unit::whereStatus(1)->where('category_id', '=', $category_id)->get();
    return Response::json($subcategory);
});





















// coupon...................................................................................................

Route::get('/coupon-dashboard', 'CouponPageController@index')->name('home');


Route::get('/home', 'HomeController@index');

Route::redirect('/home', '/');

Route::redirect('/admin', '/');

// Route::get('register/verify/{confirmationCode}', 'UserDashboardController@confirm');

// Searching Routes
Route::get('search', 'SearchController@homeSearch');
Route::get('filtersearch', 'SearchController@filterSearch');
Route::get('homefilter', 'SearchController@filter');
Route::get('allfilter', 'SearchController@allfilter');
Route::get('blogsearch', 'SearchController@blogSearch');


Route::get('home-list', 'CouponPageController@list_show');
Route::get('category', 'CouponPageController@category_show');
Route::get('category-dtl/{slug}', 'CouponPageController@cat_dtl_show');
Route::get('coupon', 'CouponPageController@coupon_show');
Route::get('coupon-dtl/{slug}', 'CouponPageController@coupon_dtl_show');
Route::get('forum', 'CouponPageController@forum_show');
Route::get('deal-dtl/{slug}', 'CouponPageController@deal_dtl_show');
Route::get('deal', 'CouponPageController@deal_show');
Route::get('discussion', 'CouponPageController@discussion_show');
Route::get('discussion-dtl/{$slug}', 'CouponPageController@forum_dtl_show');
Route::get('forum-dtl/{slug}', 'CouponPageController@forum_dtl_show');
Route::get('post/{uniID}/{slug}', 'CouponPageController@post_show')->name('postpage');
Route::get('store', 'CouponPageController@store_show');
Route::get('store-dtl/{slug}', 'CouponPageController@store_dtl_show');
Route::get('faq', 'CouponPageController@faq_show');
Route::get('tag/{slug}', 'PageController@tag_show');
Route::get('blog', 'CouponPageController@blog_show');
Route::get('blog-dtl/{uniId}/{slug}', 'CouponPageController@blog_dtl_show');
Route::get('contact_coupon', 'CouponPageController@contact_show')->name('contact_coupon');
Route::post('contact_coupon', 'CouponPageController@contact_post');
Route::get('counter', 'CouponPageController@post_counter');

Route::get('profile/{id}', 'CouponPageController@profile_show');


// Admin Dashboard Routes
Route::group(['middleware' => ['web', 'auth', 'is_admin', 'Permission_check:community_module']], function () {
    Route::get('/admin', 'AdminDashboardController@dashboard_show');
    // Route::get('admin/profile', function () {
    //     $auth = Auth::user();
    //     return view('admin.profile', compact('auth'));
    // });
    Route::post('admin/profile-update', 'AdminDashboardController@update_profile');
    Route::resource('admin/category', 'CouponCategoryController');
    Route::post('admin/category/bulk_delete', 'CouponCategoryController@bulk_delete');
    Route::resource('admin/store', 'StoreController');
    Route::post('admin/store/bulk_delete', 'StoreController@bulk_delete');
    Route::resource('admin/forumcategory', 'ForumCategoryController');
    Route::post('admin/forumcategory/bulk_delete', 'ForumCategoryController@bulk_delete');
    Route::resource('admin/discussion', 'DiscussionController');
    Route::post('admin/discussion/bulk_delete', 'DiscussionController@bulk_delete');
    Route::resource('admin/coupon', 'CouponController');
    Route::post('admin/coupon/bulk_delete', 'CouponController@bulk_delete');
    Route::get('dropdown', 'CouponController@dropdown');
    // Route::resource('admin/deal', 'DealController');
    //  Route::post('admin/deal/bulk_delete', 'DealController@bulk_delete');
    Route::resource('admin/user', 'CouponUserController');
    Route::post('admin/user/bulk_delete', 'CouponUserController@bulk_delete');
    Route::resource('admin/faqcategory', 'FaqCategoryController');
    Route::post('admin/faqcategory/bulk_delete', 'FaqCategoryController@bulk_delete');
    Route::resource('admin/faq', 'FaqController');
    Route::post('admin/faq/bulk_delete', 'FaqController@bulk_delete');
    Route::resource('admin/social', 'SocialController');
    Route::post('admin/social/bulk_delete', 'SocialController@bulk_delete');
    Route::get('admin/slider', 'AdminDashboardController@slider_show');
    Route::patch('admin/slider_update/{id}', 'AdminDashboardController@slider_update');
    Route::get('admin/settings', 'SettingsController@general_show');
    Route::patch('admin/settings_update/{id}', 'SettingsController@general_update');
    Route::resource('admin/comment', 'CommentController');
    Route::post('admin/comment/status/{id}', 'CommentController@status_update');
    Route::post('admin/comment/bulk_delete', 'CommentController@bulk_delete');
    Route::resource('admin/tag', 'TagController');
    Route::post('admin/tag/bulk_delete', 'TagController@bulk_delete');
    Route::resource('admin/blog', 'BlogController');
    Route::post('admin/blog/bulk_delete', 'BlogController@bulk_delete');
    Route::resource('admin/pages', 'PagesController');
    Route::post('admin/pages/bulk_delete', 'PagesController@bulk_delete');
});

// User Dashboard Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('user/profile-edit', 'UserDashboardController@profile_edit');
    Route::patch('user/profile-update/{id}', 'UserDashboardController@profile_update');
    Route::patch('user/profile-edit', 'UserDashboardController@change_password');
});

// User Dashboard Routes
Route::group(['middleware' => ['auth', 'is_verified']], function () {
    Route::post('submit-coupon', 'UserDashboardController@coupon_post');
    Route::post('submit-discussion', 'UserDashboardController@discussion_post');
    Route::get('user/account', 'UserDashboardController@dashboard_show');
    Route::post('profile/follow', 'UserDashboardController@follow_user')->name('user.follow');
    Route::post('post/like', 'UserDashboardController@post_like')->name('post.like');
    Route::get('submit', 'UserDashboardController@deal_submit');
    Route::post('post/write', 'UserDashboardController@comment_store')->name('post.write');
    // Route::post('post/count', 'UserDashboardController@post_counter')->name('post.counter');
});


// OAuth Routes
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

// Mail Subscription
Route::post('emailsubscribe', 'EmailSubscribeController@subscribe');

// Route::get('{page}', 'PageController@page_show');




///chore and service ..........................................
Route::group(['prefix' => 'chores'], function () {
    Route::get('/create', 'ChoreController@create');
    Route::get('/view', 'ChoreController@index');
    Route::get('/add', 'ChoreController@create');
    Route::post('/store', 'ChoreController@store');
    Route::get('/details/{id}', 'ChoreController@show');
    Route::post('/proposal/{id}', 'ChoreController@proposal');
    Route::get('wishlist', 'ChoreController@wishlist');
    Route::get('/admin', 'ChoreController@admin');
    Route::get('/mywishlist', 'ChoreController@mywishlist');
    Route::get('/my_active_task', 'ChoreController@my_active_task')->name('MY Active Task');
    Route::get('/proposal_received', 'ChoreController@proposal_received')->name('Proposal Received');
    Route::get('/my_proposals', 'ChoreController@my_proposals')->name('My Proposals');
    Route::get('/task_i_get_pay', 'ChoreController@task_i_get_pay')->name('Task From where I get pay');
    Route::get('/task_i_pay', 'ChoreController@task_i_pay')->name('Task I pay for');
    Route::get('/proposal_accept/{id}', 'ChoreController@accept');
    Route::get('/proposal_denied/{id}', 'ChoreController@denied');
});
Route::group(['prefix' => 'service'], function () {
    Route::get('add', 'ServicesController@index');
    Route::post('/store', 'ServicesController@store');
    Route::get('/details/{id}', 'ServicesController@show');
    Route::post('/proposal/{id}', 'ServicesController@proposal');
    Route::get('sold_service', 'ServicesController@sold_service');
    Route::get('proposal_received', 'ServicesController@proposal_received');
    Route::get('my_service', 'ServicesController@my_service');
    Route::get('my_active_service', 'ServicesController@my_active_service');
    // Route::get('purchased_service', 'ServicesController@purchased_service');
    Route::get('/proposal_accept/{id}', 'ServicesController@accept');
    Route::get('/proposal_denied/{id}', 'ServicesController@denied');
});
// Route::get('{any}', 'UboldController@index');

Route::get('/chore_panel','ChoreController@panel');
Route::get('chore_panel_ajax', 'ChoreController@panel_ajax');