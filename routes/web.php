<?php

/**
 * Here is where you can register web routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 *

 */

// Authentication route
Auth::routes();
// Cache clear route
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
Route::get('/','LandingController@index');
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
Route::group(
    ['middleware' => ['role:admin']],
    function () {
        Route::post('admin/clear-cache', 'SiteManagementController@clearCache');
        Route::get('admin/clear-allcache', 'SiteManagementController@clearAllCache');
        Route::get('admin/import-demo', 'SiteManagementController@importDemo');
        Route::get('admin/remove-demo', 'SiteManagementController@removeDemoContent');
        Route::get('admin/payouts', 'UserController@getPayouts')->name('adminPayouts');
        Route::get('admin/payouts/download/{year}', 'UserController@generatePDF');
        Route::get('users', 'UserController@userListing')->name('userListing');
        Route::get('admin/home-page-settings', 'SiteManagementController@homePageSettings')->name('homePageSettings');
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
        Route::get('admin/languages', 'LanguageController@index')->name('languages');
        Route::get('admin/languages/edit-langs/{id}', 'LanguageController@edit')->name('editLanguages');
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
        Route::get('admin/review-options', 'ReviewController@index')->name('reviewOptions');
        Route::get('admin/review-options/edit-review-options/{id}', 'ReviewController@edit')->name('editReviewOptions');
        Route::post('admin/store-review-options', 'ReviewController@store');
        Route::post('admin/review-options/delete-review-options', 'ReviewController@destroy');
        Route::post('admin/review-options/update-review-options/{id}', 'ReviewController@update');
        Route::post('admin/delete-checked-rev-options', 'ReviewController@deleteSelected');
        // Site Management Routes
        Route::get('admin/settings', 'SiteManagementController@Settings')->name('settings');
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
        Route::get('admin/pages', 'PageController@index')->name('pages');
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

        Route::get('admin/profile', 'UserController@adminProfileSettings')->name('adminProfile');
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




//learn ............................................................................... 

Route::get('/learn-and-grow', 'FrontendController@index')->name('homepage');;


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


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    /*demo start*/
    //    Route::middleware(['demo'])->group(function () {

    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/subscribers', 'DashboardController@manageSubscribers')->name('manage.subscribers');
    Route::post('/update-subscribers', 'DashboardController@updateSubscriber')->name('update.subscriber');
    Route::get('/send-email', 'DashboardController@sendMail')->name('send.mail.subscriber');
    Route::post('/send-email', 'DashboardController@sendMailsubscriber')->name('send.email.subscriber');

    Route::get('/live', 'DashboardController@live')->name('admin.live');
    Route::post('/live', 'DashboardController@UpdateLive')->name('update.live');

    Route::get('/category', 'DashboardController@category')->name('admin.category');
    Route::post('/search-category', 'DashboardController@searchCategory')->name('admin.searchCategory');
    Route::post('/category', 'DashboardController@UpdateCategory')->name('update.category');

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

    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
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

Route::get('register/verify/{confirmationCode}', 'UserDashboardController@confirm');

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
Route::get('blog-dtl/{uniId}/{slug}', 'PageController@blog_dtl_show');
Route::get('contact_coupon', 'CouponPageController@contact_show')->name('contact_coupon');
Route::post('contact_coupon', 'CouponPageController@contact_post');
Route::get('counter', 'CouponPageController@post_counter');

Route::get('profile/{id}', 'CouponPageController@profile_show');


// Admin Dashboard Routes
Route::group(['middleware' => ['web', 'auth', 'is_admin']], function () {
    Route::get('/admin', 'AdminDashboardController@dashboard_show');
    Route::get('admin/profile', function () {
        $auth = Auth::user();
        return view('admin.profile', compact('auth'));
    });
    Route::post('admin/profile-update', 'AdminDashboardController@update_profile');
    Route::resource('admin/category', 'CategoryController');
    Route::post('admin/category/bulk_delete', 'CategoryController@bulk_delete');
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
    Route::resource('admin/user', 'UserController');
    Route::post('admin/user/bulk_delete', 'UserController@bulk_delete');
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

Route::get('{page}', 'PageController@page_show');


